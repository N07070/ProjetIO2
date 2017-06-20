<?php
require_once("Messages.php");
require_once("Utilisateur.php");
function display_contacts(){

}
function display_messages($group_uuid){

    // Get all the messages
    $conversation = get_conversation($group_uuid);
    ?>
    <div class="conversation">
    <?php
    foreach ($conversation as $message) {
        $class = "left";

        if($message['user_from'] == $_SESSION['uuid']){
            $class = "right";
        }

        ?>
        <div class="<?php echo $class; ?> message bubble primary_background">

            <p> <?php echo htmlentities($message['text_message'], ENT_QUOTES, 'utf-8'); ?> </p>
            <small><span><?php echo get_user_from_uuid(htmlentities($message['user_from'], ENT_QUOTES, 'utf-8')); ?></span> @ <?php echo htmlentities($message['date_send'], ENT_QUOTES, 'utf-8'); ?> </small>
        </div>
        <?php
    }

    ?>
    </div>
    <?php
}

function display_group_header($group_uuid){
    $info = get_group_information($group_uuid);
    ?>
    <div id="group_header" class="card">
        <span><?php echo $info['name'] ?></span> - <span><?php echo $info['number_of_users'] ?> membres</span>
    </div>
    <?php
}

function display_send_message($group_uuid){
    ?>

    <form class="send_new_message" action="?page=messages" method="post">
        <input type="text" name="message" id="input_message">
        <input type="hidden" name="o" value="new_message">
        <input type="hidden" name="group_uuid" value="<?php echo $group_uuid ?>">
        <input type="submit" value="Send">
    </form>

    <?php

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
    // o like options
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
                    display_group_header($_GET['g']);
                    display_messages($_GET['g']);
                    display_send_message($_GET['g']);
                }
                break;
            case 'new_message':
                insert_new_message();
                break;
            default:
                display_groups();
                break;
        }
    } elseif($_SESSION['login'] && isset($_POST['o'])){
        switch ($_POST['o']) {
            case 'new_message':
                send_message($_SESSION['uuid'], $_POST['group_uuid'], $_POST['message']);
                $group = $_POST['group_uuid'];
                header("Location: ?page=messages&o=group&g=$group");
                # code...
                break;
            case 'get_messages':

                break;
            default:
                # code...
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
