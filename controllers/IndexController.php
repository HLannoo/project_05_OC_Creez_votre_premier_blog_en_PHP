<?php
/**
 *
 *
 */
class IndexController extends BaseController

{


    public function index($params = array())
    {
        $articlesinstance = new Articles(connectDB::dbConnect());
        $listarticles = $articlesinstance->getArticles();
        $manager = new \Psecio\Csrf\Manager();



        // on choisi la template à appeler
        $template = $this->twig->load('index/index.html');

        // Puis on affiche avec la méthode render
        echo $template->render(['listarticles' => $listarticles, 'formcontact_token' => $manager->generate()]);
    }

    public function contactEmail()
    {
        $manager = new \Psecio\Csrf\Manager();
        if (isset($_POST['csrf-token'])) {
            $result = $manager->verify($_POST['csrf-token']);
            if ($result === false) {
                header("Location: http://project5/error500");
            }
            if (!empty($_POST['surname']) && !empty($_POST['firstname']) && !empty($_POST['email']) && !empty($_POST['message'])) {
                $surname = htmlspecialchars($_POST['surname']);
                $firstname = htmlspecialchars($_POST['firstname']);
                $email = htmlspecialchars($_POST['email']);
                $message = htmlspecialchars($_POST['message']);
                $headers = "FROM : $email, $surname, $firstname";


                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailinstance = new Contact;
                    $emailinstance->sendEmail($email, $message, $headers);

                    header("Location: http://project5/");

                }
            }
        }
    }
}
