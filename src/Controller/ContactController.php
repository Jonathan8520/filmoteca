<?php

namespace App\Controller;

class ContactController
{
    private $twig;

    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    public function index()
    {
        echo $this->twig->render('contact.html.twig');
    }
}
