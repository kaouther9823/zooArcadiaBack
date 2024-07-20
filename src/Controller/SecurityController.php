<?php

namespace App\Controller;


use AllowDynamicProperties;
use App\Repository\UtilisateurRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;



#[AllowDynamicProperties] class SecurityController extends AbstractController
{

    public function __construct(LoggerInterface $logger, UserPasswordHasherInterface $passwordEncoder,
                                JWTTokenManagerInterface $JWTManager, UserProviderInterface $userProvider,
                                UtilisateurRepository $utilisateurRepository)
    {
        $this->logger = $logger;
        $this->passwordEncoder = $passwordEncoder;
        $this->JWTManager = $JWTManager;
        $this->userProvider = $userProvider;
        $this->utilisateurRepository = $utilisateurRepository;

    }

    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function login(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $this->logger->info(json_encode($data));

        $email = $data['username'];
        $password = $data['password'];

        $user = $this->userProvider->loadUserByIdentifier($email);


        $this->logger->debug('User {userId} has logged in', [
            'userId' => $user->getUserIdentifier(),
            'roles' => $user->getRoles()
        ]);
        $this->logger->debug('password verify {verif}', ['verif'=> $this->passwordEncoder->isPasswordValid($user, $password)]);
        // $this->logger->info(json_encode($user));
        if (!$user || !$this->passwordEncoder->isPasswordValid($user, $password)) {
            return $this->json(['message' => 'Invalid credentials'], Response::HTTP_UNAUTHORIZED);
        }
        $userObject = $this->utilisateurRepository->findOneBy(['username' => $email]);
        $token = $this->JWTManager->createFromPayload($user, [ 'username' => $user->getUserIdentifier(),
            'firstname' => $userObject->getPrenom(),
            'lastname' => $userObject->getNom(),
            'roles' => $user->getRoles()]);
        $this->logger->debug($token);
        return new JsonResponse(['status' => 'success', 'token' => $token], 200);
        #return $this->json([);
    }

    #[Route("/api/logout", name: "api_logout", methods: ("POST"))]

    public function logout(): void
    {
        // The actual logout is handled by Symfony, this is just a placeholder
    }

}
