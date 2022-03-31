<?php

namespace App\Form;

class RajouterFilmDTO
{
    public string $Categorie = "";

    #[Assert\Length(min: 3)]
    public string $Name;

    #[Assert\Length(min: 3)]
    public string $Image;

    #[Assert\Length(min: 3)]
    public string $Resumer;

    #[Assert\Length(min: 3)]
    public string $Durer;

    #[Assert\Length(min: 3)]
    public string $Directeur;

    #[Assert\Length(min: 3)]
    public string $BandeAnnonce;
}