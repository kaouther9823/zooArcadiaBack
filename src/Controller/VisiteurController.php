<?php

namespace App\Controller;
use AllowDynamicProperties;
use App\Entity\Animal;
use App\Entity\AnimalImage;
use App\Entity\Habitat;
use App\Repository\AvisVisiteurRepository;
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

#[AllowDynamicProperties] #[Route("/visiteur")]
class VisiteurController extends AbstractController
{

    private $avisVisiteurController;
    private $serviceController;

    private $habitatController;
    private $animalController;
    private $horraireController;
    public function __construct(AvisVisiteurController $avisVisiteurController,
                                ServiceController $serviceController,
                                HabitatController $habitatController,
                                AnimalController $animalController,
                                HorraireController $horraireController,
                                LoggerInterface        $logger)
    {
        $this->avisVisiteurController = $avisVisiteurController;
        $this->logger = $logger;
        $this->serviceController = $serviceController;
        $this->habitatController = $habitatController;
        $this->animalController = $animalController;
        $this->horraireController = $horraireController;
    }

    #[Route("/avis", methods: ["GET"])]

    public function listAvis(): JsonResponse
    {
        return $this->avisVisiteurController->index();
    }
    #[Route("/avis", methods: ["POST"])]

    public function createAvis(Request $request): JsonResponse
    {
        return $this->avisVisiteurController->create($request);
    }


    #[Route("/services", methods: ["GET"])]

    public function listService(): JsonResponse
    {
        return $this->serviceController->listServicesWithImage();
    }
    #[Route("/habitats", methods: ["GET"])]

    public function listHabitats(): JsonResponse
    {
        return $this->habitatController->indexAll();
    }

    #[Route("/habitats/{id}/images", methods: ["GET"])]
    public function listImageByHabitats($id): JsonResponse
    {
        return $this->habitatController->listImage($id);
    }
    #[Route("/horraires", methods: ["GET"])]

    public function listHorraires(): JsonResponse
    {
        return $this->horraireController->index();
    }

}