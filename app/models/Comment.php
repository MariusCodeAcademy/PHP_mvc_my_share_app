<?php
class Comment
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getMeComments($post_id)
    {
        $this->db->query('SELECT * FROM comments WHERE post_id = :id');

        $this->db->bind(':id', $post_id);

        $comments = $this->db->resultSet();

        if ($this->db->rowCount() > 0) {
            return $comments;
        }
        return false;
    }

    // @return Boolean
    
    public function addComment($data)
    {
        // get data and add comment using data
        $this->db->query("INSERT INTO comments (post_id, author, comment_body) VALUES (:post_id, :author, :comment_body)");

        // bind the values
        $this->db->bind(':post_id', $data['postId']);
        $this->db->bind(':author', $data['author']);
        $this->db->bind(':comment_body', $data['commentBody']);

        // make query 
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }


    }
}
