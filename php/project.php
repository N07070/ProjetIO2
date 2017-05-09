<?php
require_once("Project.php");
require_once("Utilisateur.php");

function display_project($project){
    if(!empty($project) && UUID::is_valid($project) && project_exists($project)){
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
                <div id="<?php echo($project['id']); ?>">

                    <div class="images_project card">
                        <?php foreach ( $project['pictures'] as $picture){ ?>
                            <img src="<?php echo("uploads/projects/".$picture); ?>" alt="">
                        <?php } ?>
                    </div>

                    <div>
                        <h1 class="title_project"> <?php echo($project['title']) ?> <?php if ($project['is_featured']): ?><i class="material-icons ">star_border</i><?php endif; ?></h1>
                        <small class="resume_project"> <?php echo($project['resume']) ?> </small><br>
                        <?php if ($_SESSION['login']) { ?>


                        <span onclick="upvote_project('<?php echo($project['id']); ?>','<?php echo($project['uuid']); ?>')">
                            <button id="upvote_project" class="fab light_background"><i class="material-icons ">thumb_up</i><br><span class="upvotes"><?php echo($project['nbr_upvote']);?></span></button>
                        </span>

                        <span onclick="downvote_project('<?php echo($project['id']); ?>','<?php echo($project['uuid']); ?>')">
                            <button id="downvote_project" class="fab light_background"><i class="material-icons ">thumb_up</i><br><span class="downvotes"><?php echo($project['nbr_downvote']);?></span></button>
                        </span>

                        <span onclick="join_project('<?php echo($project['uuid']); ?>')">
                            <button id="join_project" class="fab light_background"><i class="material-icons ">group_add</i></button>
                        </span>
                        <?php } else {
                            display_message("Connecte toi pour participer à ce projet ! ;-)");
                        } ?>

                        <p class="description_project">
                            <?php echo($project['description']); ?>
                        </p>
                        <div class="participants">
                            <?php

                            if(sizeof($project['participants']) > 4){
                                $first_participiants[] = $project['participants'][0];
                                $first_participiants[] = $project['participants'][1];
                                $first_participiants[] = $project['participants'][2];
                                $first_participiants[] = $project['participants'][3];

                                foreach ($first_participiants as $participants) {
                                    ?> <span class=""><?php echo(get_user_from_uuid($participants)); ?>,</span> <?php
                                }
                                ?> <span> et <?php echo(sizeof($project['participants']) - 4 ); ?> autres participent au projet.</span> <?php
                            } else {
                                for ($i=0; $i < sizeof($project['participants']) - 1; $i++) {
                                    ?> <span class="project_participant"><?php echo(get_user_from_uuid($project['participants'][$i])); ?>,</span> <?php
                                }
                                if(sizeof($project['participants'] > 1)) {
                                ?> <span class="project_participant">et <?php echo(get_user_from_uuid(end($project['participants'   ])))?> participent au projet</span> <?php
                                }
                            }

                            ?>

                        </div>
                        <br>
                        <div class="tags">
                            <?php  foreach ($project['tags'] as $tag) { ?>
                                <span class="tag"><?php echo($tag); ?></span>
                            <?php }  ?>
                        </div><br>
                        <span class="dates"> Crée le <?php echo($project['creation_date']) ?> et actif jusqu'au <?php echo($project['limit_date']) ?></span><br>
                    </div>
                </div>
                <?php
            }
        }
    } else {
        display_error("Ce projet n'existe pas.");
    }
}

function project(){
    ?><div class="project_page card"> <?php
        display_project($_GET['project']);
    ?> </div> <?php
}
?>
