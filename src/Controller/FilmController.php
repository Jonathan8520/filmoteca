<?php

namespace App\Controller;

use App\Repository\FilmRepository;
use App\Service\EntityMapper;
use App\Entity\Film;

class FilmController extends BaseController
{

    private $filmRepository;
    private $entityMapper;

    public function __construct($twig)
    {
        parent::__construct($twig);
        $this->filmRepository = new FilmRepository();
        $this->entityMapper = new EntityMapper();
    }

    public function index()
    {
        $films = $this->filmRepository->findAll();

        echo $this->twig->render('film/films.html.twig', ['films' => $films]);
    }

    public function list()
    {
        $films = $this->filmRepository->findAll();

        echo $this->twig->render('film/films_liste.html.twig', ['films' => $films]);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $newFilm = $this->entityMapper->mapToEntity($_POST, Film::class);

            if ($this->filmRepository->create($newFilm)) {
                $this->setFlash('success', 'Le film "' . $newFilm->getTitle() . '" a bien été ajouté.');
            } else {
                $this->setFlash('danger', 'Une erreur est survenue lors de l\'ajout du film.');
            }

            header('Location: /films');
            exit;
        }

        echo $this->twig->render('film/film_add.html.twig');
    }

    public function read(array $queryParams): void
    {
        $id = (int) $queryParams['id'];
        $filmRepository = new FilmRepository();
        $film = $filmRepository->findById($id);

        echo $this->twig->render('film/film_details.html.twig', ['film' => $film]);
    }

    public function update(array $queryParams): void
    {
        $id = (int) $queryParams['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $updatedFilm = $this->entityMapper->mapToEntity($_POST, Film::class);
            $updatedFilm->setId($id);
    
            if ($this->filmRepository->update($id, $updatedFilm)) {
                $this->setFlash('success', 'Le film "' . $updatedFilm->getTitle() . '" a bien été modifié.');
            } else {
                $this->setFlash('danger', 'Une erreur est survenue lors de la modification du film.');
            }

            header('Location: /films/list');
            exit;
        }

        $film = $this->filmRepository->findById($id);

        echo $this->twig->render('film/film_modif.html.twig', ['film' => $film]);
    }

    public function delete(array $queryParams): void
    {
        $id = (int) $queryParams['id'];

        if ($this->filmRepository->delete($id)) {
            $this->setFlash('success', "Le film $id a bien été supprimé.");
        } else {
            $this->setFlash('danger', 'Une erreur est survenue lors de la suppression du film.');
        }

        header('Location: /films/list');
        exit;
    }
}
