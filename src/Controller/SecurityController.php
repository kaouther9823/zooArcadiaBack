<?php

namespace App\Controller;


use AllowDynamicProperties;
use App\Repository\UtilisateurRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;



#[AllowDynamicProperties] class SecurityController extends AbstractController
{

    public function __construct(LoggerInterface $logger, UserPasswordHasherInterface $passwordEncoder,
                                JWTTokenManagerInterface $JWTManager, UserProviderInterface $userProvider,
                                UtilisateurRepository $utilisateurRepository, $jwtAuthenticator)
    {
        $this->logger = $logger;
        $this->passwordEncoder = $passwordEncoder;
        $this->JWTManager = $JWTManager;
        $this->userProvider = $userProvider;
        $this->utilisateurRepository = $utilisateurRepository;
        $this->jwtAuthenticator = $jwtAuthenticator;

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
        $this->logger->debug('token:: {verif}', ['token'=> $token]);

        $response = new JsonResponse(['status' => 'success', 'token' => $token], 200);
        $response->headers->setCookie(
            Cookie::create('jwt_token', $token, time() + 3600, '/', null, false, true, false, 'strict')
        );
        return $response;
    }

    #[Route("/api/logout", name: "api_logout", methods: ("POST"))]
    public function logout(Request $request): Response
    {
        $response = new JsonResponse(['status' => 'success'], 200);
        // Supprimer le cookie JWT
        $response->headers->clearCookie('jwt_token');

        return $response->send();
    }

    public function refreshToken(Request $request, JWTTokenManagerInterface $JWTManager): JsonResponse
    {
        $jwt = $request->cookies->get('jwt_token');
        if (!$jwt) {
            return new JsonResponse(['error' => 'No token'], Response::HTTP_UNAUTHORIZED);
        }

        try {
            $payload = $JWTManager->parse($jwt);
            $newToken = $JWTManager->createFromPayload($payload['username'], $payload);

            $response = new JsonResponse(['status' => 'success']);
            $response->headers->setCookie(
                Cookie::create('jwt_token', $newToken, time() + 3600, '/', null, true, true)
            );
            return $response;
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Invalid token'], Response::HTTP_UNAUTHORIZED);
        }
    }

    /*#[Route('/api/status', methods: ['GET'])]
    public function authStatus(Request $request): JsonResponse
    {
        try {
            $authData = $this->jwtAuthenticator->authenticate($request); // Vérification du JWT dans le cookie
            return new JsonResponse([
                'authenticated' => true,
                'role' => $authData['role'],
                'firstname' => $authData['firstname'],
                'lastname' => $authData['lastname'],
            ]);
        } catch (AuthenticationException $exception) {
            return new JsonResponse([
                'authenticated' => false,
            ], Response::HTTP_UNAUTHORIZED);
        }
    }*/

    #[Route('/api/status', methods: ['GET'])]
    public function authStatus(Request $request, JWTTokenManagerInterface $jwtManager, LoggerInterface $logger): JsonResponse
    {
        try {
            // Récupérer le token JWT depuis le cookie
            $jwtToken = $request->cookies->get('jwt_token');

            if (!$jwtToken) {
                throw new AuthenticationException('JWT token not found in the request.');
            }

            // Décoder le JWT pour obtenir les données
            $authData = $jwtManager->parse($jwtToken);

            $logger->debug('Decoded JWT token data', ['authData' => $authData]);

            return new JsonResponse([
                'authenticated' => true,
                'role' => $authData['roles'] ?? null,
                'firstname' => $authData['firstname'] ?? null,
                'lastname' => $authData['lastname'] ?? null,
            ]);
        } catch (AuthenticationException $exception) {
            $logger->error('Authentication failed', ['error' => $exception->getMessage()]);
            return new JsonResponse([
                'authenticated' => false,
                'error' => $exception->getMessage(),
            ], Response::HTTP_UNAUTHORIZED);
        }
    }


}
