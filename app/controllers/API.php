<?php
// class for returning json formated data 
class API extends Controller
{

    private $commentModel;

    public function __construct()
    {
        $this->commentModel = $this->model('Comment');
    }

    public function index()
    {
        echo 'index in api';
    }

    public function comments($post_id = null)
    {
        if ($post_id === null) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'no id given']);
            die();
        }
        $comments = $this->commentModel->getMeComments($post_id);
        $data = [
            'comments' => $comments,
            'post_id' => $post_id
        ];
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function addComment($post_id = null)
    {
        $result = [
            'errors' => [],
        ];

        if ($post_id === null) {
            $result['errors'] = 'no id given';
            redirect('/posts');
            // die();
        }
        // print_r($_POST);
        // echo 'addComment ' . $post_id;

        // validate POST values
        $vld = new Validation;
        if ($vld->ifRequestIsPostAndSanitize()) {
            // request is post and sanitized

            $data = [
                'username' => trim($_POST['username']),
                'commentBody' => trim($_POST['commentBody']),
                'errors' => [
                    'usernameErr' => '',
                    'commentBodyErr' => '',
                ]
            ];

            // validate username
            $data['errors']['usernameErr'] = $vld->validateEmpty($data['username'], 'Username can\'t be empty');
            
            $data['errors']['commentBodyErr'] = $vld->validateEmpty($data['commentBody'], 'Please enter your Comment');

            if ($vld->ifEmptyArr($data['errors'])) {
                // no errors
                // execute add post from model and get result
                $commentData = [
                    'author' => $data['username'],
                    'commentBody' => $data['commentBody'],
                    'postId' => $post_id
                ];
                
                if ($this->commentModel->addComment($commentData)) {
                    $result['success'] = "Comment added";

                } else {
                    $result['errors'] = 'error adding post';
                }

            } else {
                // create result 
                $result['errors'] = $data['errors'];
            }

        } else {
            // if request is not post
            $result['error'] = "not alowed";
            redirect('/posts');
        }

        // $commentData = $_POST;
        // // if valid add post
        
        header('Content-Type: application/json');
        echo json_encode($result);
        die();
    }

    
}
