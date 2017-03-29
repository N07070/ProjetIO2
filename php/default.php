<?php
// Gets all the 200 last projects, class them, and return
// the top 15 projects
function get_all_projects($start){
    // Connect to database
    $projects = array();
    $database_connexion = connect_to_database();
    if(isset($start) && is_int($start)){
        // Get the $start
        $req = $database_connexion->prepare('SELECT * FROM projects LIMIT ?,200 ');
        $req->execute(array($start * 10));
    }else {
        $req = $database_connexion->prepare('SELECT * FROM projects LIMIT 200 ');
        $req->execute(array($start));
    }
    $projects = $req;
    $req->closeCursor(); // Close the connexion to the database

    // Sort the array with the Algorithme
    $projects = uasort($projects, 'sort_projects');

    // Keep only the 15 first projects
    $projects = array_slice($projects, 0, 15);

    return $projects;
}

// Takes two projects in the form of an array,
// and sorts them for uasort();
function sort_projects($a, $b){
    // The algo is defined in PROJECT.md
    $ratio_a = ($a["nbr_upvote"] / $a["nbr_downvote"]) * 0.6;
    $ratio_b = ($b["nbr_upvote"] / $b["nbr_downvote"]) * 0.6 ;

    $interet_a =  (count_participants($a) / ($a["nbr_upvote"] + $a["nbr_downvote"])) * 0.3;
    $interet_b =  (count_participants($b) / ($b["nbr_upvote"] + $b["nbr_downvote"])) * 0. 3;

    $age_a = get_project_age($a) * 0.1;
    $age_b = get_project_age($b) * 0.1 ;

    if($ratio_a + $interet_a + $age_a > $ratio_b + $interet_b + $age_b){
        return 1;
    }else{
        return -1;
    }
}

function count_participants($project){
    // This might need to be better. For the moment, as the participant field
    // seperates the users by a comma, it symply counts the number of commas
    return substr_count($projects["participants"],",");
}

function get_project_age($project){
    $start_date = strtotime($project["creation_date"]);
    $since_start = $start_date->diff(time());
    return $since_start;
}

// gets an double array with the projects
function display_homepage($projects_to_display){
    // Check if some of the projects are featured
    $featured_projects = array();
    foreach ($projects_to_display as $project) {
        if ($project["is_featured"]) {
            $featured_projects[] = $project;
        }
    }

    if(!empty($featured_projects)){
        foreach ($featured_projects as $one_project) {
            // TODO
            print_r($one_project);
        }
    }

    foreach ($projects_to_display as $project) {
        if (!$project["is_featured"]) {
            // TODO
            print_r($project)
        }
    }
}
?>
