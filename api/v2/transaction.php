<?php

/**
 * Include Database connection, makes our database available through the getDatabase() function.
 **/
include_once 'database.php';

/**
 * Get All Transactions
 **/

function getAllTransactions(){
    // sql calls to get all the items, then prepare a response
    // assign the response to a variable called $data
    // This "try" runs completely unless something gets "caught" by the "catch" portion below.
    try {
	$db = getDatabase(); // Creates a database connection (found in database.php), and returns the connection.
	$query = $db->prepare( "
  SELECT dbTransaction . * , dbCampus.campus_name, blame.First_Name AS Blame_First_Name, blame.Last_Name AS Blame_Last_Name, prime.First_Name AS Primary_First_Name, prime.Last_Name AS Primary_Last_Name
FROM dbTransaction
LEFT JOIN dbCampus ON dbCampus.ID = dbTransaction.Campus_ID
LEFT JOIN dbUser AS blame ON blame.ID = dbTransaction.Blame_ID
LEFT JOIN dbUser AS prime ON prime.ID = dbTransaction.Primary_User_ID" ); // Prepare an SQL statement to be performed on the database.  In this example we are choosing to return all fields (*) from the table titled dbItem
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
	    throw new PDOException("No transactions	 were found.");
	}
    }
    catch(PDOException $e) {
	 '{"error": {"text":"' . $e->getMessage() . '"}}';
    }
}

/**
 * Get Transaction By ID
 **/

function getTransactionsByID($id){
    try {
	$db = getDatabase(); // Creates a database connection (found in database.php), and returns the connection.
	$query = $db->prepare( "SELECT dbTransaction . * , dbCampus.campus_name, blame.First_Name AS Blame_First_Name, blame.Last_Name AS Blame_Last_Name, prime.First_Name AS Primary_First_Name, prime.Last_Name AS Primary_Last_Name
FROM dbTransaction
LEFT JOIN dbCampus ON dbCampus.ID = dbTransaction.Campus_ID
LEFT JOIN dbUser AS blame ON blame.ID = dbTransaction.Blame_ID
LEFT JOIN dbUser AS prime ON prime.ID = dbTransaction.Primary_User_ID WHERE dbTransaction.ID = :id" ); // Prepare an SQL statement to be performed on the database.  In this example we are choosing to return all fields (*) from the table WHERE the id is the var $id passed to the function
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
	    throw new PDOException("No transaction found with id: $id.");
	}
    }
    // Catches any thrown error in the try{}, and returns the error message in JSON form.
    catch(PDOException $e) {
	    echo '{"error": {"text":"' . $e->getMessage() . '"}}';
    }
}

/**
 * Get Transaction By User_ID
 **/

function getTransactionsByUser($Primary_User_ID){
    try {
	$db = getDatabase(); // Creates a database connection (found in database.php), and returns the connection.
	$query = $db->prepare( "SELECT dbTransaction . * , dbCampus.campus_name, blame.First_Name AS Blame_First_Name, blame.Last_Name AS Blame_Last_Name, prime.First_Name AS Primary_First_Name, prime.Last_Name AS Primary_Last_Name
FROM dbTransaction
LEFT JOIN dbCampus ON dbCampus.ID = dbTransaction.Campus_ID
LEFT JOIN dbUser AS blame ON blame.ID = dbTransaction.Blame_ID
LEFT JOIN dbUser AS prime ON prime.ID = dbTransaction.Primary_User_ID WHERE dbTransaction.Primary_User_ID = :Primary_User_ID" ); // Prepare an SQL statement to be performed on the database.  In this example we are choosing to return all fields (*) from the table WHERE the id is the var $id passed to the function
	$query->bindParam( ':Primary_User_ID', $Primary_User_ID );
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
	    throw new PDOException("No transactions found for user: " . $Primary_User_ID . ".");
	}
    }
    // Catches any thrown error in the try{}, and returns the error message in JSON form.
    catch(PDOException $e) {
	    echo '{"error": {"text":"' . $e->getMessage() . '"}}';
    }
}

/**
 * Get Transaction By Campus_ID
 **/

