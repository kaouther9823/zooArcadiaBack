<?php
// src/Controller/NouritureController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Nouriture;
use App\Repository\NouritureRepository;


 #[Route("/nouritures")]
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

    
     #[Route("/{id}", name: "nouriture_show", methods: ["GET"])]
     
    public function show($id): JsonResponse
    {
        $nouriture = $this->nouritureRepository->find($id);

        if (!$nouriture) {
            throw $this->createNotFoundException('Nouriture not found');
        }

        return $this->json($nouriture);
    }

    
     #[Route("/", name: "nouriture_create", methods: ["POST"])]
     
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $nouriture = new Nouriture();
        $nouriture->setLabel($data['label']);
        $nouriture->setDescription($data['description']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($nouriture);
        $entityManager->flush();

        return $this->json($nouriture);
    }

    
     #[Route("/{id}", name: "nouriture_update", methods: ["PUT"])]
     
    public function update($id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $entityManager = $this->getDoctrine()->getManager();
        $nouriture = $entityManager->getRepository(Nouriture::class)->find($id);

        if (!$nouriture) {
            throw $this->createNotFoundException('Nouriture not found');
        }

        $nouriture->setLabel($data['label']);
        $nouriture->setDescription($data['description']);

        $entityManager->flush();

        return $this->json($nouriture);
    }

    
     #[Route("/{id}", name: "nouriture_delete", methods: ["DELETE"])]
     
    public function delete($id): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $nouriture = $entityManager->getRepository(Nouriture::class)->find($id);

        if (!$nouriture) {
            throw $this->createNotFoundException('Nouriture not found');
        }

        $entityManager->remove($nouriture);
        $entityManager->flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
