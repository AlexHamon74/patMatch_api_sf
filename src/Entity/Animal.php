<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Enum\SexeAnimal;
use App\Repository\AnimalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['numeroIdentification'])]
#[UniqueEntity(fields: ['numeroIdentification'], message: 'Ce numéro d\'identification existe déjà')]
#[ApiResource(normalizationContext:['groups' => ['animal:read']])]
#[ORM\HasLifecycleCallbacks]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read', 'animal:read', 'correspondance:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    #[Groups(['user:read', 'animal:read', 'correspondance:read'])]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    #[Assert\date(message : "Ce champs n'est pas valide.")]
    #[Context(normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd/m/Y'])]
    #[Groups(['user:read', 'animal:read'])]
    private ?\DateTimeImmutable $dateDeNaissance = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    #[Groups(['user:read', 'animal:read'])]
    private ?string $couleur = null;

    #[ORM\Column]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    #[Groups(['user:read', 'animal:read'])]
    private ?int $numeroIdentification = null;

    #[ORM\Column]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    #[Groups(['user:read', 'animal:read'])]
    private ?int $poids = null;

    #[ORM\Column]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    #[Groups(['user:read', 'animal:read'])]
    private ?int $taille = null;

    #[ORM\Column(enumType: SexeAnimal::class)]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    #[Groups(['user:read', 'animal:read'])]
    private ?SexeAnimal $sexe = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    #[Groups(['user:read', 'animal:read'])]
    private ?string $infosSante = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['user:read', 'animal:read'])]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['user:read', 'animal:read', 'correspondance:read'])]
    private ?string $animalImage = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $misAJourLe = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    #[Groups(['animal:read'])]
    private ?User $utilisateur = null;

    /**
     * @var Collection<int, Correspondance>
     */
    #[ORM\OneToMany(targetEntity: Correspondance::class, mappedBy: 'animal')]
    #[Groups(['user:read', 'animal:read'])]
    private Collection $correspondances;

    /**
     * @var Collection<int, AnimalPersonnalite>
     */
    #[ORM\OneToMany(targetEntity: AnimalPersonnalite::class, mappedBy: 'animal')]
    #[Groups(['user:read', 'animal:read'])]
    private Collection $animalPersonnalites;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    #[Groups(['user:read', 'animal:read'])]
    private ?Race $race = null;

    public function __construct()
    {
        $this->correspondances = new ArrayCollection();
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

    public function getDateDeNaissance(): ?\DateTimeImmutable
    {
        return $this->dateDeNaissance;
    }

    public function setDateDeNaissance(\DateTimeImmutable $dateDeNaissance): static
    {
        $this->dateDeNaissance = $dateDeNaissance;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): static
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getNumeroIdentification(): ?int
    {
        return $this->numeroIdentification;
    }

    public function setNumeroIdentification(int $numeroIdentification): static
    {
        $this->numeroIdentification = $numeroIdentification;

        return $this;
    }

    public function getPoids(): ?int
    {
        return $this->poids;
    }

    public function setPoids(int $poids): static
    {
        $this->poids = $poids;

        return $this;
    }

    public function getTaille(): ?int
    {
        return $this->taille;
    }

    public function setTaille(int $taille): static
    {
        $this->taille = $taille;

        return $this;
    }

    public function getSexe(): ?SexeAnimal
    {
        return $this->sexe;
    }

    public function setSexe(SexeAnimal $sexe): static
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getInfosSante(): ?string
    {
        return $this->infosSante;
    }

    public function setInfosSante(string $infosSante): static
    {
        $this->infosSante = $infosSante;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getAnimalImage(): ?string
    {
        return $this->animalImage;
    }

    public function setAnimalImage(?string $animalImage): static
    {
        $this->animalImage = $animalImage;

        return $this;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function updateMisAJourLe(): void
    {
        $this->misAJourLe = new \DateTimeImmutable();
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

    public function getUtilisateur(): ?User
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?User $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * @return Collection<int, Correspondance>
     */
    public function getCorrespondances(): Collection
    {
        return $this->correspondances;
    }

    public function addCorrespondance(Correspondance $correspondance): static
    {
        if (!$this->correspondances->contains($correspondance)) {
            $this->correspondances->add($correspondance);
            $correspondance->setAnimal($this);
        }

        return $this;
    }

    public function removeCorrespondance(Correspondance $correspondance): static
    {
        if ($this->correspondances->removeElement($correspondance)) {
            // set the owning side to null (unless already changed)
            if ($correspondance->getAnimal() === $this) {
                $correspondance->setAnimal(null);
            }
        }

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
            $animalPersonnalite->setAnimal($this);
        }

        return $this;
    }

    public function removeAnimalPersonnalite(AnimalPersonnalite $animalPersonnalite): static
    {
        if ($this->animalPersonnalites->removeElement($animalPersonnalite)) {
            // set the owning side to null (unless already changed)
            if ($animalPersonnalite->getAnimal() === $this) {
                $animalPersonnalite->setAnimal(null);
            }
        }

        return $this;
    }

    public function getRace(): ?Race
    {
        return $this->race;
    }

    public function setRace(?Race $race): static
    {
        $this->race = $race;

        return $this;
    }
}
