<?php
use Psecio\Csrf\Storage\Session;
use Psecio\Csrf\Storage\Cookie;
/**
 * 
 * 
 */
class IndexController extends BaseController {

    
    public function index($params = array())
    {
        $articlesinstance = new Articles(connectDB::dbConnect());
        $listarticles = $articlesinstance->getArticles();
        $manager = new \Psecio\Csrf\Manager();


        // on choisi la template à appeler
        $template = $this->twig->load('index/index.html');

        // Puis on affiche avec la méthode render
        echo $template->render(['listarticles' => $listarticles,'token'=>$manager->generate()]);
    }

}