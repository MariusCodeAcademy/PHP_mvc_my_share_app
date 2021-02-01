<?php

/*
* Post controller
* Basic CRUD Functionality
* 
*/

class Posts extends Controller
{
    public function __construct()
    {
        // restrict access of this controller only to logged in users
        if (!isLoggedIn()) redirect('/users/login');
    }

    public function index()
    {
        $data = [];
        $this->view('posts/index', $data);
    }
}
