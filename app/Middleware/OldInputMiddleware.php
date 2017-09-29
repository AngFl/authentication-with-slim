<?php
/**
 *
 */

namespace App\Middleware;

use Slim\Http\Request;

class OldInputMiddleware extends Middleware
{
    public function __invoke(Request $request, $response, $nextCallable)
    {
        //if(isset($_SESSION['oldInput'])){
            // set 'oldInput' as global in twig template
            $this->container
                ->view
                ->getEnvironment()
                ->addGlobal('oldInput', $_SESSION['oldInput']);

            // store the next request params
            $_SESSION['oldInput'] = $request->getParams();
        //}

        $response = $nextCallable($request, $response);

        return $response;
    }
}