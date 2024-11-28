<?php

namespace App\Controller;

use Twig\Environment;

class BaseController
{
    protected Environment $twig;

    // Passer l'instance de Twig depuis le Router
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;

        // Démarrer la session (si elle n'est pas déjà démarrée) pour les messages flash
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Ajouter les messages flash comme global pour Twig
        $this->twig->addGlobal('app', [
            'session' => [
                'flash' => $this->getFlash()
            ]
        ]);
    }

    // Méthode pour définir un message flash
    protected function setFlash(string $type, string $message)
    {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }

    // Méthode pour récupérer un message flash (et le supprimer)
    protected function getFlash(): ?array
    {
        if (isset($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']); // Supprime après lecture
            return $flash;
        }
        return null;
    }
}
