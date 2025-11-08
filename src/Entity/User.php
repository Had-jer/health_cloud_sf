<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: "Cet email n'est plus disponible")]




class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['medical_event:read', 'user:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Groups(['medical_event:read', 'user:read'])]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    #[Groups(['medical_event:read', 'user:read'])]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 50)]
    #[Groups(['medical_event:read', 'user:read'])]
    private ?string $first_name = null;

    #[ORM\Column(length: 50)]
    #[Groups(['medical_event:read', 'user:read'])]
    private ?string $last_name = null;
    
    // status (patient/doctor)
    #[ORM\Column(length: 50)]
    #[Groups(['medical_event:read', 'user:read'])]
    private ?string $status = null;

     // spécialité médicale
     #[ORM\Column(type: "string", length: 50, nullable: true)]
     private ?string $medicalSpeciality = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['medical_event:read', 'user:read'])]
    private ?\DateTime $birth_date = null;

    #[ORM\Column]
    #[Groups(['medical_event:read', 'user:read'])]
    private ?string $phone_number = null;


// LA RELATION AVEC HEALTH_RECORD => ONETOONE
    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?HealthRecord $healthRecord = null;


    // LA RELATION AVEC MEDICALEVENT => ONETOMANY
    /**
     * @var Collection<int, MedicalEvent>
     */
    #[ORM\OneToMany(targetEntity: MedicalEvent::class, mappedBy: 'user')]
    private Collection $medicalEvents;

   
    public function __construct()
    {
        $this->medicalEvents = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }
    //status getter setter 
  
    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    #[\Deprecated]
    public function eraseCredentials(): void
    {
        // @deprecated, to be removed when upgrading to Symfony 8
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): static
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }
    /// getter setter medicalSpecilaity 
    public function getMedicalSpeciality(): ?string
    {
        return $this->medicalSpeciality;
    }

    public function setMedicalSpeciality(string $medicalSpeciality): static
    {
        $this->medicalSpeciality = $medicalSpeciality;

        return $this;
    }

    public function getBirthDate(): ?\DateTime
    {
        return $this->birth_date;
    }

    public function setBirthDate(\DateTime $birth_date): static
    {
        $this->birth_date = $birth_date;

        return $this;
    }

    public function getPhoneNumber(): ?int
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(int $phone_number): static
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function getHealthRecord(): ?HealthRecord
    {
        return $this->healthRecord;
    }

    public function setHealthRecord(HealthRecord $healthRecord): static
    {
        // set the owning side of the relation if necessary
        if ($healthRecord->getUser() !== $this) {
            $healthRecord->setUser($this);
        }

        $this->healthRecord = $healthRecord;

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
            $medicalEvent->setDoctor($this);
            $medicalEvent->setPatient($this);
        }
        

        return $this;
    }

    public function removeMedicalEvent(MedicalEvent $medicalEvent): static
    {
        if ($this->medicalEvents->removeElement($medicalEvent)) {
            // set the owning side to null (unless already changed)
            if ($medicalEvent->getDoctor() === $this) {
                $medicalEvent->setDoctor(null);
            }
            if ($medicalEvent->getPatient() === $this) {
                $medicalEvent->setPatient(null);
            }
        }

        return $this;
    }


  
}
