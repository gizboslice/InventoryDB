<?php

/**
 * Include Database connection, makes our database available through the getDatabase() function.
 **/
include_once 'database.php';

/**
 * Add Package
 **/

function addPackages($id=0, $name, $date, $blameID) {
    try {
	$db = getDatabase();
	$query = $db->prepare( "INSERT INTO  dbPackage (ID , Name, AddDate, BlameID) VALUES (NULL , :name, :date, :blameID)" );
	$query->bindParam(':name', $name );
	$query->bindParam(':date', $date);
	$query->bindParam(':blameID', $blameID); 
	//$query->setFetchMode( PDO::FETCH_OBJ );
	// Run a process if our data set isn't empty.
	
	if ( $query->execute() ) {
		// Create a success response, and echo the message back, and reset the database.
		$response = '{"success":{"text":"Saved Package Successfully." }}';
		
		$db = null;
		echo $response;
	}
	// Run something if the query failed.
	else {
		// This is how you generate a custom error message, below in the "catch" portion of our try, we will echo out these errors if any were created.
		throw new PDOException("Package could not be added.");
	}
    }
 
    catch(PDOException $e) {
	echo '{"error": {"text":"' . $e->getMessage() . '"}}';
    }
}


/**
 * Edit Package
 **/
function editPackages($id, $name, $date, $blameID){
	try{
		$db = getDatabase(); 

		$query = $db -> prepare("UPDATE dbPackage SET Name = :name, AddDate = :date, BlameID = :blameID WHERE ID = :id"); 
		$query->bindParam(':id', $id);
		$query->bindParam(':name', $name); 
		$query->bindParam(':date', $date);
		$query->bindParam(':blameID', $blameID);

		if($query->execute()){
			$response = '{"success":{"text":"Edited Package Successfully!"}}';

			$db = null; 

			echo $response; 

		}
		else {
			throw new PDOException("Package could not be edited."); 
		}
	}
	catch(PDOException $e){
		echo '{"error": {"text":"'.$e->getMessage() . '"}}'; 
	}
}

/**
* Delete Package
**/

function deletePackage( $id ){
	try {
		$db = getDatabase($id); 

		$query = $db -> prepare("DELETE FROM dbPackage WHERE ID = :id");
		$query->bindParam(':id', $id);

		if($query->execute()){	
			$response = '{"success":{"text":"Deleted Package Successfully!"}}';

			$db = null; 

			echo $response; 

		}
		else{
			throw new PDOException("Package could not be deleted."); 
		}
	}
	catch(PDOException $e){
		echo '{"error": {"text":"'.$e->getMessage() . '"}}'; 
	}
}


/**GetAllPackages**/

function getAllPackages(){
	try{
		$db = getDatabase(); //make the call

		$query = $db->prepare("SELECT * FROM dbPackage"); 


		$query->execute(); 
		$query->setFetchMode( PDO::FETCH_OBJ );
		$data = $query->fetchAll(); 

		if($data){
			$db = null; 

			return $data; 

		}
		else {
			throw new PDOException("No Packages were found.");
		}
	}
	catch (PDOException $e){
		echo '{"error":{"text":"' . $e->getMessage() . '"}}';
	}


}



 
/**
* Get Package By ID
**/

function getPackageByID($id){
	try {
		$db = getDatabase(); // Creates a database connection (found in database.php), and returns the connection.
		$query = $db->prepare( "SELECT * FROM dbPackage WHERE ID = :id" ); // Prepare an SQL statement to be performed on the database.  In this example we are choosing to return all fields (*) from the table WHERE the id is the var $id passed to the function
		$query->bindParam( ':id', $id );
		$query->execute(); // Run the SQL query on our database
		$query->setFetchMode( PDO::FETCH_OBJ ); // A PHP method to tell the database we want to return all the data as objects with each table represented as a property of that object. This will be the case for most of our calls that return information from the database.  http://php.net/manual/en/pdo.constants.php
		$data = $query->fetchAll(); // Set $response to an array of all the result objects.
		// Run a process if our data set isn't empty.
		if ( $data ) {
			// Reset the database object, and send our data to the "prepareResponse" function to spit out our data.
			
			$db = null;
			return $data;
		}
		// Run something if the data set is empty.
		else {
			// This is how you generate a custom error message, below in the "catch" portion of our try, we will echo out these errors if any were created.
			throw new PDOException("No Package was found.");
		}
	}
	// Catches any thrown error in the try{}, and returns the error message in JSON form.
	catch(PDOException $e) {
		echo '{"error": {"text":"' . $e->getMessage() . '"}}';
	}
}
 
 ?>