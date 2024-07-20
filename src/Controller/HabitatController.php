<?php

declare(strict_types=1);
// src/Controller/HabitatController.php
namespace App\Controller;

use App\Repository\HabitatImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Habitat;
use App\Repository\HabitatRepository;
use Symfony\Component\Serializer\SerializerInterface;

#[Route("/api/habitats")]
 
class HabitatController extends AbstractController
{
    private $habitatRepository;
    private $habitatImageRepository;
     private $entityManager;

    private $serializer;

    public function __construct(HabitatImageRepository $habitatImageRepository,
                                HabitatRepository $habitatRepository,
                                EntityManagerInterface $entityManager,
                                SerializerInterface $serializer,
                                LoggerInterface $logger)
    {
        $this->habitatImageRepository = $habitatImageRepository;
        $this->entityManager = $entityManager;
        $this->habitatRepository = $habitatRepository;
        $this->logger = $logger;
        $this->serializer = $serializer;
    }


    #[Route("/", name: "habitat_index", methods: ["GET"])]
    public function indexAll(): JsonResponse
    {
        $habitats = $this->habitatRepository->findAll();
        $data = [];

        foreach ($habitats as $habitat) {
            $habitatData = [
                'id' => $habitat->getId(),
                'nom' => $habitat->getNom(),
                'description' => $habitat->getDescription(),
                'images' => []
            ];

            foreach ($habitat->getImages() as $image) {
                $habitatData['images'][] = [
                    'imageId' => $image->getImageId(),
                    'id' => $habitat->getId(),
                    //'base64Data' => $image->getBase64Data()
                ];
            }

            $data[] = $habitatData;
        }

        return new JsonResponse($data, 200);
    }
/*
     #[Route("/", name: "habitat_index", methods: ["GET"])]
     
    public function index(): JsonResponse
    {
        $habitats = $this->habitatRepository->findAll();
        $data = $this->serializer->serialize($habitats, 'json', ['groups' => 'habitat:read']);
        return new JsonResponse($data, 200, [], true);
    }*/

     #[Route("/{id}", name: "habitat_show", methods: ["GET"])]
    public function show($id): JsonResponse
    {
        $habitat = $this->habitatRepository->find($id);

        if (!$habitat) {
            throw $this->createNotFoundException('Habitat not found');
        }
       // $data = $this->serializer->serialize($habitat, 'json', ['groups' => 'habitat:read']);
        $habitatData = [
            'id' => $habitat->getId(),
            'nom' => $habitat->getNom(),
            'description' => $habitat->getDescription(),
            'images' => []
        ];

        foreach ($habitat->getImages() as $image) {
            $habitatData['images'][] = [
                'imageId' => $image->getImageId(),
                'id' => $habitat->getId(),
                //'base64Data' => $image->getBase64Data()
            ];
        }

return new JsonResponse($habitatData, 200);
    }


     #[Route("/", name: "habitat_create", methods: ["POST"])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $habitat = new Habitat();
        $habitat->setNom($data['nom']);
        $habitat->setDescription($data['description']);
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

        $this->entityManager->flush();
        //return $this->json($habitat);
        $habitatData = $this->serializer->normalize($habitat, null, ['groups' => ['habitat:read']]);

        return new JsonResponse($habitatData, Response::HTTP_OK);
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
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

     #[Route("/{id}/images", name: "habitat_list_image", methods: ["GET"])]

     public function listImage($id): JsonResponse
     {

             $habitat = $this->habitatRepository->find($id);

             if (!$habitat) {
                 throw $this->createNotFoundException('Habitat not found');
             }
         $habitatData = [];
             foreach ($habitat->getImages() as $image) {
                 $habitatData[] = [
                     'imageId' => $image->getImageId(),
                     'id' => $habitat->getId(),
                     'base64Data' => $image->getBase64Data()
                 ];
             }

             return new JsonResponse($habitatData, 200);
     }
}

