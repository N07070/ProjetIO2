<?php
require_once("Project.php");

function display_project($project){
    if(!empty($project) && UUID::is_valid($project)){
        if(get_project_data($project) !== false){
            $data = get_project_data($project);

            foreach ($data as $project) {

                $project['participants'];
                $project['creation_date'];
                $project['is_featured'];
                $project['tags'];
                $project['status'];
                $project['pictures'] = explode(",", $project['pictures']);

                ?>
                <div class="images_project">
                    <?php foreach ($project['pictures'] as $picture): ?>
                        <img src="<?php echo("uploads/projects/".$picture); ?>" alt="">
                    <?php endforeach; ?>
                </div>
                <div>
                    <h1 class="title_project"> <?php echo($project['title']) ?> </h1>
                    <small class="resume_project"> <?php echo($project['resume']) ?> </small><br>
                    <span class="upvote_project">↑</span> <span class="votes_project"> <?php echo($project['nbr_upvote']." | ".$project['nbr_downvote']) ?> </span><span>↓</span> <span class="dates"> Crée le <?php echo($project['creation_date']) ?> et actif jusqu'au <?php echo($project['limit_date']) ?></span>


                    <p class="description_project">
                        <?php echo($project['description']); ?>
                    </p>
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
