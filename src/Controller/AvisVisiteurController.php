<?php

declare(strict_types=1);

// src/Controller/AvisVisiteurController.php
namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\AvisVisiteur;
use App\Repository\AvisVisiteurRepository;
use Symfony\Component\Serializer\SerializerInterface;


#[Route("/api/avis")]
 
class AvisVisiteurController extends AbstractController
{
    private $avisVisiteurRepository;
     private $entityManager;
     private $serializer;
     private $logger;

     public function __construct(AvisVisiteurRepository $avisVisiteurRepository,
                                 EntityManagerInterface $entityManager,
                                 SerializerInterface $serializer,
                                 LoggerInterface $logger)
    {
        $this->avisVisiteurRepository = $avisVisiteurRepository;
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
        $this->logger = $logger;

    }
    
     #[Route("/", name: "avis_visiteur_index", methods: ["GET"])]
     
    public function index(): JsonResponse
    {
        $avis = $this->avisVisiteurRepository->findAllOrdred();

        return $this->json($avis);
    }

    #[Route("/home", name: "avis_visiteur_home", methods: ["GET"])]

    public function showOnHomePage(): JsonResponse
    {
        $avis = $this->avisVisiteurRepository->findByVisible();

        return $this->json($avis);
    }

     #[Route("/{id}", name: "avis_visiteur_show", methods: ["GET"])]
     
    public function show($id): JsonResponse
    {
        $avis = $this->avisVisiteurRepository->find($id);

        if (!$avis) {
            throw $this->createNotFoundException('Avis Visiteur not found');
        }

        return $this->json($avis);
    }

     #[Route("/", name: "avis_visiteur_create", methods: ["POST"])]
     
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $avis = new AvisVisiteur();
        $avis->setPseudo($data['pseudo']);
        $avis->setCommentaire($data['commentaire']);
        $avis->setNote($data['note']);
        $avis->setVisible(false);
        $avis->setTreated(false);

        $this->entityManager->persist($avis);
        $this->entityManager->flush();

        return $this->json($avis);
    }

    
     #[Route("/{id}", name: "avis_visiteur_update", methods: ["PUT"])]
     
    public function update($id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $avis = $this->avisVisiteurRepository->find($id);

        if (!$avis) {
            throw $this->createNotFoundException('Avis Visiteur not found');
        }

        $avis->setVisible($data['visible']);
        $avis->setTreated($data['treated']);


        $this->entityManager->flush();

        return $this->json($avis);
    }

    
     #[Route("/{id}", name: "avis_visiteur_delete", methods: ["DELETE"])]
     
    public function delete($id): JsonResponse
    {
        $avis = $this->avisVisiteurRepository->find($id);

        if (!$avis) {
            throw $this->createNotFoundException('Avis Visiteur not found');
        }

        $this->entityManager->remove($avis);
        $this->entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
