<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\DocumentAdministratifRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DocumentAdministratifRepository::class)]
#[ApiResource]
class DocumentAdministratif
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'documentAdministratifs')]
    private ?User $utilisateur = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $chemin_document = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCheminDocument(): ?string
    {
        return $this->chemin_document;
    }

    public function setCheminDocument(string $chemin_document): static
    {
        $this->chemin_document = $chemin_document;

        return $this;
    }
}
