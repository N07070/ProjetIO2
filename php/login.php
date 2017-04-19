<?php
require("Utilisateur.php");

function display_login_form(){
    require("../html/login_form.php");
}

function display_signup_form(){
    require("../html/signup_form.php");

function logout_user(){
    // Destroy the user session
    return false;
}

function signup_user($username, $password_1, $password_2, $email, $profile_picture, $biography){
    if(!create_new_user($username, $password_1, $password_2, $email, $profile_picture, $biography)){
        throw_error(500);
    }else {
        display_message("Signup successfull ! Welcome !");
    }
}


function login_signup_user($option,$username, $password_1, $password_2, $email, $profile_picture, $biography){
    if(!empty($options)){
        if($option == 'login_user'){

            $username = mysql_real_escape_string($username);
            $password = mysql_real_escape_string($password);

            if(!login_user($username,$password)){
                throw_error(401);
            }else {
                // Create sessions
                // TODO
                header("Location: ../www/index.php");
            }
        //  Signup new user
        } elseif ($option == 'signup_user' ) {
            signup_user($username, $password_1, $password_2, $email, $profile_picture, $biography);
        // Logout and destroy the sessions
        } else {
            display_login_form();
            display_signup_form();
        }
    } else {
        display_login_form();
        display_signup_form();
    }
}
?>
