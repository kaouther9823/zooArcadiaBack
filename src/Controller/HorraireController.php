<?php

namespace App\Controller;

use App\Repository\HorraireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/horraire')]
class HorraireController extends AbstractController {

    private $horraireRepository;
    private $entityManager;

    public function __construct(HorraireRepository $horraireRepository, EntityManagerInterface $entityManager)
{
    $this->$horraireRepository = $horraireRepository;
}


    #[Route('/', name: 'app_horraire_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $horraires = $this->horraireRepository->findAll();

        return $this->json($horraires);
    }


    #[Route('/{jour}/', name: 'app_horraire_edit', methods: ['POST'])]
    public function edit(Request $request, string $jour): Response
    {
        $data = json_decode($request->getContent(), true);
        $horraire = $this->horraireRepository->find($jour);
        if (!$horraire) {
            throw $this->createNotFoundException('Horraire not found');
        }
        $horraire->setNom($data['heure_ouverture']);
        $horraire->setDescription($data['heure_fermeture']);
        $this->entityManager->flush();
        return $this->json($horraire);
    }


}
