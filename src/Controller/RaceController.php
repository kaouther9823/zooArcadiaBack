<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Race;
use App\Repository\RaceRepository;


 #[Route("/races")]
 
class RaceController extends AbstractController
{
    private $raceRepository;

    public function __construct(RaceRepository $raceRepository)
    {
        $this->raceRepository = $raceRepository;
    }

    
     #[Route("/", name: "race_index", methods: ["GET"])]
     
    public function index(): JsonResponse
    {
        $races = $this->raceRepository->findAll();

        return $this->json($races);
    }

    
     #[Route("/{id}", name: "race_show", methods: ["GET"])]
     
    public function show($id): JsonResponse
    {
        $race = $this->raceRepository->find($id);

        if (!$race) {
            throw $this->createNotFoundException('Race not found');
        }

        return $this->json($race);
    }

    
     #[Route("/", name: "race_create", methods: ["POST"])]
     
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $race = new Race();
        $race->setLabel($data['label']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($race);
        $entityManager->flush();

        return $this->json($race);
    }

    
     #[Route("/{id}", name: "race_update", methods: ["PUT"])]
     
    public function update($id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $entityManager = $this->getDoctrine()->getManager();
        $race = $entityManager->getRepository(Race::class)->find($id);

        if (!$race) {
            throw $this->createNotFoundException('Race not found');
        }

        $race->setLabel($data['label']);

        $entityManager->flush();

        return $this->json($race);
    }

    
     #[Route("/{id}", name: "race_delete", methods: ["DELETE"])]
     
    public function delete($id): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $race = $entityManager->getRepository(Race::class)->find($id);

        if (!$race) {
            throw $this->createNotFoundException('Race not found');
        }

        $entityManager->remove($race);
        $entityManager->flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
