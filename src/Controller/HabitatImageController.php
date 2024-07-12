<?php

// src/Controller/ImageController.php
namespace App\Controller;

use App\Entity\HabitatImage;
use App\Repository\HabitatImageRepository;
use App\Repository\HabitatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
 #[Route("/api/habitats")]
 
class HabitatImageController extends AbstractController
{
    private $habitatImageRepository;
    private $entityManager;
    private $habitatRepository;
    private $logger;
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

     #[Route("/images/{id}", name: "get_images", methods: ("GET"))]
     public function getImage(int $id): Response
     {
         $image = $this->habitatImageRepository->find($id);

         if (!$image) {
             return new Response('Image not found', Response::HTTP_NOT_FOUND);
         }
             $habitatData = [
                 'imageId' => $image->getImageId(),
                 'id' => $image->getHabitat()->getId(),
                 'base64Data' => $image->getBase64Data()
             ];

         return new JsonResponse($habitatData, 200);
     }

     #[Route("/{id}/upload", name: "images_habitat_upload", methods: ["POST"])]
     public function uploadImagesForHabitat(Request $request, int $id): JsonResponse
     {
         $files = $request->files->get('images');

         // Log the received files
         $this->logger->info('Files received', ['files' => $files]);

         if (!$files) {
             $this->logger->error('No file uploaded');
             return new JsonResponse('No file uploaded', Response::HTTP_BAD_REQUEST);
         }

         // Handle single file case by converting it to an array
         if (!is_array($files)) {
             $files = [$files];
         }

         $habitat = $this->habitatRepository->find($id);
         if (!$habitat) {
             $this->logger->error('Habitat not found');
             return new JsonResponse('Habitat not found', Response::HTTP_NOT_FOUND);
         }

         foreach ($files as $file) {
             if ($file instanceof UploadedFile) {
                 try {
                     $imageData = file_get_contents($file->getPathname());
                     $habitatImage = new HabitatImage();
                     $habitatImage->setHabitat($habitat);
                     $habitatImage->setImageData($imageData);
                     $this->entityManager->persist($habitatImage);
                 } catch (\Exception $e) {
                     $this->logger->error('Failed to process file', ['exception' => $e->getMessage()]);
                     return new JsonResponse('Failed to process file', Response::HTTP_INTERNAL_SERVER_ERROR);
                 }
             } else {
                 $this->logger->error('Invalid file instance', ['file' => $file]);
                 return new JsonResponse('Invalid file instance', Response::HTTP_BAD_REQUEST);
             }
         }

         // Flush after all files have been processed
         $this->entityManager->flush();

         return $this->json(['status' => 'success']);
     }

/*     #[Route("{id}/images", name: "image_index", methods: ["GET"])]

    public function index($id): JsonResponse
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

         $data[] = $habitatData;


         return new JsonResponse($data, 200);
         }*/


     #[Route("/{id}", name: "image_delete", methods: ["DELETE"])]
     
    public function deleteImage($id): JsonResponse
    {
        $image = $this->habitatImageRepository->find($id);

        if (!$image) {
            throw $this->createNotFoundException('Image not found');
        }

        $this->entityManager->remove($image);
        $this->entityManager->flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
