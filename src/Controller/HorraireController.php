<?php

namespace App\Controller;

use App\Entity\Horraire;
use App\Repository\HorraireRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/horraires')]
class HorraireController extends AbstractController {

    private $horraireRepository;
    private $entityManager;

    public function __construct(HorraireRepository $horraireRepository, EntityManagerInterface $entityManager)
{
    $this->horraireRepository = $horraireRepository;
    $this->entityManager = $entityManager;
}


    #[Route('/', name: 'app_horraire_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $formatedHorraires= [];
        $horraires = $this->horraireRepository->findAll();
        foreach ($horraires as $horraire) {
            $formatedHorraires[] = $horraire->getFormattedData();
        }

        return $this->json($formatedHorraires);
    }


    #[Route('', name: 'app_horraire_edit', methods: ['POST'])]
    public function edit(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!is_array($data)) {
            return new JsonResponse(['message' => 'Invalid data format'], Response::HTTP_BAD_REQUEST);
        }

        foreach ($data as $item) {
            if (!isset($item['day'], $item['openingTime'], $item['closingTime'])) {
                continue; // Skip invalid entries
            }

            $day = $item['day'];
            $openingTime = DateTime::createFromFormat('H:i', $item['openingTime']);
            $closingTime = DateTime::createFromFormat('H:i', $item['closingTime']);

            if (!$openingTime || !$closingTime) {
                continue; // Skip invalid time formats
            }

            // Find existing Horaire or create a new one
            $horaire = $this->horraireRepository->find($day) ?? new Horraire();
            $horaire->setJour($day);
            $horaire->setHeureOuverture($openingTime);
            $horaire->setHeureFermeture($closingTime);

            // Persist the Horaire entity
            $this->entityManager->persist($horaire);
        }

        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Horaires updated successfully'], Response::HTTP_OK);
    }

}
