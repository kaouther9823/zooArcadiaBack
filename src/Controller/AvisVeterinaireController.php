<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\AvisVeterinaire;
use App\Repository\AvisVeterinaireRepository;
use App\Repository\HabitatRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/commentaires')]
class AvisVeterinaireController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private SerializerInterface $serializer;
    private UtilisateurRepository $utilisateurRepository;
    private AvisVeterinaireRepository $avisVeterinaireRepository;

    private HabitatRepository $habitatRepository;

    public function __construct(EntityManagerInterface $entityManager, AvisVeterinaireRepository $avisVeterinaireRepository,
                                UtilisateurRepository $utilisateurRepository, HabitatRepository $habitatRepository,
                                SerializerInterface $serializer)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
        $this->utilisateurRepository = $utilisateurRepository;
        $this->avisVeterinaireRepository = $avisVeterinaireRepository;
        $this->habitatRepository = $habitatRepository;
    }

    #[Route('/', name: 'avis_veterinaire_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $avisVeterinaires = $this->avisVeterinaireRepository->findAll();
        $data = $this->serializer->serialize($avisVeterinaires, 'json', ['groups' => 'avis_veterinaire:read']);

        return new JsonResponse($data, 200, [], true);
    }

    #[Route('/', name: 'avis_veterinaire_new', methods: ['POST'])]
    public function new(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $avisVeterinaire = new AvisVeterinaire();
        $avisVeterinaire->setCommentaire($data['commentaire']);
        //todo remplacer par getUser
        $avisVeterinaire->setVeterinaire($this->utilisateurRepository->find(53));
        $avisVeterinaire->setHabitat($this->habitatRepository->find($data['habitat']));
        $avisVeterinaire->setDate(new \DateTime());

        $this->entityManager->persist($avisVeterinaire);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Avis vétérinaire créé!'], Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'avis_veterinaire_show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {$avisVeterinaire = $this->avisVeterinaireRepository->find($id);

        $data = $this->serializer->serialize($avisVeterinaire, 'json', ['groups' => 'avis_veterinaire:read']);

        return new JsonResponse($data, 200, [], true);
    }

    #[Route('/{id}', name: 'avis_veterinaire_edit', methods: ['PUT'])]
    public function edit(Request $request, int $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $avisVeterinaire = $this->avisVeterinaireRepository->find($id);

        //todo remplacer par getUser
        $avisVeterinaire->setVeterinaire($this->utilisateurRepository->find(53));
        $avisVeterinaire->setHabitat($this->habitatRepository->find($data['habitat']));
        $avisVeterinaire->setDate(new \DateTime());

        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Avis vétérinaire mis à jour!']);
    }

    #[Route('/{id}', name: 'avis_veterinaire_delete', methods: ['DELETE'])]
    public function delete($id): JsonResponse
    {
        $avisVeterinaire = $this->avisVeterinaireRepository->find($id);
        $this->entityManager->remove($avisVeterinaire);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Avis vétérinaire supprimé!']);
    }
}