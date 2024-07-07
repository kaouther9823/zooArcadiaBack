<?php

declare(strict_types=1);

// src/Controller/AnimalController.php
namespace App\Controller;

use App\Repository\HabitatRepository;
use App\Repository\RaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Animal;
use App\Repository\AnimalRepository;


#[Route("/animals")]
class AnimalController extends AbstractController
{
private $animalRepository;
private $habitatRepository;
private $raceRepository;

private $entityManager;

public function __construct(AnimalRepository $animalRepository, HabitatRepository $habitatRepository,
                            RaceRepository $raceRepository, EntityManagerInterface $entityManager)
{
$this->animalRepository = $animalRepository;
$this->habitatRepository = $habitatRepository;
$this->raceRepository = $raceRepository;
$this->entityManager = $entityManager;
}

#[Route("/", name: "animal_index", methods: ["GET"])]
public function index(): JsonResponse
{
    $animals = $this->animalRepository->findAll();
    return $this->json($animals);
}

#[Route("/{id}", name: "animal_show", methods: ["GET"])]
public function show($id): JsonResponse
{
    $animal = $this->animalRepository->find($id);
    if (!$animal) {
        throw $this->createNotFoundException('Animal not found');
    }
    return $this->json($animal);
}

#[Route("/", name: "animal_create", methods: ["POST"])]
public function create(Request $request): JsonResponse
{
    $data = json_decode($request->getContent(), true);
    $animal = new Animal();
    $animal->setPrenom($data['prenom']);
    $animal->setEtat($data['etat']);
    $animal->setHabitat($this->habitatRepository->find($data['habitat_id']));
    $animal->setRace($this->raceRepository->find($data['race_id']));
    $this->entityManager->persist($animal);
    $this->entityManager->flush();
    return $this->json($animal);
}


 #[Route("/{id}", name: "animal_update", methods: ["PUT"])]
 
public function update($id, Request $request): JsonResponse
{
    $data = json_decode($request->getContent(), true);
    $animal = $this->animalRepository->find($id);
    if (!$animal) {
        throw $this->createNotFoundException('Animal not found');
    }
    $animal->setPrenom($data['prenom']);
    $animal->setEtat($data['etat']);
    $animal->setHabitat($this->habitatRepository->find($data['habitat_id']));
    $animal->setRace($this->raceRepository->find($data['race_id']));
    $this->entityManager->flush();
    return $this->json($animal);
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
}
