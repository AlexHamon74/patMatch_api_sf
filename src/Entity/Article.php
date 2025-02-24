<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ArticleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ApiResource]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    private ?User $utilisateur = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    private ?Categorie $categorie = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message : 'Ce champs ne peux pas être vide.')]
    private ?string $contenu = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $dateDeCreation = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $articleImage = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $misAJourLe = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUtilisateurId(): ?User
    {
        return $this->utilisateur;
    }

    public function setUtilisateurId(?User $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getCategorieId(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorieId(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getDateDeCreation(): ?\DateTimeImmutable
    {
        return $this->dateDeCreation;
    }

    public function setDateDeCreation(\DateTimeImmutable $dateDeCreation): static
    {
        $this->dateDeCreation = $dateDeCreation;

        return $this;
    }

    public function getArticleImage(): ?string
    {
        return $this->articleImage;
    }

    public function setArticleImage(?string $articleImage): static
    {
        $this->articleImage = $articleImage;

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
}
