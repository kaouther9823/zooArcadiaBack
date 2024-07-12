<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Race;
use App\Repository\RaceRepository;


 #[Route("/api/races")]
 
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

}
