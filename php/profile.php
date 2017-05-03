<?php

require_once('Utilisateur.php');
require_once('Project.php');
require_once('UUID.php');

function display_user_profile($uuid){
    $user_data = get_user_data($uuid);
    if(!empty($user_data)){
    ?>
        <h1 class="username_profile">
            <?php echo($user_data[0]['username']);?>
        </h1>

        <?php echo("<img class='user_picture_profile' height='200' src='../uploads/".$user_data[0]['profile_picture']."'>");?>

        <ul>
            <li><?php echo($user_data[0]['biography']); ?></li>
        </ul>
    <?php
    } else {
        echo("<h3> This profile does not exist. </h3>");
    }
}

function display_projects_user($user){
    $projects = get_projects_of_user($user);

    if($projects != false){
        foreach ($projects as $project) {
            ?>
            <div class="project">
                <h3 class="project_title"><?php echo($project['title']); ?></h3>
                <?php if($_SESSION['login']){ ?>
                <a href="index.php?page=profile&options=1&project=<?php echo($project['uuid']);?>&user=<?php echo($_SESSION['uuid']);?>"> Join project </a>
                <?php } ?>
            </div>
            <?php
        }
    }

}

function profile(){
    if(isset($_GET['user']) && UUID::is_valid($_GET['user'])){
        display_user_profile($_GET['user']);
        display_projects_user($_GET['user']);
    } else {
        header("Location : index.php");
    }
}
?>
