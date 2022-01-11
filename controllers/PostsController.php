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
		// on choisi la template à appeler
		$template = $this->twig->load('posts/index.html');

		// Puis on affiche avec la méthode render
		echo $template->render([]);
	}

	public function detail($id) {

		// on choisi la template à appeler
		$template = $this->twig->load('posts/index.html');

		// Puis on affiche avec la méthode render
		echo $template->render([]);
	}

}