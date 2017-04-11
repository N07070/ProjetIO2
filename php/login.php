<?php
require("Utilisateur.php");

function display_login_form(){
    require("../html/login_form.php");
}

function display_signup_form(){
    require("../html/signup_form.php");
}

function signup_user($username, $password, $email, $profile_picture, $biography){
    $username = mysql_real_escape_string($username);
    $password = mysql_real_escape_string($password);
    $email = mysql_real_escape_string($email);
    // TODO $profile_picture
    $biography = mysql_real_escape_string($biography);
    if(!create_new_user()){
        throw_error(500);
    }else {
        display_message("Signup successfull ! Welcome !");
    }
}

function login_signup_user($option,$username){
    if($_POST['login_user']){

        $username = mysql_real_escape_string($_POST['username']);
        $password = mysql_real_escape_string($_POST['password']);

        if(!login_user($username,$password)){
            throw_error(401);
        }else {
            // Create sessions
            // TODO
            header("Location: ../www/index.php");
        }
    //  Signup new user
    } elseif ($_POST['signup_user']) {
        if(!signup_user($username, $password, $email, $profile_picture, $biography)){
            throw_error(402);
        }else {
            trow_error(100);
            header("Location: ../www/index.php");
        }
    // Logout and destroy the sessions
    } elseif ($_POST['logout']) {
        logout_user();
    // Display the login page with the signup and login forms
    } else {

    }
}
?>
