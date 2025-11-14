<?php

namespace App\Mapper\MedicalEventSummary;

use App\Dto\MedicalEventSummary\MedEventSumCreateDto;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Entity\MedicalEvent;
use App\Entity\MedicalEventSummary;
use App\Repository\MedicalEventRepository;
use DateTime;


class MedEventSumCreateMapper
{
    public function map(MedEventSumCreateDto $dto, MedicalEvent $medicalEvent): MedicalEventSummary
    {

        $medicalEventSummary = new MedicalEventSummary;

        if (null !== $dto->getContent()) {


            $medicalEventSummary->setContent($dto->getContent());
        }
        $medicalEventSummary->setCreatedAt(new DateTime());
        $medicalEventSummary->setMedicalEvent($medicalEvent);

        return $medicalEventSummary;
    }

}
