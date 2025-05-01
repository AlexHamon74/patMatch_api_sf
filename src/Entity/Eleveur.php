<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\EleveurRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EleveurRepository::class)]
#[ApiResource]
class Eleveur extends User
{
    #[ORM\Column(length: 100, nullable: true)]
    private ?string $nomElevageAssociation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $numeroEnregistrement = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $aPropos = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $certificat = null;

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
