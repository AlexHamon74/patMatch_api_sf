<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use App\Controller\NonSwipedAnimalsController;
use App\Controller\UpdateAnimalImageController;
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
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['numeroIdentification'])]
#[UniqueEntity(fields: ['numeroIdentification'], message: "Ce numéro d'identification existe déjà")]
#[
    ApiResource(
        normalizationContext:['groups' => ['animal:read']],
        denormalizationContext: ['groups' => ['animal:write']],
        operations: [
            new GetCollection(
                name: 'non_swiped_animals',
                uriTemplate: '/animals/non-swiped',
                controller: NonSwipedAnimalsController::class,
                read: false,
                output: Animal::class,
                security: "is_granted('ROLE_CLIENT')"
            ),
            new Post(
                name: 'update_animal_image',
                uriTemplate: '/animals/{id}/image',
                controller: UpdateAnimalImageController::class,
                security: "is_granted('ROLE_ELEVEUR')",
                deserialize: false,
                inputFormats: ['multipart' => ['multipart/form-data']]
            ),
            new Get(),
            new Post(security: "is_granted('ROLE_ELEVEUR') or is_granted('ROLE_ADMIN')"),
            new Patch(),
            new Delete()
        ]
    ),
    ApiFilter(SearchFilter::class, properties: [
        'nom' => 'partial',
        'race.espece.nom' => 'partial',
        'race.nom' => 'partial'
    ]),
]

