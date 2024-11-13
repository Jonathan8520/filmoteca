<?php

require_once 'vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

// Connexion à la base de données
try {
    $pdo = new PDO('mysql:host=localhost;dbname=filmoteca', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
    exit; // Arrêter l'exécution si la connexion échoue
}


require_once 'src/Router.php';

$router = new Router($twig, $pdo);
$router->route();
