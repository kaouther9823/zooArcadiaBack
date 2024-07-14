<?php

declare(strict_types=1);

// src/Controller/RoleController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Role;
use App\Repository\RoleRepository;


 #[Route("/api/roles")]
 
class RoleController extends AbstractController
{
    private $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    
     #[Route("/", name: "role_index", methods: ["GET"])]
     
    public function index(): JsonResponse
    {
        $roles = $this->roleRepository->findAll();

        return $this->json($roles);
    }

    
     #[Route("/{id}", name: "role_show", methods: ["GET"])]
     
    public function show($id): JsonResponse
    {
        $role = $this->roleRepository->find($id);

        if (!$role) {
            throw $this->createNotFoundException('Role not found');
        }

        return $this->json($role);
    }

    
     #[Route("/", name: "role_create", methods: ["POST"])]
     
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $role = new Role();
        $role->setLabel($data['label']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($role);
        $entityManager->flush();

        return $this->json($role);
    }

    
     #[Route("/{id}", name: "role_update", methods: ["PUT"])]
     
    public function update($id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $entityManager = $this->getDoctrine()->getManager();
        $role = $entityManager->getRepository(Role::class)->find($id);

        if (!$role) {
            throw $this->createNotFoundException('Role not found');
        }

        $role->setLabel($data['label']);

        $entityManager->flush();

        return $this->json($role);
    }

    
     #[Route("/{id}", name: "role_delete", methods: ["DELETE"])]
     
    public function delete($id): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $role = $entityManager->getRepository(Role::class)->find($id);

        if (!$role) {
            throw $this->createNotFoundException('Role not found');
        }

        $entityManager->remove($role);
        $entityManager->flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
