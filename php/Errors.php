<?php
function throw_error($error_code){
    if(is_int($error_code)){
        switch ($error_code) {
            case 100:
                display_message("Signup succesfull ! Welcome !");
                break;
            case 401:
                display_error("Login credentials are invalid.");
                break;
            case 402:
                display_error("Error while processing inscription. Are you sure the information is valid ?");
                break;
            case 500:
                display_error("An error occured. We're on it.");
                break;
        }
    }else{
        display_error("Error.");
    }
}




function display_error($error_message){
    ?>
    <div class='card error'>
            <i class="material-icons">help_outline</i><span><?php echo($error_message) ?></span>
    </div>
    <?php
}

function display_message($message){
    ?>
    <div class='card message light_background'>
            <i class="material-icons">help_outline</i><span><?php echo($message) ?></span>
    </div>
    <?php
}
?>
