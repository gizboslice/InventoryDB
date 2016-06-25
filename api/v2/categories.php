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
function deleteCategory($id){
	// This "try" runs completely unless something gets "caught" by the "catch" portion below.
	try {
		$db = getDatabase(); // Creates a database connection (found in database.php), and returns the connection.
		$query = $db->prepare( "DELETE FROM dbCategory WHERE ID = :id"); // Prepare an SQL statement to be performed on the database.  In this example we are telling the database to Insert a row into the dbItem table, with the provided information of ID, Name, and Description (all of which have to be the exact table names in our database).  The first parenthesis contains the database columns that we will fill with the values in the second parenthesis.  Notice how the values in the second parenthesis are prefaced with a colon (:).  These are placeholders for our information given by the saveItem function - before we execute the call on the database, we will have to replace these placeholders with the item information we were given.  Lastly, the ON DUPLICATE KEY UPDATE portion tells the database what to do if an item already exists with the ID that we specified.  In this case, it is telling the database to update the item with the same ID that we were given, so essentially it is doing nothing.
		// We fill in the placeholders in our prepare statement above with the variables passed to our saveItem function (that we are currently in), using the bindParam function.  Our :id, :name, and :description values should now be substituted with their actual values.
		
		$query->bindParam( ':id', $id);
		// Execute the request.  The execute function returns true or false based on if it was successful or not, so we will check here for the status of the call.
		if ( $query->execute() ) {
			// Create a success response, and echo the message back, and reset the database.
			$response = '{"success":{"text":"Deleted Category Successfully." }}';
			
			$db = null;
			echo $response;
		}
		// Run something if the query failed.
		else {
			// This is how you generate a custom error message, below in the "catch" portion of our try, we will echo out these errors if any were created.
			throw new PDOException("Category could not be deleted.");
		}
	}
	// Catches any thrown error in the try{}, and returns the error message in JSON form.
	catch(PDOException $e) {
		echo '{"error": {"text":"' . $e->getMessage() . '"}}';
	}
}


function editCategory($id, $parent_id, $name, $resource_text, $image_link, $description){
	try {
		$testStr = "UPDATE dbCategory SET Parent_ID = :parent_id, Name = :name, Resource_Text = :resource_text, Image_Link = :image_link, Description = :description WHERE ID= :id";
		
		$db = getDatabase();
		$query = $db->prepare($testStr);
		$query->bindParam( ':id', $id  );
		$query->bindParam( ':parent_id', $parent_id );
		$query->bindParam( ':name', $name );
		$query->bindParam( ':resource_text', $resource_text );
		$query->bindParam( ':image_link', $image_link );
		$query->bindParam( ':description', $description );
		$query->setFetchMode( PDO::FETCH_OBJ );
		
		// Run a process if our data set isn't empty.
		
		if ( $query->execute() ) {
			// Create a success response, and echo the message back, and reset the database.
			$response = '{"success":{"text":"Category Edited Successfully." }}';
			
			$db = null;
			echo $response;
		}
		// Run something if the query failed.
		else {
			// This is how you generate a custom error message, below in the "catch" portion of our try, we will echo out these errors if any were created.
			throw new PDOException("Category could not be edited.");
		}
	}
	catch(PDOException $e) {
	    echo '{"error": {"text":"' . $e->getMessage() . '"}}';
	}
}


function getCategories(){
	//sql calls to save an item, then prepare a response
	// This "try" runs completely unless something gets "caught" by the "catch" portion below.
	try {
		$db = getDatabase(); // Creates a database connection (found in database.php), and returns the connection.
		$query = $db->prepare( "SELECT child.*, parent.Parent_ID as GrandParent_ID, parent.Name as Parent_Name, parent.Resource_Text as Parent_Resource_Text, parent.Image_Link as Parent_Image_Link, parent.Description as Parent_Description FROM dbCategory as child LEFT JOIN dbCategory as parent ON child.Parent_ID = parent.ID" ); // Prepare an SQL statement to be performed on the database.  In this example we are telling the database to Insert a row into the dbItem table, with the provided information of ID, Name, and Description (all of which have to be the exact table names in our database).  The first parenthesis contains the database columns that we will fill with the values in the second parenthesis.  Notice how the values in the second parenthesis are prefaced with a colon (:).  These are placeholders for our information given by the saveItem function - before we execute the call on the database, we will have to replace these placeholders with the item information we were given.  Lastly, the ON DUPLICATE KEY UPDATE portion tells the database what to do if an item already exists with the ID that we specified.  In this case, it is telling the database to update the item with the same ID that we were given, so essentially it is doing nothing.
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
			throw new PDOException("Could not get all categories.");
		}
	}
	// Catches any thrown error in the try{}, and returns the error message in JSON form.
	catch(PDOException $e) {
		echo '{"error": {"text":"' . $e->getMessage() . '"}}';
	}
}


