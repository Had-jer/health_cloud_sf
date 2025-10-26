<?php

// namespace App\Security\Voter;

// use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
// use Symfony\Component\Security\Core\Authorization\Voter\Voter;
// use Symfony\Component\Security\Core\User\UserInterface;

// class DoctorVoter extends Voter
// {
//     public const ACCESS_DOCTOR = 'ACCESS_DOCTOR';

//     protected function supports(string $attribute, $subject): bool
//     {
//         return $attribute === self::ACCESS_DOCTOR;
//     }

//     protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
//     {
//         $user = $token->getUser();

//         if (!$user instanceof UserInterface) {
//             return false;
//         }

//         return $user->getStatus() === 'doctor';
//     }
// }
