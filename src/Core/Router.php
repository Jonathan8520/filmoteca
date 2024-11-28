<?php

namespace App\Core;

use App\Controller\HomeController;
use App\Controller\FilmController;
use App\Controller\ContactController;

class Router
{
    private $twig;

    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    public function route()
    {
        // Récupère l'URL demandée (sans le domaine et la racine)
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        // Découpe l'URI pour obtenir la route et l'action
        $parts = explode('/', $uri); // Exemple : ['films', 'create']
        $route = $parts[0] ?? null;   // 'films'
        $action = $parts[1] ?? 'index'; // 'create', si rien n'est défini, on prend 'index' par défaut

        // Définit les routes et leurs contrôleurs associés
        $routes = [
            '' => 'HomeController',
            'films' => 'FilmController',
            'contact' => 'ContactController',
        ];

        if (array_key_exists($route, $routes)) {
            // Crée dynamiquement le contrôleur
            $controllerName = 'App\\Controller\\' . $routes[$route];
            if (!class_exists($controllerName)) {
                echo "Controller '$controllerName' not found";
                return;
            }

            // Instancie le contrôleur en passant l'instance de Twig
            $controller = new $controllerName($this->twig);

            // Vérifie si la méthode existe dans le contrôleur
            if (method_exists($controller, $action)) {
                $queryParams = $_GET; // Récupère les paramètres éventuels
                $controller->$action($queryParams); // Appelle la méthode dynamique
            } else {
                echo "Action '$action' not found in $controllerName";
            }
        } else {
            // Si la route n'existe pas, affiche une page 404
            echo $this->twig->render('404.html.twig');
        }
    }
}
