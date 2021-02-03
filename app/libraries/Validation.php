<?php

// this is a class to validate different inputs and data

class Validation
{
    // checks if server request is post
    // @return boolean
    public function ifRequestIsPost()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") return true;
        return false;
    }

    public function sanitizePost()
    {
        // sanitize Post Array
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    }

    public function ifRequestIsPostAndSanitize()
    {
        if ($this->ifRequestIsPost()) {
            $this->sanitizePost();
            return true;
        }
        return false;
    }
}
