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

    public function detail($id, $error = null)
    {
        $articleinstance = new Articles(connectDB::dbConnect());
        $article = $articleinstance->getArticleById($id);

        // on choisi la template à appeler
        $template = $this->twig->load('posts/pageid.html');

        // Puis on affiche avec la méthode render
        echo $template->render(['article' => $article, 'error' => $error, 'comments' => $this->getAllArticleComments($id)]);
    }

    public function addComment($id)
    {
        $content = $_POST['content'];
        $pseudo = $_POST['pseudo'];
        $title = $_POST['title'];
        $idarticle = $id;

        $commentInstance = new Comments(connectDB::dbConnect());

        $result = $commentInstance->insertComment($pseudo, $title, $content, $idarticle);
        header("Location: http://project5/posts/$id");
        exit();

    }

    private function getAllArticleComments($articleid)
    {
        $commentsInstance = new Comments(connectDB::dbConnect());
        $results = $commentsInstance->getAllArticleComments($articleid);
        return $results;


    }

    public function addArticle()
    {
        $articleInstance = new Articles(connectDB::dbConnect());
        $listarticles=$articleInstance->getArticles();

        if (isset($_POST['title']) && isset($_POST['chapo']) && isset($_POST['content'])) {
            $title = addslashes(htmlspecialchars($_POST['title']));
            $chapo = addslashes(htmlspecialchars($_POST['chapo']));
            $content = addslashes(htmlspecialchars($_POST['content']));
            $slug = addslashes(htmlspecialchars($_POST['slug']));
            $id=($_POST['id']);
            $userid = $_SESSION["id"];

            $imgpath = null;

            if(!empty($_FILES['img']))
            {
                $temp = explode(".", $_FILES["img"]["name"]);
                $newfilename = round(microtime(true)) . '.' . end($temp);

                if (move_uploaded_file(($_FILES['img']['tmp_name']),UPLOADS_DIRECTORY . $newfilename)) {

                    $imgpath = $newfilename;

                }
            }



            $checkid = $articleInstance->checkId($id);


          if ($checkid == 0) {

              $articleInstance->insertArticle($title, $chapo, $content, $slug, $userid, $imgpath);
            }
            elseif ($checkid == 1) {

                $articleInstance->replaceArticle($title, $chapo, $content, $slug, $userid,$id, $imgpath);
            }
            else
            {
                header("Location: http://project5/users/admin/gestion");
            }
        }
        $template = $this->twig->load('users/administrationpage.html');
        $listarticles=$articleInstance->getArticles();
        echo $template->render(['listarticles' => $listarticles]);
    }
    public function delArticle($id)
    {
        $articleInstance = new Articles(connectDB::dbConnect());
        $listarticles=$articleInstance->getArticles();

        if (isset($id)) {

            $checkId = $articleInstance->checkId($id);

            if ($checkId == true) {
                $articleInstance->suppArticle($id);
            }
            else
            {
                header("Location: http://project5/users/admin");
            }
        }
        $template = $this->twig->load('users/administrationpage.html');
        $listarticles=$articleInstance->getArticles();
        echo $template->render(['listarticles' => $listarticles]);
    }

    public function updateArticle($id)
    {
        $articleInstance = new Articles(connectDB::dbConnect());
        $listarticles=$articleInstance->getArticles();

        if (isset($id)) {

            $checkId = $articleInstance->checkId($id);

            if ($checkId == true) {
                $ligne=$articleInstance->modArticle($id);
            }
            else
            {
                header("Location: http://project5/users/admin");
            }
        }
        $template = $this->twig->load('users/administrationpage.html');
        $listarticles=$articleInstance->getArticles();
        echo $template->render(['ligne' => $ligne , 'listarticles' => $listarticles]);
    }
}