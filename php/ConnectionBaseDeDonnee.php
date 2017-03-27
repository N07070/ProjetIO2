<?php
function connect_to_database(){
    try {
        $bdd = new PDO('mysql:host=localhost;dbname='.DATABASE_NAME.';charset=utf8', DATABASE_USERNAME, DATABASE_PASSWORD);
    } catch (Exception $e){
        die('Erreur : ' . $e->getMessage());
    }
    return $bdd;
}
?>
