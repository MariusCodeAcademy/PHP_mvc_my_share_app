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
}
