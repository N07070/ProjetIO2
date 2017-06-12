<?php
require_once("Messages.php");
require_once("Utilisateur.php");
function display_contacts(){

}
function display_messages($group_uuid){

}

function display_create_new_group(){
    // if the option is set, then display the form,
    // otherwise, display a fab
}

function display_groups(){
    // Get all the groups the user is into
    $user = $_SESSION['uuid'];

    $groups_of_user = get_groups_of_user($user);

    foreach ($groups_of_user as $group) {
        // print_r($group);
        $last_message = get_last_message_of_group($group['uuid'])[0];

        ?>
        <a href="?page=messages&o=group&g=<?php echo($group['uuid']); ?>"><div class="card group">
            <i class="material-icons">supervisor_account</i> <h2><?php echo $group['name'] ?></h2>
            <p>
                <span class="group_user_last_message"><?php echo get_user_from_uuid($last_message['user_from']); ?></span> : <span><?php echo substr($last_message['text_message'],0,30)."..." ?></span>
            </p>
        </div></a>

        <?php

    }


}

function messages(){
    // Logged in

    // o for Options

    ?>
    <div class="card messages">
    <?php
    if($_SESSION['login'] && isset($_GET['o'])){
        switch ($_GET['o']) {
            case 'groups':
                display_groups();
                break;
            case 'new':
                display_create_new_group();
                break;
            case 'group':
                if(isset($_GET['g']) && !empty($_GET['g'])){
                    display_messages($_GET['g']);
                }
                break;
            default:
                display_groups();
                break;
        }
    } elseif ($_SESSION['login']) {
        display_groups();
    }
    ?>
    </div>
    <?php

}
?>
