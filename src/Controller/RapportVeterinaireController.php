<?php

declare(strict_types=1);

// src/Controller/RapportVeterinaireController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\RapportVeterinaire;
use App\Repository\RapportVeterinaireRepository;


 #[Route("/rapports/veterinaires")]
 
class RapportVeterinaireController extends AbstractController
{
    private $rapportVeterinaireRepository;

    public function __construct(RapportVeterinaireRepository $rapportVeterinaireRepository)
    {
        $this->rapportVeterinaireRepository = $rapportVeterinaireRepository;
    }

    
     #[Route("/", name: "rapport_veterinaire_index", methods: ["GET"])]
     
    public function index(): JsonResponse
    {
        $rapports = $this->rapportVeterinaireRepository->findAll();

        return $this->json($rapports);
    }

    
     #[Route("/{id}", name: "rapport_veterinaire_show", methods: ["GET"])]
     
    public function show($id): JsonResponse
    {
        $rapport = $this->rapportVeterinaireRepository->find($id);

        if (!$rapport) {
            throw $this->createNotFoundException('Rapport not found');
        }

        return $this->json($rapport);
    }

    
     #[Route("/", name: "rapport_veterinaire_create", methods: ["POST"])]
     
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $rapport = new RapportVeterinaire();
        $rapport->setVeterinaire($this->getDoctrine()->getRepository(Utilisateur::class)->find($data['veterinaire_id']));
        $rapport->setAnimal($this->getDoctrine()->getRepository(Animal::class)->find($data['animal_id']));
        $rapport->setDate(new \DateTime($data['date']));
        $rapport->setDetail($data['detail']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($rapport);
        $entityManager->flush();

        return $this->json($rapport);
    }

    
     #[Route("/{id}", name: "rapport_veterinaire_update", methods: ["PUT"])]
     
    public function update($id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $entityManager = $this->getDoctrine()->getManager();
        $rapport = $entityManager->getRepository(RapportVeterinaire::class)->find($id);

        if (!$rapport) {
            throw $this->createNotFoundException('Rapport not found');
        }

        $rapport->setVeterinaire($this->getDoctrine()->getRepository(Utilisateur::class)->find($data['veterinaire_id']));
        $rapport->setAnimal($this->getDoctrine()->getRepository(Animal::class)->find($data['animal_id']));
        $rapport->setDate(new \DateTime($data['date']));
        $rapport->setDetail($data['detail']);

        $entityManager->flush();

        return $this->json($rapport);
    }

    
     #[Route("/{id}", name: "rapport_veterinaire_delete", methods: ["DELETE"])]
     
    public function delete($id): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $rapport = $entityManager->getRepository(RapportVeterinaire::class)->find($id);

        if (!$rapport) {
            throw $this->createNotFoundException('Rapport not found');
        }

        $entityManager->remove($rapport);
        $entityManager->flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
