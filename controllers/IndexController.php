<?php

/**
 * 
 * 
 */
class IndexController extends BaseController {

	// Page d'accueil
	public function index() {

        // on choisi la template à appeler
        $template = $this->twig->load('index/index.html');

        // Puis on affiche la page avec la méthode render
		echo $template->render([]);
	}

}