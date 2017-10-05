<?php
/**
 *
 */

namespace App\Middleware;

//
use Slim\Http\Request;

class CsrfViewMiddleware extends Middleware
{
    public function __invoke(Request $request, $response, $nextCallable)
    {
        // add field of token name
        $tokenNameKey = $this->container->csrf->getTokenNameKey();
        $tokenName = $this->container->csrf->getTokenName();

        $fieldTokenInput = sprintf('<input type="hidden" name="%s" value="%s">',
            $tokenNameKey, $tokenName);

        // add field of token value
        $tokenValueKey = $this->container->csrf->getTokenValueKey();
        $tokenValue = $this->container->csrf->getTokenValue();

        $fileTokeValueInput = sprintf('<input type="hidden" name="%s" value="%s">',
            $tokenValueKey, $tokenValue);

        $this->container->view->getEnvironment()->addGlobal('csrf', [
             'field' => $fieldTokenInput . $fileTokeValueInput
        ]);

        $response = $nextCallable($request, $response);

        return $response;
    }
}