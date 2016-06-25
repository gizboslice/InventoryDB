<?php

/**
 * Include Database connection, makes our database available through the getDatabase() function.
 **/
include_once 'database.php';

function addPermissions($id, $name, $description){
	try{
		$db = getDatabase(); //Call getDatabase() to set connection

		$query = $db -> prepare("INSERT INTO dbPermission (ID, Name, Description) VALUES (:id, :name, :description) ON DUPLICATE KEY UPDATE ID = :id"); // adding the information the user provides to the database utalizing wildcat VARs

		$query->bindParam(':id', $id); 
		$query->bindParam(':name', $name);
		$query->bindParam(':description', $description); 

		if($query->execute()){
			$response = '{"success":{"text":"Saved Permission Successfully!"}}';

			$db = null;

			echo $response; 
		}
		else{
			//Add error message and throw to make sure that the try CAN fail
			throw new PDOException("Permission could not be saved."); 
		}
	}
	catch(PDOException $e){
		echo '{"error": {"text":"'.$e->getMessage() . '"}}'; 
	}
}

function editPermissions($id, $name, $description){
	try{
		$db = getDatabase(); 

		$query = $db -> prepare("UPDATE dbPermission SET Name = :name, Description = :description WHERE ID = :id"); 

		$query->bindParam(':id', $id);
		$query->bindParam(':name', $name); 
		$query->bindParam(':description', $description); 

		if($query->execute()){
			$response = '{"success":{"text":"Saved Permission Successfully!"}}';

			$db = null; 

			echo $response; 

		}
		else {
			throw new PDOException("Permission could not be saved."); 
		}
	}
	catch(PDOException $e){
		echo '{"error": {"text":"'.$e->getMessage() . '"}}'; 
	}
}

function deletePermissions(){
	try {
		$db = getDatabase(); 

		$query = $db -> prepare("DELETE FROM dbPermission WHERE ID = :id AND Name = :name");

		$query->bindParam(':id', $id);
		$query->bindParam(':name', $name); 

		if($query->execute()){	
			$response = '{"success":{"text":"Deleted Permission Successfully!"}}';

			$db = null; 

			echo $response; 

		}
		else{
			throw new PDOException("Permission could not be deleted."); 
		}
	}
	catch(PDOException $e){
		echo '{"error": {"text":"'.$e->getMessage() . '"}}'; 
	}
}

function getPermissions(){
	try{
		$db = getDatabase(); //make the call

		$query = $db->prepare("SELECT * FROM dbPermission"); 


		$query->execute(); 
		$query->setFetchMode( PDO::FETCH_OBJ );
		$data = $query->fetchAll(); 

		if($data){
			$db = null; 

			return $data; 

		}
		else {
			throw new PDOException("No Permissions were found.");
		}
	}
	catch (PDOException $e){
		echo '{"error":{"text":"' . $e->getMessage() . '"}}';
	}


}

function getPermissionsByID($id){
	try{
		$db = getDatabase(); 

		$query = $db->prepare("SELECT ID, Name, Description FROM dbPermission WHERE ID = :id");

		$query->bindParam(':id', $id); 
		// $query->bindParam(':name', $name);
		// $query->bindParam(':description', $description); 

		$query->execute(); 
		$query->setFetchMode( PDO::FETCH_OBJ );
		$data = $query->fetchAll(); 

		if($data){
			$db = null; 

			return $data; 

		}
		else {
			throw new PDOException("No Permissions were found.");
		}
	}

	catch (PDOException $e){
		echo '{"error":{"text":"' . $e->getMessage() . '"}}';
	}
}




