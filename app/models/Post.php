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
        $sql = "SELECT posts.title, posts.body, users.name, users.email,
        posts.id as postId,
        users.id as userId,
        posts.created_at as postCreated,
        users.created_at as userCreated
        FROM posts
        INNER JOIN users
        ON posts.user_id = users.id
        ORDER BY posts.created_at DESC";


        $this->db->query($sql);

        $result = $this->db->resultSet();

        return $result;
    }

    public function addPost($data)
    {
        // prepare statment
        $this->db->query("INSERT INTO posts (`title`, `body`, `user_id`) VALUES (:title, :body, :user_id)");

        // add values
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':body', $data['body']);
        $this->db->bind(':user_id', $data['user_id']);

        // make query 
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // will return post row if found
    // return false if not found
    public function getPostById($id)
    {
        $this->db->query("SELECT * FROM posts WHERE id = :id");

        $this->db->bind(':id', $id);

        $row = $this->db->singleRow();

        if ($this->db->rowCount() > 0) {
            return $row;
        }
        return false;
    }

    // to update one field
    public function updatePost($data)
    {
        // prepare statment
        $this->db->query("UPDATE posts SET title = :title, body = :body WHERE id = :post_id");

        // add values
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':body', $data['body']);
        $this->db->bind(':post_id', $data['post_id']);

        // make query 
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
