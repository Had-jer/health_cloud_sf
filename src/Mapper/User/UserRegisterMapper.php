<?php

namespace App\Mapper\User;

use App\Dto\User\UserRegisterDto;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class UserRegisterMapper
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {}

    public function map(UserRegisterDto $dto): User
    {
        $user = new User;

        if (null !== $dto->getFirstName()) {
            $user->setFirstName(
                $dto->getFirstName()
            );
        }

        if (null !== $dto->getLastName()) {
            $user->setLastName(
                $dto->getLastName()
            );
        }

        if (null !== $dto->getEmail()) {
            $user->setEmail(
                $dto->getEmail()
            );
        }

        if (null !== $dto->getPassword()) {
            $user->setPassword(
                $this->passwordHasher->hashPassword(
                    $user,
                    $dto->getPassword()
                )
            );
        }
        if (null !== $dto->getPhoneNumber()) {
            $user->setPhoneNumber(
                $dto->getPhoneNumber()
            );
        }

        if (null !== $dto->getBirthDate()) {
            $user->setBirthDate(new \DateTime($dto->getBirthDate()));

        }
        if (null !== $dto->getStatus()) {
            $user->setStatus($dto->getStatus());

        }
        if (null !== $dto->getMedicalSpeciality()) {

            if($dto->getStatus()!== "doctor"){
                throw new NotFoundHttpException('Vous ne pouvez pas choisir de spécialité si vous êtes un patient');
            } else {
                $user->setMedicalSpeciality($dto->getMedicalSpeciality());
            }


           

        }

    
        
       


        return $user;
    }
}