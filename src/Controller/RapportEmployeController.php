<?php

declare(strict_types=1);

// src/Controller/RapportEmployeController.php
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
use App\Entity\RapportEmploye;
use App\Repository\RapportEmployeRepository;
use Symfony\Component\Serializer\SerializerInterface;


#[Route("/api/rapports/employes")]
 
class RapportEmployeController extends AbstractController
{
    private $rapportEmployeRepository;
    private $animalRepository;
    private $etatRepository;
    private $utilisateurRepository;
    private $nouritureRepository;
    private $entityManager;
    private $serializer;

    public function __construct(RapportEmployeRepository $rapportEmployeRepository, UtilisateurRepository $utilisateurRepository,
                                EtatRepository $etatRepository, AnimalRepository $animalRepository, NouritureRepository $nouritureRepository,
                                EntityManagerInterface $entityManager, SerializerInterface $serializer)
    {
        $this->rapportEmployeRepository = $rapportEmployeRepository;
        $this->entityManager = $entityManager;
        $this->etatRepository = $etatRepository;
        $this->utilisateurRepository = $utilisateurRepository;
        $this->animalRepository = $animalRepository;
        $this->serializer = $serializer;
        $this->nouritureRepository = $nouritureRepository;
    }

    
     #[Route("/", name: "rapport_employe_index", methods: ["GET"])]
     
    public function index(): JsonResponse
    {
        $rapports = $this->rapportEmployeRepository->findAll();

        $data = $this->serializer->normalize($rapports, null, ['groups' => ['rapport_employe:read']]);

        return new JsonResponse($data, Response::HTTP_OK);
    }


    #[Route("/{id}", name: "rapport_employe_show", methods: ["GET"])]
     
    public function show($id): JsonResponse
    {
        $rapport = $this->rapportEmployeRepository->find($id);

        if (!$rapport) {
            throw $this->createNotFoundException('Rapport not found');
        }

        $data = $this->serializer->normalize($rapport, null, ['groups' => ['rapport_employe:read']]);

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @throws \Exception
     */
    #[Route("/", name: "rapport_employe_create", methods: ["POST"])]
     
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $rapport = new RapportEmploye();
        $currentUser = $this->getUser();

        $user = $this->utilisateurRepository->findOneBy(['username'=>$currentUser->getUserIdentifier()]);
        $rapport->setEmploye($user);
        $rapport->setAnimal($this->animalRepository->find($data['animal']));
        $rapport->setNouriture($this->nouritureRepository->find($data['nouriture']));
        $rapport->setQuantite($data['quantite']);
        $rapport->setDate( new DateTime($data['date']));

        $this->entityManager->persist($rapport);
        $this->entityManager->flush();

        $data = $this->serializer->normalize($rapport, null, ['groups' => ['rapport_employe:read']]);

        return new JsonResponse($data, Response::HTTP_OK);
    }


    /**
     * @throws \Exception
     */
    #[Route("/{id}", name: "rapport_employe_update", methods: ["PUT"])]
     
    public function update($id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $rapport = $this->rapportEmployeRepository->find($id);

        if (!$rapport) {
            throw $this->createNotFoundException('Rapport not found');
        }
        $currentUser = $this->getUser();

        $user = $this->utilisateurRepository->findOneBy(['username'=>$currentUser->getUserIdentifier()]);
        $rapport->setEmploye($user);
        $rapport->setAnimal($this->animalRepository->find($data['animal']));
        $rapport->setNouriture($this->nouritureRepository->find($data['nouriture']));
        $rapport->setQuantite($data['quantite']);
        $rapport->setDate( new DateTime($data['date']));

        $this->entityManager->flush();

        $data = $this->serializer->serialize($rapport, 'json', ['groups' => ['rapport_employe:read']]);

        return new JsonResponse($data, Response::HTTP_OK);
    }

    
     #[Route("/{id}", name: "rapport_employe_delete", methods: ["DELETE"])]
     
    public function delete($id): JsonResponse
    {
        $rapport = $this->entityManager->getRepository(RapportEmploye::class)->find($id);

        if (!$rapport) {
            throw $this->createNotFoundException('Rapport not found');
        }

        $this->entityManager->remove($rapport);
        $this->entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @throws \Exception
     */
    #[Route("/list/search", name: "rapport_employe_search", methods: ["GET"])]

    public function search(Request $request): JsonResponse
    {
        $animalName = $request->query->get('animal');
        $startDate = $request->query->get('startDate') ? new DateTime($request->query->get('startDate')) : null;
        $endDate = $request->query->get('endDate') ? new DateTime($request->query->get('endDate')) : null;

        $rapports = $this->rapportEmployeRepository->findReportsByCriteria($animalName, $startDate, $endDate);

        $data = $this->serializer->normalize($rapports, null, ['groups' => ['rapport_employe:read']]);

        return new JsonResponse($data, Response::HTTP_OK);
    }

}
