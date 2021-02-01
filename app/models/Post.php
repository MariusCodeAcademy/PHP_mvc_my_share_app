<?php

// Class for getting and sending Post data to and from DB
class Post
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // get all posts from posts table
    // @return Object Array
    public function getPosts()
    {
        $this->db->query("SELECT * FROM posts");

        $result = $this->db->resultSet();

        return $result;
    }
}
