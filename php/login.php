<?php
require("Utilisateur.php");

function display_login_form(){
    require("../html/login_form.php");
}

function display_signup_form(){
    require("../html/signup_form.php");
}

function logout_user(){
    // Destroy the user session
    try {
        session_destroy();
        header("Location: index.php");
    } catch (Exception $e) {
        die('Error while destroying the session: ' . $e->getMessage());
    }
}



function login_signup_user($option,$username, $password_1, $password_2, $email, $profile_picture, $biography){
    if(!empty($option)){
        if($option == 'login_user'){

            if(!login_user($username,$password_1)){
                throw_error(401);
                display_login_form();
            }else {
                // Create sessions
                // TODO
                $_SESSION['login']  = true;
                $_SESSION['uuid'] = get_uuid_from_username($username);
                header("Location: ../index.php");
            }
        //  Signup new user
        } elseif ($option == 'signup_user' ) {
            $result = create_new_user($username, $password_1, $password_2, $email, $profile_picture, $biography);
            if(gettype($result) == "boolean" && $result){
                display_message("Signup successfull ! Welcome !");
                display_login_form();
            }else {
                display_error($result);
                display_signup_form();
            }
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
