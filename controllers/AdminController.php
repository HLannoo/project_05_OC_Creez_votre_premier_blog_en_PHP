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
            $manager = new \Psecio\Csrf\Manager();

            $template = $this->twig->load('users/commentadministration.html');
            echo $template->render(['listcomments' => $listcomments,'comment_admin_token' => $manager->generate()]);
        }
        else {
            header("Location:".ERROR_500);
        }
    }


    public function articleAdminPage()
    {
        if ($_SESSION) {

            $articlesInstance = new Articles(connectDB::dbConnect());
            $listArticles = $articlesInstance->getArticles();
            $manager = new \Psecio\Csrf\Manager();

            $template = $this->twig->load('users/articleadministration.html');
            $view = $template->render(['site_link' => SITE_URL, 'listarticles' => $listArticles,'article_admin_token' => $manager->generate()]);
            echo $view;
        }

        else {
            header("Location:".ERROR_500);
        }
    }

    public function managementAdminPage()
    {
        if ($_SESSION) {

            $admininstance = new Admin(connectDB::dbConnect());
            $listadmins = $admininstance->getAdmins();
            $manager = new \Psecio\Csrf\Manager();

            $template = $this->twig->load('users/adminmanagement.html');
            $view =  $template->render(['site_link' => SITE_URL, 'listadmins' => $listadmins,'management_admin_token' => $manager->generate()]);
            echo $view;
        }

        else {
            header("Location:".ERROR_500);
        }
    }


    public function acceptComment($id)
    {
        $commentsInstance = new Comments(connectDB::dbConnect());
        $manager = new \Psecio\Csrf\Manager();
        if (isset($_POST['csrf_token'])) {
            $result = $manager->verify($_POST['csrf_token']);
            if ($result === false) {
                header("Location:".ERROR_500);
            }
                if (isset($id)) {
                    $commentsInstance->valComment($id);
                }
                    $template = $this->twig->load('users/commentadministration.html');
                    $listcomments = $commentsInstance->getComments();
                    $view = $template->render(['listcomments' => $listcomments,'comment_admin_token' => $manager->generate()]);
                    echo $view;
                }
    }

    public function refuseComment($id)
    {
        $commentsInstance = new Comments(connectDB::dbConnect());
        $manager = new \Psecio\Csrf\Manager();
        if (isset($_POST['csrf_token'])) {
            $result = $manager->verify($_POST['csrf_token']);
            if ($result === false) {
                header("Location:".ERROR_500);
            }
            if (isset($id)) {
                $commentsInstance->denComment($id);
            }
            $template = $this->twig->load('users/commentadministration.html');
            $listcomments = $commentsInstance->getComments();
            $view = $template->render(['listcomments' => $listcomments,'comment_admin_token' => $manager->generate()]);
            echo $view;
        }
    }

    public function deleteComment($id)
    {
        $commentsInstance = new Comments(connectDB::dbConnect());
        $manager = new \Psecio\Csrf\Manager();
        if (isset($_POST['csrf_token'])) {
            $result = $manager->verify($_POST['csrf_token']);
            if ($result === false) {
                header("Location:".ERROR_500);
            }

            if (isset($id)) {
                $commentsInstance->suprComment($id);


            }
            $template = $this->twig->load('users/commentadministration.html');
            $listcomments = $commentsInstance->getComments();
            $view = $template->render(['listcomments' => $listcomments,'comment_admin_token' => $manager->generate()]);
            echo $view;
        }
    }

    public function addArticle()
    {
        $articleInstance = new Articles(connectDB::dbConnect());
        $listarticles = $articleInstance->getArticles();
        $manager = new \Psecio\Csrf\Manager();

        if (isset($_POST['csrf_token'])) {
            $result = $manager->verify($_POST['csrf_token']);
            if ($result === false) {
                header("Location:" . ERROR_500);
                die;
            }
            if (isset($_POST['title']) && isset($_POST['chapo']) && isset($_POST['content'])) {
                $title = strip_tags($_POST['title'], '<br/><br>');
                $chapo = strip_tags($_POST['chapo'], '<br/><br>');
                $content = strip_tags($_POST['content'], '<br/><br>');
                $slug = strip_tags($_POST['slug'], '<br/><br>');
                $img = $_FILES['img'];
                $id = $_POST['id'];
                $userid = ($_SESSION["id"]);
                $checkId = $articleInstance->checkId($id);

                if ($checkId == 1 && $_FILES['img']['error']==4) {
                    $articleInstance->replaceArticleNoImg($title, $chapo, $content, $slug, $userid, $id);
                }
                else {
                    $security = new Security;
                    $newfilename = $security->securityReplacement();
                    $checkId = $articleInstance->checkId($id);

                    switch ($checkId) {

                        case 0;

                            if (move_uploaded_file(($_FILES['img']['tmp_name']), UPLOADS_DIRECTORY . $newfilename)) {
                                $imgPath = $newfilename;
                                $articleInstance->insertArticle($title, $chapo, $content, $slug, $userid, $imgPath);
                            }
                            break;

                        case 1;
                            $image = $articleInstance->getImage($id);
                            if (file_exists(UPLOADS_DIRECTORY . $image[0])) {
                                unlink(UPLOADS_DIRECTORY . $image[0]);
                                $imgPath = $newfilename;
                                $articleInstance->replaceArticle($title, $chapo, $content, $slug, $userid, $id, $imgPath);
                                if (move_uploaded_file(($_FILES['img']['tmp_name']), UPLOADS_DIRECTORY . $newfilename)) {
                                }
                            }
                            break;
                    }
                }
            }
                    }
                else {
            header("Location:" . ERROR_500);
        }
        $template = $this->twig->load('users/articleadministration.html');
        $listarticles = $articleInstance->getArticles();
        $view = $template->render(['listarticles' => $listarticles, 'article_admin_token' => $manager->generate()]);
        echo $view;
    }



    public function deleteArticle($id)
    {
        $articleInstance = new Articles(connectDB::dbConnect());
        $listarticles=$articleInstance->getArticles();
        $manager = new \Psecio\Csrf\Manager();
        if (isset($_POST['csrf_token'])) {
            $result = $manager->verify($_POST['csrf_token']);
            if ($result === false) {
                header("Location:" . ERROR_500);
            }

            if (isset($id)) {

                $checkId = $articleInstance->checkId($id);

                if ($checkId == true) {
                    $img = $articleInstance->getImage($id);
                    $articleInstance->suppArticle($id);
                }
                if (file_exists(UPLOADS_DIRECTORY . $img[0])){
                    unlink(UPLOADS_DIRECTORY . $img[0]);

                } else {
                    header("Location:".ERROR_500);
                }
            }
        }
        $template = $this->twig->load('users/articleadministration.html');
        $listarticles=$articleInstance->getArticles();
        $view = $template->render(['listarticles' => $listarticles,'article_admin_token' => $manager->generate()]);
        echo $view;
    }


    public function updateArticle($id)
    {
        $articleInstance = new Articles(connectDB::dbConnect());
        $listarticles = $articleInstance->getArticles();
        $manager = new \Psecio\Csrf\Manager();
        if (isset($_POST['csrf_token'])) {
            $result = $manager->verify($_POST['csrf_token']);
            if ($result === false) {
                header("Location:".ERROR_500);
            }

            if (isset($id)) {

                $checkId = $articleInstance->checkId($id);

                if ($checkId == true) {
                    $ligne = $articleInstance->modArticle($id);
                } else {
                    header("Location:".ERROR_500);
                }
            }
            $template = $this->twig->load('users/articleadministration.html');
            $listarticles = $articleInstance->getArticles();
            $view =  $template->render(['ligne' => $ligne, 'listarticles' => $listarticles, 'article_admin_token' => $manager->generate()]);
            echo $view;
        }
    }

    public function acceptAdmin($id)
    {
        $adminInstance = new Admin(connectDB::dbConnect());
        $manager = new \Psecio\Csrf\Manager();
        if (isset($_POST['csrf_token'])) {
            $result = $manager->verify($_POST['csrf_token']);
            if ($result === false) {
                header("Location:".ERROR_500);
            }

            if (isset($id)) {
                $adminInstance->valAdmin($id);

            }
            $template = $this->twig->load('users/adminmanagement.html');
            $listadmins = $adminInstance->getAdmins();
            $view =  $template->render(['site_link' => SITE_URL, 'listadmins' => $listadmins, 'management_admin_token' => $manager->generate()]);
            echo $view;
        }
    }
    public function refuseAdmin($id)
    {
        $adminInstance = new Admin(connectDB::dbConnect());
        $manager = new \Psecio\Csrf\Manager();
        if (isset($_POST['csrf_token'])) {
            $result = $manager->verify($_POST['csrf_token']);
            if ($result === false) {
                header("Location:".ERROR_500);
            }

            if (isset($id)) {
                $adminInstance->denAdmin($id);


            }
            $template = $this->twig->load('users/adminmanagement.html');
            $listadmins = $adminInstance->getAdmins();
            echo $template->render(['site_link' => SITE_URL, 'listadmins' => $listadmins, 'management_admin_token' => $manager->generate()]);
        }
    }
    public function deleteAdmin($id)
    {
        $adminInstance = new Admin(connectDB::dbConnect());
        $manager = new \Psecio\Csrf\Manager();
        if (isset($_POST['csrf_token'])) {
            $result = $manager->verify($_POST['csrf_token']);
            if ($result === false) {
                header("Location:".ERROR_500);
            }

            if (isset($id)) {
                $adminInstance->suprAdmin($id);
            }
            $template = $this->twig->load('users/adminmanagement.html');
            $listadmins = $adminInstance->getAdmins();
            echo $template->render(['site_link' => SITE_URL, 'listadmins' => $listadmins, 'management_admin_token' => $manager->generate()]);
        }
    }
}

