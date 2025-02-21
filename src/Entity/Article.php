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
    private ?\DateTimeImmutable $date_de_creation = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $article_image = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $mis_a_jour_le = null;

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
        return $this->date_de_creation;
    }

    public function setDateDeCreation(\DateTimeImmutable $date_de_creation): static
    {
        $this->date_de_creation = $date_de_creation;

        return $this;
    }

    public function getArticleImage(): ?string
    {
        return $this->article_image;
    }

    public function setArticleImage(?string $article_image): static
    {
        $this->article_image = $article_image;

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
}
