<?php
/**
 *
 */

namespace App\Controllers;

use App\Models\User;
use Slim\Views\Twig as View;

class HomeController extends Controller
{
    public function index($request, $response)
    {
        //$user = User::where('email','linframe@outlook.com')->first();

        //$users = $this->db->table('users')->find(1);
        //var_dump($users->email);
        return $this->view->render($response, 'home.twig');
    }
}