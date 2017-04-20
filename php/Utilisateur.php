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
        $username_is_in_bdd = $req->fetch();
        $req->closeCursor();
    } catch (Exception $e) {
        die('Error connecting to database: ' . $e->getMessage());
    }

    $password_is_ok = false;
    $username_is_ok = false;
    $email_is_ok = false;
    $bio_is_ok = false;
    $profile_ok = false;

    // the username exists
    if(empty($username_is_in_bdd)){
        $error['number'] = 0; // no errors
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
    if($password_1 == $password_2){
        $error['number'] = 1; // no errors
        $error['message'] = "Both passwords do not match.";
    }

    if (!empty($password_1) &&
    preg_match_all('$\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$', $password_1)){
        $error['number'] = 1; // no errors
        $error['message'] = "You need to choose a better password.";
    }

    // the email is available ?
    try {
        $req = $database_connexion->prepare('SELECT * FROM utilisateurs WHERE email = ? ');
        $req->execute(array($email));
        $email_is_in_bdd = $req->fetch();
        $req->closeCursor();
    } catch (Exception $e) {
        die('Error connecting to database: ' . $e->getMessage());
    }

    if(empty($email_is_in_bdd) && filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error['number'] = 1; // no errors
        $error['message'] = "The email is invalid.";
    }

    // the biography isn't too long ?
    if (strlen(htmlspecialchars($biography)) < 501) {
        $bio_is_ok = true;
    } else {
        $bio_is_ok = false;
    }

    // The image for the profile is an image and is in the requirements
    $target_dir = "../www/uploads/";
    $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
    $profile_ok = true;
    $image_file_type = pathinfo($target_file,PATHINFO_EXTENSION);

    // Check if image file is a actual image or fake image
    if(isset($_POST["signup"])) {
        $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
        if($check != false) {
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
    if ($_FILES["profile_picture"]["size"] > 5000000) {
        $profile_ok = false;
    }

    // Allow certain file formats
    if($image_file_type!= "jpg" && $image_file_type != "png" &&
    $image_file_type != "jpeg" &&
    $image_file_type != "gif" ) {
        $profile_ok = false;
    }

    echo("1".$password_is_ok);
    echo("<br>2".$username_is_ok);
    echo("<br>3".$email_is_ok);
    echo("<br>4".$bio_is_ok);
    echo("<br>5".$profile_ok);


    if (!empty($username) && $username_is_ok &&
        !empty($password_1) && $password_is_ok &&
        !empty($email) && $email_is_ok &&
        !empty($biography) && $bio_is_ok &&
        !empty($profile_picture) && $profile_ok) {

        // create UUID for the user
        $v4uuid = UUID::v4();

        // move profile picture to the folder with profile pictures.
        try {

            $extension = pathinfo($target_file);
            $destination_of_file = $target_dir . $v4uuid . $extension['extension'];
            $name_of_file = $v4uuid . $extension['extension'];
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
            $req->execute(array($v4uuid, $username, $hashed_password, $email, $name_of_file, $biography, 0, 0));
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

// done
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
