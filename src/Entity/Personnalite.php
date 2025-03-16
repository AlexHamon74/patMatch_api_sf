<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PersonnaliteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PersonnaliteRepository::class)]
#[ApiResource(normalizationContext:['groups' => ['personnalite:read']])]

#[ApiResource]
class Personnalite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['personnalite:read', 'animal:read', 'user:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    #[Groups(['personnalite:read', 'animal:read', 'user:read'])]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    #[Groups(['personnalite:read'])]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['personnalite:read', 'animal:read', 'user:read'])]
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
