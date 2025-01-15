<?php

namespace App\Controller;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class ContactController extends BaseController
{
    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupération des données du formulaire
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $subject = $_POST['subject'] ?? '';
            $message = $_POST['message'] ?? '';

            if (empty($name) || empty($email) || empty($subject) || empty($message)) {
                $this->setFlash('danger', 'Tous les champs sont obligatoires.');
                header('Location: /contact');
                exit;
            }

            // Envoi de l'email via PHPMailer
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'mailhog'; // Nom du conteneur MailHog
                $mail->Port = 1025; // Port MailHog pour SMTP
                $mail->SMTPAuth = false; // Pas d'authentification

                $mail->setFrom($email, $name);
                $mail->addAddress('admin@example.com');

                $mail->Subject = $subject;
                $mail->Body = $message;

                $mail->send();
                $this->setFlash('success', 'Votre message a été envoyé avec succès.');
            } catch (Exception $e) {
                $this->setFlash('danger', "Une erreur est survenue lors de l'envoi de votre message. Erreur: {$mail->ErrorInfo}");
            }

            header('Location: /contact');
            exit;
        }

        echo $this->twig->render('contact.html.twig');
    }
}
