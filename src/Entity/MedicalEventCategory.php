<?php

namespace App\Entity;

use App\Repository\MedicalEventCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MedicalEventCategoryRepository::class)]
class MedicalEventCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

 

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    /**
     * @var Collection<int, MedicalEvent>
     */
    #[ORM\OneToMany(targetEntity: MedicalEvent::class, mappedBy: 'medicalEventCategory')]
    private Collection $medicalEvents;

    public function __construct()
    {
        $this->medicalEvents = new ArrayCollection();
    }

  

    public function getId(): ?int
    {
        return $this->id;
    }

   
    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

   

    /**
     * @return Collection<int, MedicalEvent>
     */
    public function getMedicalEvents(): Collection
    {
        return $this->medicalEvents;
    }

    public function addMedicalEvent(MedicalEvent $medicalEvent): static
    {
        if (!$this->medicalEvents->contains($medicalEvent)) {
            $this->medicalEvents->add($medicalEvent);
            $medicalEvent->setMedicalEventCategory($this);
        }

        return $this;
    }

    public function removeMedicalEvent(MedicalEvent $medicalEvent): static
    {
        if ($this->medicalEvents->removeElement($medicalEvent)) {
            // set the owning side to null (unless already changed)
            if ($medicalEvent->getMedicalEventCategory() === $this) {
                $medicalEvent->setMedicalEventCategory(null);
            }
        }

        return $this;
    }
}
