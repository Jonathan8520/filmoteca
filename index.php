<?php
// Initialiser Twig
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


/////////////////////////////////////////////////////////// Fin pour la connexion


// Récupérer les films depuis la base de données
$films = $pdo->query("SELECT * FROM movie")->fetchAll(PDO::FETCH_ASSOC);

$requestUri = $_SERVER['REQUEST_URI'];

if ($requestUri === '/films') {
    echo $twig->render('films.html.twig', ['films' => $films]);
} elseif ($requestUri === '/contact') {
    echo $twig->render('contact.html.twig');
} else {
    echo $twig->render('index.html.twig');
}
