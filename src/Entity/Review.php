<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReviewRepository::class)]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $aime;

    #[ORM\ManyToOne(targetEntity: Film::class, inversedBy: 'reviews')]
    #[ORM\JoinColumn(nullable: false)]
    private $film;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAime(): ?string
    {
        return $this->aime;
    }

    public function setAime(string $aime): self
    {
        $this->aime = $aime;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
