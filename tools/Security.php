<?php
/**
 *
 *
 */
class Security extends BaseController

{

    public function __construct()
    {
        parent::__construct();
    }


    public function verifyUpload()
    {

        $nameFile = $_FILES['img']['name'];
        $typeFile = $_FILES['img']['type'];
        $sizeFile = $_FILES['img']['size'];
        $tmpFile = $_FILES['img']['tmp_name'];
        $errFile = $_FILES['img']['error'];

        $extensions = ['png', 'jpg', 'jpeg'];
        $type = ['image/png', 'image/jpg', 'image/jpeg'];

        $extension = explode('.', $nameFile);
        $max_size = 5000000;
        $response=null;

        if (count($extension) <= 2 && in_array(strtolower(end($extension)), $extensions))
        {
            if (in_array($typeFile, $type))
            {

                if ($sizeFile <= $max_size && $errFile == 0)
                {
                    $response=true;
                    return $response;

                }
                else
                {
                    $error="la taille du fichier est dépassé, maximum 5mo.";
                    $template = $this->twig->load('errors/uploaderror.html');
                    echo $template->render(['error'=>$error,'site_link' => SITE_URL]);
                    die;
                }
            }
            else
            {
                $error="L'upload nécessite un fichier, voici les types autorisés: png, jpg, jpeg.";
                $template = $this->twig->load('errors/uploaderror.html');
                echo $template->render(['error'=>$error,'site_link' => SITE_URL]);
                die;
            }
        }
        else {
            $error="L'extension du fichier n'est pas pris en charge.";
            $template = $this->twig->load('errors/uploaderror.html');
            echo $template->render(['error'=>$error,'site_link' => SITE_URL]);
            die;
        }
    }

    function securityReplacement()
    {

        $articleInstance = new Articles(connectDB::dbConnect());
        $verifyUpload = $this->verifyUpload();

        if ($verifyUpload === true) {

            $temp = explode(".", $_FILES["img"]["name"]);
            $newfilename = round(microtime(true)) . '.' . end($temp);

                return $newfilename;
            } else {
                $error = "Le fichier a rencontré un problème lors de son encodage.";
                $template = $this->twig->load('errors/uploaderror.html');
                echo $template->render(['error' => $error, 'site_link' => SITE_URL]);
            die;

            }
        }
}
