<?php
require_once("default.php");
require_once("Search.php");

function display_search_results($terms,$options){
    $results = search_on_database($terms,$options);
    if(empty($results)){
        ?>
        <div class="card">
            <p> Grumpy Cat n'a rien trouvé d'intéressant. Et il s'en fout. </p>
            <img src="img/grumpy_cat.png"><br>
            <small>Dessin par <a rel="nofollow" href="http://tsaoshin.deviantart.com/">TaoShin</a></small>
        </div>
        <?php
    } else {
        display_homepage(search_on_database($terms,$options));
    }
};

function display_search_form(){
    // Options
    // Date
    // Number of users
    // Popularity
    ?>
    <div class="card">
        <form class=" no_hover" action="index.php?page=search" method="post" enctype="multipart/form-data">
            <input type="text" name="terms" placeholder="Nom du projet, utilisateur..." required><br>
            <!-- <input type="hidden" name="options" value="signup_user" required> -->
            <input type="submit" name="search" value="Chercher">
        </form>
    </div>
    <?php
}

function search(){
    if(isset($_POST['search'])){
        display_search_form();
        display_search_results($_POST['terms'],$_POST['options']);
    } else {
        display_search_form();
    }
}
?>
