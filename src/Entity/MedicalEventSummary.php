<?php

namespace App\Entity;

use App\Repository\MedicalEventSummaryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: MedicalEventSummaryRepository::class)]
class MedicalEventSummary
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['medical_event:read'])]

    private ?int $id = null;

    

    #[ORM\Column(length: 255)]
    #[Groups(['medical_event:read'])]

    private ?string $content = null;

    #[ORM\Column]
    #[Groups(['medical_event:read'])]

    private ?\DateTime $created_at = null;

    #[ORM\ManyToOne(inversedBy: 'medicalSummaries')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['medical_event:read'])]
    private ?MedicalEvent $medicalEvent = null;

    public function getId(): ?int
    {
        return $this->id;
    }

   

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTime $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getMedicalEvent(): ?MedicalEvent
    {
        return $this->medicalEvent;
    }

    public function setMedicalEvent(?MedicalEvent $medicalEvent): static
    {
        $this->medicalEvent = $medicalEvent;

        return $this;
    }
}
