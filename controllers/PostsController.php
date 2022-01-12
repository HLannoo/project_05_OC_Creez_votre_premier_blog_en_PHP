<?php

/**
 * 
 * 
 */
class PostsController extends BaseController {


	// Initialisation du contructeur par défaut
	public function __construct()
    {
    	parent::__construct();
   	}

	// Page d'accueil
	public function index($params=array()) {

        $articlesinstance = new Articles(connectDB::dbConnect());
        $listarticles = $articlesinstance->getArticles();


		// on choisi la template à appeler
		$template = $this->twig->load('posts/index.html');

		// Puis on affiche avec la méthode render
		echo $template->render(['listarticles'=>$listarticles]);
	}

	public function detail($id) {
        $articleinstance = new Articles(connectDB::dbConnect());
        $article = $articleinstance->getArticleById($id);

		// on choisi la template à appeler
		$template = $this->twig->load('posts/pageid.html');

		// Puis on affiche avec la méthode render
		echo $template->render(['article'=>$article]);
	}

}