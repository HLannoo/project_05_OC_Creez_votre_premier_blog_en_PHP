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
        echo $template->render(['listarticles' => $listarticles]);
    }

    public function detail($id)
    {
        $verifiedId= htmlspecialchars($id);
        $idCheck = new Articles(connectDB::dbConnect());
        $resultCheck = $idCheck->checkId($verifiedId);


        if ($resultCheck)
        {
            $articleInstance = new Articles(connectDB::dbConnect());
            $article = $articleInstance->getArticleById($id);

            $template = $this->twig->load('posts/pageid.html');

            echo $template->render(['article' => $article, 'comments' => $this->getAllArticleComments($id)]);
        }
        else
        {
            $articlesInstance = new Articles(connectDB::dbConnect());
            $listarticles = $articlesInstance->getArticles();

        $template = $this->twig->load('posts/index.html');

        echo $template->render(['listarticles' => $listarticles]);
        }
    }


    public function addComment($id)
    {
        $content = htmlspecialchars($_POST['content']);
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $title = htmlspecialchars($_POST['title']);
        $idarticle = htmlspecialchars($id);

        $commentInstance = new Comments(connectDB::dbConnect());

        $result = $commentInstance->insertComment($pseudo, $title, $content, $idarticle);
        if ($result) {
            header("Location: http://project5/posts/$id/success");
            exit();
        }
        else {
            //add error page (500)
        }

    }

    private function getAllArticleComments($articleid)
    {
        $commentsInstance = new Comments(connectDB::dbConnect());
        $results = $commentsInstance->getAllArticleComments($articleid);
        return $results;


    }
}