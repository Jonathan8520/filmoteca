<?php

namespace App\Controller;

class BaseController
{
    protected $twig;

    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    
}
