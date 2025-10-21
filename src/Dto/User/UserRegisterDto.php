<?php

namespace App\Dto\User;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


// #[UniqueEntity(
//     fields: ['email'],
//     entityClass: User::class,
//     message: 'Cet email n\'est plus disponible'
// )]
class UserRegisterDto
{
    public function __construct(

        #[Assert\NotBlank(
            message: 'Veuillez choisir un status',
        )]
        #[Assert\Choice(
            ['doctor', 'patient'],
            message: 'Le status doit être "doctor" ou "patient"',
        )]
        private readonly ?string $status = null,

        // Containte colonnes firstName (ENTITY)
        #[Assert\NotBlank(
            message: 'Veuillez entrer un prénom',
        )]
        #[Assert\Length(
            min: 3,
            max: 50,
            minMessage: 'Le prénom doit contenir au moins {{limit}} caractères',
            maxMessage: 'Le prénom  ne doit pas contenir plus de {{limit}} caractères',
        )]
        #[Assert\Regex(
            pattern: '/^[a-zA-Z]{3,50}$/',
            message: 'Le prénom  ne peut contenir que des lettres(minuscules et majuscules), des chiffres et les caractères spécieux \'.\' et \'_\''
        )]
        private readonly ?string $firstName = null,
        // Containte colonnes lastName (ENTITY)

        #[Assert\NotBlank(
            message: 'Veuillez entrer un nom',
        )]
        #[Assert\Length(
            min: 3,
            max: 50,
            minMessage: 'Le nom doit contenir au moins {{limit}} caractères',
            maxMessage: 'Le nom  ne doit pas contenir plus de {{limit}} caractères',
        )]
        #[Assert\Regex(
            pattern: '/^[a-zA-Z]{3,50}$/',
            message: 'Le nom  ne peut contenir que des lettres(minuscules et majuscules), des chiffres et les caractères spécieux \'.\' et \'_\''
        )]
        private readonly ?string $lastName = null,
        // Containte colonnes email (ENTITY)

        #[Assert\NotBlank(
            message: 'Veuillez entrer un email',
        )]
        #[Assert\Email(
            message: 'Veuillez entrer une adresse e-mail valide.'
        )]
        private readonly ?string $email = null,

        // Containte colonnes password (ENTITY)

        #[Assert\NotBlank(
            message: 'Veuillez entrer un mot de passe',
        )]
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
        private readonly ?string $password = null,
        // Containte colonnes confirmation password(ENTITY)


        #[Assert\NotBlank(
            message: 'Veuillez confirmer votre mot de passe',
        )]
        #[Assert\EqualTo(
            propertyPath: 'password',
            message: 'Les mots de passe doivent être identique',
        )]
        private readonly ?string $confirmPassword = null,

        // Containte colonnes phoneNumber(ENTITY)

        #[Assert\NotBlank(
            message: 'Veuillez entrer un numéro de télephone',
        )]
        #[Assert\Regex(
            pattern: '/^(?:\+33|0)[1-9](?:[\s.-]?\d{2}){4}$/',
            message: 'Le numéro de téléphone doit être un numéro français valide'
        )]
        private readonly ?string $phoneNumber = null,
        // Containte colonnes birthdate(ENTITY)
        #[Assert\NotBlank(
            message: 'Veuillez entrer une date de naissance',
        )]
        #[Assert\Date]

        private readonly ?string $birthDate = null,

       
        #[Assert\Length(
            min: 5,
            max: 50,
            minMessage: 'La spécilaité doit contenir au moins {{limit}} caractères',
            maxMessage: 'La spécilaité  ne doit pas contenir plus de {{limit}} caractères',
        )]
        private readonly ?string $medicalSpeciality = null,


    ) {}

    /**
     * Get the value of username
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * Get the value of name
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

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
    public function getConfirmPassword(): ?string
    {
        return $this->confirmPassword;
    }

    /**
     * Get the value of plainPassword
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Get the value of phoneNumber
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }


    /**
     * Get the value of birthdate
     */
    public function getBirthDate(): ?string
    {
        return $this->birthDate;
    }
    /**
     * Get the value of status
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }
    public function getMedicalSpeciality(): ?string
    {
        return $this->medicalSpeciality;
    }
}
