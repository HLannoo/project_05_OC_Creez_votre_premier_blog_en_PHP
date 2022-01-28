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
    public function indexAuth() {

        // on choisi la template à appeler
        $template = $this->twig->load('users/login.html');

        // Puis on affiche la page avec la méthode render
        echo $template->render([]);
    }

    public function userAuth()
    {
        $articleInstance = new Articles(connectDB::dbConnect());
        $listarticles=$articleInstance->getArticles();


        if (isset($_POST['email']) && isset($_POST['password']))
        {
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);

            $userInstance = new User(connectDB::dbConnect());
            $user = $userInstance->connexion($email, $password);

            if ($user != 0) {
                $_SESSION["email"]=$user["email"];
                $_SESSION["username"]=$user["username"];
                $_SESSION["id"]=$user["id"];
                $template = $this->twig->load('users/administrationpage.html');
            } else {
                $template = $this->twig->load('users/login.html');
            }
        }
        else
        {
            $template = $this->twig->load('users/login.html');
        }
        echo $template->render(['site_link'=>SITE_URL, 'listarticles' => $listarticles]);
    }

    // Inscription home page
    public function indexIns() {

        // on choisi la template à appeler
        $template = $this->twig->load('users/inscription.html');

        // Puis on affiche la page avec la méthode render
        echo $template->render([]);
    }

    public function insCheck()
    {
        if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password2']) && isset($_POST['username']) && ($_POST['password'])===($_POST['password2']))
        {
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);
            $username = htmlspecialchars($_POST['username']);

            $userInstance = new User(connectDB::dbConnect());

            if ($userInstance->Inscription($email, $password, $username) == 1)
            {
                $template = $this->twig->load('users/login.html');
            }
            else
            {
                $template = $this->twig->load('users/inscription.html');
            }
        }
        else
        {
            $template = $this->twig->load('users/inscription.html');
        }
        echo $template->render([]);
    }
}
