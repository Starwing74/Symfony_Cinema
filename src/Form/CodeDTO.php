<?php

namespace App\Form;

class CodeDTO
{
    #[Assert\Length(min: 100000, max: 999999)]
    public int $Code;
}