<?php
// Gets the 10 last from start
// @returns array of projects
function get_all_projects(start){
    // Connect to database
    if(isset($start) && $start < 11){
        // Get the $start
    }else {

    }
    // Populate the array

    // Return the array with projects, and classed
}

function display_homepage(projects_to_display){
    // Check if some of the projects are featured
    $featured_projects = array();
    foreach ($projects_to_display as $project) {
        if ($project["is_featured"]) {
            $featured_projects[] = $project;
        }
    }

    if(!empty($featured_projects)){

    }

    foreach ($projects_to_display as $project) {
        # code...
    }
}

function compute_ratio(project_uuid){

}
?>
