<?php
/**
 * 
 * 
 */
class PostsController extends BaseController
{


    // Initialisation du contructeur par défaut
    public function __construct()
    {
        parent::__construct();
    }

    // Page d'accueil
    public function index($params = array())
    {

        $articlesinstance = new Articles(connectDB::dbConnect());
        $listarticles = $articlesinstance->getArticles();


        // on choisi la template à appeler
        $template = $this->twig->load('posts/index.html');

        // Puis on affiche avec la méthode render
        $view =  $template->render(['listarticles' => $listarticles]);
        echo $view;
    }

    public function detail($id)
    {
        $verifiedId= htmlspecialchars($id);
        $idCheck = new Articles(connectDB::dbConnect());
        $resultCheck = $idCheck->checkId($verifiedId);
        $manager = new \Psecio\Csrf\Manager();


        if ($resultCheck)
        {
            $articleInstance = new Articles(connectDB::dbConnect());
            $article = $articleInstance->getArticleById($id);

            $template = $this->twig->load('posts/pageid.html');

            $view = $template->render(['SITE_LINK' => SITE_URL,'article' => $article, 'comments' => $this->getAllArticleComments($id),'comment_token' => $manager->generate()]);
            echo $view;
        }
        else
        {
            $articlesInstance = new Articles(connectDB::dbConnect());
            $listarticles = $articlesInstance->getArticles();

        $template = $this->twig->load('posts/index.html');

        $view = $template->render(['listarticles' => $listarticles]);
        echo $view;
        }
    }


    public function addComment($id)
    {
        $articleInstance = new Articles(connectDB::dbConnect());
        $manager = new \Psecio\Csrf\Manager();

        if (!empty($_POST['content']) && !empty($_POST['pseudo']) && !empty($_POST['title'])) {

            if (isset($_POST['csrf_token'])) {
                $result = $manager->verify(stripslashes($_POST['csrf_token']));
                if ($result === false) {
                    header("Location:".ERROR_500);
                }
                $content = htmlspecialchars(stripslashes($_POST['content']));
                $pseudo = htmlspecialchars(stripslashes($_POST['pseudo']));
                $title = htmlspecialchars(stripslashes($_POST['title']));
                $idArticle = htmlspecialchars($id);

                $commentInstance = new Comments(connectDB::dbConnect());;
                $result = $commentInstance->insertComment($pseudo, $title, $content, $idArticle);

                if ($result) {
                    header("Location:".POSTS_MERCI);
                } else {
                    header("Location:".ERROR_500);
                }
            }
            else {
                header("Location:".ERROR_500);
                }
        } else {
            $error="Un champ est manquant dans votre commentaire.";
            $article = $articleInstance->getArticleById($id);
            $template = $this->twig->load('posts/pageid.html');
            $view = $template->render([
                'article' => $article,
                'comments' => $this->getAllArticleComments($id),
                'comment_token' => $manager->generate(),
                'error'=>$error]);
            echo $view;
        }
    }

    private function getAllArticleComments($articleid)
    {
        $commentsInstance = new Comments(connectDB::dbConnect());
        $results = $commentsInstance->getAllArticleComments($articleid);
        return $results;


    }
}