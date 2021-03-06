<?php
// 1&Aazzzz
require_once('UUID.php');

// Create a new user in the database
function create_new_user($username, $password_1, $password_2, $email, $profile_picture, $biography) {

    $error['number'] = 0; // no errors
    $error['message'] = "";

    // Sanitise input
    $username = htmlspecialchars(strip_tags($username));
    $email = htmlspecialchars(strip_tags($email));
    $biography = htmlspecialchars(strip_tags($biography));

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
        $error['message'] = "Ce nom d'utilisateur existe déjà, tu peux en choisir un autre.";
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
        $error['message'] = "Les deux mots de passes ne correspondent pas.";
    }


    // Test password : 1&Aazzzz
    if (empty($password_1) || !preg_match_all('$\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$', $password_1)){
        $error['number'] = 1;
        $error['message'] = "Ton mot de passe n'est pas assez bon ; il doit être tel que décrit plus bas.";
    }

    // the email is available ?
    try {
        $req = $database_connexion->prepare('SELECT * FROM utilisateurs WHERE email = ? ');
        $req->execute(array($email));
        $email_is_in_bdd = $req->fetchAll();
        $req->closeCursor();
    } catch (Exception $e) {
        die('Error connecting to database: ' . $e->getMessage());
    }

    if(!empty($email_is_in_bdd) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error['number'] = 1;
        $error['message'] = "Cet email n'est pas valide, ou il est déjà utilisé.";
    }

    // the biography isn't too long ?
    if (strlen(htmlspecialchars($biography)) > 500) {
        $error['number'] = 1; // no errors
        $error['message'] = "Ta biographie est trop longue. 500 caractères maximum.";
    }

    // Beyond this point, loose all hope.

    // The image for the profile is an image and is in the requirements
    $target_dir = "../www/uploads/";
    $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
    $image_file_type = pathinfo($target_file,PATHINFO_EXTENSION);

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
    if($check == false) {
        $error['number'] = 1;
        $error['message'] = "Ta photo de profile n'est pas valide.";
    }


    // Check if file already exists
    // This error should never be shown, as the picture is named after
    // the UUID of a user.
    if (file_exists($target_file)) {
        $error['number'] = 1;
        $error['message'] = "Cette photo de profil existe déjà.";
    }
    // Check file size (5Mb)
    if ($_FILES["profile_picture"]["size"] > 5000000) {
        $error['number'] = 1;
        $error['message'] = "Choisis une photo de profil de moins de 5Mb.";
    }

    // Allow certain file formats
    if($image_file_type!= "jpg" && $image_file_type != "png" &&
    $image_file_type != "jpeg" &&
    $image_file_type != "gif" ) {
        $error['number'] = 1;
        $error['message'] = "Tu dois utiliser des JPEG, GIF ou PNG pour ta photo de profil uniquement.";
    }

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
            $req = $database_connexion->prepare('INSERT INTO utilisateurs(uuid, username, email, password, profile_picture, biography, is_admin, is_premium, upvoted_projects, downvoted_projects) VALUES(?,?,?,?,?,?,?,?,?,?)');
            $req->execute(array($v4uuid, $username, $email, $hashed_password, $name_of_file, $biography, 0, 0,"",""));
            $req->closeCursor();
        } catch (Exception $e) {
            die('Error connecting to database: ' . $e->getMessage());
        }

        return true;
    }else{
        return $error['message'];
    }
}

