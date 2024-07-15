<?php
// src/Controller/NouritureController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Nouriture;
use App\Repository\NouritureRepository;


 #[Route("/api/nouritures")]
class NouritureController extends AbstractController
{
    private $nouritureRepository;

    public function __construct(NouritureRepository $nouritureRepository)
    {
        $this->nouritureRepository = $nouritureRepository;
    }

    
     #[Route("/", name: "nouriture_index", methods: ["GET"])]
     
    public function index(): JsonResponse
    {
        $nouritures = $this->nouritureRepository->findAll();

        return $this->json($nouritures);
    }

}
