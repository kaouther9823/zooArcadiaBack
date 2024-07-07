<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\AvisVeterinaire;
use App\Form\AvisVeterinaireType;
use App\Repository\AvisVeterinaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/avis_veterinaire')]
class AvisVeterinaireController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private SerializerInterface $serializer;

    public function __construct(EntityManagerInterface $entityManager, SerializerInterface $serializer)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    #[Route('/', name: 'avis_veterinaire_index', methods: ['GET'])]
    public function index(AvisVeterinaireRepository $avisVeterinaireRepository): JsonResponse
    {
        $avisVeterinaires = $avisVeterinaireRepository->findAll();
        $data = $this->serializer->serialize($avisVeterinaires, 'json', ['groups' => 'avis_veterinaire:read']);

        return new JsonResponse($data, 200, [], true);
    }

    #[Route('/new', name: 'avis_veterinaire_new', methods: ['POST'])]
    public function new(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $avisVeterinaire = new AvisVeterinaire();
        $avisVeterinaire->setCommentaire($data['commentaire']);
        $avisVeterinaire->setVeterinaire($this->entityManager->getRepository(Utilisateur::class)->find($data['veterinaire_id']));
        $avisVeterinaire->setHabitat($this->entityManager->getRepository(Habitat::class)->find($data['habitat_id']));

        $this->entityManager->persist($avisVeterinaire);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Avis vétérinaire créé!'], JsonResponse::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'avis_veterinaire_show', methods: ['GET'])]
    public function show(AvisVeterinaire $avisVeterinaire): JsonResponse
    {
        $data = $this->serializer->serialize($avisVeterinaire, 'json', ['groups' => 'avis_veterinaire:read']);

        return new JsonResponse($data, 200, [], true);
    }

    #[Route('/{id}/edit', name: 'avis_veterinaire_edit', methods: ['PUT'])]
    public function edit(Request $request, AvisVeterinaire $avisVeterinaire): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $avisVeterinaire->setCommentaire($data['commentaire']);
        $avisVeterinaire->setVeterinaire($this->entityManager->getRepository(Utilisateur::class)->find($data['veterinaire_id']));
        $avisVeterinaire->setHabitat($this->entityManager->getRepository(Habitat::class)->find($data['habitat_id']));

        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Avis vétérinaire mis à jour!']);
    }

    #[Route('/{id}', name: 'avis_veterinaire_delete', methods: ['DELETE'])]
    public function delete(AvisVeterinaire $avisVeterinaire): JsonResponse
    {
        $this->entityManager->remove($avisVeterinaire);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Avis vétérinaire supprimé!']);
    }
}