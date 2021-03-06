<?php

/*
* Post controller
* Basic CRUD Functionality
* 
*/

class Posts extends Controller
{
    private $postModel;
    private $userModel;
    private $vld;

    public function __construct()
    {
        // restrict access of this controller only to logged in users
        if (!isLoggedIn()) redirect('/users/login');

        $this->postModel = $this->model('Post');
        $this->userModel = $this->model('User');
        // init validation class 
        $this->vld = new Validation;
    }

    public function index()
    {
        // get posts 
        $posts = $this->postModel->getPosts();
        $data = [
            'posts' => $posts,
            'currentPage' => 'home',
        ];
        $this->view('posts/index', $data);
    }

    public function add()
    {
        // if form was submited
        if ($this->vld->ifRequestIsPostAndSanitize()) {
            // lets validate
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
        // lets get user data by user_id
        $user = $this->userModel->getUserById($post->user_id);
        // create data for the view and add post data
        $data = [
            'post' => $post,
            'user' => $user,
            'commentsOn' => true,
        ];
        // load view with data
        $this->view('posts/show', $data);
    }

    public function edit($id = null)
    {
        // if post has no parameter we redirect
        if ($id === null) redirect('/posts');

        // if form was submitted
        if ($this->vld->ifRequestIsPostAndSanitize()) {
            // lets validate
            $data = [
                'post_id' => $id,
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

                if ($this->postModel->updatePost($data)) {
                    // post added
                    flash('post_message', 'You have edited the post');
                    redirect('/posts');
                } else {
                    die('something went wrong in adding a post');
                }
            } else {
                // load view with errors
                $this->view('posts/edit', $data);
            }
        } else {
            // else (user entered onto this page)

            $post = $this->postModel->getPostById($id);

            if ($post) {
                // check if this post belong to this user
                if ($post->user_id !== $_SESSION['user_id']) redirect('/posts');
            } else {
                die('something went wrong. getPostById');
            }


            // post found and will load view
            $data = [
                'id' => $id,
                'title' => $post->title,
                'body' => $post->body,
                'titleErr' => '',
                'bodyErr' => '',
            ];

            $this->view('posts/edit', $data);
        }
    }

    public function delete($id = null)
    {

        if ($this->vld->ifRequestIsPost() && $id) {
            // die('will be deleting soon');
            if ($this->postModel->deletePost($id)) {
                flash('post_message', 'Post was removed', 'alert alert-warning');
                redirect('/posts');
            }
        } else {
            redirect('/posts');
        }
    }
}
