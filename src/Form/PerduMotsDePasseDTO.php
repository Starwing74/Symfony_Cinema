<?php

namespace App\Form;

class PerduMotsDePasseDTO
{
    #[Assert\Length(min: 9)]
    public string $Mail;
}