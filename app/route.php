<?php
/**
 *
 */

$app->get('/', function($request, $response){
     return $this->view->render($response, 'home.twig');
})->setName('home');

// guest route
// if the user session exist will redirect home ,
// could not redirect sign pages

$app->group('', function(){
    $this->get('/auth/sign-up', 'AuthController:getSignUp')->setName('auth.sign-up');
    $this->post('/auth/sign-up', 'AuthController:postSignUp')->setName('auth.sign-up');

    $this->get('/auth/sign-in', 'AuthController:getSignIn')->setName('auth.sign-in');
    $this->post('/auth/sign-in', 'AuthController:postSignIn')->setName('auth.sign-in');

})->add(new App\Middleware\GuestMiddleware($container));


$app->group('/auth', function (){
    $this->get('/sign-out', 'AuthController:getSignOut')->setName('auth.sign-out');
    $this->get('/password/change', 'PasswordController:getChangePassword')->setName('auth.password.change');
    $this->post('/password/change', 'PasswordController:postChangePassword')->setName('auth.password.change');

})->add(new App\Middleware\AuthMiddleware($container));
