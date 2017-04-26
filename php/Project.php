<?php
require_once("UUID.php");
require_once("Utilisateur.php");

function create_new_project($owner, $title, $tags, $pictures, $resume, $description){

    // In case there is a mistake
    $error["number"] = 0
    $error["message"] = "";

    // Validate the project inputs
    // $owner must exist in the database,
    if (!user_exits($owner)) {
        $error["number"] = 1
        $error["message"] = "This user does not exist. How did you do that ?";
        return $error;
    }

    // $title must not be a current

    if(!project_exists($title)){
        $error["number"] = 1
        $error["message"] = "A project with this name already exists. Pleas choose another name :-)";
        return $error;
    }

    // $tags must by in the form of word,word,word
    if(!tags_of_new_project_are_valid($tags)){
        $error["number"] = 1
        $error["message"] = "The tags are invalid. They must be like 'tags,tags,tags' with a trailing comma.";
        return $error;
    }

    // $pictures must be an array of valid pictures
    if(!pictures_are_valid($pictures)){
        $error["number"] = 1
        $error["message"] = "The pictures must be less than 5Mb and be jpgs, gifs, or pngs.";
        return $error;
    }
    // $resume must be less than 501 chars, and only text
    // $description must be less than 2001 chars., and only text.

    // Add the current time

    $v4uuid = UUID::v4();

    try {
        $req = $database_connexion->prepare('INSERT INTO projects(uuid, owner, nbr_upvote, nbr_downvote, participants, creation_date, is_featured, title, status, limit_date, pictures, resume, description) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
        $req->execute(array($v4uuid, $username, $email, $hashed_password, $name_of_file, $biography, 0, 0));
        $req->closeCursor();
    } catch (Exception $e) {
        die('Error connecting to database: ' . $e->getMessage());
    }


}

function add_user_to_project(){

}

function delete_project(){

}

// With a UUID or project name, return true if it exists.
function project_exists($project){
    try {
        $database_connexion = connect_to_database();
        $req = $database_connexion->prepare('SELECT * FROM projects WHERE uuid = ? OR title = ? ');
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
    return preg_match_all('$([A-z]+,)$', $tags))
}

function pictures_are_valid($pictures){
    foreach ($pictures as $picture) {
        // Make sure the image is true, and it has the right size.

        // TODO
        //$image_file_type = pathinfo($picture,PATHINFO_EXTENSION);

        if(!getimagesize($picture) || getimagesize($picture) > 5000000) {
            return false;
        }
    }
}

?>
