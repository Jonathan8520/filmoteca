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
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
            $this->delete($_GET['id']);
        }
    
        $films = $this->pdo->query("SELECT * FROM movie")->fetchAll(PDO::FETCH_ASSOC);
        echo $this->twig->render('films.html.twig', ['films' => $films]);
    }

    public function create() {}
    public function read($id) {}
    public function update($id) {}

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM movie WHERE id = :id");
        $stmt->execute([':id' => $id]);
    
        // Rediriger après suppression
        header('Location: /films');
        exit();
    }
    
}
