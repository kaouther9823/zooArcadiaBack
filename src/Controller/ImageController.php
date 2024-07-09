<?php

// src/Controller/ImageController.php
namespace App\Controller;

use App\Entity\HabitatImage;
use App\Repository\HabitatRepository;
use Doctrine\ORM\EntityManagerInterface;
use http\Client\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as ResponseFoundation;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Image;
use App\Repository\ImageRepository;


 #[Route("/api/images")]
 
class ImageController extends AbstractController
{
    private $imageRepository;
    private $entityManager;
    private $habitatRepository;

    public function __construct(ImageRepository $imageRepository,
                                HabitatRepository $habitatRepository,
                                EntityManagerInterface $entityManager)
    {
        $this->imageRepository = $imageRepository;
        $this->entityManager = $entityManager;
        $this->habitatRepository = $habitatRepository;
    }
     #[Route("/upload", name: "upload_image", methods: ("POST"))]
     public function uploadImage(Request $request): ResponseFoundation
     {
         $file = $request->files->get('image');
         $imageName = $request->request->get('imageName');

         if (!$file) {
             return new ResponseFoundation('No file uploaded', ResponseFoundation::HTTP_BAD_REQUEST);
         }
         if (!$imageName) {
             return new ResponseFoundation('No image name provided', ResponseFoundation::HTTP_BAD_REQUEST);
         }
         // Move the uploaded file to a directory (e.g., public/uploads/)
         //$uploadsDirectory = $this->getParameter('kernel.project_dir') . '/public/uploads/';
         $uploadsDirectory = "C:\\Users\\sh6210\\formation\\ZooArcadiaWeb\\images\\services\\";
         //$fileName = $imageName . '.' . $file->guessExtension();

         try {
             $file->move($uploadsDirectory, $imageName);
         } catch (\Exception $e) {
             return new ResponseFoundation('Failed to move file', ResponseFoundation::HTTP_INTERNAL_SERVER_ERROR);
         }

         return $this->json([
             'message' => 'File uploaded successfully',
             'filename' => $imageName,
         ]);
     }

     #[Route("/upload/habitat/{id}", name: "images_habitat_upload", methods: ("POST"))]
     public function uploadImageForHabitat(Request $request, int $id): JsonResponse
     {
         $files = $request->files->get('add-images');

         foreach ($files as $file) {
             $image = new Image();
             $image->setImageData(file_get_contents($file->getPathname()));

             $habitatImage = new HabitatImage();
             $habitatImage->setHabitat($this->habitatRepository->find($id));
             $habitatImage->setImage($image);

             $this->entityManager->persist($image);
             $this->entityManager->persist($habitatImage);
         }

         $this->entityManager->flush();

         return $this->json(['status' => 'success']);
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
