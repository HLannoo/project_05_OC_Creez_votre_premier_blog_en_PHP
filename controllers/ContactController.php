<?php

/**
 * 
 * 
 */

class ContactController extends BaseController
{

    public function contactEmail()
    {
        if (!empty($_POST['surname']) && !empty($_POST['firstname']) && !empty($_POST['email']) && !empty($_POST['message'])) {
            $surname = htmlspecialchars($_POST['surname']);
            $firstname = htmlspecialchars($_POST['firstname']);
            $email = htmlspecialchars($_POST['email']);
            $message = htmlspecialchars($_POST['message']);
            $headers = "FROM : $email, $surname, $firstname";

            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailinstance = new Contact;
                $emailinstance->sendEmail($email,$message,$headers);

                $articlesinstance = new Articles(connectDB::dbConnect());
                $listarticles = $articlesinstance->getArticles();

                // on choisi la template à appeler
                $template = $this->twig->load('index/index.html');

                // Puis on affiche avec la méthode render
                echo $template->render(['listarticles' => $listarticles]);

            }

        }
    }
}
