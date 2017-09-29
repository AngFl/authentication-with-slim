<?php
/**
 *
 */

namespace App\Middleware;


class ValidationErrorsMiddleware extends Middleware
{
    public function __invoke($request, $response, $nextCallable)
    {
        // Slim add view errors as global;
        if(isset($_SESSION['errors'])){
            $this->container
                ->view
                ->getEnvironment()
                ->addGlobal('errors', $_SESSION['errors']);

            unset($_SESSION['errors']);
        }

        $response = $nextCallable($request, $response);

        return $response;
    }
}