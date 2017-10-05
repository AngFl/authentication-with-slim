<?php
/**
 *
 */

namespace App\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class GuestMiddleware
 * @package App\Middleware
 */
class GuestMiddleware extends Middleware
{
    /**
     * @param Request $request
     * @param Response $response
     * @param $nextCallable
     * @return Response|static
     */
    public function __invoke(Request $request, Response $response, $nextCallable)
    {

        if( $this->container->auth->check()) {
            return $response->withRedirect($this->container
                ->router
                ->pathFor('home'));
        }

        $response = $nextCallable($request, $response);

        return $response;
    }
}