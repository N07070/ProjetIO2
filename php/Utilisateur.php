<?php

include 'UUID.php';

/*
Creates a new user in the database

*/

function create_new_user($username, $password, $email, $profile_picture, $biography) {

    $database_connexion = connect_to_database();
    $req = $database_connexion->prepare('SELECT * FROM utilisateurs WHERE username = ? ');
    $req->execute(array($username));

    // the username exists
    if(empty($req)){
        $username_is_ok = true;
    }else{
        $username_is_ok = false;
    }

    $req->closeCursor();

    // the password matches the requirements
    // http://code.runnable.com/UmrnTejI6Q4_AAIM/how-to-validate-complex-passwords-using-regular-expressions-for-php-and-pcre
    /*
    Explaining $\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$
    $ = beginning of string
    \S* = any set of characters
    (?=\S{8,}) = of at least length 8
    (?=\S*[a-z]) = containing at least one lowercase letter
    (?=\S*[A-Z]) = and at least one uppercase letter
    (?=\S*[\d]) = and at least one number
    (?=\S*[\W]) = and at least a special character (non-word characters)
    $ = end of the string
    */
    if (!preg_match_all('$\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$', $password))
        $password_is_ok = true;
    }else{
        $password_is_ok = false;
    }

    // the email is available ?
    $req = $database_connexion->prepare('SELECT * FROM utilisateurs WHERE email = ? ');
    $req->execute(array($email));
    if(empty($req) && filter_var($email, FILTER_VALIDATE_EMAIL)){
        $email_is_ok = true;
    }else{
        $email_is_ok = false;
    }

    $req->closeCursor();

    // the username is available
    $req = $database_connexion->prepare('SELECT * FROM utilisateurs WHERE username = ? ');
    $req->execute(array($username));
    if(empty($req)){
        $username_is_ok = true;
    }else{
        $username_is_ok = false;
    }

    $req->closeCursor();


    // the bibliography isn't too long ?
    if (len($bibliography) < 500) {
        $bibli_is_ok = true;
    } else {
        $bibli_is_ok = false;
    }



    if (!empty($username) && $username_is_ok && !empty($password) && $password_is_ok \
        !empty($email) && $email_is_ok && !empty($bibliography) && $bibli_is_ok && !empty($profile_picture)) {

        // create UUID

        // insert into database

    }else{
        // Return an error

    }

}

function delete_user($uuid,$password){

    // Is the password correct

    // those a user with this uuid exist ?

}

function update_user_profil($username, $password, $email, $profile_picture, $biography){

}

?>
