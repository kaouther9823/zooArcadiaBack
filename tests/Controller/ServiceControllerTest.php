<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Controller\ServiceController;
use App\Entity\Service;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ServiceControllerTest extends TestCase
{
    private ServiceRepository $serviceRepository;
    private EntityManagerInterface $entityManager;
    private LoggerInterface $logger;
    private CsrfTokenManagerInterface $csrfTokenManager;
    private SerializerInterface $serializer;
    private ServiceController $controller;

    protected function setUp(): void
    {
        $this->serviceRepository = $this->createMock(ServiceRepository::class);
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $this->serializer = $this->createMock(SerializerInterface::class);

        $this->controller = new ServiceController(
            $this->serviceRepository,
            $this->logger,
            $this->serializer,
            $this->entityManager,
            $this->csrfTokenManager
        );
    }

    public function testIndex(): void
    {
        // Mock data
        $service1 = new Service();
        $service1->setNom('Service 1');
        $service1->setDescription('Description 1');
        $service1->setServiceId(1);

        $service2 = new Service();
        $service2->setNom('Service 2');
        $service2->setDescription('Description 2');
        $service2->setServiceId(2);

        $this->serviceRepository->expects($this->once())
            ->method('findAll')
            ->willReturn([$service1, $service2]);

        // Act
        $response = $this->controller->index();

        // Assert
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame(200, $response->getStatusCode());
        $expected = [
            [
                'serviceId' => 1,
                'nom' => 'Service 1',
                'description' => 'Description 1',
            ],
            [
                'serviceId' => 2,
                'nom' => 'Service 2',
                'description' => 'Description 2',
            ],
        ];
        $this->assertJsonStringEqualsJsonString(json_encode($expected), $response->getContent());
    }

    public function testShow(): void
    {
        $service = new Service();
        $service->setNom('Service 1');
        $service->setDescription('Description 1');
        $service->setServiceId(1);

        $this->serviceRepository->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn($service);

        $response = $this->controller->show(1);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame(200, $response->getStatusCode());
        $expected = [
            'serviceId' => 1,
            'nom' => 'Service 1',
            'description' => 'Description 1',
        ];
        $this->assertJsonStringEqualsJsonString(json_encode($expected), $response->getContent());
    }

    public function testCreate(): void
    {
        $csrfToken = new CsrfToken('service_form', 'valid_csrf_token');
        $this->csrfTokenManager->expects($this->once())
            ->method('isTokenValid')
            ->with($csrfToken)
            ->willReturn(true);

        $this->entityManager->expects($this->once())
            ->method('persist');
        $this->entityManager->expects($this->once())
            ->method('flush');

        $request = new Request([], [], [], [], [], ['HTTP_X-CSRF-TOKEN' => 'valid_csrf_token'], json_encode([
            'nom' => 'Service 1',
            'description' => 'Description 1',
        ]));

        $response = $this->controller->create($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame(200, $response->getStatusCode());
    }

    public function testUpdate(): void
    {
        $service = new Service();
        $service->setNom('Old Service');
        $service->setDescription('Old Description');

        $csrfToken = new CsrfToken('service_form', 'valid_csrf_token');
        $this->csrfTokenManager->expects($this->once())
            ->method('isTokenValid')
            ->with($csrfToken)
            ->willReturn(true);

        $this->serviceRepository->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn($service);

        $this->entityManager->expects($this->once())
            ->method('flush');

        $request = new Request([], [], [], [], [], ['HTTP_X-CSRF-TOKEN' => 'valid_csrf_token'], json_encode([
            'nom' => 'Updated Service',
            'description' => 'Updated Description',
        ]));

        $response = $this->controller->update(1, $request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame(200, $response->getStatusCode());
    }

    public function testDelete(): void
    {
        $service = new Service();
        $csrfToken = new CsrfToken('service_form', 'valid_csrf_token');

        $this->csrfTokenManager->expects($this->once())
            ->method('isTokenValid')
            ->with($csrfToken)
            ->willReturn(true);

        $this->serviceRepository->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn($service);

        $this->entityManager->expects($this->once())
            ->method('remove')
            ->with($service);
        $this->entityManager->expects($this->once())
            ->method('flush');

        $request = new Request([], ['_csrf_token' => 'valid_csrf_token']);

        $response = $this->controller->delete(1, $request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame(204, $response->getStatusCode());
    }
}
