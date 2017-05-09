<?php
require_once("Utilisateur.php");
require_once("ConnectionBaseDeDonnee.php");

function create_new_project($owner, $title, $tags, $pictures, $resume, $description){

    // In case there is a mistake
    $error = [];
    $error["number"] = 0;
    $error["message"] = "";

    // Validate the project inputs
    // $owner must exist in the database,
    if (!user_exits($owner)) {
        $error["number"] = 1;
        $error["message"] = "This user does not exist. How did you do that ?";
        return $error;
    }

    // $title must not be a current

    if(project_exists($title)){
        $error["number"] = 1;
        $error["message"] = "A project with this name already exists. Please choose another name :-)";
        return $error;
    }

    // $tags must by in the form of word,word,word
    if(!tags_of_new_project_are_valid($tags)){
        $error["number"] = 1;
        $error["message"] = "The tags are invalid. They must be like 'tags,tags,tags' with a trailing comma.";
        return $error;
    }

    // $pictures must be an array of valid pictures
    if(!pictures_are_valid($pictures)){
        $error["number"] = 1;
        $error["message"] = "The pictures must be less than 5Mb and be jpgs, gifs, or pngs.";
        return $error;
    }

    // $resume must be less than 501 chars, and only text
    if(!resume_is_valid($resume)){
        $error["number"] = 1;
        $error["message"] = "The resume must be less than 501 chars, and only text";
        return $error;
    }

    // $description must be less than 2001 chars., and only text.
    if(!description_is_valid($description)){
        $error["number"] = 1;
        $error["message"] = "The description must be less than 2001 chars, and only text";
        return $error;
    }

    // Add the current time

    $v4uuid = UUID::v4();
    // Move the pictures for upload.
    $pictures_path = "";
    // Count number of files ( 3 at most )
    // Add a counter with number of files
    // Move each file, with uuid_of_project-number_of_file.extension as filename
    // Move it to uploads/projects/
    // Add the filename to $pictures_path
    // Add $pictures_path to the database

    $pictures = reArrayFiles($pictures['profile_picture']);
    $pictures_path = "";
    $counter = count($pictures) - 1;
    foreach ($pictures as $picture) {
        try {
            $extension = pathinfo($picture['name'], PATHINFO_EXTENSION);
            $target_dir = "uploads/projects/";
            $target_file = $v4uuid."-".$counter.".".$extension;
            $destination_of_file = $target_dir . $target_file;
            move_uploaded_file($picture["tmp_name"], $destination_of_file);
            $pictures_path .= $target_file . ",";
            $counter--;
        } catch (Exception $e) {
            die('Error uploading file: ' . $e->getMessage());
        }
    }

    $date_in_a_month = strtotime(date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"))) . " +1 month");
    $date_in_a_month = date("Y-m-d H:i:s",$date_in_a_month);

    try {
        $database_connexion = connect_to_database();
        $req = $database_connexion->prepare('INSERT INTO projets(uuid, owner, nbr_upvote, nbr_downvote, participants, creation_date, is_featured, title, tags, status, limit_date, pictures, resume, description) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
        $req->execute(array($v4uuid, $owner, 1, 0 , $owner."," , date("Y-m-d H:i:s"), 0 , $title, $tags, 1 , $date_in_a_month , $pictures_path, $resume, $description));
        $req->closeCursor();
    } catch (Exception $e) {
        die('Error connecting to database: ' . $e->getMessage());
    }

    $results = [1,$v4uuid,$title];

    return $results;

}

function add_user_to_project($uuid,$project){
    if(!user_participating_to_project($uuid, $project)){
        try {
            $database_connexion = connect_to_database();
            $req = $database_connexion->prepare("SELECT participants FROM projets WHERE uuid = ?");
            $req->execute(array($project));
            $participants = $req->fetch();
            $req->closeCursor();
        } catch (Exception $e) {
            die("Error connecting to the database " . $e->getMessage());
        }

        print_r($participants[0] . $uuid . ",");

        try {
            $database_connexion = connect_to_database();
            $req = $database_connexion->prepare("UPDATE projets SET participants = ? WHERE uuid = ?");
            $req->execute(array($participants[0] . $uuid . ",", $project));
            $req->closeCursor();
        } catch (Exception $e) {
            die("Error connecting to the database " . $e->getMessage());
        }

        return true;
    }

    return false;
}

function user_participating_to_project($uuid,$project){
    try {
        $database_connexion = connect_to_database();
        $req = $database_connexion->prepare('SELECT participants FROM projets WHERE uuid = ?');
        $req->execute(array($project));
        $participants = $req->fetch();
        $req->closeCursor();
    } catch (Exception $e) {
        die('Error connecting to database: ' . $e->getMessage());
    }

    $participants = $participants[0];

    if (strpos($participants, $uuid) !== false) {
        return true;
    } else {
        return false;
    }
}

function delete_project($project){
    // TODO: Delete the pictures too
    try {
        $database_connexion = connect_to_database();
        $req = $database_connexion->prepare('DELETE FROM projets WHERE uuid = ?');
        $req->execute(array($project));
        $req->closeCursor();
    } catch (Exception $e) {
        die('Error connecting to database: ' . $e->getMessage());
    }
    return true;
}

// With a UUID or project name, return true if it exists.
function project_exists($project){
    try {
        $database_connexion = connect_to_database();
        $req = $database_connexion->prepare('SELECT * FROM projets WHERE uuid = ? OR title = ? ');
        $req->execute(array($project, $project));
        $project_data = $req->fetchAll();
        $req->closeCursor();
    } catch (Exception $e) {
        die('Error connecting to database: ' . $e->getMessage());
    }


    if(empty($project_data)){
        return false;
    }else{
        return true;
    }
}

// Check if a string is in the form of "tags,tags,tags," WITH trailing comma.
function tags_of_new_project_are_valid($tags){
    return preg_match_all('$([A-z]+,)$', $tags);
}

function get_projects_of_user($uuid){
    try {
        $database_connexion = connect_to_database();
        $req = $database_connexion->prepare('SELECT * FROM projets WHERE owner = ?');
        $req->execute(array($uuid));
        $project_data = $req->fetchAll();
        $req->closeCursor();
    } catch (Exception $e) {
        die('Error connecting to database: ' . $e->getMessage());
    }


    if(empty($project_data)){
        return false;
    }else{
        return $project_data;
    }

}

function pictures_are_valid($pictures){
    // print_r($pictures['profile_picture']['name'][0]);
    $pictures = reArrayFiles($pictures['profile_picture']);
    foreach ($pictures as $picture) {
        // Make sure the image is true, and it has the right size.
        $image_file_type = pathinfo(basename($picture["name"]) ,PATHINFO_EXTENSION);

        // Check if image file is a actual image or fake image
        if(!getimagesize($picture["tmp_name"])) {
            return false;
        }

        // Check file size (5Mb)
        if ($picture["size"] > 5000000) {
            return false;
        }

        // Allow certain file formats
        $image_file_type = strtolower($image_file_type);
        if($image_file_type != "jpg" && $image_file_type != "png" &&
        $image_file_type != "jpeg" &&
        $image_file_type != "gif" ) {
            return false;
        }

        return true;
    }
}

function resume_is_valid($resume){
    $resume = htmlspecialchars($resume);
    if (strlen($resume) < 501) {
        return true;
    } else{
        return false;
    }
}

function description_is_valid($description){
    $description = htmlspecialchars($description);
    if (strlen($description) < 2001) {
        return true;
    } else{
        return false;
    }
}

function reArrayFiles(&$file_post) {

    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
}

function get_project_data($project){
    try {
        $database_connexion = connect_to_database();
        $req = $database_connexion->prepare('SELECT * FROM projets WHERE uuid = ?');
        $req->execute(array($project));
        $project_data = $req->fetchAll();
        $req->closeCursor();
    } catch (Exception $e) {
        die('Error connecting to database: ' . $e->getMessage());
    }


    if(empty($project_data)){
        return false;
    }else{
        return $project_data;
    }
}

function upvote_project($project){
    // TODO : Add limitation to the number of upvotes a user can give to a project
    if(project_exists($project)){
        try {
            $database_connexion = connect_to_database();
            $req = $database_connexion->prepare('SELECT nbr_upvote FROM projets WHERE uuid = ?');
            $req->execute(array($project));
            $upvotes_of_project = $req->fetch();
            $req->closeCursor();
        } catch (Exception $e) {
            die('Error connecting to database: ' . $e->getMessage());
        }

        try {
            $database_connexion = connect_to_database();
            $req = $database_connexion->prepare('UPDATE projets SET nbr_upvote = ? WHERE uuid = ?');
            $req->execute(array($upvotes_of_project[0] + 1,$project));
            $req->closeCursor();
        } catch (Exception $e) {
            die('Error connecting to database: ' . $e->getMessage());
        }

        return $upvotes_of_project[0] + 1;
    } else {
        return false;
    }
}

function downvote_project($project){
    // TODO : Add limitation to the number of upvotes a user can give to a project
    if(project_exists($project)){
        try {
            $database_connexion = connect_to_database();
            $req = $database_connexion->prepare('SELECT nbr_downvote FROM projets WHERE uuid = ?');
            $req->execute(array($project));
            $downvotes_of_project = $req->fetch();
            $req->closeCursor();
        } catch (Exception $e) {
            die('Error connecting to database: ' . $e->getMessage());
        }

        try {
            $database_connexion = connect_to_database();
            $req = $database_connexion->prepare('UPDATE projets SET nbr_downvote = ? WHERE uuid = ?');
            $req->execute(array($downvotes_of_project[0] + 1,$project));
            $req->closeCursor();
        } catch (Exception $e) {
            die('Error connecting to database: ' . $e->getMessage());
        }

        return $downvotes_of_project[0] + 1;

    } else {
        return false;
    }
}

?>
