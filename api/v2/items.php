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


//All of the GET items
function getAllItems(){

	// sql calls to get all the items, then prepare a response
	// assign the response to a variable called $data
	// This "try" runs completely unless something gets "caught" by the "catch" portion below.

	try {
		$db = getDatabase(); // Creates a database connection (found in database.php), and returns the connection.
		$query = $db->prepare( "SELECT dbItem.*, dbCampus.campus_name, dbStatus.Status_Name, dbCategory.Name as catName FROM dbItem LEFT JOIN dbCampus ON dbCampus.ID = dbItem.Campus_ID LEFT JOIN dbStatus ON dbStatus.ID = dbItem.Status_ID LEFT JOIN dbCategory ON dbCategory.ID = dbItem.Category_ID" ); // Prepare an SQL statement to be performed on the database.  In this example we are choosing to return all fields (*) from the table titled dbItem

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
			throw new PDOException("No Items were found.");
		}
	}

	// Catches any thrown error in the try{}, and returns the error message in JSON form.

	catch(PDOException $e) {
		echo '{"error": {"text":"' . $e->getMessage() . '"}}';
	}

}


function getItemById($id){
	// mysql stuff to get the item by ID
	// sql calls to get a single item
	// assign the response to a variable called $data
	// This "try" runs completely unless something gets "caught" by the "catch" portion below.
	try {
		$db = getDatabase(); // Creates a database connection (found in database.php), and returns the connection.
		$query = $db->prepare( "SELECT dbItem.*, dbCampus.campus_name, dbStatus.Status_Name, dbCategory.Name as catName FROM dbItem LEFT JOIN dbCampus ON dbCampus.ID = dbItem.Campus_ID LEFT JOIN dbStatus ON dbStatus.ID = dbItem.Status_ID LEFT JOIN dbCategory ON dbCategory.ID = dbItem.Category_ID WHERE dbItem.ID = :id  " ); // Prepare an SQL statement to be performed on the database.  In this example we are choosing to return all fields (*) from the table WHERE the id is the var $id passed to the function
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
			throw new PDOException("No Items were found.");
		}
	}
	// Catches any thrown error in the try{}, and returns the error message in JSON form.
	catch(PDOException $e) {
		echo '{"error": {"text":"' . $e->getMessage() . '"}}';
	}
}


function getItemsByCategory($cat_id){

	try{
		$db = getDatabase();
		$query = $db->prepare("SELECT * FROM dbItem WHERE Category_ID = :cat_id");
		$query->bindParam(':cat_id', $cat_id);
		$query->execute();
		$data = $query->fetchAll();

		if ($data){
			$db = null;

			return $data;
		}
		else {
			throw new PDOexception("No Items were found.");
		}
	}

	catch(PDOException $e){
		echo '{"error": {"text":"' . $e->getMessage() . '"}}';
	}
}


function getItemsByStatus( $status_id ) {

	try{
		$db = getDatabase();
		$query = $db->prepare("SELECT * FROM dbItem WHERE Status_ID = :status_id");
		$query->bindParam(':status_id', $status_id);
		$query->execute();
		$data = $query->fetchAll();

		if ($data){
			$db = null;

			return $data;
		}
		else {
			throw new PDOexception("No Items were found with status id $status_id.");
		}
	}

	catch(PDOException $e){
		return '{"error": {"text":"' . $e->getMessage() . '"}}';
	}

}





//END all of the GET items



