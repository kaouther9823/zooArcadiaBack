<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EtatRepository;


#[Route("/api/etats")]
class EtatController extends AbstractController
{
    private $etatRepository;

    public function __construct(EtatRepository $etatRepository)
    {
        $this->etatRepository = $etatRepository;
    }


    #[Route("/", name: "etat_index", methods: ["GET"])]

    public function index(): JsonResponse
    {
        $etats = $this->etatRepository->findAll();

        return $this->json($etats);
    }
    
}
