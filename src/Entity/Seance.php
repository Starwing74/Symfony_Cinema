<?php

namespace App\Entity;

use App\Repository\SeanceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeanceRepository::class)]
class Seance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    private $jourHoraire;

    #[ORM\Column(type: 'string', length: 255)]
    private $langue;

    #[ORM\ManyToOne(targetEntity: Film::class)]
    private $film;

    #[ORM\ManyToOne(targetEntity: Salle::class)]
    private $salle;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJourHoraire(): ?\DateTimeInterface
    {
        return $this->jourHoraire;
    }

    public function setJourHoraire(\DateTimeInterface $jourHoraire): self
    {
        $this->jourHoraire = $jourHoraire;

        return $this;
    }

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(string $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    public function getFilm(): ?Film
    {
        return $this->film;
    }

    public function setFilm(?Film $film): self
    {
        $this->film = $film;

        return $this;
    }

    public function getSalle(): ?Salle
    {
        return $this->salle;
    }

    public function setSalle(?Salle $salle): self
    {
        $this->salle = $salle;

        return $this;
    }
}