// Permet de gérer l'upload de l'image de l'animal
#[Vich\Uploadable]
#[ORM\HasLifecycleCallbacks]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['animal:read', 'eleveur:read', 'swipe:read', 'client:read', 'adoption:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    #[Groups(['animal:read', 'animal:write', 'eleveur:read', 'swipe:read', 'client:read', 'adoption:read'])]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    #[Context(normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd/m/Y'])]
    #[Groups(['animal:read', 'eleveur:read', 'animal:write'])]
    private ?\DateTimeImmutable $dateDeNaissance = null;

    #[ORM\Column]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    #[Groups(['animal:read', 'animal:write'])]
    private ?string $numeroIdentification = null;

    #[ORM\Column]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    #[Groups(['animal:read', 'animal:write'])]
    private ?int $poids = null;

    #[ORM\Column]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    #[Groups(['animal:read', 'animal:write'])]
    private ?int $taille = null;

    #[ORM\Column(enumType: SexeAnimal::class)]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    #[Groups(['animal:read', 'eleveur:read', 'animal:write'])]
    private ?SexeAnimal $sexe = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    #[Groups(['animal:read', 'animal:write'])]
    private ?string $infosSante = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['animal:read', 'animal:write'])]
    private ?string $histoire = null;

    #[Vich\UploadableField(mapping: 'animals', fileNameProperty: 'animalImage')]
    public ?File $animalImageFile = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['animal:read', 'animal:write', 'eleveur:read', 'swipe:read', 'client:read', 'adoption:read'])]
    private ?string $animalImage = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $misAJourLe = null;

    /**
     * @var Collection<int, Swipe>
     */
    #[ORM\OneToMany(targetEntity: Swipe::class, mappedBy: 'animal')]
    #[Groups(['eleveur:read'])]
    private Collection $swipes;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    #[Groups(['animal:read', 'eleveur:read', 'animal:write', 'client:read'])]
    private ?Race $race = null;

    #[ORM\Column(length: 100)]
    #[Groups(['animal:read', 'animal:write'])]
    private ?string $statutVaccination = null;

    #[ORM\Column(length: 100)]
    #[Groups(['animal:read', 'animal:write'])]
    private ?string $statutSterilisation = null;

    #[ORM\Column(length: 100)]
    #[Groups(['animal:read', 'animal:write'])]
    private ?string $typeAlimentation = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['animal:read', 'animal:write'])]
    private ?string $typeAlimentationDetails = null;

    #[ORM\Column(length: 255)]
    #[Groups(['animal:read', 'animal:write'])]
    private ?string $niveauEnergie = null;

    #[ORM\Column(length: 100)]
    #[Groups(['animal:read', 'animal:write'])]
    private ?string $sociabilite = null;

    #[ORM\Column(length: 100)]
    #[Groups(['animal:read', 'animal:write'])]
    private ?string $education = null;

    #[ORM\Column(length: 100)]
    #[Groups(['animal:read', 'animal:write'])]
    private ?string $typeLogement = null;

    #[ORM\Column(length: 100)]
    #[Groups(['animal:read', 'animal:write'])]
    private ?string $familleIdeale = null;

    #[ORM\Column]
    #[Groups(['animal:read', 'animal:write'])]
    private ?float $prix = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['animal:read', 'animal:write'])]
    private ?string $infosSupplementaires = null;

    #[ORM\Column(length: 255)]
    #[Groups(['animal:read', 'animal:write'])]
    private ?string $besoinsExercice = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['animal:read', 'animal:write', 'client:read'])]
    private ?Eleveur $eleveur = null;

    /**
     * @var Collection<int, Adoption>
     */
    #[ORM\OneToMany(targetEntity: Adoption::class, mappedBy: 'animal')]
    #[Groups(['eleveur:read'])]
    private Collection $adoptions;

    public function __construct()
    {
        $this->swipes = new ArrayCollection();
        $this->adoptions = new ArrayCollection();
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

    public function getNumeroIdentification(): ?string
    {
        return $this->numeroIdentification;
    }

    public function setNumeroIdentification(string $numeroIdentification): static
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

    public function getHistoire(): ?string
    {
        return $this->histoire;
    }

    public function setHistoire(?string $histoire): static
    {
        $this->histoire = $histoire;

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

    public function getAnimalImageFile(): ?File
    {
        return $this->animalImageFile;
    }

    public function setAnimalImageFile(?File $animalImageFile): static
    {
        $this->animalImageFile = $animalImageFile;

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
            $swipe->setAnimal($this);
        }

        return $this;
    }

    public function removeSwipe(Swipe $swipe): static
    {
        if ($this->swipes->removeElement($swipe)) {
            // set the owning side to null (unless already changed)
            if ($swipe->getAnimal() === $this) {
                $swipe->setAnimal(null);
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

    public function getStatutVaccination(): ?string
    {
        return $this->statutVaccination;
    }

    public function setStatutVaccination(string $statutVaccination): static
    {
        $this->statutVaccination = $statutVaccination;

        return $this;
    }

    public function getStatutSterilisation(): ?string
    {
        return $this->statutSterilisation;
    }

    public function setStatutSterilisation(string $statutSterilisation): static
    {
        $this->statutSterilisation = $statutSterilisation;

        return $this;
    }

    public function getTypeAlimentation(): ?string
    {
        return $this->typeAlimentation;
    }

    public function setTypeAlimentation(string $typeAlimentation): static
    {
        $this->typeAlimentation = $typeAlimentation;

        return $this;
    }

    public function getTypeAlimentationDetails(): ?string
    {
        return $this->typeAlimentationDetails;
    }

    public function setTypeAlimentationDetails(?string $typeAlimentationDetails): static
    {
        $this->typeAlimentationDetails = $typeAlimentationDetails;

        return $this;
    }

    public function getNiveauEnergie(): ?string
    {
        return $this->niveauEnergie;
    }

    public function setNiveauEnergie(string $niveauEnergie): static
    {
        $this->niveauEnergie = $niveauEnergie;

        return $this;
    }

    public function getSociabilite(): ?string
    {
        return $this->sociabilite;
    }

    public function setSociabilite(string $sociabilite): static
    {
        $this->sociabilite = $sociabilite;

        return $this;
    }

    public function getEducation(): ?string
    {
        return $this->education;
    }

    public function setEducation(string $education): static
    {
        $this->education = $education;

        return $this;
    }

    public function getTypeLogement(): ?string
    {
        return $this->typeLogement;
    }

    public function setTypeLogement(string $typeLogement): static
    {
        $this->typeLogement = $typeLogement;

        return $this;
    }

    public function getFamilleIdeale(): ?string
    {
        return $this->familleIdeale;
    }

    public function setFamilleIdeale(string $familleIdeale): static
    {
        $this->familleIdeale = $familleIdeale;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getInfosSupplementaires(): ?string
    {
        return $this->infosSupplementaires;
    }

    public function setInfosSupplementaires(?string $infosSupplementaires): static
    {
        $this->infosSupplementaires = $infosSupplementaires;

        return $this;
    }

    public function getBesoinsExercice(): ?string
    {
        return $this->besoinsExercice;
    }

    public function setBesoinsExercice(string $besoinsExercice): static
    {
        $this->besoinsExercice = $besoinsExercice;

        return $this;
    }

    public function getEleveur(): ?Eleveur
    {
        return $this->eleveur;
    }

    public function setEleveur(?Eleveur $eleveur): static
    {
        $this->eleveur = $eleveur;

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
            $adoption->setAnimal($this);
        }

        return $this;
    }

    public function removeAdoption(Adoption $adoption): static
    {
        if ($this->adoptions->removeElement($adoption)) {
            // set the owning side to null (unless already changed)
            if ($adoption->getAnimal() === $this) {
                $adoption->setAnimal(null);
            }
        }

        return $this;
    }
}
