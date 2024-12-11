<?php

namespace App\Controller;

use App\Document\Consultation;
use App\Repository\ConsultationRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\MongoDBException;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route("/api/consultations")]
class ConsultationController extends AbstractController
{
    private $serializer;
    private $logger;
    private $documentManager;
    private $consultationRepository;

    public function __construct( LoggerInterface $logger, SerializerInterface $serializer,
                                 DocumentManager $documentManager, ConsultationRepository $consultationRepository)
    {
        $this->logger = $logger;
        $this->serializer = $serializer;
        $this->documentManager = $documentManager;
        $this->consultationRepository = $consultationRepository;
    }
    /**
     * @throws MongoDBException
     */
    #[Route('/', name: 'consult_animal', methods: ['POST'])]
    public function consultAnimal(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $animalName = $data['prenom'] ?? null;
        $animalRace = $data['race']['label'] ?? null;
        $animalHabitat = $data['habitat']['nom'] ?? null;

        if (!$animalName) {
            return new JsonResponse(['error' => 'Animal name is required'], Response::HTTP_BAD_REQUEST);
        }

        $consultation = $this->consultationRepository->findOneByAnimalName($animalName);
        $logger = $this->logger;
        $logger->info("consultation", ['consultation' => $consultation]);

        if (!$consultation) {
            $consultation = new Consultation();
            $consultation->setAnimalName($animalName);
            $consultation->setAnimalHabitat($animalHabitat);
            $consultation->setAnimalRace($animalRace);
            $consultation->setCount(1);
        } else {
            $consultation->setCount($consultation->getCount() + 1);
        }

        $this->documentManager->persist($consultation);
        $this->documentManager->flush();

        return new JsonResponse(['message' => 'Consultation updated successfully', 'count' => $consultation->getCount()]);
    }


    #[Route('/', name: 'admin_dashboard', methods: ['GET'])]
    public function index(): Response
    {
        $consultations = $this->consultationRepository->findAll();
        $logger = $this->logger;
        $logger->info("consultations", ['consultations' => $consultations]);

        $consultationsData = $this->serializer->normalize($consultations, null, ['groups' => ['consultation:read']]);

        return new JsonResponse($consultationsData, Response::HTTP_OK);
    }
}