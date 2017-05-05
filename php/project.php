<?php
require_once("Project.php");
require_once("Utilisateur.php");

function display_project($project){
    if(!empty($project) && UUID::is_valid($project)){
        if(get_project_data($project) !== false){
            $data = get_project_data($project);

            foreach ($data as $project) {

                $project['participants'] = explode(",", $project['participants']);
                array_pop($project['participants'] );
                $project['creation_date'];
                $project['is_featured'];
                $project['status'];
                $project['tags'] = explode(",", $project['tags']);
                array_pop($project['tags'] );
                $project['pictures'] = explode(",", $project['pictures']);
                array_pop($project['pictures']);

                ?>
                <div class="images_project card">
                    <?php foreach ( $project['pictures'] as $picture){ ?>
                        <img src="<?php echo("uploads/projects/".$picture); ?>" alt="">
                    <?php } ?>
                </div>

                <div>
                    <h1 class="title_project"> <?php echo($project['title']) ?> </h1>
                    <small class="resume_project"> <?php echo($project['resume']) ?> </small><br>
                    <button id="upvote_project" class="fab light_background"><i class="material-icons ">thumb_up</i><br><?php echo($project['nbr_upvote']);?></button>
                    <button id="downvote_project" class="fab light_background"><i class="material-icons ">thumb_down</i><br><?php echo($project['nbr_downvote']); ?></button>
                    <button id="join_project" class="fab light_background"><i class="material-icons ">group_add</i></button>


                    <p class="description_project">
                        <?php echo($project['description']); ?>
                    </p>
                    <div class="participants">
                        <?php  foreach ($project['participants'] as $participants) { ?>
                            <span class=""><?php echo(get_user_from_uuid($participants)); ?>,</span>
                        <?php }  ?>
                        <span>et <?php echo "1"; ?> autre participent au projet.</span>
                    </div>
                    <br>
                    <div class="tags">
                        <?php  foreach ($project['tags'] as $tag) { ?>
                            <span class="tag"><?php echo($tag); ?></span>
                        <?php }  ?>
                    </div><br>
                    <span class="dates"> Crée le <?php echo($project['creation_date']) ?> et actif jusqu'au <?php echo($project['limit_date']) ?></span><br>
                </div>
                <?php
            }
        }
    }
}

function project(){
    ?><div class="project_page card"> <?php
    display_project($_GET['project']);
    ?> </div> <?php
}
?>