// TODO
function delete_user($uuid,$password){

    try {
        $database_connexion = connect_to_database();
        $req = $database_connexion->prepare('SELECT password FROM utilisateurs WHERE uuid = ?');
        $req->execute(array($uuid));
        $password_hased = $req->fetch();
        $req->closeCursor();
    } catch (Exception $e) {
        die('Error connecting to database: ' . $e->getMessage());
    }

    // Is the password correct
    print_r($uuid);
    echo("");
    print_r($password);
    print_r();
    print_r($password_hased);

    if(password_verify($password,$password_hased['password'])){
        echo "bite";
        try {
            $database_connexion = connect_to_database();

            // Set the project to inactive and precise in the resume that the user is gone.
            $req = $database_connexion->prepare('UPDATE projets SET is_featured = ?, status = ?, resume = ? WHERE owner = ?');
            $req->execute(array(0,0,"Ce projet est inactif, car le créateur est parti vers d'autres horizons.", $uuid));
            $req->closeCursor();

            // Delete the user
            // - Set his profile picture to a grey background,
            // - Set his password and email to null
            // - Set this biography to [deleted]
            // - Set his admin and premium status to 0.
            $req = $database_connexion->prepare('UPDATE utilisateurs SET email = ?, password = ?, profile_picture = ?, biography = ?, is_admin = ?, is_premium = ? WHERE uuid = ?');
            $req->execute(array(null,null,"deleted_user.jpg","[deleted]",0,0, $uuid));
            $req->closeCursor();

            // Replace all the user comments by "[deleted]"
            $req = $database_connexion->prepare('UPDATE commentaires SET commentaire = ? WHERE user = ?');
            $req->execute(array("[deleted]", $uuid));
            $req->closeCursor();
        } catch (Exception $e) {
            die('Error connecting to database: ' . $e->getMessage());
        }
        return true;
    } else {
        return false;
    }
}

function update_user_profil($uuid, $old_password, $password_1 , $password_2 , $email, $profile_picture, $biography){
    // TODO :
    // Make it possible for the user to change his/her username.

    // Sanitise input
    $email = htmlspecialchars(strip_tags($email));
    $biography = htmlspecialchars(strip_tags($biography));

    try {
        $database_connexion = connect_to_database();
        $req = $database_connexion->prepare('SELECT password FROM utilisateurs WHERE uuid = ?');
        $req->execute(array($uuid));
        $password_hased = $req->fetch();
        $req->closeCursor();
    } catch (Exception $e) {
        die('Error connecting to database: ' . $e->getMessage());
    }

    // Is the password correct
    if(password_verify($old_password,$password_hased[0])){

        $error['number'] = 0; // no errors
        $error['message'] = "";

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
            $error['message'] = "Les deux mots de passes ne correspondent pas.";
            return $error;
        }


        if (empty($password_1) || !preg_match_all('$\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$', $password_1)){
            $error['number'] = 1;
            $error['message'] = "Ton mot de passe n'est pas assez bon ; il doit être tel que décrit plus bas.";
            return $error;
        }

        // the email is available ?
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error['number'] = 1;
            $error['message'] = "Cet email n'est pas valide.";
            return $error;
        }

        // We need to check that the new email is not also the old one
        try {
            $req = $database_connexion->prepare('SELECT * FROM utilisateurs WHERE email = ? ');
            $req->execute(array($email));
            $email_is_in_bdd = $req->fetchAll();
            $req->closeCursor();
        } catch (Exception $e) {
            die('Error connecting to database: ' . $e->getMessage());
        }

        // If the UUID is the one of the user changing his email, then the email is
        // valid.
        // Otherwise, it means that the new email is already in use.
        if($email_is_in_bdd[0]['email'] != $email){
            $error['number'] = 1;
            $error['message'] = "Cet email est déjà utilisé.";
            return $error;
        }


        // the biography isn't too long ?
        if (strlen(htmlspecialchars($biography)) > 500) {
            $error['number'] = 1;
            $error['message'] = "Ta biographie est trop longue. 500 caractères maximum.";
            return $error;
        }

        // Beyond this point, loose all hope.

        // // The image for the profile is an image and is in the requirements
        // $target_dir = "../www/uploads/";
        // $target_file = $target_dir . basename($profile_picture["profile_picture"]["name"]);
        // $image_file_type = pathinfo($target_file,PATHINFO_EXTENSION);
        //
        // // Check if image file is a actual image or fake image
        // $check = getimagesize($profile_picture["profile_picture"]["tmp_name"]);
        //
        // print_r($profile_picture);
        // print_r();
        // print_r($target_file);
        // print_r();
        // print_r($image_file_type);
        // print_r();
        // print_r($check);
        //
        //
        // if($check == false) {
        //     $error['number'] = 1;
        //     $error['message'] = "Ta photo de profil n'est pas valide.";
        //     return $error;
        // }
        //
        // // Check file size (5Mb)
        // if ($profile_picture["profile_picture"]["size"] > 5000000) {
        //     $error['number'] = 1;
        //     $error['message'] = "Choisis une photo de profil de moins de 5Mb.";
        //     return $error;
        // }
        //
        // // Allow certain file formats
        // if( $image_file_type!= "jpg" &&
        //     $image_file_type != "png" &&
        //     $image_file_type != "jpeg" &&
        //     $image_file_type != "gif" ) {
        //     $error['number'] = 1;
        //     $error['message'] = "Tu dois utiliser des JPEG, GIF ou PNG pour ta photo de profil uniquement.";
        //     return $error;
        // }

        // Hash new password
        $new_hashed_password = password_hash($password_1, PASSWORD_BCRYPT);

        try {
            $database_connexion = connect_to_database();
            // $req = $database_connexion->prepare('UPDATE utilisateurs SET email = ?, profile_picture = ?, biography = ?, password = ? WHERE uuid = ?');
            $req = $database_connexion->prepare('UPDATE utilisateurs SET email = ?, biography = ?, password = ? WHERE uuid = ?');
            // $req->execute(array($email,$profile_picture,$biography, $new_hashed_password, $uuid));
            $req->execute(array($email,$biography, $new_hashed_password, $uuid));
            $req->closeCursor();
        } catch (Exception $e) {
            die('Error connecting to database: ' . $e->getMessage());
        }

        $error['number'] = 0;
        $error['message'] = "Tes informations ont été mises à jour !";
        return $error;
    } else {
        $error['number'] = 1;
        $error['message'] = "Ton ancien mot de passe n'ai pas bon.";
        return $error;
    }
}