//All of the SAVE items
// more parameters obviously needed
function addItem($id, $name, $description, $barcode, $serial, $purchasePrice, $purchaseDate, $reseller, $resellerPartNum, $manPartNumber, $notes, $photoURL, $manufacturer, $modelNum, $ucTag, $macTF, $campusID, $building, $roomNum, $statusID, $currentCondit, $catID, $flagged){
	//sql calls to save an item, then prepare a response
	// This "try" runs completely unless something gets "caught" by the "catch" portion below.

	try {
		$db = getDatabase(); // Creates a database connection (found in database.php), and returns the connection.

		$query = $db->prepare( "INSERT INTO dbItem ( ID, Name, Description, Barcode, Serial, PurchasePrice, PurchaseDate, Reseller, Reseller_Part_Number, Manufacturer_Part_Number, Notes, Photo_URL, Manufacturer, Model_Number, UC_Tag, MAC_TF, Campus_ID, Building, Room_Number, Status_ID, Current_Condition, Category_ID, Flagged ) VALUES ( :id, :name, :description, :barcode, :serialNum, :purchasePrice, :purchaseDate, :reseller, :resellerPartNum, :manPartNumber, :notes, :photoURL, :manufacturer, :modelNum, :ucTag, :macTF, :campusID, :building, :roomNum, :statusID, :currentCondit, :catID, :flagged) ON DUPLICATE KEY UPDATE ID = :id" ); // Prepare an SQL statement to be performed on the database.  In this example we are telling the database to Insert a row into the dbItem table, with the provided information of ID, Name, and Description (all of which have to be the exact table names in our database).  The first parenthesis contains the database columns that we will fill with the values in the second parenthesis.  Notice how the values in the second parenthesis are prefaced with a colon (:).  These are placeholders for our information given by the saveItem function - before we execute the call on the database, we will have to replace these placeholders with the item information we were given.  Lastly, the ON DUPLICATE KEY UPDATE portion tells the database what to do if an item already exists with the ID that we specified.  In this case, it is telling the database to update the item with the same ID that we were given, so essentially it is doing nothing.

		// We fill in the placeholders in our prepare statement above with the variables passed to our saveItem function (that we are currently in), using the bindParam function.  Our :id, :name, and :description values should now be substituted with their actual values.
		$query->bindParam(':id', $id);
		$query->bindParam(':name', $name);
		$query->bindParam(':description', $description);
		$query->bindParam(':barcode', $barcode);
		$query->bindParam(':serialNum', $serial);
		$query->bindParam(':purchasePrice', $purchasePrice);
		$query->bindParam(':purchaseDate', $purchaseDate);
		$query->bindParam(':reseller', $reseller);
		$query->bindParam(':resellerPartNum', $resellerPartNum);
		$query->bindParam(':manPartNumber', $manPartNumber);
		$query->bindParam(':notes', $notes);
		$query->bindParam(':photoURL', $photoURL);
		$query->bindParam(':manufacturer', $manufacturer);
		$query->bindParam(':modelNum', $modelNum);
		$query->bindParam(':ucTag', $ucTag);
		$query->bindParam(':macTF', $macTF);
		$query->bindParam(':campusID', $campusID);
		$query->bindParam(':building', $building);
		$query->bindParam(':roomNum', $roomNum);
		$query->bindParam(':statusID', $statusID);
		$query->bindParam(':currentCondit', $currentCondit);
		$query->bindParam(':catID', $catID);
		$query->bindParam(':flagged', $flagged);

		// Execute the request.  The execute function returns true or false based on if it was successful or not, so we will check here for the status of the call.
		if ( $query->execute() ) {
			// Create a success response, and echo the message back, and reset the database.
			$response = '{"success":{"text":"Saved Item Successfully." }}';

			$db = null;
			echo $response;
		}
		// Run something if the query failed.
		else {
			// This is how you generate a custom error message, below in the "catch" portion of our try, we will echo out these errors if any were created.
			throw new PDOException("Item could not be saved.");
		}
	}

	// Catches any thrown error in the try{}, and returns the error message in JSON form.
	catch(PDOException $e) {
		echo '{"error": {"text":"' . $e->getMessage() . '"}}';
	}

}




//All EDIT item functions
function editItem($id, $name, $description, $barcode, $serial, $purchasePrice, $purchaseDate, $reseller, $resellerPartNum, $manPartNumber, $notes, $photoURL, $manufacturer, $modelNumber, $ucTag, $macTF, $campusID, $building, $roomNum, $statusID, $currentCondit, $catID, $flagged){

	try{
		$db = getDatabase();
		$query = $db->prepare("UPDATE dbItem SET Name = :name, Description = :description, Barcode = :barcode, Serial = :serialNum, PurchasePrice = :purchasePrice, PurchaseDate = :purchaseDate, Reseller = :reseller, Reseller_Part_Number = :resellerPartNum, Manufacturer_Part_Number = :manPartNumber, Notes = :notes, Photo_URL = :photoURL, Manufacturer = :manufacturer, Model_Number = :modelNum, UC_Tag = :ucTag, MAC_TF = :macTF, Campus_ID = :campusID, Building = :building, Room_Number = :roomNum, Status_ID = :statusID, Current_Condition = :currentCondit, Category_ID = :catID, Flagged = :flagged WHERE ID = :id   ");

		$query->bindParam(':id', $id);
		$query->bindParam(':name', $name);
		$query->bindParam(':description', $description);
		$query->bindParam(':barcode', $barcode);
		$query->bindParam(':serialNum', $serial);
		$query->bindParam(':purchasePrice', $purchasePrice);
		$query->bindParam(':purchaseDate', $purchaseDate);
		$query->bindParam(':reseller', $reseller);
		$query->bindParam(':resellerPartNum', $resellerPartNum);
		$query->bindParam(':manPartNumber', $manPartNumber);
		$query->bindParam(':notes', $notes);
		$query->bindParam(':photoURL', $photoURL);
		$query->bindParam(':manufacturer', $manufacturer);
		$query->bindParam(':modelNum', $modelNum);
		$query->bindParam(':ucTag', $ucTag);
		$query->bindParam(':macTF', $macTF);
		$query->bindParam(':campusID', $campusID);
		$query->bindParam(':building', $building);
		$query->bindParam(':roomNum', $roomNum);
		$query->bindParam(':statusID', $statusID);
		$query->bindParam(':currentCondit', $currentCondit);
		$query->bindParam(':catID', $catID);
		$query->bindParam(':flagged', $flagged);

		if($query->execute()){
			$response = '{"success":{"text":"Saved Item Successfully!"}}';

			$db = null;

			echo $response;

		}
		else {
			throw new PDOException("Item could not be saved.");
		}
	}
	catch(PDOException $e){
		echo '{"error": {"text":"'.$e->getMessage() . '"}}';
	}

}



//Adding Delete ITEMS
function deleteItem(){
	try{
		$db = getDatabase();

		$query = $db -> prepare("DELETE FROM dbPermission WHERE ID = :id AND Name = :name");

		$query->bindParam(':id', $id);
		$query->bindParam(':name', $name);

		if($query->execute()){
			$response = '{"success":{"text":"Deleted Item Successfully!"}}';

			$db = null;

			echo $response;

		}
		else{
			throw new PDOException("Item could not be saved.");
		}
	}
	catch(PDOException $e){
		echo '{"error": {"text":"'.$e->getMessage() . '"}}';
	}
}
