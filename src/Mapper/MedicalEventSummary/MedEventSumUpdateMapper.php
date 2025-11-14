<?php

namespace App\Mapper\MedicalEventSummary;

use App\Dto\MedicalEventSummary\MedEventSumUpdateDto;
use App\Repository\UserRepository;
use App\Entity\MedicalEvent;
use App\Entity\MedicalEventSummary;
use App\Repository\MedicalEventRepository;
use DateTime;


class MedEventSumUpdateMapper
{
    public function map(MedEventSumUpdateDto $dto, MedicalEventSummary $medicalEventSummary): MedicalEventSummary
    {


        if (null !== $dto->getContent()) {


            $medicalEventSummary->setContent($dto->getContent());
        }
       
        return $medicalEventSummary;
    }

}
