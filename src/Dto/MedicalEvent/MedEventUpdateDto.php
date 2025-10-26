<?php

namespace App\Dto\MedicalEvent;

use App\Entity\MedicalEvent;
// use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;



class MedEventUpdateDto
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
       

    ) {}

  


   
    /**
     * Get the value of status
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }
}
