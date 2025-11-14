<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserRepository;
use App\Repository\MedicalEventRepository;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpFoundation\Response;
use App\Dto\MedicalEvent\MedEventCreateDto;
use App\Dto\MedicalEvent\MedEventUpdateDto;
use App\Entity\MedicalEvent;
use App\Mapper\MedicalEvent\MedEventCreateMapper;
use App\Mapper\MedicalEvent\MedEventUpdateMapper;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Security\Voter\MedicalEventVoter;
use App\Entity\User;

#[Route('api/medicalEvent', name: 'api_med_event')]
class MedicalEventController extends AbstractController
{
    public function __construct(
        private UserRepository $userRepository,
        private EntityManagerInterface $em,
        private MedEventCreateMapper $medEventCreateMapper,
        private MedicalEventRepository $medicalEventRepository,
        private MedEventUpdateMapper $medEventUpdateMapper,
    ) {}

    /**
     * Méthode 1: Utiliser l'attribut #[IsGranted]
     * C'est la méthode la plus simple et recommandée
     */
    #[Route('/create', name: 'register', methods: ['POST'])]
    #[IsGranted(MedicalEventVoter::CREATE)]
    public function create(
        #[MapRequestPayload] MedEventCreateDto $dto
    ): JsonResponse {
        $connectedUser = $this->getUser();
        $medicalEvent = $this->medEventCreateMapper->map($dto, $connectedUser);

        $this->em->persist($medicalEvent);
        $this->em->flush();

        return $this->json(
            ['id' => $medicalEvent->getId()],
            Response::HTTP_CREATED,
        );
    }

    /**
     * Méthode 2: Utiliser denyAccessUnlessGranted() dans le code
     * Plus flexible si tu as besoin de logique conditionnelle
     */
    #[Route('/update/{id}', name: 'update', methods: ['PATCH'])]
    public function update(
        MedicalEvent $medicalEvent,
        #[MapRequestPayload] MedEventUpdateDto $dto
    ): JsonResponse {
        // Vérifier la permission AVANT de faire quoi que ce soit
        $this->denyAccessUnlessGranted(MedicalEventVoter::EDIT, $medicalEvent);

        $event = $this->medicalEventRepository->find($medicalEvent);

        if (!$event) {
            throw new NotFoundHttpException('Événement médical introuvable');
        }

        $this->medEventUpdateMapper->map($dto, $event);
        $this->em->flush();

        return $this->json(
            $event,
            Response::HTTP_OK,
            context: ['groups' => ['medical_event:read']]
        );
    }

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $connectedUser = $this->getUser();
        $email = $connectedUser->getUserIdentifier();
        $user = $this->userRepository->findOneBy(['email' => $email]);

        $medicalEvents = $this->medicalEventRepository->findByUser($user);

        return $this->json(
            $medicalEvents,
            Response::HTTP_OK,
            context: ['groups' => ['medical_event:read']]
        );
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(MedicalEvent $medicalEvent): JsonResponse
    {
        $connectedUser = $this->getUser();
        $email = $connectedUser->getUserIdentifier();
        $user = $this->userRepository->findOneBy(['email' => $email]);

        return $this->json(
            $this->medicalEventRepository->findOneByUser($user, $medicalEvent),
            Response::HTTP_OK,
            context: ['groups' => ['medical_event:read']]
        );
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    #[IsGranted(MedicalEventVoter::DELETE, subject: 'medicalEvent')]
    public function delete(MedicalEvent $medicalEvent): JsonResponse
    {
        $this->em->remove($medicalEvent);
        $this->em->flush();

        return $this->json([], Response::HTTP_OK);
    }
}