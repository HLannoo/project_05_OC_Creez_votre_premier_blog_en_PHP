<?php

session_start();
define('APP_DIRECTORY', __DIR__ . '/');
define('UPLOADS_DIRECTORY', __DIR__ . '/public/uploads/');
define('SITE_URL','http://'.$_SERVER['SERVER_NAME']);
define('LOGIN_PAGE', __DIR__ . '/views/users/login.html');

require APP_DIRECTORY . 'vendor/autoload.php';


// todo : A charger dans un autoloader plus tard
require_once APP_DIRECTORY . 'models/connectDB.php';
require_once APP_DIRECTORY . 'models/Articles.php';
require_once APP_DIRECTORY . 'models/Comments.php';
require_once APP_DIRECTORY . 'models/User.php';
require_once APP_DIRECTORY . 'controllers/BaseController.php';
require_once APP_DIRECTORY . 'controllers/IndexController.php';
require_once APP_DIRECTORY . 'controllers/PostsController.php';
require_once APP_DIRECTORY . 'controllers/UsersController.php';
require_once APP_DIRECTORY . 'controllers/AdminController.php';






// on défini nos routes ici
$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {

    // page d'accueil
    $r->addRoute('GET', '/', IndexController::class . '/index');

    // Page des posts
    $r->addRoute('GET', '/posts/', PostsController::class . '/index');

    // Page détail d'un post
    $r->addRoute('GET', '/posts/{id:\d+}', PostsController::class . '/detail');

    // Comments add function on post page
    $r->addRoute('POST', '/posts/{id:\d+}/addComment', PostsController::class . '/addComment');

    // Inscription Page
    $r->addRoute('GET', '/users/inscription', UsersController::class . '/insPage');

    // Inscription Validation function
    $r->addRoute('POST', '/users/inscription/check', UsersController::class . '/insCheck');

    // Login Page
    $r->addRoute('GET', '/users/login', UsersController::class . '/logPage');

    // Login Authentication Function
    $r->addRoute('POST', '/users/admin', UsersController::class . '/logAuth');

    // Deconnexion Function
    $r->addRoute('POST', '/users/admin/deconnexion', UsersController::class . '/decFun');

    // articles administration page
    $r->addRoute('GET', '/users/admin/article', AdminController::class . '/articleAdminPage');

    // Add Article function
    $r->addRoute('POST', '/users/admin/article/add', AdminController::class . '/addArticle');

    // Delete Article function
    $r->addRoute('GET', '/users/admin/article/delete/{id:\d+}', AdminController::class . '/delArticle');

    // Update Article function
    $r->addRoute('GET', '/users/admin/update/{id:\d+}', AdminController::class . '/updateArticle');

    // Comments administration Page --
    $r->addRoute('GET', '/users/admin/comment', AdminController::class . '/commentAdminPage');

    // Accepted Comment Page
    $r->addRoute('GET', '/users/admin/comment/accepted/{id:\d+}', AdminController::class . '/accComment');

    // Refused comment Page
    $r->addRoute('GET', '/users/admin/comment/refused/{id:\d+}', AdminController::class . '/refComment');

    // Delete Comment Page
    $r->addRoute('GET', '/users/admin/comment/delete/{id:\d+}', AdminController::class . '/delComment');



});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];


// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);



$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        // Todo : definir une page d'erreur
        echo 'PAGE NOT FOUND';
        break;
    

    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        die('405');
        break;

    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        list($class, $method) = explode("/", $handler, 2);

        // on appelle automatique notre controlleur, avec la bonne méthode et les bons paramètres donnés à notre fonction
        // Exemple pour la syntaxe "IndexController::class . '/index'", voici ce qui sera appelé : "IndexController->index()"

        call_user_func_array(array(new $class, $method), $vars);
        break;
}