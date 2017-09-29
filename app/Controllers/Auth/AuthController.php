<?php
/**
 *
 */

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Models\User;
use Slim\Http\Request;
use Slim\Http\Response;
use Respect\Validation\Validator as Respector;

use Slim\Views\Twig as View;

class AuthController extends Controller
{
    public function getSignUp(Request $request, $response)
    {
        return $this->view->render($response, 'auth/signup.twig');
    }

    // sign up works
    public function postSignUp(Request $request, Response $response)
    {

        $validation = $this->validator->validate($request,[
            'email' => Respector::noWhitespace()->notEmpty(),
            'username' => Respector::noWhitespace()->notEmpty()->alpha(),
            'password' => Respector::noWhitespace()->notEmpty(),
        ]);

        if($validation->failed()){
            // redirect back
            return $response->withRedirect($this->router->pathFor('auth.sign-up'));
        }

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