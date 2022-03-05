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
            header("Location: http://project5/users/login");;
        }
    }


    public function articleAdminPage()
    {
        if ($_SESSION) {

            $commentsinstance = new Articles(connectDB::dbConnect());
            $listarticles = $commentsinstance->getArticles();
            $manager = new \Psecio\Csrf\Manager();

            $template = $this->twig->load('users/articleadministration.html');
            echo $template->render(['site_link' => SITE_URL, 'listarticles' => $listarticles,'article_admin_token' => $manager->generate()]);
        }

        else {
            header("Location: http://project5/users/login");;
        }
    }

    public function managementAdminPage()
    {
        if ($_SESSION) {

            $admininstance = new Admin(connectDB::dbConnect());
            $listadmins = $admininstance->getAdmins();
            $manager = new \Psecio\Csrf\Manager();

            $template = $this->twig->load('users/adminmanagement.html');
            echo $template->render(['site_link' => SITE_URL, 'listadmins' => $listadmins,'management_admin_token' => $manager->generate()]);
        }

        else {
            header("Location: http://project5/users/login");
        }
    }


    public function acceptComment($id)
    {
        $commentsInstance = new Comments(connectDB::dbConnect());
        $manager = new \Psecio\Csrf\Manager();
        if (isset($_POST['csrf_token'])) {
            $result = $manager->verify($_POST['csrf_token']);
            if ($result === false) {
                header("Location: http://project5/error500");
            }
                if (isset($id)) {
                    var_dump($_POST['csrf_token']);
                    $commentsInstance->valComment($id);
                }
                    $template = $this->twig->load('users/commentadministration.html');
                    $listcomments = $commentsInstance->getComments();
                    echo $template->render(['listcomments' => $listcomments,'comment_admin_token' => $manager->generate()]);
                }
    }

    public function refuseComment($id)
    {
        $commentsInstance = new Comments(connectDB::dbConnect());
        $manager = new \Psecio\Csrf\Manager();
        if (isset($_POST['csrf_token'])) {
            $result = $manager->verify($_POST['csrf_token']);
            if ($result === false) {
                header("Location: http://project5/error500");
            }
            if (isset($id)) {
                $commentsInstance->denComment($id);
            }
            $template = $this->twig->load('users/commentadministration.html');
            $listcomments = $commentsInstance->getComments();
            echo $template->render(['listcomments' => $listcomments,'comment_admin_token' => $manager->generate()]);
        }
    }

    public function deleteComment($id)
    {
        $commentsInstance = new Comments(connectDB::dbConnect());
        $manager = new \Psecio\Csrf\Manager();
        if (isset($_POST['csrf_token'])) {
            $result = $manager->verify($_POST['csrf_token']);
            if ($result === false) {
                header("Location: http://project5/error500");
            }

            if (isset($id)) {
                $commentsInstance->suprComment($id);


            }
            $template = $this->twig->load('users/commentadministration.html');
            $listcomments = $commentsInstance->getComments();
            echo $template->render(['listcomments' => $listcomments,'comment_admin_token' => $manager->generate()]);
        }
    }

    public function addArticle()
    {
        $articleInstance = new Articles(connectDB::dbConnect());
        $listarticles=$articleInstance->getArticles();
        $manager = new \Psecio\Csrf\Manager();
        if (isset($_POST['csrf_token'])) {
            $result = $manager->verify($_POST['csrf_token']);
            if ($result === false) {
                header("Location: http://project5/error500");
            }

            if (isset($_POST['title']) && isset($_POST['chapo']) && isset($_POST['content'])) {
                $title = addslashes(htmlspecialchars($_POST['title']));
                $chapo = addslashes(htmlspecialchars($_POST['chapo']));
                $content = addslashes(htmlspecialchars($_POST['content']));
                $slug = addslashes(htmlspecialchars($_POST['slug']));
                $id = ($_POST['id']);
                $userid = $_SESSION["id"];
                $imgpath = null;

                if (!empty($_FILES['img'])) {
                    $temp = explode(".", $_FILES["img"]["name"]);
                    $newfilename = round(microtime(true)) . '.' . end($temp);

                    if (move_uploaded_file(($_FILES['img']['tmp_name']), UPLOADS_DIRECTORY . $newfilename)) {

                        $imgpath = $newfilename;

                    }
                }
                $checkId = $articleInstance->checkId($id);
                if ($checkId == 0) {

                    $articleInstance->insertArticle($title, $chapo, $content, $slug, $userid, $imgpath);
                } elseif ($checkId == 1) {

                    $articleInstance->replaceArticle($title, $chapo, $content, $slug, $userid, $id, $imgpath);

                } else {
                    header("Location: http://project5/users/admin");
                }
            }
        }
        $template = $this->twig->load('users/articleadministration.html');
        $listarticles=$articleInstance->getArticles();
        echo $template->render(['listarticles' => $listarticles,'article_admin_token' => $manager->generate()]);
    }

    public function deleteArticle($id)
    {
        $articleInstance = new Articles(connectDB::dbConnect());
        $listarticles=$articleInstance->getArticles();
        $manager = new \Psecio\Csrf\Manager();
        if (isset($_POST['csrf_token'])) {
            $result = $manager->verify($_POST['csrf_token']);
            if ($result === false) {
                header("Location: http://project5/error500");
            }

            if (isset($id)) {

                $checkId = $articleInstance->checkId($id);

                if ($checkId == true) {
                    $articleInstance->suppArticle($id);
                } else {
                    header("Location: http://project5/users/admin");
                }
            }
        }
        $template = $this->twig->load('users/articleadministration.html');
        $listarticles=$articleInstance->getArticles();
        echo $template->render(['listarticles' => $listarticles,'article_admin_token' => $manager->generate()]);
    }


    public function updateArticle($id)
    {
        $articleInstance = new Articles(connectDB::dbConnect());
        $listarticles = $articleInstance->getArticles();
        $manager = new \Psecio\Csrf\Manager();
        if (isset($_POST['csrf_token'])) {
            $result = $manager->verify($_POST['csrf_token']);
            if ($result === false) {
                header("Location: http://project5/error500");
            }

            if (isset($id)) {

                $checkId = $articleInstance->checkId($id);

                if ($checkId == true) {
                    $ligne = $articleInstance->modArticle($id);
                } else {
                    header("Location: http://project5/error500");
                }
            }
            $template = $this->twig->load('users/articleadministration.html');
            $listarticles = $articleInstance->getArticles();
            echo $template->render(['ligne' => $ligne, 'listarticles' => $listarticles, 'article_admin_token' => $manager->generate()]);
        }
    }

    public function acceptAdmin($id)
    {
        $adminInstance = new Admin(connectDB::dbConnect());
        $manager = new \Psecio\Csrf\Manager();
        if (isset($_POST['csrf_token'])) {
            $result = $manager->verify($_POST['csrf_token']);
            if ($result === false) {
                header("Location: http://project5/error500");
            }

            if (isset($id)) {
                $adminInstance->valAdmin($id);

            }
            $template = $this->twig->load('users/adminmanagement.html');
            $listadmins = $adminInstance->getAdmins();
            echo $template->render(['site_link' => SITE_URL, 'listadmins' => $listadmins, 'management_admin_token' => $manager->generate()]);
        }
    }
    public function refuseAdmin($id)
    {
        $adminInstance = new Admin(connectDB::dbConnect());
        $manager = new \Psecio\Csrf\Manager();
        if (isset($_POST['csrf_token'])) {
            $result = $manager->verify($_POST['csrf_token']);
            if ($result === false) {
                header("Location: http://project5/error500");
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
                header("Location: http://project5/error500");
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

