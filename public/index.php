<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// Initialisation de Twig
$loader = new FilesystemLoader(__DIR__ . '/../src/views/');
$twig = new Environment($loader);

// Connexion à la base de données
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__ ) . '/.docker');
$dotenv->load();


$host = "filmoteca_db";
$dbname = $_ENV['MYSQL_DATABASE'];
$username = $_ENV['MYSQL_USER'];
$password = $_ENV['MYSQL_PASSWORD'];


try {
    $pdo = new PDO("mysql:host=$host; dbname=$dbname; charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
    exit; // Arrêter l'exécution si la connexion échoue
}

// Passer Twig et PDO à l'instance de Router
$router = new Router($twig, $pdo);
$router->route();
