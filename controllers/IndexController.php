<?php

/**
 * 
 * 
 */
class IndexController extends BaseController {


    // Section "les projets"
    public function index($params = array())
    {
        $articlesinstance = new Articles(connectDB::dbConnect());
        $listarticles = $articlesinstance->getArticles();


        // on choisi la template à appeler
        $template = $this->twig->load('index/index.html');

        // Puis on affiche avec la méthode render
        echo $template->render(['listarticles' => $listarticles]);
    }

}