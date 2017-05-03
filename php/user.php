<?php
require_once('Utilisateur.php');
require('Project.php');

function display_user_nav(){

}

function display_projects_user(){
    $projects = get_projects_of_user($_SESSION['uuid']);

    if($projects != false){
        foreach ($projects as $project) {
            ?>
            <div class="project">
                <h3 class="project_title"><?php echo($project['title']); ?></h3>
                <a href="index.php?page=user&options=3&project=<?php echo($project['uuid']); ?>">Paramètres du projet</a>
                <a href="index.php?page=user&options=2&project=<?php echo($project['uuid']); ?>">Supprimer le projet</a>
            </div>
            <?php
        }
    }

}

function display_options(){
    ?> <ul>
        <li><a href="index.php?page=user&options=1">Créer un nouveau projet</a></li>
        <li><a href="index.php?page=user&options=4">Changer tes paramètres</a></li>
    </ul> <?php

}

function display_profile_page(){
    $user_data = get_user_data($_SESSION['uuid']);
    if(!empty($user_data)){
    ?>
        <h1>
            <?php echo($user_data[0]['username']);?>
        </h1>

        <?php echo("<img height='200' src='../uploads/".$user_data[0]['profile_picture']."'>");?>

        <ul>
            <li><?php echo($user_data[0]['uuid']);?></li>
            <li><?php echo($user_data[0]['email']);?></li>
            <li><?php echo($user_data[0]['biography']); ?></li>
        </ul>
    <?php
    } else {
        echo("<h3> This profile does not exist. </h3>");
    }
    display_projects_user();
}

function display_create_new_project(){

    if (isset($_POST['create_new_project']) && $_POST['create_new_project']) {
        // Create the project
        // Validate the inputs
        $owner = $_SESSION['uuid'];
        $title = $_POST['project_title'];
        $tags = $_POST['project_tags'];
        $pictures = $_FILES;
        $resume = $_POST['project_resume'];
        $description = $_POST['project_description'];

        $result = create_new_project($owner, $title, $tags, $pictures, $resume, $description);
        print_r($result);
        if($result == true){
            echo("Ton nouveau projet viens d'être crée. ");
        }else {
            display_error($result['message']);
        }

    } else {
        // Display the form
        ?>
        <form class="" action="index.php?page=user&options=1" method="post" enctype="multipart/form-data">
            <input type="text" name="project_title" placeholder="Project Title" required><br>
            <textarea name="project_resume" rows="6" cols="40" required>Project Resume (500 chars)</textarea><br>
            <textarea name="project_description" rows="16" cols="40" required>Project Description (2000 chars)</textarea><br>
            <p>Pictures for the project</p>
            <input type="file" name="profile_picture[]" placeholder="Picture" required><br>
            <input type="file" name="profile_picture[]" placeholder="Picture" required><br>
            <input type="file" name="profile_picture[]" placeholder="Picture" required><br>
            <input type="text" name="project_tags" placeholder="the,project,tags," required><br>

            <input type="hidden" name="create_new_project" value="true" required>
            <input type="submit" value="Créer un nouveau projet">
        </form>
        <?php
    }



}

function display_delete_project($project){
    if(delete_project($project)){
        ?>
        <h3> Ton projet viens d'être supprimé.</h3>
        <?php
    }
}

function display_change_project_settings(){

}

function display_change_user_settings(){

}

function user(){
    if($_SESSION['login'] && ( !isset($_GET['options']) ||  ($_GET['options'] > 10 || $_GET['options'] < 1 ))){
        display_profile_page($_SESSION['uuid']);
        display_options();
    }else if ($_SESSION['login'] && isset($_GET['options']) && $_GET['options'] < 11 && $_GET['options'] > 0){
        switch ($_GET['options']) {
            case 1:
                display_create_new_project();
                break;
            case 2:
                display_delete_project($_GET['project']);
                break;
            case 3:
                display_change_project_settings($_GET['project']);
                break;
            case 4:
                display_change_user_settings();
            default:
                echo('');
                break;
        }
    } else {
        header('Location : index.php?page=login');
    }
}
?>
