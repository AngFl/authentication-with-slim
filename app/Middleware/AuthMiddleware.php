<?php
/**
 *
 */

namespace App\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

class AuthMiddleware extends Middleware
{
    public function __invoke(Request $request, Response $response, $nextCallable)
    {

        //check if the user is not signed in
        if( ! $this->container->auth->check()) {

            return $response->withRedirect($this->container->router->pathFor('auth.sign-in'));
        }
        // flash
        // redirect

        $response = $nextCallable($request, $response);

        return $response;
    }
}