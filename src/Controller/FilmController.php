<?php

namespace App\Controller;

use App\Repository\FilmRepository;

class FilmController extends BaseController
{

    public function index()
    {
        $filmRepository = new FilmRepository();
        $films = $filmRepository->findAll();

        echo $this->twig->render('films.html.twig', ['films' => $films]);
    }

    public function list()
    {
        $filmRepository = new FilmRepository();
        $films = $filmRepository->findAll();

        echo $this->twig->render('films_liste.html.twig', ['films' => $films]);
    }

    public function create()
    {
        echo "Création d'un film";
    }

    public function read(array $queryParams)
    {

        $id = (int) $queryParams['id'];
        $filmRepository = new FilmRepository();
        $film = $filmRepository->findById($id);

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