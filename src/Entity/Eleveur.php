<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\EleveurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: EleveurRepository::class)]
#[ApiResource(normalizationContext:['groups' => ['eleveur:read']])]
class Eleveur extends User
{
    #[ORM\Column(length: 100, nullable: true)]
    #[Groups(['eleveur:read', 'animal:read'])]
    private ?string $nomElevageAssociation = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['eleveur:read'])]
    private ?string $numeroEnregistrement = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['eleveur:read'])]
    private ?string $presentation = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['eleveur:read'])]
    private ?string $certificat = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['eleveur:read', 'animal:read'])]
    private ?string $adresseElevage = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['eleveur:read'])]
    private ?string $anneeCreation = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['eleveur:read'])]
    private ?string $especeProposee = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['eleveur:read'])]
    private ?string $horaireOuverture = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['eleveur:read'])]
    private ?string $conditionAdoption = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['eleveur:read'])]
    private ?bool $suiviPostAdoption = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['eleveur:read'])]
    private ?string $suiviPostAdoptionDuree = null;

    /**
     * @var Collection<int, Animal>
     */
    #[ORM\OneToMany(targetEntity: Animal::class, mappedBy: 'eleveur', orphanRemoval: true)]
    #[Groups(['eleveur:read'])]
    private Collection $animals;

    public function __construct()
    {
        parent::__construct();
        $this->animals = new ArrayCollection();
    }

    public function getNomElevageAssociation(): ?string
    {
        return $this->nomElevageAssociation;
    }

    public function setNomElevageAssociation(?string $nomElevageAssociation): static
    {
        $this->nomElevageAssociation = $nomElevageAssociation;

        return $this;
    }

    public function getNumeroEnregistrement(): ?string
    {
        return $this->numeroEnregistrement;
    }

    public function setNumeroEnregistrement(?string $numeroEnregistrement): static
    {
        $this->numeroEnregistrement = $numeroEnregistrement;

        return $this;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(?string $presentation): static
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getCertificat(): ?string
    {
        return $this->certificat;
    }

    public function setCertificat(?string $certificat): static
    {
        $this->certificat = $certificat;

        return $this;
    }

    public function getAdresseElevage(): ?string
    {
        return $this->adresseElevage;
    }

    public function setAdresseElevage(?string $adresseElevage): static
    {
        $this->adresseElevage = $adresseElevage;

        return $this;
    }

    public function getAnneeCreation(): ?string
    {
        return $this->anneeCreation;
    }

    public function setAnneeCreation(?string $anneeCreation): static
    {
        $this->anneeCreation = $anneeCreation;

        return $this;
    }

    public function getEspeceProposee(): ?string
    {
        return $this->especeProposee;
    }

    public function setEspeceProposee(?string $especeProposee): static
    {
        $this->especeProposee = $especeProposee;

        return $this;
    }

    public function getHoraireOuverture(): ?string
    {
        return $this->horaireOuverture;
    }

    public function setHoraireOuverture(?string $horaireOuverture): static
    {
        $this->horaireOuverture = $horaireOuverture;

        return $this;
    }

    public function getConditionAdoption(): ?string
    {
        return $this->conditionAdoption;
    }

    public function setConditionAdoption(?string $conditionAdoption): static
    {
        $this->conditionAdoption = $conditionAdoption;

        return $this;
    }

    public function isSuiviPostAdoption(): ?bool
    {
        return $this->suiviPostAdoption;
    }

    public function setSuiviPostAdoption(?bool $suiviPostAdoption): static
    {
        $this->suiviPostAdoption = $suiviPostAdoption;

        return $this;
    }

    public function getSuiviPostAdoptionDuree(): ?string
    {
        return $this->suiviPostAdoptionDuree;
    }

    public function setSuiviPostAdoptionDuree(?string $suiviPostAdoptionDuree): static
    {
        $this->suiviPostAdoptionDuree = $suiviPostAdoptionDuree;

        return $this;
    }

    /**
     * @return Collection<int, Animal>
     */
    public function getAnimals(): Collection
    {
        return $this->animals;
    }

    public function addAnimal(Animal $animal): static
    {
        if (!$this->animals->contains($animal)) {
            $this->animals->add($animal);
            $animal->setEleveur($this);
        }

        return $this;
    }

    public function removeAnimal(Animal $animal): static
    {
        if ($this->animals->removeElement($animal)) {
            // set the owning side to null (unless already changed)
            if ($animal->getEleveur() === $this) {
                $animal->setEleveur(null);
            }
        }

        return $this;
    }
}
