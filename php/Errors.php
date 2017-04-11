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
    echo("
    <div class='error'>
        <pre>
        ".$error_message."
        </pre>
    </div>");
}

function display_message($message){
    echo("
    <div class='message'>
        <pre>
        ".$error_message."
        </pre>
    </div>");
}
?>
