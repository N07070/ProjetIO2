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
            require("../html/header.php");
            require("../html/navigation.php");
            search();
            require("../html/footer.php");
            break;
        case 'project':
            require("../php/project.php");
            // Get a project's id
            require("../html/header.php");
            require("../html/navigation.php");
            project();
            require("../html/footer.php");
            break;
        case 'user':
            require("../php/user.php");
            // Get the user's id
            require("../html/header.php");
            require("../html/navigation.php");
            user();
            require("../html/footer.php");
            break;
        case 'login':
            require("../php/login.php");
            require("../html/header.php");
            require '../html/navigation.php';
            login_signup_user($_POST['options'],$_POST['username'],$_POST['password_1'],$_POST['password_2'],$_POST['email'],$_FILES['profile_picture'],$_POST['biography']);
            require("../html/footer.php");
            break;
        case 'logout':
            require("../php/login.php");
            logout_user();
            break;
        case 'profile':
            // Make the difference between a user and an admin.
            // For that, it's very simple to just add a few options.
            require("../php/profile.php");
            require("../html/header.php");
            require '../html/navigation.php';
            profile();
            require("../html/footer.php");
            break;
        case 'messages':
            require("../html/header.php");
            require("../html/navigation.php");
            require("../php/messages.php");

            require("../html/footer.php");
            break;
        default:
            require_once("../php/default.php");
            require_once("../html/header.php");
            require_once('../html/navigation.php');
            require_once("../php/Utilisateur.php");
            default_page($_GET['p']);
            require("../html/footer.php");
            break;
    }
} elseif (isset($_GET["action"]) && !empty($_GET["action"])) {
    switch ($_GET['action']) {
        case 'upvote_project':
            require_once('../php/Project.php');
            if (isset($_GET['upvote_project']) && !empty($_GET['upvote_project'])) {
                error_log("User ".get_user_from_uuid($_SESSION['uuid'])." upvoted project " . $_GET['upvote_project'] );
                echo(upvote_project($_GET['upvote_project']));
            }
            break;
        case 'downvote_project' :
            require_once('../php/Project.php');
            if (isset($_GET['downvote_project']) && !empty($_GET['downvote_project'])) {
                error_log("User ".get_user_from_uuid($_SESSION['uuid'])." downvoted project " . $_GET['downvote_project'] );
                echo(downvote_project($_GET['downvote_project']));
            }
            break;
        case 'join_project':
            require_once('../php/Project.php');
            if (isset($_GET['project']) && !empty($_GET['project'])  && $_SESSION['login'] && !empty($_SESSION['uuid'])) {
                add_user_to_project($_SESSION['uuid'],$_GET['project']);
            //     // if(add_user_to_project($_SESSION['uuid'],$_GET['project'])){
            //     //     error_log("User ".get_user_from_uuid($_SESSION['uuid'])." added to project " . $_GET['project'] );
            //     // };
            }
            break;
        default:
            echo "dzdez";
            break;
    }
} else {
    // Connect to the database to get the projects
    require_once("../php/default.php");
    require_once("../html/header.php");
    require_once('../html/navigation.php');
    require_once("../php/Utilisateur.php");
    default_page($_GET['p']);
    require("../html/footer.php");
}

?>
