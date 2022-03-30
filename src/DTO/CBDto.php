<?php

namespace App\DTO;

use App\Entity\AbstractEntity;
use App\Entity\CarteBancaire;
use DateTime;
use Doctrine\Common\Annotations\Annotation\Required;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class CBDto extends AbstractDto {

    #[Required]
    public string $numero_carte;

    #[Required]
    public string $cvc;

    #[Required]
    public DateTime $date_expiration;

    /**
     * @param CarteBancaire $cb
     */
    public function setFromEntity(AbstractEntity $cb): void {
        $this->date_expiration = $cb->getDateExpiration();
    }

    /**
     * Credit card validation
     *
     * @param ClassMetadata $metadata
     * @return void
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('numero_carte', new Assert\CardScheme([
            'schemes' => [
                Assert\CardScheme::VISA,
                Assert\CardScheme::MASTERCARD,
            ],
            'message' => 'Your credit card number is invalid.',
        ]));
    }
}
