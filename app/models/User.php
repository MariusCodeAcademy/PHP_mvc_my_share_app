<?php
// User class 
// for getting and setting database values 

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // finds user by given email
    // @return Boolean
    public function findUserByEmail($email)
    {
        // check if the given email is in data base
        // prepare statement
        $this->db->query("SELECT * FROM users WHERE `email` = :email");

        // add values to statment
        $this->db->bind(':email', $email);

        // save result in $row
        $row = $this->db->singleRow();

        // check if we got some results
        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // Register user with given sanitized data 
    // @return Boolean 
    public function register($data)
    {
        // prepare statment
        $this->db->query("INSERT INTO users (`name`, `email`, `password`) VALUES (:name, :email, :password)");

        // add values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        // hasshed
        $this->db->bind(':password', $data['password']);

        // make query 
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
