<?php
/**
 *
 */

session_start();


require_once __DIR__ . '/../vendor/autoload.php';


use Respect\Validation\Validator as loadValidation;


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
// Eloquent Model binding
$container['db'] = function($container) use ($capsule){
    return $capsule;
};
// Validator binding
$container['validator'] = function($container){
    return new App\Validation\Validator();
};
// Cross-Site-Token binding
$container['csrf'] = function ($container){
    return new \Slim\Csrf\Guard();
};

$container['HomeController'] = function($container){
    return new App\Controllers\HomeController($container);
};

$container['AuthController'] = function($container){
    return new App\Controllers\Auth\AuthController($container);
};


// 'email'
//      => Respect::noWhitespace()
//          ->notEmpty()
//          ->email()
//          ->emailAvailable(),
loadValidation::with('App\\Validation\\Rules');

$app->add(new \App\Middleware\ValidationErrorsMiddleware($container));
$app->add(new \App\Middleware\OldInputMiddleware($container));

$app->add($container->csrf);


require_once __DIR__ . '/../app/route.php';