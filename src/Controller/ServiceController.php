<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Service;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route("/api/services")]
class ServiceController extends AbstractController
{
    private $serviceRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(ServiceRepository $serviceRepository, EntityManagerInterface $entityManager)
    {
        $this->serviceRepository = $serviceRepository;
        $this->entityManager = $entityManager;
    }

    #[Route("/", name: "service_index", methods: ["GET"])]
    public function index(): JsonResponse
    {
        $services = $this->serviceRepository->findAll();
        return $this->json($services);
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
        $service->setImagePath($data['imagePath']);
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
        $service->setImagePath($data['imagePath']);
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
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
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

}
