<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['client:read']])]
class Client extends User
{
    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['client:read'])]
    private ?string $typeLogement = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['client:read'])]
    private ?string $espaceExterieur = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['client:read'])]
    private ?string $typeEnvironnement = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['client:read'])]
    private ?bool $autresAnimaux = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['client:read'])]
    private ?string $animauxDescription = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['client:read'])]
    private ?bool $presenceEnfant = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['client:read'])]
    private ?string $enfantDescription = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['client:read'])]
    private ?string $animauxPreferes = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['client:read'])]
    private ?string $raceSouhaite = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['client:read'])]
    private ?string $ageSouhaite = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['client:read'])]
    private ?string $sexeSouhaite = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['client:read'])]
    private ?string $niveauExperience = null;

    /**
     * @var Collection<int, Swipe>
     */
    #[ORM\OneToMany(targetEntity: Swipe::class, mappedBy: 'client')]
    #[Groups(['client:read'])]
    private Collection $swipes;

    /**
     * @var Collection<int, Adoption>
     */
    #[ORM\OneToMany(targetEntity: Adoption::class, mappedBy: 'client')]
    private Collection $adoptions;

    public function __construct()
    {
        parent::__construct();
        $this->swipes = new ArrayCollection();
        $this->adoptions = new ArrayCollection();
    }

    public function getTypeLogement(): ?string
    {
        return $this->typeLogement;
    }

    public function setTypeLogement(?string $typeLogement): static
    {
        $this->typeLogement = $typeLogement;

        return $this;
    }

    public function getEspaceExterieur(): ?string
    {
        return $this->espaceExterieur;
    }

    public function setEspaceExterieur(?string $espaceExterieur): static
    {
        $this->espaceExterieur = $espaceExterieur;

        return $this;
    }

    public function getTypeEnvironnement(): ?string
    {
        return $this->typeEnvironnement;
    }

    public function setTypeEnvironnement(?string $typeEnvironnement): static
    {
        $this->typeEnvironnement = $typeEnvironnement;

        return $this;
    }

    public function isAutresAnimaux(): ?bool
    {
        return $this->autresAnimaux;
    }

    public function setAutresAnimaux(?bool $autresAnimaux): static
    {
        $this->autresAnimaux = $autresAnimaux;

        return $this;
    }

    public function getAnimauxDescription(): ?string
    {
        return $this->animauxDescription;
    }

    public function setAnimauxDescription(?string $animauxDescription): static
    {
        $this->animauxDescription = $animauxDescription;

        return $this;
    }

    public function isPresenceEnfant(): ?bool
    {
        return $this->presenceEnfant;
    }

    public function setPresenceEnfant(?bool $presenceEnfant): static
    {
        $this->presenceEnfant = $presenceEnfant;

        return $this;
    }

    public function getEnfantDescription(): ?string
    {
        return $this->enfantDescription;
    }

    public function setEnfantDescription(?string $enfantDescription): static
    {
        $this->enfantDescription = $enfantDescription;

        return $this;
    }

    public function getAnimauxPreferes(): ?string
    {
        return $this->animauxPreferes;
    }

    public function setAnimauxPreferes(?string $animauxPreferes): static
    {
        $this->animauxPreferes = $animauxPreferes;

        return $this;
    }

    public function getRaceSouhaite(): ?string
    {
        return $this->raceSouhaite;
    }

    public function setRaceSouhaite(?string $raceSouhaite): static
    {
        $this->raceSouhaite = $raceSouhaite;

        return $this;
    }

    public function getAgeSouhaite(): ?string
    {
        return $this->ageSouhaite;
    }

    public function setAgeSouhaite(?string $ageSouhaite): static
    {
        $this->ageSouhaite = $ageSouhaite;

        return $this;
    }

    public function getSexeSouhaite(): ?string
    {
        return $this->sexeSouhaite;
    }

    public function setSexeSouhaite(?string $sexeSouhaite): static
    {
        $this->sexeSouhaite = $sexeSouhaite;

        return $this;
    }

    public function getNiveauExperience(): ?string
    {
        return $this->niveauExperience;
    }

    public function setNiveauExperience(?string $niveauExperience): static
    {
        $this->niveauExperience = $niveauExperience;

        return $this;
    }

    /**
     * @return Collection<int, Swipe>
     */
    public function getSwipes(): Collection
    {
        return $this->swipes;
    }

    public function addSwipe(Swipe $swipe): static
    {
        if (!$this->swipes->contains($swipe)) {
            $this->swipes->add($swipe);
            $swipe->setClient($this);
        }

        return $this;
    }

    public function removeSwipe(Swipe $swipe): static
    {
        if ($this->swipes->removeElement($swipe)) {
            // set the owning side to null (unless already changed)
            if ($swipe->getClient() === $this) {
                $swipe->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Adoption>
     */
    public function getAdoptions(): Collection
    {
        return $this->adoptions;
    }

    public function addAdoption(Adoption $adoption): static
    {
        if (!$this->adoptions->contains($adoption)) {
            $this->adoptions->add($adoption);
            $adoption->setClient($this);
        }

        return $this;
    }

    public function removeAdoption(Adoption $adoption): static
    {
        if ($this->adoptions->removeElement($adoption)) {
            // set the owning side to null (unless already changed)
            if ($adoption->getClient() === $this) {
                $adoption->setClient(null);
            }
        }

        return $this;
    }
}
