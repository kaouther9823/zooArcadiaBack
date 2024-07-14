<?php

declare(strict_types=1);

// src/Controller/AvisVisiteurController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\AvisVisiteur;
use App\Repository\AvisVisiteurRepository;


 #[Route("/api/avis-visiteur")]
 
class AvisVisiteurController extends AbstractController
{
    private $avisVisiteurRepository;

    public function __construct(AvisVisiteurRepository $avisVisiteurRepository)
    {
        $this->avisVisiteurRepository = $avisVisiteurRepository;
    }

    
     #[Route("/", name: "avis_visiteur_index", methods: ["GET"])]
     
    public function index(): JsonResponse
    {
        $avis = $this->avisVisiteurRepository->findAll();

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
        $avis->setIsVisible($data['isVisible']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($avis);
        $entityManager->flush();

        return $this->json($avis);
    }

    
     #[Route("/{id}", name: "avis_visiteur_update", methods: ["PUT"])]
     
    public function update($id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $entityManager = $this->getDoctrine()->getManager();
        $avis = $entityManager->getRepository(AvisVisiteur::class)->find($id);

        if (!$avis) {
            throw $this->createNotFoundException('Avis Visiteur not found');
        }

        $avis->setPseudo($data['pseudo']);
        $avis->setCommentaire($data['commentaire']);
        $avis->setIsVisible($data['isVisible']);

        $entityManager->flush();

        return $this->json($avis);
    }

    
     #[Route("/{id}", name: "avis_visiteur_delete", methods: ["DELETE"])]
     
    public function delete($id): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $avis = $entityManager->getRepository(AvisVisiteur::class)->find($id);

        if (!$avis) {
            throw $this->createNotFoundException('Avis Visiteur not found');
        }

        $entityManager->remove($avis);
        $entityManager->flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
