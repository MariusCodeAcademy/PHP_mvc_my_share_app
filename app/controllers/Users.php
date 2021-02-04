<?php
/*  
 * Users class 
 * Register user 
 * Login user
 * Control Uses behavior and access
*/
class Users extends Controller
{
    private $userModel; // x9829
    private $vld;

    public function __construct()
    {
        $this->userModel = $this->model('User');
        // ini validation class
        $this->vld = new Validation;
    }

    public function index()
    {
        redirect('/posts');
    }

    public function register()
    {
        // echo 'Register in progress';
        if ($this->vld->ifRequestIsPostAndSanitize()) {

            // create data 
            $data = [
                'name'      => trim($_POST['name']),
                'email'     => trim($_POST['email']),
                'password'  => trim($_POST['password']),
                'confirmPassword' => trim($_POST['confirmPassword']),
                'errors' => [
                    'nameErr'      => '',
                    'emailErr'     => '',
                    'passwordErr'  => '',
                    'confirmPasswordErr' => '',
                ],

            ];

            $data['errors']['nameErr'] = $this->vld->validateName($data['name']);

            $data['errors']['emailErr'] = $this->vld->validateEmail($data['email'], $this->userModel);

            $data['errors']['passwordErr'] = $this->vld->validatePassword($data['password'], 6, 10);

            $data['errors']['confirmPasswordErr'] = $this->vld->confirmPassword($data['confirmPassword']);


            // if there is no erros
            if ($this->vld->ifEmptyArr($data['errors'])) {
                // there are no errors; 
                // die('SUCCESS');

                // validation OK 

                // hash password // save way to store pass
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // create user

                if ($this->userModel->register($data)) {
                    // success user added 
                    // set flash msg
                    flash('register_success', 'You have registered successfully');
                    // header("Location: " . URLROOT . "/users/login");
                    redirect('/users/login');
                } else {
                    die('Something went wrong in adding user to db');
                }
            } else {
                // set flash msg
                flash('register_fail', 'please check the form', 'alert alert-danger');
                $data['currentPage'] = 'register';
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
                'errors' => [
                    'nameErr'      => '',
                    'emailErr'     => '',
                    'passwordErr'  => '',
                    'confirmPasswordErr' => '',
                ],
                'currentPage' => 'register',
            ];

            // load view
            $this->view('users/register', $data);
        }
    }

    public function login()
    {
        // echo 'Login in progress';
        if ($this->vld->ifRequestIsPostAndSanitize()) {
            // form process in progress

            // create data 
            $data = [
                'email'     => trim($_POST['email']),
                'password'  => trim($_POST['password']),
                'errors' => [
                    'emailErr'     => '',
                    'passwordErr'  => '',
                ],
            ];

            $data['errors']['emailErr'] = $this->vld->validateLoginEmail($data['email'], $this->userModel);

            $data['errors']['passwordErr'] = $this->vld->validateEmpty($data['password'], 'Please enter your password');

            // check if we have errors
            if ($this->vld->ifEmptyArr($data['errors'])) {
                // no errors 
                // email was found and password was entered
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                if ($loggedInUser) {
                    // create session 
                    // password match
                    // die('email and passs match start session immediately');
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['errors']['passwordErr'] = 'Wrong password or email';
                    // load view with errors
                    $this->view('users/login', $data);
                }

                // die('SUCCESS');
            } else {
                $data['currentPage'] = 'login';
                // load view with errors
                $this->view('users/login', $data);
            }
        } else {

            // if we go to users/login by url or link or btn
            // load form
            // echo 'load form';

            // create data 
            $data = [
                'email'     => '',
                'password'  => '',
                'errors' => [
                    'emailErr'     => '',
                    'passwordErr'  => '',
                ]
            ];
            $data['currentPage'] = 'login';
            // load view
            $this->view('users/login', $data);
        }
    }

    // if we have user we save its data in session
    public function createUserSession($userRow)
    {
        $_SESSION['user_id'] = $userRow->id;
        $_SESSION['user_email'] = $userRow->email;
        $_SESSION['user_name'] = $userRow->name;
        redirect('/posts');
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);

        session_destroy();

        redirect('/users/login');
    }
}
