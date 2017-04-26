<?php
// Gets all the 200 last projets, class them, and return
// the top 15 projects
function get_all_projects($start){
    // Connect to database
    $projects = array();
    $database_connexion = connect_to_database();
    if(isset($start) && $start > 0 && !empty($start)){
        // Get the $start
        try {
            $req = $database_connexion->prepare('SELECT * FROM projets WHERE limit_date > CURRENT_TIME LIMIT ? ,200 ');
            $req->execute(array($start * 10));
            $projects = $req->fetchAll();
            $req->closeCursor();
        } catch (Exception $e) {
            die('Error getting the projects ' . $e->getMessage());
        }
    }else {
        try {
            $req = $database_connexion->prepare('SELECT * FROM projets WHERE limit_date > CURRENT_TIME LIMIT 200');
            $req->execute();
            $projects = $req->fetchAll();
            $req->closeCursor();
        } catch (Exception $e) {
            throw_error(500);
            die('Error getting the projects ' . $e->getMessage());
        }
    }


    // Sort the array with the Algorithme
    if(!uasort($projects, 'sort_projects_hot')){
        // Error gestion
    }

    // Keep only the 15 first projects
    $projects = array_slice($projects, 0, 15);
    return $projects;
}

// Takes two projects in the form of an array,
// and sorts them for uasort();
function sort_projects_hot($a, $b){
    // TODO : put up the real ratio

    $time_reference = 1493197190;

    $time_a = strtotime($a['creation_date']) - $time_reference;
    $time_b = strtotime($b['creation_date']) - $time_reference;

    $score_a = ($a["nbr_upvote"] - $a["nbr_downvote"]);
    $score_b = ($b["nbr_upvote"] - $b["nbr_downvote"]);

    if ($score_a > 0) {
        $y_a = 1;
    }elseif ($score_a = 0) {
        $y_a = 0;
    } else {
        $y_a = -1;
    }

    if ($score_b > 0) {
        $y_b = 1;
    }elseif ($score_b = 0) {
        $y_b = 0;
    } else {
        $y_b = -1;
    }

    if(abs($score_a) >= 1){
        $z_a = abs($score_a);
    }else {
        $z_a = 1;
    }

    if(abs($score_b) >= 1){
        $z_b = abs($score_b);
    }else {
        $z_b = 1;
    }

    // $y_a = 1 if $score_a > 0 else -1 if $score_a < 0 else 0;
    // $y_b = 1 if $score_b > 0 else -1 if $score_b < 0 else 0;

    $ratio_a = log($z_a) + ( $y_a * $time_a) / 4500;
    $ratio_b = log($z_b) + ( $y_b * $time_b) / 4500;

    if($ratio_a  > $ratio_b ){
        return 1;
    }else{
        return -1;
    }
}

function sort_projects_new($projects) {
    # code...
}

function sort_projects_controversial($projects) {

}

// function count_participants($project){
//     // This might need to be better. For the moment, as the participant field
//     // seperates the users by a comma, it symply counts the number of commas
//     return substr_count($project["participants"],",");
// }
//
// function get_project_age($project){
//     $start_date = strtotime($project["creation_date"]);
//     $since_start = $start_date->diff(time());
//     return $since_start;
// }

// gets an double array with the projects
function display_homepage($projects_to_display){
    // Check if some of the projects are featured
    $featured_projects = array();

    require("../html/header.php");
    require '../html/navigation.php';
    require("Utilisateur.php");


    if (isset($_SESSION['login']) && $_SESSION['login']) {
        echo(get_user_from_uuid($_SESSION['uuid'])." is logged in.");
    }
    foreach ($projects_to_display as $project) {
        if ($project["is_featured"]) {
            $featured_projects[] = $project;
        }
    }

    if(!empty($featured_projects)){
        foreach ($featured_projects as $one_project) {
            // TODO
            echo("
            <div class='featuredProject'>
                <h2 class='titleFp'>".$one_project['title']."</h2>
                <small>".$one_project['nbr_upvote']."/".$one_project['nbr_downvote']." - ".get_user_from_uuid($one_project['owner'])." </small>
            </div>");

        }
    }

    foreach ($projects_to_display as $one_project) {
        if (!$one_project["is_featured"]) {
        echo("
            <div class='project'>
                <h2 class='title_project'>".$one_project['title']."</h2>
                <small>".$one_project['nbr_upvote']."/".$one_project['nbr_downvote']." - ". get_user_from_uuid($one_project['owner'])." </small>
            </div>");

        }
    }

    require("../html/footer.php");
}
?>
