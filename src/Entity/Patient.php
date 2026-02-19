<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PatientRepository::class)]
class Patient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date_naissance = null;

    /**
     * @var Collection<int, Medecin>
     */
    #[ORM\ManyToMany(targetEntity: Medecin::class, mappedBy: 'patient')]
    private Collection $medecin;

    #[ORM\OneToOne(inversedBy: 'patient', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, RendezVous>
     */
    #[ORM\OneToMany(targetEntity: RendezVous::class, mappedBy: 'patient')]
    private Collection $rendez_vous;

    /**
     * @var Collection<int, Rappel>
     */
    #[ORM\OneToMany(targetEntity: Rappel::class, mappedBy: 'patient')]
    private Collection $rappels;

    public function __construct()
    {
        $this->medecin = new ArrayCollection();
        $this->rendez_vous = new ArrayCollection();
        $this->rappels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }


    public function getDateNaissance(): ?\DateTime
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(\DateTime $date_naissance): static
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    /**
     * @return Collection<int, Medecin>
     */
    public function getMedecin(): Collection
    {
        return $this->medecin;
    }

    public function addMedecin(Medecin $medecin): static
    {
        if (!$this->medecin->contains($medecin)) {
            $this->medecin->add($medecin);
            $medecin->addPatient($this);
        }

        return $this;
    }

    public function removeMedecin(Medecin $medecin): static
    {
        if ($this->medecin->removeElement($medecin)) {
            $medecin->removePatient($this);
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setPatient(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getPatient() !== $this) {
            $user->setPatient($this);
        }

        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, RendezVous>
     */
    public function getRendezVous(): Collection
    {
        return $this->rendez_vous;
    }

    public function addRendezVou(RendezVous $rendezVou): static
    {
        if (!$this->rendez_vous->contains($rendezVou)) {
            $this->rendez_vous->add($rendezVou);
            $rendezVou->setPatient($this);
        }

        return $this;
    }

    public function removeRendezVou(RendezVous $rendezVou): static
    {
        if ($this->rendez_vous->removeElement($rendezVou)) {
            // set the owning side to null (unless already changed)
            if ($rendezVou->getPatient() === $this) {
                $rendezVou->setPatient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Rappel>
     */
    public function getRappels(): Collection
    {
        return $this->rappels;
    }

    public function addRappel(Rappel $rappel): static
    {
        if (!$this->rappels->contains($rappel)) {
            $this->rappels->add($rappel);
            $rappel->setPatient($this);
        }

        return $this;
    }

    public function removeRappel(Rappel $rappel): static
    {
        if ($this->rappels->removeElement($rappel)) {
            // set the owning side to null (unless already changed)
            if ($rappel->getPatient() === $this) {
                $rappel->setPatient(null);
            }
        }

        return $this;
    }
}