function getTransactionsByCampus($Campus_ID){
    try {
	$db = getDatabase(); // Creates a database connection (found in database.php), and returns the connection.
	$query = $db->prepare( "SELECT dbTransaction . * , dbCampus.campus_name, blame.First_Name AS Blame_First_Name, blame.Last_Name AS Blame_Last_Name, prime.First_Name AS Primary_First_Name, prime.Last_Name AS Primary_Last_Name
FROM dbTransaction
LEFT JOIN dbCampus ON dbCampus.ID = dbTransaction.Campus_ID
LEFT JOIN dbUser AS blame ON blame.ID = dbTransaction.Blame_ID
LEFT JOIN dbUser AS prime ON prime.ID = dbTransaction.Primary_User_ID WHERE dbTransaction.Campus_ID = :Campus_ID" ); // Prepare an SQL statement to be performed on the database.  In this example we are choosing to return all fields (*) from the table WHERE the id is the var $id passed to the function
	$query->bindParam( ':Campus_ID', $Campus_ID );
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
	    throw new PDOException("No transactions found for campus ID: " . $Primary_User_ID . ".");
	}
    }
    // Catches any thrown error in the try{}, and returns the error message in JSON form.
    catch(PDOException $e) {
	    echo '{"error": {"text":"' . $e->getMessage() . '"}}';
    }
}

/**
 * Get Transaction By Blame_ID
 **/

function getTransactionsByBlame($Blame_ID){
    try {
	$db = getDatabase(); // Creates a database connection (found in database.php), and returns the connection.
	$query = $db->prepare( "SELECT dbTransaction . * , dbCampus.campus_name, blame.First_Name AS Blame_First_Name, blame.Last_Name AS Blame_Last_Name, prime.First_Name AS Primary_First_Name, prime.Last_Name AS Primary_Last_Name
FROM dbTransaction
LEFT JOIN dbCampus ON dbCampus.ID = dbTransaction.Campus_ID
LEFT JOIN dbUser AS blame ON blame.ID = dbTransaction.Blame_ID
LEFT JOIN dbUser AS prime ON prime.ID = dbTransaction.Primary_User_ID WHERE dbTransaction.Blame_ID = :Blame_ID" ); // Prepare an SQL statement to be performed on the database.  In this example we are choosing to return all fields (*) from the table WHERE the id is the var $id passed to the function
	$query->bindParam( ':Blame_ID', $Blame_ID );
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
	    throw new PDOException("No transactions found for blame user: " . $Blame_ID . ".");
	}
    }
    // Catches any thrown error in the try{}, and returns the error message in JSON form.
    catch(PDOException $e) {
	    echo '{"error": {"text":"' . $e->getMessage() . '"}}';
    }
}

/**
 * Get Transaction By Date_Out
 **/

function getTransactionsByDateOut($Date_Out){
    try {
	$db = getDatabase(); // Creates a database connection (found in database.php), and returns the connection.
	$query = $db->prepare( "SELECT dbTransaction . * , dbCampus.campus_name, blame.First_Name AS Blame_First_Name, blame.Last_Name AS Blame_Last_Name, prime.First_Name AS Primary_First_Name, prime.Last_Name AS Primary_Last_Name
FROM dbTransaction
LEFT JOIN dbCampus ON dbCampus.ID = dbTransaction.Campus_ID
LEFT JOIN dbUser AS blame ON blame.ID = dbTransaction.Blame_ID
LEFT JOIN dbUser AS prime ON prime.ID = dbTransaction.Primary_User_ID WHERE dbTransaction.Date_Out = :Date_Out" ); // Prepare an SQL statement to be performed on the database.  In this example we are choosing to return all fields (*) from the table WHERE the id is the var $id passed to the function
	$query->bindParam( ':Date_Out', $Date_Out );
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
	    throw new PDOException("No transactions found for date: " . $Date_Out . ".");
	}
    }
    // Catches any thrown error in the try{}, and returns the error message in JSON form.
    catch(PDOException $e) {
	    echo '{"error": {"text":"' . $e->getMessage() . '"}}';
    }
}

 /**
 * Get Transaction By Date_Due
 **/

