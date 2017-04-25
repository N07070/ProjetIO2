<?php

include 'UUID.php';

// Create a new user in the database
function create_new_user($username, $password_1, $password_2, $email, $profile_picture, $biography) {

    $error['number'] = 0; // no errors
    $error['message'] = "";

    try {
        $database_connexion = connect_to_database();
        $req = $database_connexion->prepare('SELECT * FROM utilisateurs WHERE username = ? ');
        $req->execute(array($username));
        $username_is_in_bdd = $req->fetchAll();
        $req->closeCursor();
    } catch (Exception $e) {
        die('Error connecting to database: ' . $e->getMessage());
    }

    // the username exists
    if(!empty($username_is_in_bdd)){
        $error['number'] = 1;
        $error['message'] = "That username already exists. Sorry!";
    }

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
    if($password_1 != $password_2){
        $error['number'] = 1;
        $error['message'] = "Both passwords do not match.";
    }

    // && preg_match_all('$\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$', $password_1)
    if (empty($password_1)){
        $error['number'] = 1;
        $error['message'] = "You need to choose a better password.";
    }

    // the email is available ?
    print_r($email);
    try {
        $req = $database_connexion->prepare('SELECT * FROM utilisateurs WHERE email = ? ');
        $req->execute(array($email));
        $email_is_in_bdd = $req->fetchAll();
        $req->closeCursor();
    } catch (Exception $e) {
        die('Error connecting to database: ' . $e->getMessage());
    }

    print_r($email_is_in_bdd);

    if(!empty($email_is_in_bdd) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error['number'] = 1;
        $error['message'] = "The email is invalid.";
    }

    // the biography isn't too long ?
    if (strlen(htmlspecialchars($biography)) > 500) {
        $error['number'] = 1; // no errors
        $error['message'] = "The biography is invalid.";
    }

    // Beyond this point is no hope.

    // The image for the profile is an image and is in the requirements
    $target_dir = "../www/uploads/";
    $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
    $image_file_type = pathinfo($target_file,PATHINFO_EXTENSION);

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
    if($check == false) {
        $error['number'] = 1;
        $error['message'] = "The profile picture is invalid.";
    }


    // Check if file already exists
    // This error should never be shown, as the picture is named after
    // the UUID of a user.
    if (file_exists($target_file)) {
        $error['number'] = 1;
        $error['message'] = "This profile picture already exists.";
    }
    // Check file size (5Mb)
    if ($_FILES["profile_picture"]["size"] > 5000000) {
        $error['number'] = 1;
        $error['message'] = "This profile picture is too big. 5Mb is the maximum.";
    }

    // Allow certain file formats
    if($image_file_type!= "jpg" && $image_file_type != "png" &&
    $image_file_type != "jpeg" &&
    $image_file_type != "gif" ) {
        $error['number'] = 1;
        $error['message'] = "This profile picture is invalid, please use jpg, png or gifs.";
    }
    echo($error['message']);
    if (!$error['number']) {

        // create UUID for the user
        $v4uuid = UUID::v4();

        // move profile picture to the folder with profile pictures.
        try {

            $extension = pathinfo($target_file);
            $destination_of_file = $target_dir . $v4uuid .".". $extension['extension'];
            $name_of_file = $v4uuid ."." .$extension['extension'];
            move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $destination_of_file);
        } catch (Exception $e) {
            die('Error uploading file: ' . $e->getMessage());
        }

        $hashed_password = password_hash($password_1, PASSWORD_BCRYPT);

        // insert into database
            // $v4uuid,
            // $username,
            // $email,
            // $hashed_password,
            // $name_of_file,
            // $biography,
        try {
            $req = $database_connexion->prepare('INSERT INTO utilisateurs(uuid, username, email, password, profile_picture, biography, is_admin, is_premium) VALUES(?,?,?,?,?,?,?,?)');
            $req->execute(array($v4uuid, $username, $email, $hashed_password, $name_of_file, $biography, 0, 0));
            $req->closeCursor();
        } catch (Exception $e) {
            die('Error connecting to database: ' . $e->getMessage());
        }

        return true;
    }else{
        echo($error['message']);
        return false;
    }
}

// TODO
function delete_user($uuid,$password){

    // Is the password correct

    // those a user with this uuid exist ?

    return false;

}

// TODO
function update_user_profil($username, $password, $email, $profile_picture, $biography){

    return false;
}

function get_uuid_from_username($user_)

// Done
function get_user_from_uuid($user_uuid){
    try {
        $database_connexion = connect_to_database();
        $req = $database_connexion->prepare('SELECT username FROM utilisateurs WHERE uuid = ? ');
        $req->execute(array($user_uuid));
        $username = $req->fetch();
        $req->closeCursor();
    } catch (Exception $e) {
        die('Error connecting to database: ' . $e->getMessage());
    }


    if(empty($username['username'])){
        return false;
    }else{
        return $username['username'];
    }
}

// done
function login_user($username, $password){

    try {
        $database_connexion = connect_to_database();
        $req = $database_connexion->prepare('SELECT password FROM utilisateurs WHERE username = ? ');
        $req->execute(array($username));
        $password_hased = $req->fetch();
        $req->closeCursor();
    } catch (Exception $e) {
        die('Error connecting to database: ' . $e->getMessage());
    }

    // No need to check that the password is empty or anything, as it will not verify.
    if(password_verify($password,$password_hased)){
        return true;
    }else{
        return false;
    }
}

function display_user($user_email){
    try {
        $database_connexion = connect_to_database();
        $req = $database_connexion->prepare('SELECT * FROM utilisateurs WHERE email = ? ');
        $req->execute(array($user_email));
        $user_data = $req->fetchAll();
        $req->closeCursor();
    } catch (Exception $e) {
        die('Error connecting to database: ' . $e->getMessage());
    }

    return $user_data;

}
?>
