<?php

namespace App\Controller;

use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Dto\User\UserRegisterDto;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use App\Mapper\User\UserRegisterMapper;
use Symfony\Component\HttpFoundation\Response;
use App\Mapper\User\UserUpdateMapper;
use App\Dto\User\UserUpdateDto;
use App\Entity\User;





#[Route('api', name: 'api_users_')]
class UserController extends AbstractController
{
    public function __construct(
        private UserRepository $userRepository,
        private EntityManagerInterface $em,
        private UserRegisterMapper $userRegisterMapper,
        private UserUpdateMapper $userUpdateMapper,

    ) {}
    // read user
    #[Route('/profile', name: 'show_profile', methods: ['GET'])]
    public function show(): JsonResponse
    {
        $user =  $this->getUser();

        return $this->json(
            $user,
            Response::HTTP_OK,
        );
    }
    //  CREATE USER 
    #[Route('/register', name: 'register', methods: ['POST'])]
    public function register(
        #[MapRequestPayload]
        UserRegisterDto $dto
    ): JsonResponse {


        $user = $this->userRegisterMapper->map($dto);


        $this->em->persist($user);

        $this->em->flush();

        return $this->json(
            [
                'id' => $user->getId(),
            ],
            Response::HTTP_CREATED,
        );
    }

    // update user

    #[Route('/profile', name: 'update', methods: ['PATCH'])]
    public function update(
        #[MapRequestPayload]
        UserUpdateDto $dto
    ): JsonResponse {
        $connectedUser =  $this->getUser();
        $email = $connectedUser->getUserIdentifier();
        $user = $this->userRepository->findOneBy(['email' => $email]);

        $this->userUpdateMapper->map($dto, $user);

        $this->em->flush();

        return $this->json([
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
        ],
        Response::HTTP_OK,
    );
    }

    // delete user
    #[Route('/profile', name: 'delete', methods: ['DELETE'])]
    public function delete(): JsonResponse
    {
        $user =  $this->getUser();

        $this->em->remove($user);
        $this->em->flush();

        return $this->json(
            [],
            Response::HTTP_OK,
        );
    }
}