function getCategoryByID( $id ) {

	try {
		$db = getDatabase(); // Creates a database connection (found in database.php), and returns the connection.
		$query = $db->prepare( "SELECT child.*, parent.Parent_ID as GrandParent_ID, parent.Name as Parent_Name, parent.Resource_Text as Parent_Resource_Text, parent.Image_Link as Parent_Image_Link, parent.Description as Parent_Description FROM dbCategory as child LEFT JOIN dbCategory as parent ON child.Parent_ID = parent.ID  WHERE child.ID = :id"); // Prepare an SQL statement to be performed on the database.  In this example we are telling the database to Insert a row into the dbItem table, with the provided information of ID, Name, and Description (all of which have to be the exact table names in our database).  The first parenthesis contains the database columns that we will fill with the values in the second parenthesis.  Notice how the values in the second parenthesis are prefaced with a colon (:).  These are placeholders for our information given by the saveItem function - before we execute the call on the database, we will have to replace these placeholders with the item information we were given.  Lastly, the ON DUPLICATE KEY UPDATE portion tells the database what to do if an item already exists with the ID that we specified.  In this case, it is telling the database to update the item with the same ID that we were given, so essentially it is doing nothing.
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
			throw new PDOException("No category found for id $id");
		}
	}
	// Catches any thrown error in the try{}, and returns the error message in JSON form.
	catch(PDOException $e) {
		echo '{"error": {"text":"' . $e->getMessage() . '"}}';
	}

}


function addCategory($id=0, $parent_id, $name, $resource_text, $image_link, $description){
	//sql calls to save an item, then prepare a response
	// This "try" runs completely unless something gets "caught" by the "catch" portion below.
	try {
		$db = getDatabase(); // Creates a database connection (found in database.php), and returns the connection.
		$query = $db->prepare( "INSERT INTO dbCategory (Parent_ID, Name, Resource_Text, Image_Link, Description) VALUES ( :parent_id, :name, :resource_text, :image_link, :description )"); // Prepare an SQL statement to be performed on the database.  In this example we are telling the database to Insert a row into the dbItem table, with the provided information of ID, Name, and Description (all of which have to be the exact table names in our database).  The first parenthesis contains the database columns that we will fill with the values in the second parenthesis.  Notice how the values in the second parenthesis are prefaced with a colon (:).  These are placeholders for our information given by the saveItem function - before we execute the call on the database, we will have to replace these placeholders with the item information we were given.  Lastly, the ON DUPLICATE KEY UPDATE portion tells the database what to do if an item already exists with the ID that we specified.  In this case, it is telling the database to update the item with the same ID that we were given, so essentially it is doing nothing.
		// We fill in the placeholders in our prepare statement above with the variables passed to our saveItem function (that we are currently in), using the bindParam function.  Our :id, :name, and :description values should now be substituted with their actual values.
		
		$query->bindParam( ':parent_id', $parent_id );
		$query->bindParam( ':name', $name );
		$query->bindParam( ':resource_text', $resource_text );
		$query->bindParam( ':image_link', $image_link );
		$query->bindParam( ':description', $description );
		// Execute the request.  The execute function returns true or false based on if it was successful or not, so we will check here for the status of the call.
		if ( $query->execute() ) {
			// Create a success response, and echo the message back, and reset the database.
			$response = '{"success":{"text":"Saved Category Successfully." }}';
			
			$db = null;
			echo $response;
		}
		// Run something if the query failed.
		else {
			// This is how you generate a custom error message, below in the "catch" portion of our try, we will echo out these errors if any were created.
			throw new PDOException("Category could not be saved.");
		}
	}
	// Catches any thrown error in the try{}, and returns the error message in JSON form.
	catch(PDOException $e) {
		echo '{"error": {"text":"' . $e->getMessage() . '"}}';
	}
}

