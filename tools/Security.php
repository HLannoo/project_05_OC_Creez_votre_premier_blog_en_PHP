<?php
/**
 *
 *
 */
class Security extends BaseController

{
    private function checkIsIsset()
    {
        if (isset($_FILES['img']['name']) && isset($_FILES['img']['size']) && isset($_FILES['img']['tmp_name']) && isset($_FILES['img']['error'])) {

            return $response = true;
        }
        else {
            return $response = null;
        }

    }

    public function verifyUpload()
    {
        $checkFile=$this->checkIsIsset();
        $nameFile = $_FILES['img']['name'];
        $sizeFile = $_FILES['img']['size'];
        $tmpFile = $_FILES['img']['tmp_name'];
        $typeFile = !empty($tmpFile)? mime_content_type($tmpFile):"EMPTY";
        $errFile = $_FILES['img']['error'];

        $extensions = ['png', 'jpg', 'jpeg'];
        $type = ['image/png', 'image/jpg', 'image/jpeg'];

        $extension = explode('.', $nameFile);
        $max_size = 2000000;
        $response=false;


        if ($checkFile === null){
            $error="Le fichier n'a pas été reçu";

        }
        elseif (empty($tmpFile) ) {
            $error="Le fichier image est vide.";


        }
        elseif ($sizeFile > $max_size || $errFile != 0 ) {
            $error="la taille du fichier est dépassé, maximum 2mo.";


        }
        elseif (count($extension) <2 || !in_array(strtolower(end($extension)),$extensions)) {
            $error="L'extension du fichier n'est pas pris en charge.";

        }
        elseif (!in_array($typeFile,$type)) {

            $error="L'upload nécessite un fichier, voici les types autorisés: png, jpg, jpeg.";

        }
        else {
            $response=true;
            return $response;
        }
        $template = $this->twig->load('errors/uploaderror.html');
        $view = $template->render(['POSTS_INDEX' => POSTS_INDEX,
            'SITE_LINK' => SITE_URL,
            'LOGIN_PAGE' => LOGIN_PAGE,
            'error' => $error, 'site_link' => SITE_URL]);
        echo $view;
        return $response;

    }

    function securityReplacement()
    {

        $verifyUpload = $this->verifyUpload();

        if ($verifyUpload === true) {

            $temp = explode(".", $_FILES["img"]["name"]);
            $newfilename = round(microtime(true)) . '.' . end($temp);
            return $newfilename;
            }
        }
}
