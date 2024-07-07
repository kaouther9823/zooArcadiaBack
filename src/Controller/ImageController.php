<?php

// src/Controller/ImageController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Image;
use App\Repository\ImageRepository;


 #[Route("/images")]
 
class ImageController extends AbstractController
{
    private $imageRepository;

    public function __construct(ImageRepository $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    
     #[Route("/", name: "image_index", methods: ["GET"])]
     
    public function index(): JsonResponse
    {
        $images = $this->imageRepository->findAll();

        return $this->json($images);
    }

    
     #[Route("/{id}", name: "image_show", methods: ["GET"])]
     
    public function show($id): JsonResponse
    {
        $image = $this->imageRepository->find($id);

        if (!$image) {
            throw $this->createNotFoundException('Image not found');
        }

        return $this->json($image);
    }

    
     #[Route("/", name: "image_create", methods: ["POST"])]
     
    public function create(Request $request): JsonResponse
    {
        // Exemple de création d'une image avec des données en base64 depuis une requête JSON
        $data = json_decode($request->getContent(), true);

        $imageData = base64_decode($data['image_data']);

        $image = new Image();
        $image->setImageData($imageData);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($image);
        $entityManager->flush();

        return $this->json($image);
    }

    
     #[Route("/{id}", name: "image_update", methods: ["PUT"])]
     
    public function update($id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $entityManager = $this->getDoctrine()->getManager();
        $image = $entityManager->getRepository(Image::class)->find($id);

        if (!$image) {
            throw $this->createNotFoundException('Image not found');
        }

        $imageData = base64_decode($data['image_data']);
        $image->setImageData($imageData);

        $entityManager->flush();

        return $this->json($image);
    }

    
     #[Route("/{id}", name: "image_delete", methods: ["DELETE"])]
     
    public function delete($id): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $image = $entityManager->getRepository(Image::class)->find($id);

        if (!$image) {
            throw $this->createNotFoundException('Image not found');
        }

        $entityManager->remove($image);
        $entityManager->flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
