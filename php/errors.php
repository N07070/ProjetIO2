<?php
function throw_error($error_code){
    if(is_int($error_code)){
        switch ($error_code) {
            case 500:
                display_error("An error occured. We're on it.");
                break;
        }
    }else{

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
?>
