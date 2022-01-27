<?php

/**
 * 
 * 
 */
class CommentsValidationController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        $commentsinstance = new Comments(connectDB::dbConnect());
        $listcomments = $commentsinstance->getComments();

        $template = $this->twig->load('users/validationpage.html');
        echo $template->render(['listcomments' => $listcomments]);
    }

    public function accComment($id)
    {
        $commentsInstance = new Comments(connectDB::dbConnect());

        if (isset($id)) {
                $commentsInstance->valComment($id);

        }
        $template = $this->twig->load('users/validationpage.html');
        $listcomments=$commentsInstance->getComments();
        echo $template->render(['listcomments' => $listcomments]);
    }

    public function refComment($id)
    {
        $commentsInstance = new Comments(connectDB::dbConnect());

        if (isset($id)) {
                $commentsInstance->denComment($id);


        }
        $template = $this->twig->load('users/validationpage.html');
        $listcomments=$commentsInstance->getComments();
        echo $template->render(['listcomments' => $listcomments]);
    }
    public function delComment($id)
    {
        $commentsInstance = new Comments(connectDB::dbConnect());

        if (isset($id)) {
            $commentsInstance->suprComment($id);


        }
        $template = $this->twig->load('users/validationpage.html');
        $listcomments=$commentsInstance->getComments();
        echo $template->render(['listcomments' => $listcomments]);
    }
}