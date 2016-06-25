<?php
/**
 * Include Database connection, makes our database available through the getDatabase() function.
 **/
include_once 'database.php';

/**
*
*
* Add Strike
*
*
**/

function addStrike($id=0, $strike, $description){
	
	// sql calls to get all the items, then prepare a response
	// assign the response to a variable called $data
	// This "try" runs completely unless something gets "caught" by the "catch" portion below.

	try {
		$db = getDatabase(); // Creates a database connection (found in database.php), and returns the connection.
		$query = $db->prepare( "INSERT INTO  dbStrike (ID , Strike_Name, Description) VALUES (NULL , :strike, :description)" ); // Prepare an SQL statement to be performed on the database.  In this example we are choosing to return all fields (*) from the table titled dbItem
		$query->bindParam( ':strike', $strike );
		$query->bindParam( ':description', $description );
		
		if ( $query->execute() ) {
			// Reset the database object, and send our data to the "prepareResponse" (way down there...) function to spit out our data.
			$response = '{"success":{"text":"Saved Strike Successfully." }}';
			$db = null;
			echo $response;
		}
		// Run something if the data set is empty.
		else {
			// This is how you generate a custom error message, below in the "catch" portion of our try, we will echo out these errors if any were created.
			throw new PDOException("This strike could not be");
		}
	}

	// Catches any thrown error in the try{}, and returns the error message in JSON form.

	catch(PDOException $e) {
		echo '{"error": {"text":"' . $e->getMessage() . '"}}';
	}

}

/**
*
*
* Edit Strike
*
*
**/

function editStrike($id, $strike, $description){
		try {
			$db = getDatabase();
			$query = $db->prepare("UPDATE dbStrike SET Strike_Name = :strike, Description = :description WHERE ID = :id");
			$query->bindParam( ':id', $id );
			$query->bindParam( ':strike', $strike );
			$query->bindParam( ':description', $description );
			$query->setFetchMode( PDO::FETCH_OBJ );	
			// Run a process if our data set isn't empty.

			if ( $query->execute() ) {
				// Create a success response, and echo the message back, and reset the database.
				$response = '{"success":{"text":"Edited Strike Successfully." }}';

				$db = null;
				echo $response;
			}
			// Run something if the query failed.
			else {
				// This is how you generate a custom error message, below in the "catch" portion of our try, we will echo out these errors if any were created.
				throw new PDOException("Strike could not be edited.");
			}
		}

	   catch(PDOException $e) {
		echo '{"error": {"text":"' . $e->getMessage() . '"}}';
	   }

	}

/**
*
*
* Get All Strikes
*
*
**/

function getAllStrikes(){
	
	// sql calls to get all the items, then prepare a response
	// assign the response to a variable called $data
	// This "try" runs completely unless something gets "caught" by the "catch" portion below.

	try {
		$db = getDatabase(); // Creates a database connection (found in database.php), and returns the connection.
		$query = $db->prepare( "SELECT * FROM dbStrike"); // Prepare an SQL statement to be performed on the database.  In this example we are choosing to return all fields (*) from the table titled dbItem
		$query->execute(); // Run the SQL query on our database
		$query->setFetchMode( PDO::FETCH_OBJ ); // A PHP method to tell the database we want to return all the data as objects with each table represented as a property of that object. This will be the case for most of our calls that return information from the database.  http://php.net/manual/en/pdo.constants.php
		$data = $query->fetchAll(); // Set $response to an array of all the result objects.
		// Run a process if our data set isn't empty.

		if ( $data ) {
			// Reset the database object, and send our data to the "prepareResponse" (way down there...) function to spit out our data.
			$db = null;
			return $data;
		}
		// Run something if the data set is empty.
		else {
			// This is how you generate a custom error message, below in the "catch" portion of our try, we will echo out these errors if any were created.
			throw new PDOException("No strikes could be found");
		}
	}

	// Catches any thrown error in the try{}, and returns the error message in JSON form.

	catch(PDOException $e) {
		echo '{"error": {"text":"' . $e->getMessage() . '"}}';
	}

}

/**
*
*
* Delete Strike
*
*
**/


function deleteStrike($id){
    try {
	$db = getDatabase();
	$query = $db->prepare( "DELETE FROM dbStrike WHERE ID=:id" );
	$query->bindParam( ':id', $id);
	if ( $query->execute() ) {
		$response = '{"success":{"text":"Deleted Strike Successfully." }}';
		$db = null;
		echo $response;
	}
	else {
		throw new PDOException("Strike could not be deleted.");
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

function getStrikeById($id){
	try {
		$db = getDatabase(); // Creates a database connection (found in database.php), and returns the connection.
		$query = $db->prepare( "SELECT ID, Strike_Name, Description FROM dbStrike WHERE ID = :id" ); // Prepare an SQL statement to be performed on the database.  In this example we are choosing to return all fields (*) from the table WHERE the id is the var $id passed to the function
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
			throw new PDOException("No strike was found.");
		}
	}
	// Catches any thrown error in the try{}, and returns the error message in JSON form.
	catch(PDOException $e) {
		echo '{"error": {"text":"' . $e->getMessage() . '"}}';
	}
}