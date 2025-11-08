<?php

namespace App\Dto\User;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;



class UserUpdateDto
{
    public function __construct(
       
        // Containte colonnes email (ENTITY)

       
        #[Assert\Email(
            message: 'Veuillez entrer une adresse e-mail valide.'
        )]
        private readonly ?string $email = null,

        // Containte colonnes password (ENTITY)

       
        #[Assert\Regex(
            pattern: '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&.,]{6,}$/',
            message: 'Le mot de passe doit contenir au moins une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial (@ $ ! % * ? &)'
        )]
        #[Assert\Length(
            min: 6,
            max: 4096,
            minMessage: 'Le mot de passe doit contenir au moins {{limit}} caractères',
            maxMessage: 'Le mot de pass ne doit pas contenir plus de {{limit}} caractères',
        )]
        // CURRENT PASWD
        private readonly ?string $currentPassword = null,

        #[Assert\Regex(
            pattern: '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&.,]{6,}$/',
            message: 'Le mot de passe doit contenir au moins une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial (@ $ ! % * ? &)'
        )]
        #[Assert\Length(
            min: 6,
            max: 4096,
            minMessage: 'Le mot de passe doit contenir au moins {{limit}} caractères',
            maxMessage: 'Le mot de pass ne doit pas contenir plus de {{limit}} caractères',
        )]
        private readonly ?string $newPassword = null,
        // Containte colonnes confirmation password(ENTITY)


     
        #[Assert\EqualTo(
            propertyPath: 'password',
            message: 'Les mots de passe doivent être identique',
        )]
        private readonly ?string $confirmNewPassword = null,

        // Containte colonnes phoneNumber(ENTITY)

       
        #[Assert\Regex(
            pattern: '/^(?:\+33|0)[1-9](?:[\s.-]?\d{2}){4}$/',
            message: 'Le numéro de téléphone doit être un numéro français valide'
        )]
        private readonly ?string $phoneNumber = null,
       

    ) {}

  


    /**
     * Get the value of email
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Get the value of confirmPassword
     */
    public function getConfirmNewPassword(): ?string
    {
        return $this->confirmNewPassword;
    }

    /**
     * Get the value of plainPassword
     */
    public function getCurrentPassword(): ?string
    {
        return $this->currentPassword;
    }
     /**
     * Get the value of newPassword
     */
    public function getNewPassword(): ?string
    {
        return $this->newPassword;
    }

    /**
     * Get the value of phoneNumber
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }


  
}
