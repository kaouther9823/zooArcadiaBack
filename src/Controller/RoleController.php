<?php

declare(strict_types=1);

// src/Controller/RoleController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
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


}
