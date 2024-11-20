<?php

namespace App\Controller;

use App\Repository\FilmRepository;
use PDO;

class FilmController extends BaseController
{
    
    private $filmRepository;

    public function __construct($twig, $pdo)
    {
        parent::__construct($twig);  // Appelle le constructeur de la classe parente pour initialiser Twig
        $this->filmRepository = new FilmRepository($pdo);
    }

    public function index()
    {
        // Récupérer tous les films à l'aide de FilmRepository
        $films = $this->filmRepository->findAll();

        // Passer les films à la vue Twig
        echo $this->twig->render('films.html.twig', ['films' => $films]);
    }

    public function list()
    {
        echo "Liste des films";
    }

    public function create()
    {
        echo "Création d'un film";
    }

    public function read()
    {
        echo "Lecture d'un film";
    }

    public function update()
    {
        echo "Mise à jour d'un film";
    }

    public function delete()
    {
        echo "Suppression d'un film";
    }
}