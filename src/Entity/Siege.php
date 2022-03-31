<?php

namespace App\Entity;

use App\Repository\SiegeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\ManyToOne(targetEntity: Salle::class)]
    private $salle;

    #[ORM\ManyToOne(targetEntity: Seance::class)]
    private $seance;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $user;

    #[ORM\ManyToMany(targetEntity: Reservation::class, mappedBy: 'sieges')]
    private $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

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

    public function getSalle(): ?Salle
    {
        return $this->salle;
    }

    public function setSalle(?Salle $salle): self
    {
        $this->salle = $salle;

        return $this;
    }

    public function getSeance(): ?Seance
    {
        return $this->seance;
    }

    public function setSeance(?Seance $seance): self
    {
        $this->seance = $seance;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->addSiege($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            $reservation->removeSiege($this);
        }

        return $this;
    }
}
