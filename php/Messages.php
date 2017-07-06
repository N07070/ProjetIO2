<?php

function get_user_conversations($user_uuid){
    // Return an array with the name,
}

function get_group_information($group_uuid){
    try {
        $database_connexion = connect_to_database();
        $req = $database_connexion->prepare('SELECT * FROM `groups` WHERE `uuid` = ?');
        $req->execute(array($group_uuid));
        $group  = $req->fetchAll();
        $req->closeCursor();
    } catch (Exception $e) {
        die('Error connecting to database: ' . $e->getMessage());
    }

    $group_info['number_of_users'] = count(explode(',', $group[0]["users"])) - 1; // Because the last item of the array is empty.
    $group_info['creation_date'] = $group[0]['creation_date'];
    $group_info['number_of_messages'] = get_number_of_messages_for_group($group_uuid);
    $group_info['name'] = $group[0]['name'];


    return $group_info;
}

function get_number_of_messages_for_group($group_uuid){
    try {
        $database_connexion = connect_to_database();
        $req = $database_connexion->prepare('SELECT COUNT(*) FROM `messages` WHERE `group_to` = ?');
        $req->execute(array($group_uuid));
        $nbr_messages = $req->fetchAll();
        $req->closeCursor();
    } catch (Exception $e) {
        die('Error connecting to database: ' . $e->getMessage());
    }

    return $nbr_messages;

}

function get_conversation($group_uuid){
    try {
        $database_connexion = connect_to_database();
        $req = $database_connexion->prepare('SELECT * FROM `messages` WHERE `group_to` = ? ORDER BY date_send');
        $req->execute(array($group_uuid));
        $group_messages = $req->fetchAll();
        $req->closeCursor();
    } catch (Exception $e) {
        die('Error connecting to database: ' . $e->getMessage());
    }

    return $group_messages;
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

function send_message($user_uuid, $group_uuid, $text_message){
    try {
        $database_connexion = connect_to_database();
        $req = $database_connexion->prepare('INSERT INTO messages(user_from, group_to, date_send, text_message) VALUES(?,?, NOW() ,?)');
        $req->execute(array($user_uuid, $group_uuid, $text_message ));
        $req->closeCursor();
    } catch (Exception $e) {
        die('Error connecting to database: ' . $e->getMessage());
    }
}

function group_exists($group_uuid){

}

function create_new_group($name, $first_user, $options) {

    $v4uuid = UUID::v4();

    try {
        $database_connexion = connect_to_database();
        $req = $database_connexion->prepare('INSERT INTO groups(uuid, name, users, creation_date) VALUES(?,?, ? ,NOW())');
        $req->execute(array($v4uuid, $name, $first_user.","));
        $req->closeCursor();
    } catch (Exception $e) {
        die('Error connecting to database: ' . $e->getMessage());
    }
}

function add_user_to_group($user, $group_uuid){
    try {
        $database_connexion = connect_to_database();
        $req = $database_connexion->prepare('SELECT users FROM `groups` WHERE `uuid` = ?');
        $req->execute(array($group_uuid));
        $group_members = $req->fetchAll();
        $req->closeCursor();
    } catch (Exception $e) {
        die('Error connecting to database: ' . $e->getMessage());
    }

    $group_members[0]['users'] .= $user . ",";
    
    try {
        $database_connexion = connect_to_database();
        $req = $database_connexion->prepare('UPDATE groups SET users = ? WHERE uuid = ?');
        $req->execute(array($group_members[0], $group_uuid));
        $req->closeCursor();
    } catch (Exception $e) {
        die('Error connecting to database: ' . $e->getMessage());
    }


}

?>
