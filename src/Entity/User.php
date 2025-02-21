<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'Cet email existe déjà')]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    #[Assert\email(message : "L'email n'est pas valide.")]
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

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    private ?string $nom = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    private ?string $prenom = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    #[Assert\date(message : "Ce champs n'est pas valide.")]
    private ?\DateTimeImmutable $date_de_naissance = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $numero_de_telephone = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column(length: 5, nullable: true)]
    private ?string $code_postal = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $ville = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $photo_profil = null;

    #[ORM\Column]
    #[Assert\datetime(message : "Ce champs n'est pas valide.")]
    private ?\DateTimeImmutable $mis_a_jour_le = null;

    #[ORM\Column(nullable: true)]
    private ?array $interet_animalier = null;

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
        return $this->date_de_naissance;
    }

    public function setDateDeNaissance(\DateTimeImmutable $date_de_naissance): static
    {
        $this->date_de_naissance = $date_de_naissance;

        return $this;
    }

    public function getNumeroDeTelephone(): ?string
    {
        return $this->numero_de_telephone;
    }

    public function setNumeroDeTelephone(?string $numero_de_telephone): static
    {
        $this->numero_de_telephone = $numero_de_telephone;

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
        return $this->code_postal;
    }

    public function setCodePostal(?string $code_postal): static
    {
        $this->code_postal = $code_postal;

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
        return $this->photo_profil;
    }

    public function setPhotoProfil(?string $photo_profil): static
    {
        $this->photo_profil = $photo_profil;

        return $this;
    }

    public function getMisAJourLe(): ?\DateTimeImmutable
    {
        return $this->mis_a_jour_le;
    }

    public function setMisAJourLe(\DateTimeImmutable $mis_a_jour_le): static
    {
        $this->mis_a_jour_le = $mis_a_jour_le;

        return $this;
    }

    public function getInteretAnimalier(): ?array
    {
        return $this->interet_animalier;
    }

    public function setInteretAnimalier(?array $interet_animalier): static
    {
        $this->interet_animalier = $interet_animalier;

        return $this;
    }
}
