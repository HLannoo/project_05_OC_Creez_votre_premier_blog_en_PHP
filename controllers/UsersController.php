<?php

/**
 * 
 * 
 */
class UsersController extends BaseController
{

    // Authentication home page
    public function loginPage()
    {
        $manager = new \Psecio\Csrf\Manager();
        if (isset($_SESSION["email"]) && isset($_SESSION["id"]) && ($_SESSION["role"]==2)) {
            $template = $this->twig->load('users/administrationhome.html');
        }
        else {

            // on choisi la template à appeler
            $template = $this->twig->load('users/login.html');

            // Puis on affiche la page avec la méthode render
        }
        $view = $template->render(['login_token' => $manager->generate()]);
        echo $view;;
    }

    public function loginAuthentication()
    {
        $error = "";
        $manager = new \Psecio\Csrf\Manager();
        if (isset($_POST['csrf_token'])) {
            $result = $manager->verify(stripslashes($_POST['csrf_token']));
            if ($result === false) {
                header("Location:".ERROR_500);
            }

            if (!empty($_POST['email']) && !empty($_POST['password'])) {
                $email = htmlspecialchars(filter_var(stripslashes($_POST['email']),FILTER_VALIDATE_EMAIL));
                $password = htmlspecialchars(stripslashes($_POST['password']));

                $userInstance = new User(ConnectDB::dbConnect());
                $user = $userInstance->connexion($email, $password);
                if (!empty($user)) {
                    $resultRole = $user['role'];

                    switch ($resultRole) {
                        case 3:
                            $template = $this->twig->load('users/login.html');
                            $error = "Votre demande de compte administrateur n'a pas été validé";
                            break;
                        case 2:
                            $template = $this->twig->load('users/administrationhome.html');
                            $_SESSION["email"] = $user["email"];
                            $_SESSION["username"] = $user["username"];
                            $_SESSION["id"] = $user["id"];
                            $_SESSION["role"] = $user["role"];
                            break;
                        case 0:
                            $template = $this->twig->load('users/login.html');
                            $error = "Votre compte est en attente d'une vérification par un admin";
                            break;
                        default:
                            $template = $this->twig->load('users/login.html');
                            $error = "Un problème inconnu est survenu";
                    }
                } else {
                    $template = $this->twig->load('users/login.html');
                    $error = "Aucun compte administrateur n'existe avec ces identifiants";
                }
            } else {
                $template = $this->twig->load('users/login.html');
                $error = "Un champ est manquant";
            }

        }
                $view = $template->render(['error' => $error,'login_token' => $manager->generate()]);
                echo $view;;
            }




    public function disconnect()
    {
        session_destroy();
        header("Location:".SITE_URL);
    }

    // Inscription home page
    public function register()
    {
        $manager = new \Psecio\Csrf\Manager();

        // on choisi la template à appeler
        $template = $this->twig->load('users/inscription.html');

        // Puis on affiche la page avec la méthode render
        $view = $template->render(['inscription_token' => $manager->generate()]);
        echo $view;;
    }

    public function registrationVerification()
    {
        $error = "";
        $manager = new \Psecio\Csrf\Manager();
        if (isset($_POST['csrf_token'])) {
            $result = $manager->verify(stripslashes($_POST['csrf_token']));
            if ($result === false) {
                header("Location:".ERROR_500);
            }
            if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password2']) && !empty($_POST['username'])) {
                $email = htmlspecialchars(stripslashes($_POST['email']));
                $password = htmlspecialchars(stripslashes($_POST['password']));
                $username = htmlspecialchars(stripslashes($_POST['username']));

                if ($_POST['password'] === $_POST['password2']) {

                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $userInstance = new User(ConnectDB::dbConnect());
                        $checkInscription = $userInstance->Inscription($email, $password, $username);

                        if ($checkInscription == 1) {
                            header("Location:".LOGIN_PAGE);

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
        }
            $view = $template->render(['error' => $error,'inscription_token' => $manager->generate()]);
            echo $view;;

    }
}



