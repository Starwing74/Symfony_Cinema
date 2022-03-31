<?php

namespace App\Entity;

use App\DTO\AbstractDto;
use App\DTO\ReservationDto;
use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation extends AbstractEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected int $id;

    #[ORM\ManyToOne(targetEntity: CarteBancaire::class, inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private CarteBancaire $carte;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    #[ORM\ManyToOne(targetEntity: Seance::class, inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private Seance $seance;

    #[ORM\Column(type: 'integer')]
    private int $prix;

    #[ORM\ManyToMany(targetEntity: Siege::class, inversedBy: 'reservations')]
    private Collection $sieges;

    public function __construct()
    {
        $this->sieges = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCarte(): ?CarteBancaire
    {
        return $this->carte;
    }

    public function setCarte(?CarteBancaire $carte): self
    {
        $this->carte = $carte;

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

    public function getSeance(): ?Seance
    {
        return $this->seance;
    }

    public function setSeance(?Seance $seance): self
    {
        $this->seance = $seance;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * @return Collection<int, Siege>
     */
    public function getSieges(): Collection
    {
        return $this->sieges;
    }

    public function addSiege(Siege $siege): self
    {
        if (!$this->sieges->contains($siege)) {
            $this->sieges[] = $siege;
        }

        return $this;
    }

    public function removeSiege(Siege $siege): self
    {
        $this->sieges->removeElement($siege);

        return $this;
    }

    /**
     * @param ReservationDto $dto
     */
    public function setFromDto(AbstractDto $dto): void {
        $this->setCarte($dto->carte);
    }

}
