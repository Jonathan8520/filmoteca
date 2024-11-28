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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $filmRepository = new FilmRepository();

            $newFilm = [
                'title' => $_POST['title'],
                'year' => (int) $_POST['year'],
                'synopsis' => $_POST['synopsis'],
                'director' => $_POST['director'],
                'type' => $_POST['type'],
            ];

            if ($filmRepository->create($newFilm)) {
                $this->setFlash('success', 'Le film "' . $newFilm['title'] . '" a bien été ajouté.');
            } else {
                $this->setFlash('danger', 'Une erreur est survenue lors de l\'ajout du film.');
            }

            header('Location: /films');
            exit;
        }

        echo $this->twig->render('film_add.html.twig');
    }

    public function read(array $queryParams)
    {

        $id = (int) $queryParams['id'];
        $filmRepository = new FilmRepository();
        $film = $filmRepository->findById($id);

        echo $this->twig->render('film_details.html.twig', ['film' => $film]);
    }

    public function update(array $queryParams)
    {
        $id = (int) $queryParams['id'];
        $filmRepository = new FilmRepository();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $updatedFilm = [
                'id' => $id,
                'title' => $_POST['title'],
                'year' => (int) $_POST['year'],
                'synopsis' => $_POST['synopsis'],
                'director' => $_POST['director'],
                'type' => $_POST['type'],
            ];

            $filmRepository->update($id, $updatedFilm);

            if ($filmRepository->update($id, $updatedFilm)) {
                $this->setFlash('success', 'Le film "' . $updatedFilm['title'] . '" a bien été modifié.');
            } else {
                $this->setFlash('danger', 'Une erreur est survenue lors de la modification du film.');
            }

            header('Location: /films/list');
            exit;
        }

        $film = $filmRepository->findById($id);

        echo $this->twig->render('film_modif.html.twig', ['film' => $film]);
    }

    public function delete(array $queryParams)
    {
        $id = (int) $queryParams['id'];
        $filmRepository = new FilmRepository();

        if ($filmRepository->delete($id)) {
            $this->setFlash('success', "Le film $id a bien été supprimé.");
        } else {
            $this->setFlash('danger', 'Une erreur est survenue lors de la suppression du film.');
        }

        header('Location: /films/list');
        exit;
    }
}
