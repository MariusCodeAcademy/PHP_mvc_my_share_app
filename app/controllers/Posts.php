<?php

/*
* Post controller
* Basic CRUD Functionality
* 
*/

class Posts extends Controller
{
    private $postModel;

    public function __construct()
    {
        // restrict access of this controller only to logged in users
        if (!isLoggedIn()) redirect('/users/login');

        $this->postModel = $this->model('Post');
    }

    public function index()
    {
        // get posts 
        $posts = $this->postModel->getPosts();
        $data = [
            'posts' => $posts
        ];
        $this->view('posts/index', $data);
    }

    public function add()
    {
        // if form was submited
        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            // lets validate
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'user_id' => $_SESSION['user_id'],
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'titleErr' => '',
                'bodyErr' => '',
            ];

            // validate title
            if (empty($data['title'])) {
                $data['titleErr'] = 'Please enter a title';
            }

            // validate title
            if (empty($data['body'])) {
                $data['bodyErr'] = 'Please enter a text';
            }

            // check of there are no errors
            if (empty($data['titleErr']) && empty($data['bodyErr'])) {
                // there are no errors
                // die('no errors, can submit');

                if ($this->postModel->addPost($data)) {
                    // post added
                    flash('post_message', 'You have added a new post');
                    redirect('/posts');
                } else {
                    die('something went wrong in adding a post');
                }
            } else {
                // load view with errors
                $this->view('posts/add', $data);
            }
        } else {
            // else (user entered onto this page)
            $data = [
                'title' => '',
                'body' => '',
                'titleErr' => '',
                'bodyErr' => '',
            ];

            $this->view('posts/add', $data);
        }
    }

    public function show($id = null)
    {
        // if no id given we redirect
        if ($id === null) redirect('/posts');

        // get post row 
        $post = $this->postModel->getPostById($id);

        // create data for the view and add post data
        $data = [
            'post' => $post,
        ];
        // load view with data
        $this->view('posts/show', $data);
    }
}
