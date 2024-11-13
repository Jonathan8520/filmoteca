<?php

namespace App\Core;

class Router
{
    private $twig;
    private $pdo;

    public function __construct($twig, $pdo)
    {
        $this->twig = $twig;
        $this->pdo = $pdo;
    }

    public function route()
    {
        $requestUri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        $routes = [
            '' => 'HomeController', // Page d'accueil
            'films' => 'FilmController',
            'contact' => 'ContactController',
        ];

        if (array_key_exists($requestUri, $routes)) {
            $controllerName = "App\\Controller\\" . $routes[$requestUri];
            
            if (class_exists($controllerName)) {
                $controller = new $controllerName($this->twig, $this->pdo);
                $controller->index();
            } else {
                echo "Erreur : Le contrôleur $controllerName n'existe pas.";
            }
        } else {
            echo "404 Not Found";
        }
    }
}
