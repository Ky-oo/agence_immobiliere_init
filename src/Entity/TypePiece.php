<?php

namespace App\Entity;

use App\Repository\TypePieceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypePieceRepository::class)]
class TypePiece
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column]
    private ?bool $surfaceHabitable = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function isSurfaceHabitable(): ?bool
    {
        return $this->surfaceHabitable;
    }

    public function setSurfaceHabitable(bool $surfaceHabitable): static
    {
        $this->surfaceHabitable = $surfaceHabitable;

        return $this;
    }

}
