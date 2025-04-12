<?php

namespace App\Entity;

use App\Enum\TypeCompte;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'Cet email existe déjà')]
#[ApiResource(normalizationContext:['groups' => ['user:read']])]
#[ORM\HasLifecycleCallbacks]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read', 'correspondance:read', 'article:read', 'animal:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    #[Assert\Email(message : "L'email n'est pas valide.")]
    #[Groups(['user:read', 'correspondance:read'])]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    #[Groups(['user:read'])]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    #[Groups(['user:read'])]
    private ?string $password = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    #[Groups(['user:read', 'correspondance:read', 'article:read', 'animal:read'])]
    private ?string $nom = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    #[Groups(['user:read', 'correspondance:read', 'article:read', 'animal:read'])]
    private ?string $prenom = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    #[Context(normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd/m/Y'])]
    #[Groups(['user:read'])]
    private ?\DateTimeImmutable $dateDeNaissance = null;

    #[ORM\Column(length: 10, nullable: true)]
    #[Groups(['user:read'])]
    private ?string $numeroDeTelephone = null;

    #[ORM\Column(length: 150, nullable: true)]
    #[Groups(['user:read'])]
    private ?string $adresse = null;

    #[ORM\Column(length: 5, nullable: true)]
    #[Groups(['user:read'])]
    private ?string $codePostal = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Groups(['user:read'])]
    private ?string $ville = null;

    #[Vich\UploadableField(mapping: 'users', fileNameProperty: 'photoProfil')]
    public ?File $photoProfilFile = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['user:read', 'correspondance:read'])]
    private ?string $photoProfil = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $misAJourLe = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['user:read'])]
    private ?array $interetAnimalier = null;

    #[ORM\Column(nullable: true, enumType: TypeCompte::class)]
    private ?TypeCompte $typeCompte = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $nomElevageAssociation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $numeroEnregistrement = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $aPropos = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $certificat = null;
    
    /**
     * @var Collection<int, Article>
     */
    #[ORM\OneToMany(targetEntity: Article::class, mappedBy: 'utilisateur')]
    #[Groups(['user:read'])]
    private Collection $articles;

    /**
     * @var Collection<int, DocumentAdministratif>
     */
    #[ORM\OneToMany(targetEntity: DocumentAdministratif::class, mappedBy: 'utilisateur')]
    #[Groups(['user:read'])]
    private Collection $documentAdministratifs;

    /**
     * @var Collection<int, Animal>
     */
    #[ORM\OneToMany(targetEntity: Animal::class, mappedBy: 'utilisateur')]
    #[Groups(['user:read'])]
    private Collection $animals;

    /**
     * @var Collection<int, Correspondance>
     */
    #[ORM\OneToMany(targetEntity: Correspondance::class, mappedBy: 'user')]
    #[Groups(['user:read'])]
    private Collection $correspondances;


    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->documentAdministratifs = new ArrayCollection();
        $this->animals = new ArrayCollection();
        $this->correspondances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getDateDeNaissance(): ?\DateTimeImmutable
    {
        return $this->dateDeNaissance;
    }

    public function setDateDeNaissance(\DateTimeImmutable $dateDeNaissance): static
    {
        $this->dateDeNaissance = $dateDeNaissance;

        return $this;
    }

    public function getNumeroDeTelephone(): ?string
    {
        return $this->numeroDeTelephone;
    }

    public function setNumeroDeTelephone(?string $numeroDeTelephone): static
    {
        $this->numeroDeTelephone = $numeroDeTelephone;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(?string $codePostal): static
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getPhotoProfil(): ?string
    {
        return $this->photoProfil;
    }

    public function setPhotoProfil(?string $photoProfil): static
    {
        $this->photoProfil = $photoProfil;

        return $this;
    }

    public function getPhotoProfilFile(): ?File
    {
        return $this->photoProfilFile;
    }

    public function setPhotoProfilFile(?File $photoProfilFile): static
    {
        $this->photoProfilFile = $photoProfilFile;

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

    public function getInteretAnimalier(): ?array
    {
        return $this->interetAnimalier;
    }

    public function setInteretAnimalier(?array $interetAnimalier): static
    {
        $this->interetAnimalier = $interetAnimalier;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): static
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
            $article->setUtilisateur($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): static
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getUtilisateur() === $this) {
                $article->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DocumentAdministratif>
     */
    public function getDocumentAdministratifs(): Collection
    {
        return $this->documentAdministratifs;
    }

    public function addDocumentAdministratif(DocumentAdministratif $documentAdministratif): static
    {
        if (!$this->documentAdministratifs->contains($documentAdministratif)) {
            $this->documentAdministratifs->add($documentAdministratif);
            $documentAdministratif->setUtilisateur($this);
        }

        return $this;
    }

    public function removeDocumentAdministratif(DocumentAdministratif $documentAdministratif): static
    {
        if ($this->documentAdministratifs->removeElement($documentAdministratif)) {
            // set the owning side to null (unless already changed)
            if ($documentAdministratif->getUtilisateur() === $this) {
                $documentAdministratif->setUtilisateur(null);
            }
        }

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
            $animal->setUtilisateur($this);
        }

        return $this;
    }

    public function removeAnimal(Animal $animal): static
    {
        if ($this->animals->removeElement($animal)) {
            // set the owning side to null (unless already changed)
            if ($animal->getUtilisateur() === $this) {
                $animal->setUtilisateur(null);
            }
        }

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
            $correspondance->setUser($this);
        }

        return $this;
    }

    public function removeCorrespondance(Correspondance $correspondance): static
    {
        if ($this->correspondances->removeElement($correspondance)) {
            // set the owning side to null (unless already changed)
            if ($correspondance->getUser() === $this) {
                $correspondance->setUser(null);
            }
        }

        return $this;
    }

    public function getTypeCompte(): ?TypeCompte
    {
        return $this->typeCompte;
    }

    public function setTypeCompte(?TypeCompte $typeCompte): static
    {
        $this->typeCompte = $typeCompte;

        return $this;
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

    public function getAPropos(): ?string
    {
        return $this->aPropos;
    }

    public function setAPropos(?string $aPropos): static
    {
        $this->aPropos = $aPropos;

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
}