function get_uuid_from_username($username){

    try {
        $database_connexion = connect_to_database();
        $req = $database_connexion->prepare('SELECT uuid FROM utilisateurs WHERE username = ? ');
        $req->execute(array($username));
        $uuid_of_user = $req->fetch();
        $req->closeCursor();
    } catch (Exception $e) {
        die('Error connecting to database: ' . $e->getMessage());
    }


    if(empty($uuid_of_user['uuid'])){
        return false;
    }else{
        return $uuid_of_user['uuid'];
    }
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

    try {
        $database_connexion = connect_to_database();
        $req = $database_connexion->prepare('SELECT password FROM utilisateurs WHERE username = ?');
        $req->execute(array($username));
        $password_hased = $req->fetch();
        $req->closeCursor();
    } catch (Exception $e) {
        die('Error connecting to database: ' . $e->getMessage());
    }

    // No need to check that the password is empty or anything, as it will not verify.
    if(password_verify($password,$password_hased[0])){ // Do not forget that it returns an array.
        return true;
    }else{
        return false;
    }
}

function get_user_data($uuid){
    try {
        $database_connexion = connect_to_database();
        $req = $database_connexion->prepare('SELECT * FROM utilisateurs WHERE uuid = ? ');
        $req->execute(array($uuid));
        $user_data = $req->fetchAll();
        $req->closeCursor();
    } catch (Exception $e) {
        die('Error connecting to database: ' . $e->getMessage());
    }

    return $user_data;

}

function user_exits($uuid){
    try {
        $database_connexion = connect_to_database();
        $req = $database_connexion->prepare('SELECT * FROM utilisateurs WHERE uuid = ? ');
        $req->execute(array($uuid));
        $userdata = $req->fetchAll();
        $req->closeCursor();
    } catch (Exception $e) {
        die('Error connecting to database: ' . $e->getMessage());
    }


    if(empty($userdata)){
        return false;
    }else{
        return true;
    }
}

?>
