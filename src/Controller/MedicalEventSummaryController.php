<?php


namespace App\Controller;

use App\Repository\MedicalEventSummaryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use App\Dto\MedicalEventSummary\MedEventSumCreateDto;
use App\Dto\MedicalEventSummary\MedEventSumUpdateDto;
use App\Mapper\MedicalEventSummary\MedEventSumCreateMapper;
use App\Mapper\MedicalEventSummary\MedEventSumUpdateMapper;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\MedicalEvent;
use App\Entity\MedicalEventSummary;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Security\Voter\MedicalEventSummaryVoter;

#[Route('api/medicalEventSummary', name: 'api_med_event_sum')]
class MedicalEventSummaryController extends AbstractController
{
    public function __construct(
        private MedicalEventSummaryRepository $medicalEventSummaryRepository,
        private EntityManagerInterface $em,
        private MedEventSumCreateMapper $medEventSumCreateMapper,
        private MedEventSumUpdateMapper $medEventSumUpdateMapper,
    ) {}

    /**
     * Créer un résumé d'événement médical
     * Accessible uniquement aux docteurs
     */
    #[Route('/create/{id}', name: 'create', methods: ['POST'])]
    #[IsGranted(MedicalEventSummaryVoter::CREATE)]
    public function create(
        MedicalEvent $medicalEvent,
        #[MapRequestPayload] MedEventSumCreateDto $dto,
    ): JsonResponse {
        $medicalEventSummary = $this->medEventSumCreateMapper->map($dto, $medicalEvent);

        $this->em->persist($medicalEventSummary);
        $this->em->flush();

        return $this->json(
            ['id' => $medicalEventSummary->getId()],
            Response::HTTP_CREATED,
            context: ['groups' => ['medical_event:read']]
        );
    }

    /**
     * Modifier un résumé d'événement médical
     * Accessible uniquement aux docteurs
     */
    #[Route('/update/{id}', name: 'update', methods: ['PATCH'])]
    #[IsGranted(MedicalEventSummaryVoter::EDIT, subject: 'medicalEventSummary')]
    public function update(
        MedicalEventSummary $medicalEventSummary,
        #[MapRequestPayload] MedEventSumUpdateDto $dto,
    ): JsonResponse {
        $this->medEventSumUpdateMapper->map($dto, $medicalEventSummary);

        $this->em->flush();

        return $this->json(
            ['id' => $medicalEventSummary->getId()],
            Response::HTTP_OK,
            context: ['groups' => ['medical_event:read']]
        );
    }

    /**
     * Afficher un résumé d'événement médical
     * Accessible à tous les utilisateurs authentifiés
     */
    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(MedicalEventSummary $medicalEventSummary): JsonResponse
    {
        return $this->json(
            $this->medicalEventSummaryRepository->findOneBy(['id' => $medicalEventSummary->getId()]),
            Response::HTTP_OK,
            context: ['groups' => ['medical_event:read']]
        );
    }

    /**
     * Supprimer un résumé d'événement médical
     * Accessible uniquement aux docteurs
     */
    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    #[IsGranted(MedicalEventSummaryVoter::DELETE, subject: 'medicalEventSummary')]
    public function delete(MedicalEventSummary $medicalEventSummary): JsonResponse
    {
        $this->em->remove($medicalEventSummary);
        $this->em->flush();

        return $this->json([], Response::HTTP_OK);
    }
}
