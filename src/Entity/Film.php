<?php

namespace App\Entity;

use App\Repository\FilmRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FilmRepository::class)]
class Film
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $image;

    #[ORM\Column(type: 'text', length: 20000, nullable: true)]
    private $resumer;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $durer;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $directeur;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $bandeAnnonce;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'films')]
    #[ORM\JoinColumn(nullable: false)]
    private $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getResumer(): ?string
    {
        return $this->resumer;
    }

    public function setResumer(?string $resumer): self
    {
        $this->resumer = $resumer;

        return $this;
    }

    public function getDurer(): ?string
    {
        return $this->durer;
    }

    public function setDurer(?string $durer): self
    {
        $this->durer = $durer;

        return $this;
    }

    public function getDirecteur(): ?string
    {
        return $this->directeur;
    }

    public function setDirecteur(?string $directeur): self
    {
        $this->directeur = $directeur;

        return $this;
    }

    public function getBandeAnnonce(): ?string
    {
        return $this->bandeAnnonce;
    }

    public function setBandeAnnonce(?string $bandeAnnonce): self
    {
        $this->bandeAnnonce = $bandeAnnonce;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
