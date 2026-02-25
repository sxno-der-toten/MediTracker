<?php

namespace App\Entity;

use App\Repository\MedecinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MedecinRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['medecin:read']],
    denormalizationContext: ['groups' => ['medecin:write']]
)]
class Medecin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['medecin:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['medecin:read', 'medecin:write'])]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Groups(['medecin:read', 'medecin:write'])]
    private ?string $specialite = null;

    #[ORM\Column(length: 4)]
    #[Groups(['medecin:read', 'medecin:write'])]
    private ?string $numeroOrdre = null;

    /**
     * @var Collection<int, Patient>
     */
    #[ORM\ManyToMany(targetEntity: Patient::class, inversedBy: 'medecin')]
    private Collection $patient;

    #[ORM\OneToOne(inversedBy: 'medecin', cascade: ['persist', 'remove'])]
    #[Groups(['medecin:write'])]
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
        return $this->numeroOrdre;
    }

    public function setNumeroOrdre(string $numeroOrdre): static
    {
        $this->numeroOrdre = $numeroOrdre;
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
        if ($user === null && $this->user !== null) {
            $this->user->setMedecin(null);
        }

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
}