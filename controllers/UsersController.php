<?php

/**
 * 
 * 
 */
class UsersController extends BaseController
{


    // Initialisation du contructeur par défaut
    public function __construct()
    {
        parent::__construct();
    }

    // Authentication home page
    public function loginPage()
    {

        // on choisi la template à appeler
        $template = $this->twig->load('users/login.html');

        // Puis on affiche la page avec la méthode render
        echo $template->render([]);
    }

    public function loginAuthentication()
    {

        if (isset($_POST['email']) && isset($_POST['password'])) {
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);

            $userInstance = new User(connectDB::dbConnect());
            $user = $userInstance->connexion($email, $password);

            if ($user != 0) {
                $template = $this->twig->load('users/administrationhome.html');
                $_SESSION["email"] = $user["email"];
                $_SESSION["username"] = $user["username"];
                $_SESSION["id"] = $user["id"];
            } else {
                $template = $this->twig->load('users/login.html');
            }
        } else {
            $template = $this->twig->load('users/login.html');
        }
        echo $template->render([$_SESSION]);
    }

    public function disconnect()
    {
        session_destroy();
        header("Location: http://project5/users/login");
    }

    // Inscription home page
    public function register()
    {

        // on choisi la template à appeler
        $template = $this->twig->load('users/inscription.html');

        // Puis on affiche la page avec la méthode render
        echo $template->render([]);
    }

    public function registrationVerification()
    {
        $error = "";
        if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password2']) && !empty($_POST['username'])) {
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);
            $username = htmlspecialchars($_POST['username']);

            if ($_POST['password'] === $_POST['password2']) {

                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $userInstance = new User(connectDB::dbConnect());
                    $checkInscription = $userInstance->Inscription($email, $password, $username);

                    if ($checkInscription == 1) {
                        $template = $this->twig->load('users/login.html');

                    } else {
                        $template = $this->twig->load('users/inscription.html');
                        $error = "Erreur système";

                    }
                } else {
                    $template = $this->twig->load('users/inscription.html');
                    $error = "Email invalide";
                }
            } else {
                $template = $this->twig->load('users/inscription.html');
                $error = "Le second mot de passe est différent du premier";
            }
        } else {
            $template = $this->twig->load('users/inscription.html');
            $error = "Un champ n'est pas connu";
        }
        echo $template->render(['error' => $error]);
    }
}



