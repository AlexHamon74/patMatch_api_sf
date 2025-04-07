<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\EspeceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EspeceRepository::class)]
#[ApiResource(normalizationContext:['groups' => ['espece:read']])]
class Espece
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['espece:read', 'animal:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    #[Groups(['espece:read', 'animal:read'])]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['espece:read'])]
    private ?string $especeImage = null;

    /**
     * @var Collection<int, Race>
     */
    #[ORM\OneToMany(targetEntity: Race::class, mappedBy: 'espece')]
    #[Groups(['espece:read'])]
    private Collection $races;

    public function __construct()
    {
        $this->races = new ArrayCollection();
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

    public function getEspeceImage(): ?string
    {
        return $this->especeImage;
    }

    public function setEspeceImage(?string $especeImage): static
    {
        $this->especeImage = $especeImage;

        return $this;
    }

    /**
     * @return Collection<int, Race>
     */
    public function getRaces(): Collection
    {
        return $this->races;
    }

    public function addRace(Race $race): static
    {
        if (!$this->races->contains($race)) {
            $this->races->add($race);
            $race->setEspece($this);
        }

        return $this;
    }

    public function removeRace(Race $race): static
    {
        if ($this->races->removeElement($race)) {
            // set the owning side to null (unless already changed)
            if ($race->getEspece() === $this) {
                $race->setEspece(null);
            }
        }

        return $this;
    }
}
