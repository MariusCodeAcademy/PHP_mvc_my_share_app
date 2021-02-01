<?php
// Session helper for displaying useful feedback to the user
session_start();
// flash msg helper 
// Example save msg flash('register_success', 'You have registered successfully');
// for display flash('register_success');

function flash($name = '', $message = '', $class = 'alert alert-success')
{
    if (!empty($name)) {
        // this is the part where we set the message
        if (!empty($message) && empty($_SESSION[$name])) {

            // if there is some class left in session we unset it 
            if (!empty($_SESSION[$name . '_class'])) {
                unset($_SESSION[$name . '_class']);
            }

            $_SESSION[$name] = $message;
            $_SESSION[$name . '_class'] = $class;

            // this is where we display msg to the view
        } elseif (empty($message) && !empty($_SESSION[$name])) {
            $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : '';
            echo "<div class='$class' id='msg-flash'>{$_SESSION[$name]}</div>";
            // unset the values that have been shown
            unset($_SESSION[$name]);
            unset($_SESSION[$name . '_class']);
        }
    }
}

// check if user is logged in 
// @returns boolean
function isLoggedIn()
{
    // older simpler way 
    // if (isset($_SESSION['user_id'])) {
    //     return true;
    // } else {
    //     return false;
    // }

    // more complex
    if (isset($_SESSION['user_id'])) return true;
    return false;
}
