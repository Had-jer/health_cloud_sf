<?php

namespace App\Mapper\MedicalEvent;

use App\Dto\MedicalEvent\MedEventCreateDto;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Entity\MedicalEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class MedEventCreateMapper
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {}
    public function map(MedEventCreateDto $dto, $ConnectedUser): MedicalEvent
    {
        
        $medicalEvent = new MedicalEvent;

        if (null !== $dto->getPatient()) {
            

            $patient = $this->userRepository->find($dto->getPatient());
            
            if (null === $patient) {
                throw new NotFoundHttpException('Patient introuvable');
            }

            if ($patient->getStatus() === "patient") {
            $medicalEvent->setPatient(
                $patient
            );
        }else{
            throw new NotFoundHttpException('Vous devez entrer un patient valide');

        }
        }

        if (null !== $ConnectedUser) {

            if ($ConnectedUser !== $patient) {
                
                    $medicalEvent->setDoctor($ConnectedUser);

                
            
            } else {
                throw new NotFoundHttpException('Le patient ne peut pas être vous même');
            }
        } else {
            throw new NotFoundHttpException('Vous devez être connecté');
        }


       

      

     
        if (null !== $dto->getDate()) {
            $medicalEvent->setDate(new \DateTime($dto->getDate()));

        }
        if (null !== $dto->getStatus()) {
            $medicalEvent->setStatus($dto->getStatus());

        }
        if (null !== $dto->getEventCategory()) {

           
            $medicalEvent->setEventCategory($dto->getEventCategory());


           

        }

    
        
       


        return $medicalEvent;
    }
}