<?php

namespace App\Controller;

class ContactController extends BaseController
{
    public function index()
    {
        echo $this->twig->render('contact.html.twig');
    }
}