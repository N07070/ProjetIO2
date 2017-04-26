<?php
function display_user_profile($uuid){
    $user_data = display_user($uuid);
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
}
?>
