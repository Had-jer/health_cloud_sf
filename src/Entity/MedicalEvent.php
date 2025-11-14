<?php

namespace App\Entity;

use App\Repository\MedicalEventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: MedicalEventRepository::class)]
class MedicalEvent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['medical_event:read'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['medical_event:read'])]
    private ?\DateTime $date = null;

    #[ORM\Column(length: 255)]
    #[Groups(['medical_event:read', 'medical_event:write'])]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'medicalEvents')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['medical_event:read'])]
    private ?User $patient = null;

    #[ORM\Column(length: 255)]
    #[Groups(['medical_event:read'])]
    private ?string $eventCategory = null;

    #[ORM\ManyToOne(inversedBy: 'medicalEvents')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['medical_event:read'])]
    private ?User $doctor = null;

    #[ORM\OneToMany(targetEntity: MedicalEventSummary::class, mappedBy: 'medicalEvent')]
    #[Groups(['medical_event:read'])]


 
    public function getId(): ?int
    {
        return $this->id;
    }

   

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getEventCategory(): ?string
    {
        return $this->eventCategory;
    }

    public function setEventCategory(string $eventCategory): static
    {
        $this->eventCategory= $eventCategory;

        return $this;
    }


    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

   

    public function getDoctor(): ?User
    {
        return $this->doctor;
    }

    public function setDoctor(?User $user): static
    {
        $this->doctor = $user;

        return $this;
    }
    public function getPatient(): ?User
    {
        return $this->patient;
    }

    public function setPatient(?User $user): static
    {
        $this->patient = $user;

        return $this;
    }

   
 

   
}
