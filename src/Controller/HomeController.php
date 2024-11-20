<?php

namespace App\Controller;

class HomeController extends BaseController
{
    
    public function index()
    {
        echo $this->twig->render('index.html.twig');
    }
}
