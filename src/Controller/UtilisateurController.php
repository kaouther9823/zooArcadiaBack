<?php

declare(strict_types=1);
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;


 #[Route("/utilisateurs")]
 
class UtilisateurController extends AbstractController
{
    private $utilisateurRepository;

    public function __construct(UtilisateurRepository $utilisateurRepository)
    {
        $this->utilisateurRepository = $utilisateurRepository;
    }

    
     #[Route("/", name: "utilisateur_index", methods: ["GET"])]
     
    public function index(): JsonResponse
    {
        $utilisateurs = $this->utilisateurRepository->findAll();

        return $this->json($utilisateurs);
    }

    
     #[Route("/{id}", name: "utilisateur_show", methods: ["GET"])]
     
    public function show($id): JsonResponse
    {
        $utilisateur = $this->utilisateurRepository->find($id);

        if (!$utilisateur) {
            throw $this->createNotFoundException('Utilisateur not found');
        }

        return $this->json($utilisateur);
    }

    
     #[Route("/", name: "utilisateur_create", methods: ["POST"])]
     
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $utilisateur = new Utilisateur();
        $utilisateur->setRole($this->getDoctrine()->getRepository(Role::class)->find($data['role_id']));
        $utilisateur->setUsername($data['username']);
        $utilisateur->setPassword($data['password']);
        $utilisateur->setNom($data['nom']);
        $utilisateur->setPrenom($data['prenom']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($utilisateur);
        $entityManager->flush();

        return $this->json($utilisateur);
    }

    
     #[Route("/{id}", name: "utilisateur_update", methods: ["PUT"])]
     
    public function update($id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $entityManager = $this->getDoctrine()->getManager();
        $utilisateur = $entityManager->getRepository(Utilisateur::class)->find($id);

        if (!$utilisateur) {
            throw $this->createNotFoundException('Utilisateur not found');
        }

        $utilisateur->setRole($this->getDoctrine()->getRepository(Role::class)->find($data['role_id']));
        $utilisateur->setUsername($data['username']);
        $utilisateur->setPassword($data['password']);
        $utilisateur->setNom($data['nom']);
        $utilisateur->setPrenom($data['prenom']);

        $entityManager->flush();

        return $this->json($utilisateur);
    }

    
     #[Route("/{id}", name: "utilisateur_delete", methods: ["DELETE"])]
     
    public function delete($id): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $utilisateur = $entityManager->getRepository(Utilisateur::class)->find($id);

        if (!$utilisateur) {
            throw $this->createNotFoundException('Utilisateur not found');
        }

        $entityManager->remove($utilisateur);
        $entityManager->flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
