<?php 
namespace App\Dto\MedicalEventSummary;

use App\Entity\MedicalEventSummary;
use Symfony\Component\Validator\Constraints as Assert;




class MedEventSumUpdateDto
{
    public function __construct(


        #[Assert\NotBlank(
            message: 'Veuillez entrer le contenu du compte rendu de l\'évenement médical',
        )]
        #[Assert\Length(
            min: 5,
            max: 255,
            minMessage: 'Le contenu doit contenir au moins {{limit}} caractères',
            maxMessage: 'Le contenu ne doit pas contenir plus de {{limit}} caractères',
        )]
        private readonly ?string $content = null,


    ) {}

   


   

    
   
    /**
     * Get the value of Content
     */
    public function getContent(): ?string
    {
        return $this->content;
    }
}
