<?php

require_once('Utilisateur.php');
require_once('Project.php');
require_once('UUID.php');

function display_profile_page($uuid){
    $user_data = get_user_data($uuid);
    if(!empty($user_data)){
    ?>
        <div class="user_information">
            <img height='200' src='../uploads/<?php echo($user_data[0]['profile_picture']); ?>'>
            <h1><?php echo($user_data[0]['username']);?></h1>
            <small><i><?php echo($user_data[0]['biography']); ?></i></small>
            <p>Créateur ou créatrice de projet depuis le <?php echo($user_data[0]['date_creation']);?> </p>
        </div>
        <hr>
    <?php
    } else {
        echo("<h3> Tu chercher un·e utilisateur·trice qui n'existe pas. </h3>");
    }
}

function display_projects_user($uuid){
    $projects = get_projects_of_user($uuid);

    if($projects != false){
        foreach ($projects as $project) {
            $project['pictures'] = explode("," ,$project['pictures']);
            ?>
            <div class="user_project card">
                <img src="../uploads/projects/<?php echo($project['pictures'][0]); ?>" alt="Picture of the project">
                <div>
                    <a href="?page=project&project=<?php echo($project['uuid']); ?>"><h3 class="project_title"><?php echo($project['title']); ?></h3></a>
                    <p><?php echo($project['resume']); ?></p>
                    <?php //echo(count(explode(',',$project["participants"])) - 1); ?>
                    <p>Déjà <?php echo(get_nbr_participants($project['uuid'])); ?> participant·es </p>
                </div>
            </div>
            <?php
        }
    }

}


function profile(){
    if(isset($_GET['user']) && UUID::is_valid($_GET['user'])){
        ?> <div class="card profile"><?php
        display_profile_page($_GET['user']);
        display_projects_user($_GET['user']);
        ?> </div> <?php
    } else {
        header("Location : index.php");
    }
}
?>
