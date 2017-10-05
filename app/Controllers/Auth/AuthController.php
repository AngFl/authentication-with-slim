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
            // Available email with customize Load Rules ,
            // emailAvailable() will call the methods of EmailAvailable->validate()
            'email' => Respector::noWhitespace()->notEmpty()->email()->emailAvailable(),
            'username' => Respector::noWhitespace()->notEmpty()->alpha(),
            'password' => Respector::noWhitespace()->notEmpty(),
        ]);

        if($validation->failed()){
            // redirect back
            return $response->withRedirect($this->router->pathFor('auth.sign-up'));
        }

        $user = new User();
        $registerUser = $user->create([
            'email' => $request->getParam('email'),
            'username' => $request->getParam('username'),
            'password' => password_hash($request->getParam('password'),
                PASSWORD_DEFAULT)
        ]);

        if($registerUser){
            $this->auth->attempt(
                $registerUser->email,
                $request->getParam('password')
            );
        }


        return $response->withRedirect($this->router->pathFor('home'));

    }


    public function getSignIn(Request $request , $response)
    {
        return $this->view->render($response, 'auth/signin.twig');
    }


    public function postSignIn(Request $request , Response  $response)
    {
        $auth = $this->auth->attempt(
            $request->getParam('email'),
            $request->getParam('password')
        );

        if(! $auth) {
            return $response->withRedirect($this->router->pathFor('auth.sign-in'));
        }

        //// flush message
        return $response->withRedirect($this->router->pathFor('home'));
    }


    public function getSignOut(Request $request , Response  $response)
    {
        //sign out /destroy session
        //redirect
        if($this->auth->check()){
            $this->auth->logout();

            return $response->withRedirect($this->router->pathFor('auth.sign-in'));
        }
    }
}