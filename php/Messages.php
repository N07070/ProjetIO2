<?php

function get_user_conversations($user_uuid){
    // Return an array with the name,
}

function get_conversation($group_uuid){

}

function get_groups_of_user($user_uuid){
    try {
        $database_connexion = connect_to_database();
        $req = $database_connexion->prepare('SELECT * FROM `groups` WHERE `users` LIKE ?');
        $req->execute(array("%".$user_uuid."%"));
        $user_groups = $req->fetchAll();
        $req->closeCursor();
    } catch (Exception $e) {
        die('Error connecting to database: ' . $e->getMessage());
    }

    return $user_groups;
}

function get_last_message_of_group($group_uuid){
    try {
        $database_connexion = connect_to_database();
        $req = $database_connexion->prepare('SELECT * FROM `messages` WHERE `group_to` = ? ORDER BY date_send DESC');
        $req->execute(array($group_uuid));
        $messages_of_group = $req->fetchAll();
        $req->closeCursor();
    } catch (Exception $e) {
        die('Error connecting to database: ' . $e->getMessage());
    }
    return $messages_of_group;
}

function send_message(){

}?>
