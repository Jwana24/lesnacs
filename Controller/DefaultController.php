<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class DefaultController extends Controller
{
    public function index()
    {
        $titlePage = 'Le site LesNACs';
        $articleManager = new ArticleManager();
        $articles = $articleManager->showLast();

        // Send message with the form on the homepage
        $errors = [];

        if(!empty($_POST))
        {
            $post = array_map('trim', array_map('strip_tags', $_POST));

            if(!isset($post['lastName']) || !preg_match('#^[A-z0-9-_ ]{4,50}$#', $post['lastName']))
            {
                $errors[] = 'Votre nom n\'est pas valide, il ne doit contenir aucun accent';
            }

            if(!isset($post['firstName']) || !preg_match('#^[A-z0-9-_ ]{4,50}$#', $post['firstName']))
            {
                $errors[] = 'Votre prénom n\'est pas valide';
            }

            if(!isset($post['mail']) || !preg_match('#^[A-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,5}$#', $post['mail']))
            {
                $errors[] = 'Votre email n\'est pas valide';
            }

            if(!isset($post['message']) || !preg_match('#^.{2,450}$#', $post['message']))
            {
                $errors[] = 'Votre message doit comporter entre 2 est 450 caractères maximum';
            }

            if(count($errors) == 0)
            {
                $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
                try
                {
                    //Server settings
                    // $mail->SMTPDebug = 2;                                 // Enable verbose debug output
                    $mail->isSMTP();                                      // Set mailer to use SMTP
                    $mail->Host = 'smtp.office365.com';                   // Specify main and backup SMTP servers
                    $mail->SMTPAuth = true;                               // Enable SMTP authentication
                    $mail->Username = '';                                 // SMTP username
                    $mail->Password = '';                                 // SMTP password
                    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                    $mail->Port = 587;                                    // TCP port to connect to

                    //Recipients
                    $mail->setFrom('', 'Mailer');
                    $mail->addAddress('', 'LesNacs');                     // Add a recipient

                    //Content
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = 'Envoi de message via le formulaire de la page d\'accueil';
                    $mail->Body    = 'Le message de : '.$post['lastName'].' '.$post['firstName'].' ('.$post['mail'].')'.'<br/>'.$post['message'];
                    $mail->AltBody = 'Le message de : '.$post['lastName'].' '.$post['firstName'].' ('.$post['mail'].')'.$post['message'];

                    $mail->send();
                    $this->addMessages('Votre message a bien été envoyé !', 'success');
                }
                catch (Exception $e)
                {
                    $this->addMessages('Il y a eu une erreur lors de l\'envoi du mail', 'error');
                }
            }
            else
            {
                foreach($errors as $error)
                {
                    $this->addMessages($error, 'error');
                }
            }
        }
        ob_start();
        require '../View/general/homepage.php';
        echo ob_get_clean();
    }

    public function mentionsLegales()
    {
        $titlePage = $this->translation('Mentions légales');
        // We create a cookie bandeau bound to the legacy notices's page, when the visitor go to this page, the cookie are accepted for 1 year
        setcookie('cookie-bandeauCookie', 'myseconddata', time() + 32140800, "/");

        ob_start();
        require '../View/general/legalnotices.php';
        echo ob_get_clean();
    }

}