<?php

namespace App\Entity;

use App\DTO\CBDto;
use App\Repository\CarteBancaireRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\DTO\AbstractDto;

#[ORM\Entity(repositoryClass: CarteBancaireRepository::class)]
class CarteBancaire extends AbstractEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected int $id;

    #[ORM\Column(type: 'string')]
    private string $numero_carte;

    #[ORM\Column(type: 'datetime')]
    private DateTime $date_expiration;

    #[ORM\Column(type: 'string')]
    private string $cvc;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'carteBancaires')]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNumeroCarte(): string
    {
        return $this->numero_carte;
    }

    public function getNumeroCarteDiscret(): string
    {
        return substr($this->numero_carte, -4);
    }

    public function setNumeroCarte(string $numero_carte): self
    {
        $this->numero_carte = $numero_carte;

        return $this;
    }

    public function getDateExpiration(): DateTime
    {
        return $this->date_expiration;
    }

    public function getDateExpirationString(): string
    {
        return $this->date_expiration->format('m/Y');
    }

    public function setDateExpiration(DateTime $date_expiration): self
    {
        $this->date_expiration = $date_expiration;

        return $this;
    }

    public function getCvc(): string
    {
        return $this->cvc;
    }

    public function setCvc(string $cvc): self
    {
        $this->cvc = $cvc;

        return $this;
    }

    public function getUserId(): User
    {
        return $this->user;
    }

    public function setUserId(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @param CBDto $dto
     */
    public function setFromDto(AbstractDto $dto): void {
        $this->setNumeroCarte($dto->numero_carte);
        $this->setCvc($dto->cvc);
        $this->setDateExpiration($dto->date_expiration);
    }
}
