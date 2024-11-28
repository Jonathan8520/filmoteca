<?php

// Charge l'autoloader de Composer (si ce n'est pas déjà fait)
require_once __DIR__ . '/../vendor/autoload.php';

// Configuration de Twig
$loader = new \Twig\Loader\FilesystemLoader('../src/views');
$twig = new \Twig\Environment($loader, [
    'cache' => false,
]);

// Instancie le routeur en passant l'instance de Twig
$router = new \App\Core\Router($twig);
$router->route();
