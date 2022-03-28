<?php

namespace App\Entity;

use App\Repository\SiegeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SiegeRepository::class)]
class Siege
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $status;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $numeroSiege;

    #[ORM\Column(type: 'string', length: 255)]
    private $ligne;

    #[ORM\Column(type: 'string', length: 255)]
    private $colonne;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getNumeroSiege(): ?string
    {
        return $this->numeroSiege;
    }

    public function setNumeroSiege(?string $numeroSiege): self
    {
        $this->numeroSiege = $numeroSiege;

        return $this;
    }

    public function getLigne(): ?string
    {
        return $this->ligne;
    }

    public function setLigne(string $ligne): self
    {
        $this->ligne = $ligne;

        return $this;
    }

    public function getColonne(): ?string
    {
        return $this->colonne;
    }

    public function setColonne(string $colonne): self
    {
        $this->colonne = $colonne;

        return $this;
    }
}
