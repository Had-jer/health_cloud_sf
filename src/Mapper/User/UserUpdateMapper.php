<?php

namespace App\Mapper\User;

use App\Dto\User\UserUpdateDto;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class UserUpdateMapper
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {}

    public function map(UserUpdateDto $dto, User $user): User
    {



        if (null !== $dto->getEmail()) {
            $user->setEmail(
                $dto->getEmail()
            );
        }

        if (null !== $dto->getNewPassword()) {
            if (!$dto->getCurrentPassword()) {
                throw new NotFoundHttpException('Veuillez valider votre mot de passe actuel');
            }

            if (
                $this->passwordHasher->isPasswordValid($user, $dto->getCurrentPassword())
            ) {
                $user->setPassword(
                    $this->passwordHasher->hashPassword(
                        $user,
                        $dto->getNewPassword()
                    )
                );
            } else {
                throw new NotFoundHttpException('Le mot de passe actuel entrée n\'est pas correcte');
            }
        }
        if (null !== $dto->getPhoneNumber()) {
            $user->setPhoneNumber(
                $dto->getPhoneNumber()
            );
        }






        return $user;
    }
}
