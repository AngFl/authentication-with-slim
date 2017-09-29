<?php
/**
 *
 */

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Models\User;
use Slim\Http\Request;
use Slim\Http\Response;

use Slim\Views\Twig as View;

class AuthController extends Controller
{
    public function getSignUp(Request $request, $response)
    {
        return $this->view->render($response, 'auth/signup.twig');
    }

    public function postSignUp(Request $request, Response $response)
    {
        $user = new User();
        $user->create([
            'email' => $request->getParam('email'),
            'username' => $request->getParam('username'),
            'password' => password_hash($request->getParam('password'),
                PASSWORD_DEFAULT)
        ]);

        return $response->withRedirect($this->router->pathFor('home'));

    }
}