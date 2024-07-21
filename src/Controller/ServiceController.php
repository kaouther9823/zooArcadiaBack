<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Service;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route("/api/services")]
class ServiceController extends AbstractController
{
    private $serviceRepository;
    private EntityManagerInterface $entityManager;
    private $logger;

    public function __construct(ServiceRepository $serviceRepository, LoggerInterface $logger,
                                EntityManagerInterface $entityManager)
    {
        $this->serviceRepository = $serviceRepository;
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }

    #[Route("/", name: "service_index", methods: ["GET"])]
    public function index(): JsonResponse
    {
        $services = $this->serviceRepository->findAll();
        $serviceData = [];

        foreach ($services as $service) {
            array_push($serviceData, [
                'serviceId' => $service->getServiceId(),
                'nom' => $service->getNom(),
                'description' => $service->getDescription(),
            ]);

        }

        return new JsonResponse($serviceData, 200);
    }

    #[Route("/{id}", name: "service_show", methods: ["GET"])]
    public function show($id): JsonResponse
    {
        $service = $this->serviceRepository->find($id);
        if (!$service) {
            throw $this->createNotFoundException('Service not found');
        }
        return $this->json($service);
    }

    #[Route("/", name: "service_create", methods: ["POST"])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $service = new Service();
        $service->setNom($data['nom']);
        $service->setDescription($data['description']);

        $this->entityManager->persist($service);
        $this->entityManager->flush();
        return $this->json($service);
    }

    #[Route("/{id}", name: "service_update", methods: ["PUT"])]
    public function update($id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $service = $this->serviceRepository->find($id);
        if (!$service) {
            throw $this->createNotFoundException('Service not found');
        }
        $service->setNom($data['nom']);
        $service->setDescription($data['description']);

        $this->entityManager->flush();
        return $this->json($service);
    }

    #[Route("/{id}", name: "service_delete", methods: ["DELETE"])]
    public function delete($id): JsonResponse
    {
        $service = $this->serviceRepository->find($id);
        if (!$service) {
            throw $this->createNotFoundException('Service not found');
        }
        $this->entityManager->remove($service);
        $this->entityManager->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    #[Route("/upload", name: "upload_image", methods: ("POST"))]
    public function uploadImage(Request $request): Response
    {
        $file = $request->files->get('image');
        $imageName = $request->request->get('imageName');
        if (!$file) {
            return new Response('No file uploaded', Response::HTTP_BAD_REQUEST);
        }
        if (!$imageName) {
            return new Response('No image name provided', Response::HTTP_BAD_REQUEST);
        }
        // Move the uploaded file to a directory (e.g., public/uploads/)
        //$uploadsDirectory = $this->getParameter('kernel.project_dir') . '/public/uploads/';
        $uploadsDirectory = "C:\\Users\\sh6210\\formation\\ZooArcadiaWeb\\images\\services\\";
        //$fileName = $imageName . '.' . $file->guessExtension();

        try {
            $file->move($uploadsDirectory, $imageName);
        } catch (\Exception $e) {
            return new Response('Failed to move file', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->json([
            'message' => 'File uploaded successfully',
            'filename' => $imageName,
        ]);
    }

    #[Route("/{id}/upload", name: "image_service_upload", methods: ["POST"])]
    public function uploadImageForService(Request $request, int $id): JsonResponse
    {
        $files = $request->files->get('image');

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

        $service = $this->serviceRepository->find($id);
        if (!$service) {
            $this->logger->error('Service not found');
            return new JsonResponse('Habitat not found', Response::HTTP_NOT_FOUND);
        }

        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                try {
                    $imageData = file_get_contents($file->getPathname());
                    $service->setImageData($imageData);
                    $this->entityManager->persist($service);
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
    #[Route("/images/list", name: "service_with_image", methods: ["GET"])]
    public function listServicesWithImage(): JsonResponse
    {
        $services = $this->serviceRepository->findAll();
        $serviceData = [];

        foreach ($services as $service) {
            array_push($serviceData, [
                'serviceId' => $service->getServiceId(),
                'nom' => $service->getNom(),
                'description' => $service->getDescription(),
                'imageData' => $service->getBase64Data()
            ]);

        }

        return new JsonResponse($serviceData, 200);
    }
}
