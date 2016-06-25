<?php
/**
 * Include Database connection, makes our database available through the getDatabase() function.
 **/
include_once 'database.php';
/** 
*
*
* Functions to do the actual stuff! ;
*
*
**/
function deleteUser($id){
	// This "try" runs completely unless something gets "caught" by the "catch" portion below.
	try {
		$db = getDatabase(); // Creates a database connection (found in database.php), and returns the connection.
		$query = $db->prepare( "DELETE FROM dbUser WHERE ID = :id");
		// Prepare an SQL statement to be performed on the database.  In this example we are telling the database to Insert a row into the dbItem table, with the provided information of ID, Name, and Description (all of which have to be the exact table names in our database).  The first parenthesis contains the database columns that we will fill with the values in the second parenthesis.  Notice how the values in the second parenthesis are prefaced with a colon (:).  These are placeholders for our information given by the saveItem function - before we execute the call on the database, we will have to replace these placeholders with the item information we were given.  Lastly, the ON DUPLICATE KEY UPDATE portion tells the database what to do if an item already exists with the ID that we specified.  In this case, it is telling the database to update the item with the same ID that we were given, so essentially it is doing nothing.
		// We fill in the placeholders in our prepare statement above with the variables passed to our saveItem function (that we are currently in), using the bindParam function.  Our :id, :name, and :description values should now be substituted with their actual values.
		
		$query->bindParam( ':id', $id );

		// Execute the request.  The execute function returns true or false based on if it was successful or not, so we will check here for the status of the call.
		if ( $query->execute() ) {
			// Create a success response, and echo the message back, and reset the database.
			$response = '{"success":{"text":"Deleted User Successfully." }}';
			
			$db = null;
			echo $response;
		}
		// Run something if the query failed.
		else {
			// This is how you generate a custom error message, below in the "catch" portion of our try, we will echo out these errors if any were created.
			throw new PDOException("User could not be deleted.");
		}
	}
	// Catches any thrown error in the try{}, and returns the error message in JSON form.
	catch(PDOException $e) {
		echo '{"error": {"text":"' . $e->getMessage() . '"}}';
	}
}


function editUser($id, $first_name, $last_name, $email_primary, $email_secondary, $phone_primary, $mag_stripe, $prox_id, $affil, $campus_id, $netid, $level){
	try {
		$testStr = "UPDATE dbUser SET First_Name = :first_name, Last_Name = :last_name, Email_Primary = :email_primary, Email_Secondary = :email_secondary, Phone_Primary = :phone_primary, Mag_Stripe = :mag_stripe, Prox_ID = :prox_id, Affil = :affil, Campus_ID = :campus_id, NetID = :net_id, Level = :level WHERE ID = :id;";
		
		$db = getDatabase();
		$query = $db->prepare($testStr);
		$query->bindParam( ':id', $id  );
		$query->bindParam( ':first_name', $first_name );
		$query->bindParam( ':last_name', $last_name );
		$query->bindParam( ':email_primary', $email_primary );
		$query->bindParam( ':email_secondary', $email_secondary );
		$query->bindParam( ':phone_primary', $phone_primary );
		$query->bindParam( ':mag_stripe', $mag_stripe );
		$query->bindParam( ':prox_id', $prox_id );
		$query->bindParam( ':affil', $affil );
		$query->bindParam( ':campus_id', $campus_id );
		$query->bindParam( ':net_id', $net_id );
		$query->bindParam( ':level', $level );
		$query->setFetchMode( PDO::FETCH_OBJ );
		
		// Run a process if our data set isn't empty.
		
		if ( $query->execute() ) {
			// Create a success response, and echo the message back, and reset the database.
			$response = '{"success":{"text":"User Edited Successfully." }}';
			
			$db = null;
			echo $response;
		}
		// Run something if the query failed.
		else {
			// This is how you generate a custom error message, below in the "catch" portion of our try, we will echo out these errors if any were created.
			throw new PDOException("User could not be edited.");
		}
	}
	catch(PDOException $e) {
	    echo '{"error": {"text":"' . $e->getMessage() . '"}}';
	}
}


function getUsers(){
	//sql calls to save an item, then prepare a response
	// This "try" runs completely unless something gets "caught" by the "catch" portion below.
	try {
		$db = getDatabase(); // Creates a database connection (found in database.php), and returns the connection.
		$query = $db->prepare( "SELECT * FROM dbUser" ); // Prepare an SQL statement to be performed on the database.  In this example we are telling the database to Insert a row into the dbItem table, with the provided information of ID, Name, and Description (all of which have to be the exact table names in our database).  The first parenthesis contains the database columns that we will fill with the values in the second parenthesis.  Notice how the values in the second parenthesis are prefaced with a colon (:).  These are placeholders for our information given by the saveItem function - before we execute the call on the database, we will have to replace these placeholders with the item information we were given.  Lastly, the ON DUPLICATE KEY UPDATE portion tells the database what to do if an item already exists with the ID that we specified.  In this case, it is telling the database to update the item with the same ID that we were given, so essentially it is doing nothing.
		// We fill in the placeholders in our prepare statement above with the variables passed to our saveItem function (that we are currently in), using the bindParam function.  Our :id, :name, and :description values should now be substituted with their actual values.

		$query->execute(); // Run the SQL query on our database
		$query->setFetchMode( PDO::FETCH_OBJ ); // A PHP method to tell the database we want to return all the data as objects with each table represented as a property of that object. This will be the case for most of our calls that return information from the database.  http://php.net/manual/en/pdo.constants.php
		$data = $query->fetchAll(); // Set $response to an array of all the result objects.
		// Execute the request.  The execute function returns true or false based on if it was successful or not, so we will check here for the status of the call.
			if ( $data ) {
			// Reset the database object, and send our data to the "prepareResponse" function to spit out our data.
			
			$db = null;
			return $data;
		}
		// Run something if the data set is empty.
		else {
			// This is how you generate a custom error message, below in the "catch" portion of our try, we will echo out these errors if any were created.
			throw new PDOException("Could not get all users.");
		}
	}
	// Catches any thrown error in the try{}, and returns the error message in JSON form.
	catch(PDOException $e) {
		echo '{"error": {"text":"' . $e->getMessage() . '"}}';
	}
}

