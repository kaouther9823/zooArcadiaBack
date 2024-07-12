<?php

declare(strict_types=1);

// src/Controller/AnimalController.php
namespace App\Controller;

use App\Entity\AnimalImage;
use App\Repository\AnimalImageRepository;
use App\Repository\EtatRepository;
use App\Repository\HabitatRepository;
use App\Repository\RaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Animal;
use App\Repository\AnimalRepository;
use Symfony\Component\Serializer\SerializerInterface;


#[Route("/api/animaux")]
class AnimalController extends AbstractController
{
    private $animalRepository;
    private $habitatRepository;
    private $raceRepository;
    private $etatRepository;
    private $entityManager;
private $animalImageRepository;
    private $logger;

    private $serializer;

    public function __construct(AnimalRepository       $animalRepository, HabitatRepository $habitatRepository,
                                RaceRepository         $raceRepository, EtatRepository $etatRepository,
                                EntityManagerInterface $entityManager, LoggerInterface $logger,
                                SerializerInterface $serializer, AnimalImageRepository $animalImageRepository)
    {
        $this->animalRepository = $animalRepository;
        $this->habitatRepository = $habitatRepository;
        $this->raceRepository = $raceRepository;
        $this->etatRepository = $etatRepository;
        $this->entityManager = $entityManager;
        $this->logger = $logger;
        $this->serializer = $serializer;
        $this->animalImageRepository = $animalImageRepository;
    }

    #[Route("/", name: "animal_index", methods: ["GET"])]
    public function index(): JsonResponse
    {
        $animals = $this->animalRepository->findAll();
        return $this->json($animals);
    }

    #[Route("/habitat/{id}", name: "animal_index_by_habitat", methods: ["GET"])]
    public function indexVByHabitat($id): JsonResponse
    {
        $animals = $this->animalRepository->findByHabitat($id);

/*        $animalsData = [];
        foreach ($animals as $animal) {
            $animalsData[] = [
                'id' => $animal->getId(),
                'race' => $animal->getRace(),
                'etat' => $animal->getEtat(),
                'prenom' => $animal->getPrenom(),
            ];
        }*/

        $animalData = $this->serializer->normalize($animals, null, ['groups' => ['animal:read']]);

        return new JsonResponse($animalData, JsonResponse::HTTP_OK);
    }


    #[Route("/{id}", name: "animal_show", methods: ["GET"])]
    public function show($id): JsonResponse
    {
        $animal = $this->animalRepository->find($id);
        if (!$animal) {
            throw $this->createNotFoundException('Animal not found');
        }
        $animalData = $this->serializer->normalize($animal, null, ['groups' => ['animal:read']]);

        return new JsonResponse($animalData, JsonResponse::HTTP_OK);
    }

    #[Route("/", name: "animal_create", methods: ["POST"])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $habitat = $this->habitatRepository->find($data['habitatId']);
        $animal = new Animal();
        $animal->setPrenom($data['prenom']);
        $animal->setEtat($this->etatRepository->find($data['etatId']));
        $animal->setHabitat($habitat);
        $animal->setRace($this->raceRepository->find($data['raceId']));
        $this->entityManager->persist($animal);
        $this->entityManager->flush();

        $animalData = $this->serializer->normalize($animal, null, ['groups' => ['animal:read']]);

        return new JsonResponse($animalData, JsonResponse::HTTP_OK);
    }

    #[Route("/{id}", name: "animal_update", methods: ["PUT"])]
    public function update($id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $animal = $this->animalRepository->find($id);
        if (!$animal) {
            throw $this->createNotFoundException('Animal not found');
        }
        $habitat = $this->habitatRepository->find($data['habitatId']);
        $animal->setPrenom($data['prenom']);
        $animal->setEtat($this->etatRepository->find($data['etatId']));
        $animal->setHabitat($habitat);
        $animal->setRace($this->raceRepository->find($data['raceId']));
        $this->entityManager->persist($animal);
        $this->entityManager->flush();
        $animalData = $this->serializer->normalize($animal, null, ['groups' => ['animal:read']]);

        return new JsonResponse($animalData, JsonResponse::HTTP_OK);
    }


    #[Route("/{id}", name: "animal_delete", methods: ["DELETE"])]
    public function delete($id): JsonResponse
    {
        $animal = $this->animalRepository->find($id);

        if (!$animal) {
            throw $this->createNotFoundException('Animal not found');
        }
        $this->entityManager->remove($animal);
        $this->entityManager->flush();
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }

    #[Route("/{id}/images", name: "animal_list_image", methods: ["GET"])]

    public function listImage($id): JsonResponse
    {

        $animal = $this->animalRepository->find($id);

        if (!$animal) {
            throw $this->createNotFoundException('Animal not found');
        }
        $animalData = [];
        foreach ($animal->getImages() as $image) {
            $animalData[] = [
                'imageId' => $image->getImageId(),
                'id' => $animal->getId(),
                'base64Data' => $image->getBase64Data()
            ];
        }

        return new JsonResponse($animalData, 200);
    }

    function sanitize_utf8($data)
    {
        if (is_string($data)) {
            return mb_check_encoding($data, 'UTF-8') ? $data : mb_convert_encoding($data, 'UTF-8', 'ISO-8859-1');
        } elseif (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = sanitize_utf8($value);
            }
        } elseif (is_object($data)) {
            foreach ($data as $key => $value) {
                $data->$key = sanitize_utf8($value);
            }
        }
        return $data;
    }
    #[Route("/images/{idImage}", name: "animal_get_images", methods: ("GET"))]
    public function getImage(int $idImage): Response
    {
        $image = $this->animalImageRepository->find($idImage);

        if (!$image) {
            return new Response('Image not found', Response::HTTP_NOT_FOUND);
        }
        $animalData = [
            'imageId' => $image->getImageId(),
            'animalId' => $image->getAnimal()->getId(),
            'base64Data' => $image->getBase64Data()
        ];

        return new JsonResponse($animalData, 200);
    }

    #[Route("/{id}/upload", name: "animal_images_upload", methods: ["POST"])]
    public function uploadImagesForAnimal(Request $request, int $id): JsonResponse
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

        $animal = $this->animalRepository->find($id);
        if (!$animal) {
            $this->logger->error('Animal not found');
            return new JsonResponse('Animal not found', Response::HTTP_NOT_FOUND);
        }

        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                try {
                    $imageData = file_get_contents($file->getPathname());
                    $animalImage = new AnimalImage();
                    $animalImage->setAnimal($animal);
                    $animalImage->setImageData($imageData);
                    $this->entityManager->persist($animalImage);
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

    #[Route("/images/{id}", name: "animak_image_delete", methods: ["DELETE"])]

    public function deleteImage($id): JsonResponse
    {
        $image = $this->animalImageRepository->find($id);

        if (!$image) {
            throw $this->createNotFoundException('Image not found');
        }

        $this->entityManager->remove($image);
        $this->entityManager->flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}