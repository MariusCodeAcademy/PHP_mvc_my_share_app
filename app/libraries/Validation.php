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
    // check if every array value is empty
    // @return boolean
    public function ifEmptyArr($arr)
    {
        // check if all values of array is empty
        foreach ($arr as $errorValue) {
            if (!empty($errorValue)) {
                return false;
            }
        }
        return true;
    }

    public function ifEmptyFieldWithReference(&$data, $field, $fieldDisplayName)
    {
        $fieldError = $field . 'Err';
        // Validate Name 
        if (empty($data[$field])) {
            // empty field
            $data['errors'][$fieldError] = "Please enter Your $fieldDisplayName";
        }
    }

    // if field is empty we return message, else we return empty string
    public function ifEmptyField($field, $fieldDisplayName, $msg = null)
    {
        // Validate Name 
        if (empty($field)) {
            // empty field
            if ($msg) {
                return $msg;
            }
            return "Please enter Your $fieldDisplayName";
        }
        return ''; //falsy
    }
}
