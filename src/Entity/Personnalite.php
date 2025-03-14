<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PersonnaliteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonnaliteRepository::class)]
#[ApiResource]
class Personnalite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $personnaliteImage = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $misAJourLe = null;

    /**
     * @var Collection<int, AnimalPersonnalite>
     */
    #[ORM\OneToMany(targetEntity: AnimalPersonnalite::class, mappedBy: 'personnalite')]
    private Collection $animalPersonnalites;

    public function __construct()
    {
        $this->animalPersonnalites = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPersonnaliteImage(): ?string
    {
        return $this->personnaliteImage;
    }

    public function setPersonnaliteImage(string $personnaliteImage): static
    {
        $this->personnaliteImage = $personnaliteImage;

        return $this;
    }

    public function getMisAJourLe(): ?\DateTimeImmutable
    {
        return $this->misAJourLe;
    }

    public function setMisAJourLe(\DateTimeImmutable $misAJourLe): static
    {
        $this->misAJourLe = $misAJourLe;

        return $this;
    }

    /**
     * @return Collection<int, AnimalPersonnalite>
     */
    public function getAnimalPersonnalites(): Collection
    {
        return $this->animalPersonnalites;
    }

    public function addAnimalPersonnalite(AnimalPersonnalite $animalPersonnalite): static
    {
        if (!$this->animalPersonnalites->contains($animalPersonnalite)) {
            $this->animalPersonnalites->add($animalPersonnalite);
            $animalPersonnalite->setPersonnalite($this);
        }

        return $this;
    }

    public function removeAnimalPersonnalite(AnimalPersonnalite $animalPersonnalite): static
    {
        if ($this->animalPersonnalites->removeElement($animalPersonnalite)) {
            // set the owning side to null (unless already changed)
            if ($animalPersonnalite->getPersonnalite() === $this) {
                $animalPersonnalite->setPersonnalite(null);
            }
        }

        return $this;
    }
}
