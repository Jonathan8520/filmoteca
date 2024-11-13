<?php

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
        $requestUri = $_SERVER['REQUEST_URI'];

        /*
                 if ($requestUri === '/films') {
                    var_dump('films');
                    $films = $this->pdo->query("SELECT * FROM movie")->fetchAll(PDO::FETCH_ASSOC);
                    echo $this->twig->render('films.html.twig', ['films' => $films]);
                } elseif ($requestUri === '/contact') {
                    var_dump('Contact');
                    echo $this->twig->render('contact.html.twig');
                } else {
                    var_dump('Accueil');
                    echo $this->twig->render('index.html.twig');
                }
        */
        
        switch ($requestUri) {
            case '/films':
                var_dump('films');
                $films = $this->pdo->query("SELECT * FROM movie")->fetchAll(PDO::FETCH_ASSOC);
                echo $this->twig->render('films.html.twig', ['films' => $films]);
                break;
            case '/contact':
                var_dump('Contact');
                echo $this->twig->render('contact.html.twig');
                break;
            default:
                var_dump('Accueil');
                echo $this->twig->render('index.html.twig');
                break;
        }
    }
}
