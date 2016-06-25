<?php

function getUsersForTransaction( $id ) {

  //sql calls to save an item, then prepare a response
  // This "try" runs completely unless something gets "caught" by the "catch" portion below.
  try {
    $db = getDatabase(); // Creates a database connection (found in database.php), and returns the connection.
    $query = $db->prepare( "
      SELECT dbTransaction_User.Transaction_ID,
      dbTransaction_User.User_ID as Secondary_User_ID,
      PrimaryUser.ID as Primary_User_ID,
      PrimaryUser.First_Name as Primary_User_First_Name,
      PrimaryUser.Last_Name as Primary_User_Last_Name,
      PrimaryUser.NetID as Primary_User_NetID,
      SecondaryUser.First_Name as Secondary_User_First_Name,
      SecondaryUser.Last_Name as Secondary_User_Last_Name,
      SecondaryUser.NetID as Secondary_User_NetID,
      dbCampus.campus_name
      FROM dbTransaction_User
      LEFT JOIN dbTransaction
        LEFT JOIN dbCampus
        ON dbCampus.ID = dbTransaction.Campus_ID
        LEFT JOIN dbUser as PrimaryUser
        ON PrimaryUser.ID = dbTransaction.Primary_User_ID
      ON dbTransaction.ID = dbTransaction_User.Transaction_ID
      LEFT JOIN dbUser as SecondaryUser
      ON SecondaryUser.ID = dbTransaction_User.User_ID
      WHERE dbTransaction_User.Transaction_ID = :id" );

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
      throw new PDOException("Could not retrieve users for transactionID: $id");
    }
  }
  // Catches any thrown error in the try{}, and returns the error message in JSON form.
  catch(PDOException $e) {
    echo '{"error": {"text":"' . $e->getMessage() . '"}}';
  }

}