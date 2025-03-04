<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Enum\SexeAnimal;
use App\Repository\AnimalRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


#[ORM\Entity(repositoryClass: AnimalRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['numeroIdentification'])]
#[UniqueEntity(fields: ['numeroIdentification'], message: 'Ce numéro d\'identification existe déjà')]
#[ApiResource]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    #[Assert\date(message : "Ce champs n'est pas valide.")]
    private ?\DateTimeImmutable $dateDeNaissance = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    private ?string $couleur = null;

    #[ORM\Column]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    private ?int $numeroIdentification = null;

    #[ORM\Column]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    private ?int $poids = null;

    #[ORM\Column]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    private ?int $taille = null;

    #[ORM\Column(enumType: SexeAnimal::class)]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    private ?SexeAnimal $sexe = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    private ?string $infosSante = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $animalImage = null;

    #[ORM\Column]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    private ?\DateTimeImmutable $misAJourLe = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    private ?User $utilisateur = null;

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
}
