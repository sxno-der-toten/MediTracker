<?php

namespace App\Entity;

use App\Repository\MedecinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MedecinRepository::class)]
class Medecin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $specialite = null;

    #[ORM\Column(length: 4)]
    private ?string $numero_ordre = null;

    #[ORM\Column(length: 13, nullable: true)]
    private ?string $telephone = null;

    /**
     * @var Collection<int, Patient>
     */
    #[ORM\ManyToMany(targetEntity: Patient::class, inversedBy: 'medecin')]
    private Collection $patient;

    #[ORM\OneToOne(inversedBy: 'medecin', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    /**
     * @var Collection<int, Creneau>
     */
    #[ORM\OneToMany(targetEntity: Creneau::class, mappedBy: 'medecin', orphanRemoval: true)]
    private Collection $creneau;

    public function __construct()
    {
        $this->patient = new ArrayCollection();
        $this->creneau = new ArrayCollection();
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

    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(string $specialite): static
    {
        $this->specialite = $specialite;

        return $this;
    }

    public function getNumeroOrdre(): ?string
    {
        return $this->numero_ordre;
    }

    public function setNumeroOrdre(string $numero_ordre): static
    {
        $this->numero_ordre = $numero_ordre;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * @return Collection<int, Patient>
     */
    public function getPatient(): Collection
    {
        return $this->patient;
    }

    public function addPatient(Patient $patient): static
    {
        if (!$this->patient->contains($patient)) {
            $this->patient->add($patient);
        }

        return $this;
    }

    public function removePatient(Patient $patient): static
    {
        $this->patient->removeElement($patient);

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
            $this->user->setMedecin(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getMedecin() !== $this) {
            $user->setMedecin($this);
        }

        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Creneau>
     */
    public function getCreneau(): Collection
    {
        return $this->creneau;
    }

    public function addCreneau(Creneau $creneau): static
    {
        if (!$this->creneau->contains($creneau)) {
            $this->creneau->add($creneau);
            $creneau->setMedecin($this);
        }

        return $this;
    }

    public function removeCreneau(Creneau $creneau): static
    {
        if ($this->creneau->removeElement($creneau)) {
            // set the owning side to null (unless already changed)
            if ($creneau->getMedecin() === $this) {
                $creneau->setMedecin(null);
            }
        }

        return $this;
    }
}
