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
use App\Mapper\MedicalEvent\MedEventCreateMapper;
use App\Mapper\MedicalEvent\MedEventUpdateMapper;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


use App\Entity\User;

#[Route('api/medicalEvent', name: 'api_med_event')]

class MedicalEventController extends AbstractController
{
    public function __construct(
        private UserRepository $userRepository,
        private EntityManagerInterface $em,
        private MedEventCreateMapper $medEventCreateMapper,
        private readonly MedicalEventRepository $medicalEventRepository,
        private readonly MedEventUpdateMapper $medEventUpdateMapper,
        


    ) {}
    #[Route('/create', name: 'register', methods: ['POST'])]

    public function create(#[MapRequestPayload]
    MedEventCreateDto $dto): JsonResponse
    {
        $connectedUser =  $this->getUser();
        $medicalEvent = $this->medEventCreateMapper->map($dto, $connectedUser);


        $this->em->persist($medicalEvent);

        $this->em->flush();

        return $this->json(
            [
                'id' => $medicalEvent->getId(),
            ],
            Response::HTTP_CREATED,
        );
    }

    // // UPDATE DOCTOR MEDICAL EVENT 
    // #[Route('/update', name: 'update', methods: ['PATCH'])]
    // public function update(
    //     int $id,
    //     #[MapRequestPayload]
    //     MedEventUpdateDto $dto
    // ): JsonResponse {

    //     $event = $this->medicalEventRepository->find($id);

    //     if (!$event) {
    //         throw new NotFoundHttpException('Événement médical introuvable');
    //     }

    //     $this->medicalEventRepository ->map($dto, $event);

    //     $this->em->flush();

    //     return $this->json($event, Response::HTTP_OK);

      
    // }
}
