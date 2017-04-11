<?php
session_start();
// Report all PHP errors (see changelog)
error_reporting(E_ALL);
// Include the global vars for connexion to the database
require_once("../php/Identifiants.php");
require_once("../php/Errors.php");
require_once("../php/ConnectionBaseDeDonnee.php");

if(isset($_GET["page"]) && !empty($_GET["page"])){
    switch ($_GET["page"]) {
        case 'search':
            require("../php/search.php");
        case 'project':
            require("../../project.php");
            pwd();
            // Get a project's id

            break;
        case 'user':
            require("../php/user.php");
            // Get the user's id

            break;
        case 'login':
            require("../php/login.php");
            require("../html/header.php");  
            login_signup_user();
            require("../html/footer.php");
            break;

        case 'profile':
            // Make the difference between a user and an admin.
            // For that, it's very simple to just add a few options.
            require("../php/profile.php");

            break;
        case 'messages':
            require("../php/messages.php");

            break;

        default:
            // Connect to the database to get the projects
            include("../php/default.php");
            // echo "hello world";
            // If we need to paginate
            if (isset($_GET["p"]) && !empty($_GET["p"]) && is_int($_GET["p"])) {
                $projects_to_display = get_all_projects($_GET["p"]);
            }else{
            // Get the 10 last projects
                $projects_to_display = get_all_projects();
            }
            // Display the homepage
            display_homepage($projects_to_display);
            // echo("<img scr='../cat.jpg'>");
            break;
    }
} else {
    // Connect to the database to get the projects
    include("../php/default.php");
    // If we need to paginate
    if (isset($_GET["p"])&& !empty($_GET["p"])  && $_GET["p"] > 0) {
        $projects_to_display = get_all_projects($_GET["p"]);
    }else{
    // Get the 10 last projects
        $projects_to_display = get_all_projects(null);
        // echo($_GET["p"]);
    }
    // Display the homepage
    display_homepage($projects_to_display);
    echo("<img scr='img/cat.jpg'>");
}

?>
