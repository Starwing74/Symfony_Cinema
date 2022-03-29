<?php

namespace App\Form;

class NouveauMotsDePasseDTO
{
    #[Assert\Password]
    public ?string $NewPassword = null;
}