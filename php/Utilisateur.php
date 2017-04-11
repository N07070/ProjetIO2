<?php

include 'UUID.php';

// Create a new user in the database
function create_new_user($username, $password, $email, $profile_picture, $biography) {

    try {
        $database_connexion = connect_to_database();
        $req = $database_connexion->prepare('SELECT * FROM utilisateurs WHERE username = ? ');
        $req->execute(array($username));
        $username_is_in_bdd = $req->fetch();
        $req->closeCursor();
    } catch (Exception $e) {
        die('Error connecting to database: ' . $e->getMessage());
    }

    // the username exists
    if(empty($username_is_in_bdd)){
        $username_is_ok = true;
    }else{
        $username_is_ok = false;
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
    if (!empty($password) && !preg_match_all('$\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$', $password)){
        $password_is_ok = true;
    } else {
        $password_is_ok = false;
    }

    // the email is available ?
    try {
        $req = $database_connexion->prepare('SELECT * FROM utilisateurs WHERE email = ? ');
        $req->execute(array($email));
        $email_is_in_bdd = $req->fetch();
    } catch (Exception $e) {
        die('Error connecting to database: ' . $e->getMessage());
    }
    $req->closeCursor();

    if(empty($email_is_in_bdd) && filter_var($email, FILTER_VALIDATE_EMAIL)){
        $email_is_ok = true;
    }else{
        $email_is_ok = false;
    }

    // the bibliography isn't too long ?
    if (len($bibliography) < 501) {
        $bibli_is_ok = true;
    } else {
        $bibli_is_ok = false;
    }

    // The image for the profile is an image and is in the requirements
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["profile_picture_user"]["name"]);
    $profile_ok = true;
    $image_file_type = pathinfo($target_file,PATHINFO_EXTENSION);
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["profile_picture_user"]["tmp_name"]);
        if($check !== false) {
            // echo "File is an image - " . $check["mime"] . ".";
            $profile_ok = true;
        } else {
            $profile_ok = false;
        }
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        $profile_ok = false;
    }
    // Check file size (5Mb)
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        $profile_ok = false;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        $profile_ok = false;
    }

    if (!empty($username) && $username_is_ok && !empty($password) && $password_is_ok && !empty($email) && $email_is_ok && !empty($bibliography) && $bibli_is_ok && !empty($profile_picture && !empty($profile_picture) && $profile_ok)) {
        // create UUID for the user
        $v4uuid = UUID::v4();

        // move profile picture to the folder with profile pictures.
        try {
            move_uploaded_file($_FILES["profile_picture_user"]["tmp_name"], $target_file);
        } catch (Exception $e) {
            die('Error uploading file: ' . $e->getMessage());
        }

        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        // insert into database
        try {
            $req = $database_connexion->prepare('INSERT INTO utilisateurs WHERE email = ? ');
            $req->execute(array($email));
            $req->closeCursor();
        } catch (Exception $e) {
            die('Error connecting to database: ' . $e->getMessage());
        }
        return true;
    }else{
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

// Done
function login_user($username, $password){
    $password = mysql_real_escape_string($password);
    $username = mysql_real_escape_string($username);
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
?>
