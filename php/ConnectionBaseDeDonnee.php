<?php
function connect_to_database(){
    try {
        // $pdo_options[PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES utf8";
		// $bdd = new PDO('mysql:host=localhost;dbname='.DATABASE_NAME, DATABASE_USERNAME, DATABASE_USERNAME, $pdo_options);
        $bdd = new PDO('mysql:host=localhost;dbname='.DATABASE_NAME.';charset=utf8', DATABASE_USERNAME, DATABASE_PASSWORD);
    } catch (Exception $e){
        die('Erreur : ' . $e->getMessage());
    }
    return $bdd;
}
?>
