<?php
// Pages class responsible for controlin Pages
class Pages extends Controller
{
    public function __construct()
    {
        // echo 'hello form pages controller';
    }

    public function index()
    {
        // create some data to load into vie
        $data = [
            'title' => 'Welcome to ' . SITENAME,
        ];

        // load the view
        $this->view('pages/index', $data);
    }

    public function about()
    {
        // load the view
        // create some data to load into vie
        $data = [
            'title' => 'Welcome to About page - ' . SITENAME,
        ];

        // load the view
        $this->view('pages/about', $data);
    }
}
