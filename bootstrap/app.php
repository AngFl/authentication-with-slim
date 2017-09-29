<?php
/**
 *
 */

session_start();


require_once __DIR__ . '/../vendor/autoload.php';


$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true,

        'db' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'codecourse',
            'username' => 'root',
            'password' => 'qweqwe',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => ''
        ]
    ],
]);

$container = $app->getContainer();

$capsule = new \Illuminate\Database\Capsule\Manager();

$capsule->addConnection($container['settings']['db']);
// configure Eloquent;
$capsule->setAsGlobal();
//
$capsule->bootEloquent();

// bind twig-view
$container['view'] = function($container){
    $view = new \Slim\Views\Twig(__DIR__ . '/../resources/views',[
        'cache' => false,
    ]);

    // configure slim router,
    $view->addExtension(new \Slim\Views\TwigExtension(
        $container->router,
        $container->request->getUri()
    ));

    return $view;
};

$container['db'] = function($container) use ($capsule){
    return $capsule;
};

$container['HomeController'] = function($container){
    return new App\Controllers\HomeController($container);
};

$container['AuthController'] = function($container){
    return new App\Controllers\Auth\AuthController($container);
};


require_once __DIR__ . '/../app/route.php';