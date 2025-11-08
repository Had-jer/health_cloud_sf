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


            $event->setStatus($dto->getStatus());
        }



        return $event;
    }
}
