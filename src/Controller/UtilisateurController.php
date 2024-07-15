<?php

declare(strict_types=1);
namespace App\Controller;
use App\Repository\RoleRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Symfony\Component\Serializer\SerializerInterface;


#[Route("/api/users")]
 
class UtilisateurController extends AbstractController
{
    private $utilisateurRepository;
    private $roleRepository;
    private $entityManager;
     private $serializer;
     private $mailer;

     private $logger;

     public function __construct(UtilisateurRepository $utilisateurRepository, SerializerInterface $serializer,
                                 RoleRepository $roleRepository, EntityManagerInterface $entityManager,
                                 MailerInterface $mailer, LoggerInterface $logger)
    {
        $this->utilisateurRepository = $utilisateurRepository;
        $this->roleRepository = $roleRepository;
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
        $this->mailer = $mailer;
        $this->logger = $logger;
    }

    
     #[Route("/", name: "utilisateur_index", methods: ["GET"])]
     
    public function index(): JsonResponse
    {
        $utilisateurs = $this->utilisateurRepository->findAll();

        $data = $this->serializer->normalize($utilisateurs, null, ['groups' => ['utilisateur:read']]);

        return new JsonResponse($data, Response::HTTP_OK);
    }

    
     #[Route("/{id}", name: "utilisateur_show", methods: ["GET"])]
     
    public function show($id): JsonResponse
    {
        $utilisateur = $this->utilisateurRepository->find($id);

        if (!$utilisateur) {
            throw $this->createNotFoundException('Utilisateur not found');
        }

        $data = $this->serializer->normalize($utilisateur, null, ['groups' => ['utilisateur:read']]);

        return new JsonResponse($data, Response::HTTP_OK);
    }

    
     #[Route("/", name: "utilisateur_create", methods: ["POST"])]
     
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $utilisateur = new Utilisateur();
        $utilisateur->setRole($this->roleRepository->find($data['role']));
        $utilisateur->setUsername($data['username']);
        $utilisateur->setPassword($data['password']);
        $utilisateur->setNom($data['nom']);
        $utilisateur->setPrenom($data['prenom']);

        try {
            $this->entityManager->persist($utilisateur);
            $this->entityManager->flush();
        }catch (UniqueConstraintViolationException $e){
            $data = ['message' => "l'adresse mail".$data['username']." est dejà attribué à un autre utilisateur"];
            $this->logger->critical("Utilisateur creation failed with message: {$e->getMessage()}");
            return new JsonResponse($data, Response::HTTP_CONFLICT);
        }

        $data = $this->serializer->normalize($utilisateur, null, ['groups' => ['utilisateur:read']]);
        if ($utilisateur->getUserId()) {
            $this->sendEmail($utilisateur);
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    
     #[Route("/{id}", name: "utilisateur_update", methods: ["PUT"])]
     
    public function update($id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $utilisateur = $this->utilisateurRepository->find($id);

        if (!$utilisateur) {
            throw $this->createNotFoundException('Utilisateur not found');
        }

        $utilisateur->setRole($this->roleRepository->find($data['role_id']));
        $utilisateur->setUsername($data['username']);
        $utilisateur->setPassword($data['password']);
        $utilisateur->setNom($data['nom']);
        $utilisateur->setPrenom($data['prenom']);

        $this->entityManager->flush();

        $data = $this->serializer->normalize($utilisateur, null, ['groups' => ['utilisateur:read']]);

        return new JsonResponse($data, Response::HTTP_OK);
    }

    
     #[Route("/{id}", name: "utilisateur_delete", methods: ["DELETE"])]
     
    public function delete($id): JsonResponse
    {
        $utilisateur = $this->utilisateurRepository->find($id);

        if (!$utilisateur) {
            throw $this->createNotFoundException('Utilisateur not found');
        }

        $this->entityManager->remove($utilisateur);
        $this->entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    public function sendEmail(Utilisateur $user): Response
    {
        $email = (new Email())
            //->from('hello@example.com')
            ->to($user->getUsername())
            ->priority(Email::PRIORITY_HIGH)
            ->subject('Inscription au site Arcadia')
            ->text('Sending emails is fun again!')
            ->html("<p>Vous êtes inscrit au site Arcadia zoo. Veuillez contacter l\'administrateur pour récupérer votre mot de passe</p>");

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            $this->logger->error("Le mail à destination" .$user->getUsername(). " n'a pas pu être envoyé", $e->getMessage());
        }
        return new Response(null, Response::HTTP_OK);
    }
}
