<?php

function getPermissionsForUser( $id ) {

  //sql calls to save an item, then prepare a response
  // This "try" runs completely unless something gets "caught" by the "catch" portion below.
  try {
    $db = getDatabase(); // Creates a database connection (found in database.php), and returns the connection.
    $query = $db->prepare( "
      SELECT dbUser_Permission.*,
      user.First_Name as User_First_Name,
      user.Last_Name as User_Last_Name,
      user.NetID as User_NetID,
      blame.First_Name as Blame_First_Name,
      blame.Last_Name as Blame_Last_Name,
      blame.NetID as Blame_NetID,
      dbPermission.Name as Permission_Name,
      dbPermission.Description as Permission_Description
      FROM dbUser_Permission
      LEFT JOIN dbUser as user
      ON user.ID = dbUser_Permission.User_ID
      LEFT JOIN dbUser as blame
      ON blame.ID = dbUser_Permission.Blame_ID
      LEFT JOIN dbPermission
      ON dbPermission.ID = dbUser_Permission.Permission_ID
      WHERE dbUser_Permission.User_ID = :id" );

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
      throw new PDOException("Could not receive Permission information for userID: $id");
    }
  }
  // Catches any thrown error in the try{}, and returns the error message in JSON form.
  catch(PDOException $e) {
    echo '{"error": {"text":"' . $e->getMessage() . '"}}';
  }

}