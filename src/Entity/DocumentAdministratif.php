<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\DocumentAdministratifRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DocumentAdministratifRepository::class)]
#[ORM\Table(name: '`documentAdministratif`')]
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
    private ?string $cheminDocument = null;

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
        return $this->cheminDocument;
    }

    public function setCheminDocument(string $cheminDocument): static
    {
        $this->cheminDocument = $cheminDocument;

        return $this;
    }
}
