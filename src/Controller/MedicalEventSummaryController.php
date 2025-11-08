<?php
namespace App\Controller;

use App\Repository\MedicalEventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;



#[Route('api/medicalEventSummary', name: 'api_med_event_sum')]
class MedicalEventSummaryController extends AbstractController{
    // public function __construct(
    // private MedicalEventRepository $medicalEventRepository
    // ){}

    // #[Route('/create', name: 'register', methods: ['POST'])]
    // public function create(#[MapRequestPayload]
    // MedEventCreateDto $dto): JsonResponse
    // {
    //     $connectedUser =  $this->getUser();
    //     $medicalEvent = $this->medEventSumCreateMapper->map($dto, $connectedUser);


    //     $this->em->persist($medicalEvent);

    //     $this->em->flush();

    //     return $this->json(
    //         [
    //             'id' => $medicalEvent->getId(),
    //         ],
    //         Response::HTTP_CREATED,
    //     );
    // }

}