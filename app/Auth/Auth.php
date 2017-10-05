<?php
/**
 *
 */

namespace App\Auth;


use App\Models\User;

class Auth
{

    public function attempt($email, $password)
    {
        // grab the user by email,
        // if user dose not exist return false,
        // verify the password for that user

        // don't dependency injection , because it would be concrete class
        $user = new User();

        $attemptUser = $user->where('email', $email)->first();

        if(! $attemptUser) {
            return false;
        }

        if(!isset($attemptUser->password)) {
            throw new \Exception("{$attemptUser->email} dose not have password ...", 1000 );
        }

        // match the function of password_hash()
        if(password_verify($password, $attemptUser->password)){

            // set into the PHP Session
            $_SESSION['user_sign_in'] = $attemptUser->id;
            return true;
        }

        return false;
    }

    public function user()
    {
        if(isset($_SESSION['user_sign_in'])){
            return (new User())->find($_SESSION['user_sign_in']);
        }
        return false;
    }

    public function check()
    {
        return isset($_SESSION['user_sign_in']);
    }

    public function logout()
    {
        if(isset($_SESSION['user_sign_in'])) {
            unset($_SESSION['user_sign_in']);
        }else {
            //
            return false;
        }
    }
}