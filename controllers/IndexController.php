<?php
/**
 *
 *
 */
class IndexController extends BaseController

{

    public function index()
    {
        $articlesinstance = new Articles(ConnectDB::dbConnect());
        $listarticles = $articlesinstance->getArticles();
        $manager = new \Psecio\Csrf\Manager();

        // on choisi la template à appeler
        $template = $this->twig->load('index/index.html');

        // Puis on affiche avec la méthode render
       $view = $template->render(['SITE_LINK'=>SITE_URL, 'listarticles' => $listarticles, 'form_contact_token' => $manager->generate()]);
        echo $view;

    }

    public function contactEmail()
    {
        $manager = new \Psecio\Csrf\Manager();

        if (isset($_POST['csrf-token'])) {
            $result = $manager->verify($_POST['csrf-token']);
            if ($result === false) {
                header("Location: ".ERROR_500);
            }
            if (!empty($_POST['surname']) && !empty($_POST['firstname']) && !empty($_POST['email']) && !empty($_POST['message'])) {
                $surname = htmlspecialchars(stripslashes($_POST['surname']));
                $firstname = htmlspecialchars(stripslashes($_POST['firstname']));
                $email = htmlspecialchars(stripslashes(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)));
                $message = htmlspecialchars(stripslashes($_POST['message']));
                $headers = "FROM : $email, $surname, $firstname";


                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailinstance = new Contact;
                    $emailinstance->sendEmail($email, $message, $headers);
                    $template = $this->twig->load('index/merci.html');
                    $error='';

                } else {
                    $error = 'Email Invalide';
                    $template = $this->twig->load('index/index.html');

                }
            }
                else {
                    $error = 'Un champ est manquant';
                    $template = $this->twig->load('index/index.html');
            }
        }
        $view = $template->render([ 'error' => $error,'form_contact_token' => $manager->generate(),'SITE_LINK'=> SITE_URL]);
        echo $view;
    }
}
