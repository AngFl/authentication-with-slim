<?php
/**
 *
 */

$app->get('/', function($request, $response){
     return $this->view->render($response, 'home.twig');
})->setName('home');

$app->get('/auth/sign-up', 'AuthController:getSignUp')->setName('auth.sign-up');
$app->post('/auth/sign-up', 'AuthController:postSignUp')->setName('auth.sign-up');