<?php

/**
 * 
 * 
 */
class RedirectController extends BaseController
{

    public function erreurServeur()
    {
        // on choisi la template à appeler
        $template = $this->twig->load('errors/error500.html');

        // Puis on affiche avec la méthode render
        $view = $template->render([]);
        echo $view;

    }

    public function thankComment()
    {
        // on choisi la template à appeler
        $template = $this->twig->load('posts/merci.html');

        // Puis on affiche avec la méthode render
        $view = $template->render([]);
        echo $view;

    }

    public function thankEmail()
    {
        // on choisi la template à appeler
        $template = $this->twig->load('index/merci.html');

        // Puis on affiche avec la méthode render
        $view = $template->render([]);
        echo $view;

    }

}