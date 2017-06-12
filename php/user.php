<?php
require_once('Utilisateur.php');
require('Project.php');

function display_profile_page(){
    $user_data = get_user_data($_SESSION['uuid']);
    if(!empty($user_data)){
    ?>
        <div class="user_information">
            <?php echo("<img height='200' src='../uploads/".$user_data[0]['profile_picture']."'>");?>
            <h1>
                <?php echo($user_data[0]['username']);?>
            </h1>
            <br>
            <small><?php echo($user_data[0]['biography']); ?></small>
            <p>Créateur ou créatrice de projet depuis le <?php echo($user_data[0]['date_creation']);?> </p>
        </div>
        <hr>
    <?php
    } else {
        echo("<h3> Tu chercher un·e utilisateur·trice qui n'existe pas. </h3>");
    }
    display_options();
    display_projects_user();
}

function display_options(){
    ?>
    <div class="user_options">
        <a class="btn primary_background" href="index.php?page=user&options=1">Créer un nouveau projet</a>
        <a class="btn primary_background" href="index.php?page=user&options=4">Changer tes paramètres</a>
    </div>
    <?php

}

function display_projects_user(){
    $projects = get_projects_of_user($_SESSION['uuid']);

    if($projects != false){
        foreach ($projects as $project) {
            $project['pictures'] = explode("," ,$project['pictures']);
            ?>
            <div class="user_project card">
                <img src="../uploads/projects/<?php echo($project['pictures'][0]); ?>" alt="">
                <h3 class="project_title"><?php echo($project['title']); ?></h3>
                <!-- <a class="btn primary_background" href="index.php?page=user&options=3&project=<?php echo($project['uuid']); ?>">Paramètres du projet</a> -->
                <a class="btn primary_background" href="index.php?page=user&options=2&project=<?php echo($project['uuid']); ?>">Supprimer le projet</a>
            </div>
            <?php
        }
    }

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
        if($result[0] == true){
            ?>
            <h3>Ton nouveau projet viens d'être créée !</h3>
            <p>Voici quelques petits conseils pour qu'il prenne forme :
                <ul>
                    <li>Déjà, plus des gens le voit, plus il sera populaire. N'hésite pas à le partager sur les réseaux sociaux.</li>
                    <li>Un projet vivant est plus attractif. Rajoute des informations au fur et à mesure qu'il avance.</li>
                    <li>N'attend pas que des gens viennent vers toi, commence ton projet seul et plus il avancera, plus tu aura de l'aide.</li>
                </ul>
            </p>

            <h4>Consulte-le ici : <a class="btn primary_background" href="/?page=project&project=<?php echo($result[1])?>"><?php echo $result[2]; ?></a></p>
            <?php
        }else {
            display_error($result['message']);
        }

    } else {
        // Display the form
        ?>
        <form class="" action="index.php?page=user&options=1" method="post" enctype="multipart/form-data">
            <input type="text" name="project_title" placeholder="Project Title" required><br>
            <textarea name="project_resume" rows="6" cols="40" maxlength="500" placeholder="Explique rapidement, en 500 caractères, les grandes lignes de ton projet." required></textarea><br>
            <textarea name="project_description" rows="16" cols="40" maxlength="2000" placeholder="Explique plus en détails, en 2000 caractères, quels sont tes moyens, tes objectifs..." required></textarea><br>
            <p>Les photos de présentation du projet.</p>
            <input type="file" name="profile_picture[]" placeholder="Picture" required><br>
            <input type="file" name="profile_picture[]" placeholder="Picture" required><br>
            <input type="file" name="profile_picture[]" placeholder="Picture" required><br>
            <input type="text" name="project_tags" placeholder="Les tags du projet sous la forme tag,tag,tag," required><br>

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

function display_delete_user(){
    echo("<hr>");
    if(isset($_SESSION['uuid']) && isset($_SESSION['login']) && isset($_POST['password']) && !empty($_POST["password"])){
        if(delete_user($_SESSION['uuid'],$_POST['password'])){
            header("Location: ?page=logout");
        } else {
            display_error("Une erreure est survenue en supprimant ton compte. Réessaye ?");
        }
    } else {
        require('../html/delete_user.php');
    }

}

function display_change_user_settings(){
    // Change the settings
    if(isset($_POST['change_user_settings']) && $_POST['change_user_settings']) {
        $result = update_user_profil($_SESSION["uuid"], $_POST['old_password'] , $_POST['password_1'] , $_POST['password_2'] , $_POST['email'], $_FILES['profile_picture'], $_POST['biography']);
        if ($result['number'] != 1) {
            display_message("Ton compte à été mit à jour.");
            display_profile_page($_SESSION['uuid']);

        } else {
            display_error($result['message']);
            require('../html/change_user_settings_form.php');
        }
    } else {
    // Display the form
    $user = get_user_data($_SESSION['uuid']);
    require('../html/change_user_settings_form.php');
    display_delete_user();
    }
}

function user(){
    ?> <div class="user_page card"> <?php
    if($_SESSION['login'] && ( !isset($_GET['options']) ||  ($_GET['options'] > 10 || $_GET['options'] < 1 ))){
        display_profile_page($_SESSION['uuid']);
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
                break;
            case 5:
                display_delete_user();
                break;
            default:
                echo('');
                break;
        }
    } else {
        header('Location : ?page=login');
    }
    ?>
    </div>
    <?php
}
?>
