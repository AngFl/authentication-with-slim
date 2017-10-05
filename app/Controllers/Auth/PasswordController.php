<?php
/**
 *
 */

namespace App\Controllers\Auth;


use App\Controllers\Controller;
use Respect\Validation\Validator as Validator;
use Slim\Http\Response;
use Slim\Http\Request;

/**
 * Class PasswordController
 * @package App\Controllers\Auth
 */
class PasswordController extends Controller
{
    /**
     * @param Request $request
     * @param Response $response
     * @return mixed
     */
    public function getChangePassword(Request $request, Response $response)
    {
        return $this->view->render($response, 'auth/password/change.twig');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return static
     */
    public function postChangePassword(Request $request, Response $response)
    {
        $validation = $this->validator->validate($request, [
            'password_old' => Validator::noWhitespace()
                ->notEmpty()
                ->matchesPassword($this->auth->user()->password),

            'password' => Validator::noWhitespace()->notEmpty()
        ]);

        if($validation->failed()){
            return $response->withRedirect($this->router->pathFor('auth.password.change'));
        }

        // Eloquent Model
        $changeResult = $this->auth->user()->setPassword($request->getParam('password'));

        if($changeResult){
            return $response->withRedirect($this->router->pathFor('home'));
        }
    }
}