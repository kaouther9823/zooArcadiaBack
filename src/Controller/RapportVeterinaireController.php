<?php

declare(strict_types=1);

// src/Controller/RapportVeterinaireController.php
namespace App\Controller;

use App\Repository\AnimalRepository;
use App\Repository\EtatRepository;
use App\Repository\NouritureRepository;
use App\Repository\UtilisateurRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\RapportVeterinaire;
use App\Repository\RapportVeterinaireRepository;
use Symfony\Component\Serializer\SerializerInterface;


#[Route("/api/rapports/veterinaires")]
 
class RapportVeterinaireController extends AbstractController
{
    private $rapportVeterinaireRepository;
    private $animalRepository;
    private $etatRepository;
    private $utilisateurRepository;
    private $nouritureRepository;
    private $entityManager;
    private $serializer;

    public function __construct(RapportVeterinaireRepository $rapportVeterinaireRepository, UtilisateurRepository $utilisateurRepository,
                                EtatRepository $etatRepository, AnimalRepository $animalRepository, NouritureRepository $nouritureRepository,
                                EntityManagerInterface $entityManager, SerializerInterface $serializer)
    {
        $this->rapportVeterinaireRepository = $rapportVeterinaireRepository;
        $this->entityManager = $entityManager;
        $this->etatRepository = $etatRepository;
        $this->utilisateurRepository = $utilisateurRepository;
        $this->animalRepository = $animalRepository;
        $this->serializer = $serializer;
        $this->nouritureRepository = $nouritureRepository;
    }

    
     #[Route("/", name: "rapport_veterinaire_index", methods: ["GET"])]
     
    public function index(): JsonResponse
    {
        $rapports = $this->rapportVeterinaireRepository->findAll();

        $data = $this->serializer->normalize($rapports, null, ['groups' => ['rapport_veterinaire:read']]);

        return new JsonResponse($data, Response::HTTP_OK);
    }


    /**
     * @throws \Exception
     */
    #[Route("/search", name: "rapport_veterinaire_search", methods: ["GET"])]

    public function search(Request $request): JsonResponse
    {
        $animalName = $request->query->get('animal');
        $startDate = $request->query->get('startDate') ? new DateTime($request->query->get('startDate')) : null;
        $endDate = $request->query->get('endDate') ? new DateTime($request->query->get('endDate')) : null;

        $rapports = $this->rapportVeterinaireRepository->findReportsByCriteria($animalName, $startDate, $endDate);

        $data = $this->serializer->normalize($rapports, null, ['groups' => ['rapport_veterinaire:read']]);

        return new JsonResponse($data, Response::HTTP_OK);
    }




    #[Route("/{id}", name: "rapport_veterinaire_show", methods: ["GET"])]
     
    public function show($id): JsonResponse
    {
        $rapport = $this->rapportVeterinaireRepository->find($id);

        if (!$rapport) {
            throw $this->createNotFoundException('Rapport not found');
        }

        $data = $this->serializer->normalize($rapport, null, ['groups' => ['rapport_veterinaire:read']]);

        return new JsonResponse($data, Response::HTTP_OK);
    }
    
     #[Route("/", name: "rapport_veterinaire_create", methods: ["POST"])]
     
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $rapport = new RapportVeterinaire();
        $currentUser = $this->getUser();
        $user = $this->utilisateurRepository->findOneBy(['username'=>$currentUser->getUserIdentifier()]);
       // $rapport->setVeterinaire($this->utilisateurRepository->find($data['veterinaire_id']));
        $rapport->setVeterinaire($user);
        $rapport->setAnimal($this->animalRepository->find($data['animal']));
        $rapport->setEtat($this->etatRepository->find($data['etat']));
        $rapport->setNouriture($this->nouritureRepository->find($data['nouriture']));
        $rapport->setQuantite($data['quantite']);
        $rapport->setDate(new DateTime());
        $rapport->setDetail($data['description']);

        $this->entityManager->persist($rapport);
        $this->entityManager->flush();

        $data = $this->serializer->normalize($rapport, null, ['groups' => ['rapport_veterinaire:read']]);

        return new JsonResponse($data, Response::HTTP_OK);
    }

    
     #[Route("/{id}", name: "rapport_veterinaire_update", methods: ["PUT"])]
     
    public function update($id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $rapport = $this->rapportVeterinaireRepository->find($id);

        if (!$rapport) {
            throw $this->createNotFoundException('Rapport not found');
        }

        $rapport->setAnimal($this->animalRepository->find($data['animal']));
        $rapport->setDate(new DateTime());
        $rapport->setDetail($data['description']);
        $rapport->setEtat($this->etatRepository->find($data['etat']));
        $rapport->setNouriture($this->nouritureRepository->find($data['nouriture']));
        $rapport->setQuantite($data['quantite']);

        $this->entityManager->flush();

        $data = $this->serializer->serialize($rapport, 'json', ['groups' => ['rapport_veterinaire:read']]);

        return new JsonResponse($data, Response::HTTP_OK);
    }

    
     #[Route("/{id}", name: "rapport_veterinaire_delete", methods: ["DELETE"])]
     
    public function delete($id): JsonResponse
    {
        $rapport = $this->entityManager->getRepository(RapportVeterinaire::class)->find($id);

        if (!$rapport) {
            throw $this->createNotFoundException('Rapport not found');
        }

        $this->entityManager->remove($rapport);
        $this->entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
