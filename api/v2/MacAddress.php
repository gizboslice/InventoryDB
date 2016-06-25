<?php 

//Include the database
include_once 'database.php'; 


function getMacForItem($itemId, $macNum) {

	try {
		$db = getDatabase(); 
		$query = $db->prepare("SELECT * FROM dbMac_Address WHERE Item_ID = :itemId AND MAC_Num = :macNum "); 

		$query->bindParam( ':itemId', $itemId );
		$query->bindParam(':macNum', $macNum); 
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
			throw new PDOException("Could not get mac address for ItemID $itemId.");
		}
	}
	// Catches any thrown error in the try{}, and returns the error message in JSON form.
	catch(PDOException $e) {
		echo '{"error": {"text":"' . $e->getMessage() . '"}}';
	}

}


function addMacForItem($itemId, $macNum, $macAddress) {

	try{
		$db = getDatabase();
		$query = $db->prepare("INSERT INTO dbMac_Address (Item_ID, MAC_Num, MAC_Address) VALUES (:itemId, :macNum, :macAdd) ON DUPLICATE KEY UPDATE Item_ID = :itemId");
		$query->bindParam(':itemId', $itemId);
		$query->bindParam('macNum', $macNum);
		$query->bindParam(':macAdd', $macAddress); 

		if ( $query->execute() ) {
				// Create a success response, and echo the message back, and reset the database.
				$response = '{"success":{"text":"Saved Mac Address Successfully." }}';

				$db = null;
				echo $response;
			}
			// Run something if the query failed.
			else {
				// This is how you generate a custom error message, below in the "catch" portion of our try, we will echo out these errors if any were created.
				throw new PDOException("Mac Address could not be saved.");
			}
	}

	// Catches any thrown error in the try{}, and returns the error message in JSON form.
	catch(PDOException $e) {
		echo '{"error": {"text":"' . $e->getMessage() . '"}}';
	}

}


function deleteMacAddress($itemId, $macNum) {
	try {
		$db = getDatabase(); 

		$query = $db->prepare("DELETE FROM dbMac_Address WHERE Item_ID = :itemId AND MAC_Num = :macNum");

		$query->bindParam(':itemId', $itemId);
		$query->bindParam(':macNum', $macNum); 

		if($query->execute()){	
			$response = '{"success":{"text":"Deleted Mac Address Successfully!"}}';

			$db = null; 

			return $response; 

		}
		else{
			throw new PDOException("Mac Address could not be saved."); 
		}
	}

	catch(PDOException $e){
		echo '{"error": {"text":"'.$e->getMessage() . '"}}'; 
	}
}

function editMacAddress($itemId, $macNum, $macAddress) {

	try{
		$db = getDatabase(); 
		$query = $db->prepare("UPDATE dbMac_Address SET MAC_Address = :macAdd WHERE Item_ID = :itemId AND MAC_Num = :macNum"); 

		$query->bindParam(':itemId', $itemId); 
		$query->bindParam(':macNum', $macNum); 
		$query->bindParam(':macAdd', $macAddress); 
		
		if($query->execute()){
			$response = '{"success":{"text":"Saved Mac Address Successfully!"}}';

			$db = null; 

			echo $response; 

		}
		else {
			throw new PDOException("Mac Address could not be saved."); 
		}
	}

	catch(PDOException $e){
		echo '{"error": {"text":"'.$e->getMessage() . '"}}'; 
	}


}




?>