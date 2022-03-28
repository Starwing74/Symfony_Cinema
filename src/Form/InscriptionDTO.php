<?php

namespace App\Form;

class InscriptionDTO
{
    #[Assert\Length(min: 3)]
    public string $Prenom;

    #[Assert\Length(min: 3)]
    public string $Nom;

    #[Assert\Email]
    public ?string $Mail = null;

    #[Assert\Password]
    public ?string $Password = null;
}