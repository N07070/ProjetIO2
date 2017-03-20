<?php
// Include the global vars for connexion to the database
include_once("../php/Identifiants.php");
include_once("../php/ConnectionBaseDeDonnee.php");

if(isset($_GET["page"]) && !empty($_GET["page"])){
    switch ($_GET["page"]) {
        case 'search':
            include("../../search.php");
        case 'project':
            // Get a project's id
            echo("<a href='http://localhost:8080/?page='>home</a>");

            break;
        case 'user':
            // Get the user's id
            echo("<a href='http://localhost:8080/?page='>home</a>");

            break;
        case 'login':
            // Login or register
            echo("<a href='http://localhost:8080/?page='>home</a>");

            break;
        case 'profile':
            // Make the difference between a user and an admin.
            // For that, it's very simple to just add a few options.
            echo("<a href='http://localhost:8080/?page='>home</a>");

            break;
        case 'messages':
            echo("<a href='http://localhost:8080/?page='>home</a>");

            break;

        default:
            // Connect to the database to get the projects
            include("../php/Projet.php");
            // If we need to paginate
            if (isset($_GET["p"]) && !empty($_GET["p"]) && is_int($_GET["p"])) {
                $projects_to_display = get_all_projects($_GET["p"]);
            }else{
            // Get the 10 last projects
                $projects_to_display = get_all_projects();
            }
            // Display the homepage
            display_homepage($projects_to_display);
            break;
    }
}

?>
