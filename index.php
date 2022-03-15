<?php
// Start Session and verification Session IP
ini_set('session.cookie_httponly',true);
session_start();
if (isset($_SESSION['last_ip'])===false) {
    $_SESSION['last_ip'] = $_SERVER['REMOTE_ADDR'];
}
if ($_SESSION['last_ip'] !== $_SERVER['REMOTE_ADDR']){
    session_unset();
    session_destroy();
    header("Location: ".ERROR_500);
}



define('APP_DIRECTORY', __DIR__ . '/');
define('UPLOADS_DIRECTORY', __DIR__ . '/public/uploads/');


//INDEX LINK SHORTCUT
define('SITE_URL','http://'.$_SERVER['SERVER_NAME']);
define('CONTACT_MERCI', 'http://'.$_SERVER['SERVER_NAME'].'/merci');

//POSTS LINK SHORTCUT
define('POSTS_INDEX', 'http://'.$_SERVER['SERVER_NAME'].'/posts/');
define('POSTS_PAGE_ID', 'http://'.$_SERVER['SERVER_NAME'].'/posts/{id:\d+}');
define('POSTS_MERCI', 'http://'.$_SERVER['SERVER_NAME'].'/posts/merci');

//USERS LINK SHORTCUT
define('ADMIN_HOME_INDEX','http://'.$_SERVER['SERVER_NAME'].'/users/admin');
define('ADMIN_MANAGEMENT', 'http://'.$_SERVER['SERVER_NAME'].'/users/admin/management');
define('ADMIN_ARTICLE', 'http://'.$_SERVER['SERVER_NAME'].'/users/admin/article');
define('ADMIN_COMMENT', 'http://'.$_SERVER['SERVER_NAME'].'/users/admin/comment');
define('INSCRIPTION_PAGE', 'http://'.$_SERVER['SERVER_NAME'].'/users/inscription');
define('LOGIN_PAGE', 'http://'.$_SERVER['SERVER_NAME'].'/users/login');

//ERROR LINK SHORTCUT
define('ERROR_500', 'http://'.$_SERVER['SERVER_NAME'].'/error500');


require APP_DIRECTORY . 'vendor/autoload.php';



// autoloader : rapporte les controllers et models si appelé
spl_autoload_register(function ($class) {
    $class = str_replace("\\","/", $class);
    if (file_exists(__DIR__ .'/controllers/' . $class . '.php')) {
        include __DIR__ .'/controllers/' . $class . '.php';
    } elseif (file_exists(__DIR__ .'/models/' . $class . '.php')) {
        include __DIR__ .'/models/' . $class . '.php';
    }
    elseif (file_exists(__DIR__ .'/vendor/psecio/csrf/' . $class . '.php')) {
        include __DIR__ .'/vendor/psecio/csrf/' . $class . '.php';
    }
    elseif (file_exists(__DIR__ .'/tools/' . $class . '.php')) {
        include __DIR__ .'/tools/' . $class . '.php';
    }
    elseif (file_exists(__DIR__ .'/config/' . $class . '.php')) {
        include __DIR__ .'/config/' . $class . '.php';
    }
});


// on défini nos routes ici
$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {

    // page d'accueil
    $r->addRoute('GET', '/', IndexController::class . '/index');

    // Page des posts
    $r->addRoute('GET', '/posts/', PostsController::class . '/index');

    // Page détail d'un post
    $r->addRoute('GET', '/posts/{id:\d+}', PostsController::class . '/detail');

    // validation commentaire
    $r->addRoute('GET', '/posts/{id:\d+}/success', PostsController::class . '/detail');

    // Comments add function on post page
    $r->addRoute('POST', '/posts/{id:\d+}', PostsController::class . '/addComment');

    // Inscription Page
    $r->addRoute('GET', '/users/inscription', UsersController::class . '/register');

    // Inscription Validation function
    $r->addRoute('POST', '/users/inscription/check', UsersController::class . '/registrationVerification');

    // Login Page
    $r->addRoute('GET', '/users/login', UsersController::class . '/loginPage');

    // Login Authentication Function
    $r->addRoute('POST', '/users/admin', UsersController::class . '/loginAuthentication');

    // Deconnexion Function
    $r->addRoute('POST', '/users/admin/deconnexion', UsersController::class . '/disconnect');

    // articles administration page
    $r->addRoute('GET', '/users/admin/article', AdminController::class . '/articleAdminPage');

    // Add Article function
    $r->addRoute('POST', '/users/admin/article/add', AdminController::class . '/addArticle');

    // Delete Article function
    $r->addRoute('POST', '/users/admin/article/delete/{id:\d+}', AdminController::class . '/deleteArticle');

    // Update Article function
    $r->addRoute('POST', '/users/admin/update/{id:\d+}', AdminController::class . '/updateArticle');

    // Comments administration Page --
    $r->addRoute('GET', '/users/admin/comment', AdminController::class . '/commentAdminPage');

    // Accepted Comment Page
    $r->addRoute('POST', '/users/admin/comment/accepted/{id:\d+}', AdminController::class . '/acceptComment');

    // Refused comment Page
    $r->addRoute('POST', '/users/admin/comment/refused/{id:\d+}', AdminController::class . '/refuseComment');

    // Delete Comment Page
    $r->addRoute('POST', '/users/admin/comment/delete/{id:\d+}', AdminController::class . '/deleteComment');

    // Admin management Page --
    $r->addRoute('GET', '/users/admin/management', AdminController::class . '/managementAdminPage');

    // Accepted admin Page
    $r->addRoute('POST', '/users/admin/management/accepted/{id:\d+}', AdminController::class . '/acceptAdmin');

    // Refused admin Page
    $r->addRoute('POST', '/users/admin/management/refused/{id:\d+}', AdminController::class . '/refuseAdmin');

    // Delete admin Page
    $r->addRoute('POST', '/users/admin/management/delete/{id:\d+}', AdminController::class . '/deleteAdmin');

    // Email sent
    $r->addRoute('POST', '/', IndexController::class . '/contactEmail');

    // Display error server
    $r->addRoute('GET', '/error500', RedirectController::class . '/erreurServeur');

    // Display thanks for your comment
    $r->addRoute('GET', '/posts/merci', RedirectController::class . '/thankComment');

    // Display thanks for your Email
    $r->addRoute('GET', '/merci', RedirectController::class . '/thankEmail');

    // Security Function -> upload img
    $r->addRoute('GET', '/upload', Security::class . '/verifyUpload');


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