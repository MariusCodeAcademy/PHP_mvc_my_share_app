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

            // sanitize Post Array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // create data 
            $data = [
                'name'      => trim($_POST['name']),
                'email'     => trim($_POST['email']),
                'password'  => trim($_POST['password']),
                'confirmPassword' => trim($_POST['confirmPassword']),
                'nameErr'      => '',
                'emailErr'     => '',
                'passwordErr'  => '',
                'confirmPasswordErr' => '',
            ];

            // Validate Name 
            if (empty($data['name'])) {
                // empty field
                $data['nameErr'] = "Please enter Your Name";
            }

            // Validate Email 
            if (empty($data['email'])) {
                // empty field
                $data['emailErr'] = "Please enter Your Email";
            } else {
                if (filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) {
                    $data['emailErr'] = "Please check your email";
                }
            }

            // Validate Password 
            if (empty($data['password'])) {
                // empty field
                $data['passwordErr'] = "Please enter a password";
            } elseif (strlen($data['password']) < 6) {
                $data['passwordErr'] = "Password must be 6 or more characters";
            }

            // Validate confirmPassword 
            if (empty($data['confirmPassword'])) {
                // empty field
                $data['confirmPasswordErr'] = "Please repeat password";
            } else {
                if ($data['confirmPassword'] !== $data['password']) {
                    $data['confirmPasswordErr'] = "Password must match";
                }
            }



            // if there is no erros
            if (empty($data['nameErr']) && empty($data['emailErr']) && empty($data['passwordErr']) && empty($data['confirmPasswordErr'])) {
                // there are no errors; 
                die('SUCCESS');
            } else {
                // load view with errors 
                $this->view('users/register', $data);
            }
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