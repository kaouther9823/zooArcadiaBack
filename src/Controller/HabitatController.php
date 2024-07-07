<?php

declare(strict_types=1);
// src/Controller/HabitatController.php
namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Habitat;
use App\Repository\HabitatRepository;

 #[Route("/api/habitats")]
 
class HabitatController extends AbstractController
{
    private $habitatRepository;
     private $entityManager;

     public function __construct(HabitatRepository $habitatRepository, EntityManagerInterface $entityManager)
     {
         $this->habitatRepository = $habitatRepository;
         $this->entityManager = $entityManager;
     }
    
     #[Route("/", name: "habitat_index", methods: ["GET"])]
     
    public function index(): JsonResponse
    {
        $habitats = $this->habitatRepository->findAll();
        return $this->json($habitats);
    }

     #[Route("/{id}", name: "habitat_show", methods: ["GET"])]
    public function show($id): JsonResponse
    {
        $habitat = $this->habitatRepository->find($id);

        if (!$habitat) {
            throw $this->createNotFoundException('Habitat not found');
        }
        return $this->json($habitat);
    }

    
     #[Route("/", name: "habitat_create", methods: ["POST"])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $habitat = new Habitat();
        $habitat->setNom($data['nom']);
        $habitat->setDescription($data['description']);
        $habitat->setCommentaireHabitat($data['commentaire_habitat']);
        $this->entityManager->persist($habitat);
        $this->entityManager->flush();
        return $this->json($habitat);
    }

    
     #[Route("/{id}", name: "habitat_update", methods: ["PUT"])]
     
    public function update($id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $habitat = $this->habitatRepository->find($id);

        if (!$habitat) {
            throw $this->createNotFoundException('Habitat not found');
        }

        $habitat->setNom($data['nom']);
        $habitat->setDescription($data['description']);
        $habitat->setCommentaireHabitat($data['commentaire_habitat']);

        $this->entityManager->flush();
        return $this->json($habitat);
    }

    
     #[Route("/{id}", name: "habitat_delete", methods: ["DELETE"])]
     
    public function delete($id): JsonResponse
    {
        $habitat = $this->habitatRepository->find($id);

        if (!$habitat) {
            throw $this->createNotFoundException('Habitat not found');
        }
        $this->entityManager->remove($habitat);
        $this->entityManager->flush();
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}

