<?php

namespace App\Controller;

use PDO;

class FilmController
{
    private $twig;
    private $pdo;

    public function __construct($twig, $pdo)
    {
        $this->twig = $twig;
        $this->pdo = $pdo;
    }

    public function index()
    {
        $films = $this->pdo->query("SELECT * FROM movie")->fetchAll(PDO::FETCH_ASSOC);
        echo $this->twig->render('films.html.twig', ['films' => $films]);
    }
}
