<?php

/**
 * Include Database connection, makes our database available through the getDatabase() function.
 **/
include_once 'database.php';


/**
*
*
* Add Status
*
*
**/
function addStatus( $name ) {

    try {
        $db = getDatabase();
        $query = $db->prepare( "INSERT INTO dbStatus ( Status_Name ) VALUES ( :name ) ON DUPLICATE KEY UPDATE dbStatus.ID = dbStatus.ID" );
        $query->bindParam( ':name', $name );
        
        if ( $query->execute() ) {
            $response = '{"success":{"text":"Saved Status Successfully." }}';
            $db = null;
            echo $response;
        }

        else {
            throw new PDOException("Could not save status.");
        }
    }

    catch(PDOException $e) {
        echo '{"error": {"text":"' . $e->getMessage() . '"}}';
    }

}

/**
*
*
* Edit Status
*
*
**/
function editStatus( $id, $name ){
    try {
        $db = getDatabase();
        $query = $db->prepare("UPDATE dbStatus SET Status_Name = :name WHERE ID = :id");
        $query->bindParam( ':id', $id );
        $query->bindParam( ':name', $name );
        $query->setFetchMode( PDO::FETCH_OBJ ); 

        if ( $query->execute() ) {
            $response = '{"success":{"text":"Edited Status Successfully." }}';
            $db = null;
            echo $response;
        }

        else {
            throw new PDOException("Status could not be edited.");
        }
    }

    catch(PDOException $e) {
        echo '{"error": {"text":"' . $e->getMessage() . '"}}';
    }

}


/**
*
*
* Get All Statuses
*
*
**/
function getAllStatuses(){

    try {
        $db = getDatabase();
        $query = $db->prepare( "SELECT * FROM dbStatus");
        $query->execute();
        $query->setFetchMode( PDO::FETCH_OBJ );
        $data = $query->fetchAll();

        if ( $data ) {
            $db = null;
            return $data;
        }

        else {
            throw new PDOException("No statuses could be found");
        }
    }

    catch(PDOException $e) {
        echo '{"error": {"text":"' . $e->getMessage() . '"}}';
    }

}


/**
*
*
* Delete Status
*
*
**/
function deleteStatus( $id ){
    try {
        $db = getDatabase();
        $query = $db->prepare( "DELETE FROM dbStatus WHERE ID = :id" );
        $query->bindParam( ':id', $id);
        if ( $query->execute() ) {
            $response = '{"success":{"text":"Deleted Status Successfully." }}';
            $db = null;
            echo $response;
        }
        else {
            throw new PDOException("Status could not be deleted.");
        }
    }

    catch(PDOException $e) {
        echo '{"error": {"text":"' . $e->getMessage() . '"}}';
    }
}


/**
*
*
* Get Strike by ID
*
*
**/
function getStatusByID( $id ){
    try {
        $db = getDatabase();
        $query = $db->prepare( "SELECT * FROM dbStatus WHERE ID = :id" );
        $query->bindParam( ':id', $id );
        $query->execute();
        $query->setFetchMode( PDO::FETCH_OBJ );
        $data = $query->fetchAll();

        if ( $data ) {
            $db = null;
            return $data;
        }

        else {
            throw new PDOException("No status was found.");
        }
    }

    catch(PDOException $e) {
        echo '{"error": {"text":"' . $e->getMessage() . '"}}';
    }
}