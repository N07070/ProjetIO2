<?php
require_once('ConnectionBaseDeDonnee.php');
function search_on_database($terms,$options){

    if (empty($terms) && empty($options)) {
        return array();
    }

    if (!empty($options)) {
        try {
            $database_connexion = connect_to_database();
            $req = $database_connexion->prepare('');
            $req->execute(array());
            $projects = $req->fetchAll();
            $req->closeCursor();
        } catch (Exception $e) {
            die('Error connecting to database: ' . $e->getMessage());
        }

        return $projects;
    } else {

        try {
            $database_connexion = connect_to_database();
            $req = $database_connexion->prepare('SELECT * FROM projets WHERE title LIKE ? OR description LIKE ? OR resume LIKE ? LIMIT 15');
            $req->execute(array("%".$terms."%","%".$terms."%","%".$terms."%"));
            $projects = $req->fetchAll();
            $req->closeCursor();
        } catch (Exception $e) {
            die('Error connecting to database: ' . $e->getMessage());
        }

        return $projects;
    }
}
 ?>
