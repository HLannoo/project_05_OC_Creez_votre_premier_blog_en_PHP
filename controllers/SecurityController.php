<?php
/**
 * 
 * 
 */
class SecurityController extends BaseController
{


    public function verifyUpload()
    {

        $nameFile = $_FILES['img']['name'];
        $typeFile = $_FILES['img']['type'];
        $sizeFile = $_FILES['img']['size'];
        $tmpFile = $_FILES['img']['tmp_name'];
        $errFile = $_FILES['img']['error'];

        $extensions = ['png', 'jpg', 'jpeg', 'gif'];
        $type = ['image/png', 'image/jpg', 'image/jpeg', 'image/gif'];

        $extension = explode('.', $nameFile);
        $max_size = 500000;
        $response=null;

        if (in_array($typeFile, $type))
        {
            if (count($extension) <= 2 && in_array(strtolower(end($extension)), $extensions))
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
                $error="L'extension du fichier n'est pas pris en charge.";
                $template = $this->twig->load('errors/uploaderror.html');
                echo $template->render(['error'=>$error,'site_link' => SITE_URL]);
                die;
            }
        }
            else {
                $error="L'upload nécessite un fichier, voici les types autorisés: png, jpg, jpeg, gif .";
                $template = $this->twig->load('errors/uploaderror.html');
                echo $template->render(['error'=>$error,'site_link' => SITE_URL]);
                die;

            }
    }
}


