<?php

namespace App\Dto\MedicalEvent;

use App\Entity\MedicalEvent;
use Symfony\Component\Validator\Constraints as Assert;



class MedEventCreateDto
{
    public function __construct(

        #[Assert\NotBlank(
            message: 'Veuillez choisir un status',
        )]
        #[Assert\Choice(
            ['scheduled', 'done', 'canceled'],
            message: 'Le status doit être soit "scheduled", "done" ou  "canceled"',
        )]
        private readonly ?string $status = null,
// patient_id

        #[Assert\NotBlank(
            message: 'Veuillez indiquer le patient.'
        )]
        #[Assert\Positive(message: 'Le patient doit etre un identifiant valide',)]
        private readonly ?int $patient = null,

   

     
        // Containte colonnes date(ENTITY)
        #[Assert\NotBlank(
            message: 'Veuillez entrer la date de l\'évenement médical',
        )]
        #[Assert\Date]

        private readonly ?string $date = null,
// la category de l'evenement medical
        #[Assert\NotBlank(
            message: 'Veuillez entrer la catégorie de l\'évenement médical',
        )]
        #[Assert\Length(
            min: 5,
            max: 50,
            minMessage: 'La catégorie doit contenir au moins {{limit}} caractères',
            maxMessage: 'La catégorie  ne doit pas contenir plus de {{limit}} caractères',
        )]
        private readonly ?string $eventCategory = null,


    ) {}

   


   

    /**
     * Get the value of date
     */
    public function getDate(): ?string
    {
        return $this->date;
    }
    /**
     * Get the value of status
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }
    /**
     * Get the value of patient
     */
    public function getPatient(): ?int
    {
        return $this->patient;
    }
    /**
     * Get the value of eventCategory
     */
    public function getEventCategory(): ?string
    {
        return $this->eventCategory;
    }
}
