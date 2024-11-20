<?php

namespace App\Controller;

use App\Repository\FilmRepository;

class FilmController
{
    private $twig;
    private $filmRepository;

    public function __construct($twig, $pdo)
    {
        $this->twig = $twig;
        $this->filmRepository = new FilmRepository($pdo);
    }

    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
            $this->delete($_GET['id']);
        }

        $films = $this->filmRepository->findAll();
        echo $this->twig->render('films.html.twig', ['films' => $films]);
    }

    public function create() 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'],
                'year' => $_POST['year'],
                'genre' => $_POST['genre'],
                'synopsis' => $_POST['synopsis'],
                'director' => $_POST['director']
            ];
            $this->filmRepository->create($data);
            header('Location: /films');
            exit();
        }
    }

    public function read($id)
    {
        $film = $this->filmRepository->findById($id);
        echo $this->twig->render('film_detail.html.twig', ['film' => $film]);
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'],
                'year' => $_POST['year'],
                'genre' => $_POST['genre'],
                'synopsis' => $_POST['synopsis'],
                'director' => $_POST['director']
            ];
            $this->filmRepository->update($id, $data);
            header('Location: /films');
            exit();
        }

        $film = $this->filmRepository->findById($id);
        echo $this->twig->render('film_edit.html.twig', ['film' => $film]);
    }

    public function delete($id)
    {
        $this->filmRepository->delete($id);
        header('Location: /films');
        exit();
    }
}
