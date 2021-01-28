<?php
/*  
 * Users class 
 * Register user 
 * Login user
 * Control Uses behavior and access
*/
class Users extends Controller
{
    public function __construct()
    {
    }

    public function register()
    {
        // echo 'Register in progress';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // form process in progress
        } else {
            // load form
            // echo 'load form';

            // create data 
            $data = [
                'name'      => '',
                'email'     => '',
                'password'  => '',
                'confirmPassword' => '',
                'nameErr'      => '',
                'emailErr'     => '',
                'passwordErr'  => '',
                'confirmPasswordErr' => '',
            ];

            // load view
            $this->view('users/register', $data);
        }
    }

    public function login()
    {
        // echo 'Login in progress';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // form process in progress
        } else {
            // load form
            // echo 'load form';

            // create data 
            $data = [
                'email'     => '',
                'password'  => '',
                'emailErr'     => '',
                'passwordErr'  => '',
            ];

            // load view
            $this->view('users/login', $data);
        }
    }
}
