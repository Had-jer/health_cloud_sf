<?php

namespace App\Mapper\MedicalEvent;

use App\Dto\MedicalEvent\MedEventUpdateDto;
use App\Entity\MedicalEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MedEventUpdateMapper
{
    public function map(MedEventUpdateDto $dto, MedicalEvent $event): MedicalEvent
    {
        
        if (null !== $dto->getStatus()) {
            $allowedStatuses = ['scheduled', 'done', 'canceled'];

            if (!in_array($dto->getStatus(), $allowedStatuses, true)) {
                throw new NotFoundHttpException('Le statut doit être "scheduled", "done" ou "canceled"');
            }

            $event->setStatus($dto->getStatus());
        }

     

        return $event;
    }
}
