<?php


namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\HttpFoundation\Cookie;

class JWTListener
{
    private JWTTokenManagerInterface $jwtManager;

    public function __construct(JWTTokenManagerInterface $jwtManager)
    {
        $this->jwtManager = $jwtManager;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        // Récupérer le JWT depuis le cookie
        $jwt = $request->cookies->get('jwt_token');
        if (!$jwt) {
            // Si pas de token, laisser passer, l'utilisateur n'est pas authentifié
            return;
        }

        try {
            // Décoder et valider le JWT
            $payload = $this->jwtManager->parse($jwt);

            // Vous pouvez attacher l'utilisateur au token si nécessaire
            // Par exemple en définissant l'utilisateur courant pour cette session
            // $user = $this->userRepository->find($payload['username']);
            // $request->getSession()->set('_security_main', serialize($user));

        } catch (\Exception $e) {
            throw new AuthenticationException('Invalid JWT token');
        }
    }
}
