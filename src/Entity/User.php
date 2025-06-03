<?php

namespace App\Entity;

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
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use App\Controller\MeController;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]

// Permet de gérer les ressources API et de définir les groupes de sérialisation 
#[
    ApiResource(
            operations: [
                new Get(
                    name: 'me',
                    uriTemplate: '/me',
                    controller: MeController::class,
                    security: "is_granted('IS_AUTHENTICATED_FULLY')",
                    read: false,
                    output: User::class,
                ),
                new Get,
                new Post(),
                new Patch(),
                new Delete(),
        ]
    )
]

// Permet de gérer les doublons d'email
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'Cet email existe déjà')]

// Permet de gérer les fichiers uploadés
#[Vich\Uploadable]
#[ORM\HasLifecycleCallbacks]

// Permet de définir l'héritage de la classe User
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "discr", type: "string")]
#[ORM\DiscriminatorMap(["user" => User::class, "eleveur" => Eleveur::class, "client" => Client::class])]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['client:read', 'eleveur:read', 'animal:read', 'adoption:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    #[Assert\Email(message : "L'email n'est pas valide.")]
    #[Groups(['client:read', 'eleveur:read', 'animal:read', 'adoption:read'])]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    private ?string $password = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Groups(['client:read', 'eleveur:read', 'adoption:read'])]
    private ?string $nom = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Groups(['client:read', 'eleveur:read', 'adoption:read'])]
    private ?string $prenom = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    #[Context(normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd/m/Y'])]
    #[Groups(['client:read', 'eleveur:read'])]
    private ?\DateTimeImmutable $dateDeNaissance = null;

    #[ORM\Column(length: 10, nullable: true)]
    #[Groups(['client:read', 'eleveur:read'])]
    private ?string $numeroDeTelephone = null;

    #[ORM\Column(length: 150, nullable: true)]
    #[Groups(['client:read', 'eleveur:read'])]
    private ?string $adresse = null;

    #[Vich\UploadableField(mapping: 'users', fileNameProperty: 'photoProfil')]
    public ?File $photoProfilFile = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['client:read', 'eleveur:read', 'adoption:read'])]
    private ?string $photoProfil = null;

    #[ORM\Column]
    #[Groups(['client:read', 'eleveur:read'])]
    private ?\DateTimeImmutable $misAJourLe = null;


    /**
     * @var Collection<int, DocumentAdministratif>
     */
    #[ORM\OneToMany(targetEntity: DocumentAdministratif::class, mappedBy: 'utilisateur')]
    private Collection $documentAdministratifs;

    public function __construct()
    {
        $this->documentAdministratifs = new ArrayCollection();
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

}