function getUserByID( $id ) {

	try {
		$db = getDatabase(); // Creates a database connection (found in database.php), and returns the connection.
		$query = $db->prepare( "SELECT * FROM dbUser WHERE ID = :id" ); // Prepare an SQL statement to be performed on the database.  In this example we are telling the database to Insert a row into the dbItem table, with the provided information of ID, Name, and Description (all of which have to be the exact table names in our database).  The first parenthesis contains the database columns that we will fill with the values in the second parenthesis.  Notice how the values in the second parenthesis are prefaced with a colon (:).  These are placeholders for our information given by the saveItem function - before we execute the call on the database, we will have to replace these placeholders with the item information we were given.  Lastly, the ON DUPLICATE KEY UPDATE portion tells the database what to do if an item already exists with the ID that we specified.  In this case, it is telling the database to update the item with the same ID that we were given, so essentially it is doing nothing.
		// We fill in the placeholders in our prepare statement above with the variables passed to our saveItem function (that we are currently in), using the bindParam function.  Our :id, :name, and :description values should now be substituted with their actual values.

		$query->bindParam( ':id', $id );
		$query->execute(); // Run the SQL query on our database
		$query->setFetchMode( PDO::FETCH_OBJ ); // A PHP method to tell the database we want to return all the data as objects with each table represented as a property of that object. This will be the case for most of our calls that return information from the database.  http://php.net/manual/en/pdo.constants.php
		$data = $query->fetchAll(); // Set $response to an array of all the result objects.
		// Execute the request.  The execute function returns true or false based on if it was successful or not, so we will check here for the status of the call.
			if ( $data ) {
			// Reset the database object, and send our data to the "prepareResponse" function to spit out our data.
			
			$db = null;
			return $data;
		}
		// Run something if the data set is empty.
		else {
			// This is how you generate a custom error message, below in the "catch" portion of our try, we will echo out these errors if any were created.
			throw new PDOException("Could not get user by ID $id.");
		}
	}
	// Catches any thrown error in the try{}, and returns the error message in JSON form.
	catch(PDOException $e) {
		echo '{"error": {"text":"' . $e->getMessage() . '"}}';
	}

}


function addUser($id=0, $first_name, $last_name, $email_primary, $email_secondary, $phone_primary, $mag_stripe, $prox_id, $affil, $campus_id, $netid, $level){
	//sql calls to save an item, then prepare a response
	// This "try" runs completely unless something gets "caught" by the "catch" portion below.
	try {
		$db = getDatabase(); // Creates a database connection (found in database.php), and returns the connection.
		$query = $db->prepare( "INSERT INTO dbUser (ID, First_Name, Last_Name, Email_Primary, Email_Secondary, Phone_Primary, Mag_Stripe, Prox_ID, Affil, Campus_ID, Netid, Level) VALUES ( :id, :first_name, :last_name, :email_primary, :email_secondary, :phone_primary, :mag_Stripe, :prox_ID, :affil, :campus_id, :netid, :level)"); // Prepare an SQL statement to be performed on the database.  In this example we are telling the database to Insert a row into the dbItem table, with the provided information of ID, Name, and Description (all of which have to be the exact table names in our database).  The first parenthesis contains the database columns that we will fill with the values in the second parenthesis.  Notice how the values in the second parenthesis are prefaced with a colon (:).  These are placeholders for our information given by the saveItem function - before we execute the call on the database, we will have to replace these placeholders with the item information we were given.  Lastly, the ON DUPLICATE KEY UPDATE portion tells the database what to do if an item already exists with the ID that we specified.  In this case, it is telling the database to update the item with the same ID that we were given, so essentially it is doing nothing.
		// We fill in the placeholders in our prepare statement above with the variables passed to our saveItem function (that we are currently in), using the bindParam function.  Our :id, :name, and :description values should now be substituted with their actual values.
		
		$query->bindParam( ':id', $id );
		$query->bindParam( ':first_name', $first_name );
		$query->bindParam( ':last_name', $last_name );
		$query->bindParam( ':email_primary', $email_primary );
		$query->bindParam( ':email_secondary', $email_secondary );
		$query->bindParam( ':phone_primary', $phone_primary );
		$query->bindParam( ':mag_stripe', $mag_stripe );
		$query->bindParam( ':prox_id', $prox_id );
		$query->bindParam( ':affil', $affil );
		$query->bindParam( ':campus_id', $campus_id );
		$query->bindParam( ':net_id', $net_id );
		$query->bindParam( ':level', $level );

		// Execute the request.  The execute function returns true or false based on if it was successful or not, so we will check here for the status of the call.
		if ( $query->execute() ) {
			// Create a success response, and echo the message back, and reset the database.
			$response = '{"success":{"text":"Saved User Successfully." }}';
			
			$db = null;
			echo $response;
		}
		// Run something if the query failed.
		else {
			// This is how you generate a custom error message, below in the "catch" portion of our try, we will echo out these errors if any were created.
			throw new PDOException("User could not be saved.");
		}
	}
	// Catches any thrown error in the try{}, and returns the error message in JSON form.
	catch(PDOException $e) {
		echo '{"error": {"text":"' . $e->getMessage() . '"}}';
	}
}

