<?php

/**
 * 
 * 
 */
class AdminController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function commentAdminPage()
    {
        if ($_SESSION) {
            $commentsinstance = new Comments(connectDB::dbConnect());
            $listcomments = $commentsinstance->getComments();

            $template = $this->twig->load('users/commentadministration.html');
            echo $template->render(['listcomments' => $listcomments]);
        }
        else {
            header("Location: http://project5/users/login");;
        }
    }




    public function articleAdminPage()
    {
        if ($_SESSION) {

            $commentsinstance = new Articles(connectDB::dbConnect());
            $listarticles = $commentsinstance->getArticles();

            $template = $this->twig->load('users/articleadministration.html');
            echo $template->render(['site_link' => SITE_URL, 'listarticles' => $listarticles]);
        }

        else {
            header("Location: http://project5/users/login");;
        }
    }


    public function accComment($id)
    {
        $commentsInstance = new Comments(connectDB::dbConnect());

        if (isset($id)) {
                $commentsInstance->valComment($id);

        }
        $template = $this->twig->load('users/commentadministration.html');
        $listcomments=$commentsInstance->getComments();
        echo $template->render(['listcomments' => $listcomments]);
    }

    public function refComment($id)
    {
        $commentsInstance = new Comments(connectDB::dbConnect());

        if (isset($id)) {
                $commentsInstance->denComment($id);


        }
        $template = $this->twig->load('users/commentadministration.html');
        $listcomments=$commentsInstance->getComments();
        echo $template->render(['listcomments' => $listcomments]);
    }
    public function delComment($id)
    {
        $commentsInstance = new Comments(connectDB::dbConnect());

        if (isset($id)) {
            $commentsInstance->suprComment($id);


        }
        $template = $this->twig->load('users/commentadministration.html');
        $listcomments=$commentsInstance->getComments();
        echo $template->render(['listcomments' => $listcomments]);
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
                header("Location: http://project5/users/admin");
            }
        }
        $template = $this->twig->load('users/articleadministration.html');
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
        $template = $this->twig->load('users/articleadministration.html');
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
        $template = $this->twig->load('users/articleadministration.html');
        $listarticles=$articleInstance->getArticles();
        echo $template->render(['ligne' => $ligne , 'listarticles' => $listarticles]);
    }
}