function getTransactionByDateDue($Date_Due){
    try {
	$db = getDatabase(); // Creates a database connection (found in database.php), and returns the connection.
	$query = $db->prepare( "SELECT dbTransaction . * , dbCampus.campus_name, blame.First_Name AS Blame_First_Name, blame.Last_Name AS Blame_Last_Name, prime.First_Name AS Primary_First_Name, prime.Last_Name AS Primary_Last_Name
FROM dbTransaction
LEFT JOIN dbCampus ON dbCampus.ID = dbTransaction.Campus_ID
LEFT JOIN dbUser AS blame ON blame.ID = dbTransaction.Blame_ID
LEFT JOIN dbUser AS prime ON prime.ID = dbTransaction.Primary_User_ID WHERE dbTransaction.Date_Due = :Date_Due" ); // Prepare an SQL statement to be performed on the database.  In this example we are choosing to return all fields (*) from the table WHERE the id is the var $id passed to the function
	$query->bindParam( ':Date_Due', $Date_Due );
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
	    throw new PDOException("No transactions found for date: " . $Date_Out . ".");
	}
    }
    // Catches any thrown error in the try{}, and returns the error message in JSON form.
    catch(PDOException $e) {
	    echo '{"error": {"text":"' . $e->getMessage() . '"}}';
    }
}

/**
 * Add Transaction
 **/

function addTransaction ($ID=0, $Primary_User_ID, $Campus_ID, $Blame_ID, $Date_Out, $Date_Due) {
    try {
	$db = getDatabase();
	$query = $db->prepare( "INSERT INTO  dbTransaction (ID , Primary_User_ID, Campus_ID, Blame_ID, Date_Out, Date_Due) VALUES (NULL , :Primary_User_ID, :Campus_ID, :Blame_ID, :Date_Out, :Date_Due)" );
	$query->bindParam( ':Primary_User_ID', $Primary_User_ID);
	$query->bindParam( ':Campus_ID', $Campus_ID);
	$query->bindParam( ':Blame_ID', $Blame_ID);
	$query->bindParam( ':Date_Out', $Date_Out);
	$query->bindParam( ':Date_Due', $Date_Due);
	$query->setFetchMode( PDO::FETCH_OBJ );

	if ( $query->execute() ) {
	    // Create a success response, and echo the message back, and reset the database.
	    $response = '{"success":{"text":"Added Transaction Successfully." }}';

	    $db = null;
	    echo $response;
	}
	else {
	    // This is how you generate a custom error message, below in the "catch" portion of our try, we will echo out these errors if any were created.
	    throw new PDOException("Transaction was not created");
	}
    }

    catch(PDOException $e) {
	echo '{"error": {"text":"' . $e->getMessage() . '"}}';
    }
}


/**
 * Edit Transaction
 * */

function editTransaction($ID, $Primary_User_ID, $Campus_ID, $Blame_ID, $Date_Out, $Date_Due) {
    try {
	$db = getDatabase();
	$query = $db->prepare( "UPDATE dbTransaction SET Primary_User_ID = :Primary_User_ID, Campus_ID = :Campus_ID, Blame_ID = :Blame_ID, Date_Out = :Date_Out, Date_Due = :Date_Due WHERE ID= :id" );
	$query->bindParam( ':id', $ID  );
	$query->bindParam( ':Primary_User_ID', $Primary_User_ID);
	$query->bindParam( ':Campus_ID', $Campus_ID);
	$query->bindParam( ':Blame_ID', $Blame_ID);
	$query->bindParam( ':Date_Out', $Date_Out);
	$query->bindParam( ':Date_Due', $Date_Due);
	$query->setFetchMode( PDO::FETCH_OBJ );

	if ( $query->execute() ) {
	    $response = '{"success":{"text":"Transaction Edited Successfully." }}';

	    $db = null;
	    echo $response;
	}

	else {
	    throw new PDOException("Transaction could not be edited.");
	}

    }

    catch(PDOException $e) {
	echo '{"error": {"text":"' . $e->getMessage() . '"}}';
    }
}

/**
 * Delete Transaction
 **/

function deleteTransaction($id){
    try {
	$db = getDatabase();
	$query = $db->prepare( "DELETE FROM dbTransaction WHERE ID=:id" );
	$variables = Array();

	//parse_str ( file_get_contents('php://input'), $variables );
	//$itemid = $variables[ÔitemidÕ];

	$query->bindParam( ':id', $id);

	if ( $query->execute() ) {
		$response = '{"success":{"text":"Deleted Transaction Successfully." }}';
		$db = null;
		echo $response;
	}
	else {
		throw new PDOException("Transaction could not be added.");
	}
    }
    catch(PDOException $e) {
	echo '{"error": {"text":"' . $e->getMessage() . '"}}';
    }
}

?>