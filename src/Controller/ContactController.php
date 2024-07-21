<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;


#[Route("/api/contact")]

class ContactController extends AbstractController
{
    private $logger;
    private $mailer;


    public function __construct(LoggerInterface $logger, MailerInterface $mailer,)
    {
        $this->logger = $logger;
        $this->mailer = $mailer;
    }
    #[Route("/", name: "contact_post", methods: ["POST"])]

    public function index(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        return $this->sendEmail($data);
    }

     public function sendEmail($data): JsonResponse
     {
        $email = (new Email())
            ->to($data['email'])
            ->from("contact@demomailtrap.com")
            ->priority(Email::PRIORITY_HIGH)
            ->subject('Demande de contact de la part de '.$data['nom'])
            ->html("<p>".$data['message']."</p>");
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            $this->logger->error("Le mail à destination de :" .$data['email']. " n'a pas pu être envoyé", (array)$e->getMessage());
        }
        return new JsonResponse(['message' => 'Demande de contact envoyée'], Response::HTTP_OK);
    }

}
