<?php

namespace App\Controller;

use App\Repository\FilmRepository;

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
        // Récupérer tous les films à l'aide de FilmRepository
        $films = $this->filmRepository->findAll();

        // Passer les films à la vue Twig
        echo $this->twig->render('films_liste.html.twig', ['films' => $films]);
    }

    public function create()
    {
        echo "Création d'un film";
    }

    public function read(array $queryParams)
    {
        // Vérifier si 'id' est présent dans les paramètres
        if (!isset($queryParams['id']) || !is_numeric($queryParams['id'])) {
            echo $this->twig->render('error.html.twig', ['message' => "ID invalide ou manquant."]);
            return;
        }

        $id = (int) $queryParams['id'];
        $film = $this->filmRepository->findById($id);

        if (!$film) {
            echo $this->twig->render('error.html.twig', ['message' => "Film introuvable."]);
            return;
        }

        // Rendu de la page des détails
        echo $this->twig->render('film_details.html.twig', ['film' => $film]);
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