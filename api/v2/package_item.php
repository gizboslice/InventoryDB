<?php

function getItemsInPackage( $id ) {

  //sql calls to save an item, then prepare a response
  // This "try" runs completely unless something gets "caught" by the "catch" portion below.
  try {
    $db = getDatabase(); // Creates a database connection (found in database.php), and returns the connection.
    $query = $db->prepare( "
      SELECT dbPackage_Item.*,
      dbItem.Name as Item_Name,
      dbItem.Description as Item_Description,
      dbItem.Barcode as Item_Barcode,
      dbItem.Notes as Item_Notes,
      dbItem.Photo_URL as Item_Photo_URL,
      dbItem.Building as Item_Building,
      dbItem.Room_Number as Item_Room_Number,
      dbItem.Status_ID as Item_Status_ID,
      dbItem.Campus_ID as Item_Campus_ID,
      dbItem.Current_Condition as Item_Current_Condition,
      dbItem.Category_ID as Item_Category_ID,
      dbItem.Current_Condition as Item_Current_Condition,
      dbItem.Flagged as Item_Flagged,
      dbStatus.Status_Name as Item_Status_Name,
      dbCampus.campus_name as Item_Campus_Name,
      dbCategory.Name as Item_Category_Name,
      dbCategory.Description as Item_Category_Description
      FROM dbPackage_Item
      LEFT JOIN dbItem
        LEFT JOIN dbStatus
        ON dbStatus.ID = dbItem.Status_ID
        LEFT JOIN dbCampus
        ON dbCampus.ID = dbItem.Campus_ID
        LEFT JOIN dbCategory
        ON dbCategory.ID = dbItem.Category_ID
      ON dbItem.ID = dbPackage_Item.Item_ID
      WHERE dbPackage_Item.Package_ID = :id
      " );

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
      throw new PDOException("Could not retrieve items for packageID: $id");
    }
  }
  // Catches any thrown error in the try{}, and returns the error message in JSON form.
  catch(PDOException $e) {
    return '{"error": {"text":"' . $e->getMessage() . '"}}';
  }

}



function getPackagesForItem( $id ) {

  //sql calls to save an item, then prepare a response
  // This "try" runs completely unless something gets "caught" by the "catch" portion below.
  try {
    $db = getDatabase(); // Creates a database connection (found in database.php), and returns the connection.
    $query = $db->prepare( "
      SELECT dbPackage_Item.*,
      dbPackage.Name as Package_Name,
      dbPackage.AddDate as Package_Add_Date,
      dbPackage.BlameID as Package_Blame_ID,
      dbUser.First_Name as Package_Blame_First_Name,
      dbUser.Last_Name as Package_Blame_Last_Name,
      dbUser.NetID as Package_Blame_NetID
      FROM dbPackage_Item
      LEFT JOIN dbPackage
        LEFT JOIN dbUser
        ON dbUser.ID = dbPackage.BlameID
      ON dbPackage.ID = dbPackage_Item.Package_ID
      WHERE dbPackage_Item.Item_ID = :id
      " );

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
      throw new PDOException("Could not retrieve packages for ItemID: $id");
    }
  }
  // Catches any thrown error in the try{}, and returns the error message in JSON form.
  catch(PDOException $e) {
    return '{"error": {"text":"' . $e->getMessage() . '"}}';
  }

}



function addItemToPackage( $packageID, $itemID, $blameID ) {

  try {
    $db = getDatabase();
    $query = $db->prepare( "INSERT INTO dbPackage_Item ( Package_ID, Item_ID, Date, Blame_ID ) VALUES ( :package_id, :item_id, :date, :blame_id ) ON DUPLICATE KEY UPDATE Package_ID = Package_ID" );

    $curr_date = date('Y-m-d');
    $query->bindParam(':package_id', $packageID );
    $query->bindParam(':item_id', $itemID);
    $query->bindParam(':date', $curr_date); 
    $query->bindParam(':blame_id', $blameID);
    //$query->setFetchMode( PDO::FETCH_OBJ );
    // Run a process if our data set isn't empty.
  
    if ( $query->execute() ) {
    // Create a success response, and echo the message back, and reset the database.
      $response = '{"success":{"text":"Saved Item to Package Successfully." }}';
    
      $db = null;
      echo $response;
    }
    // Run something if the query failed.
    else {
    // This is how you generate a custom error message, below in the "catch" portion of our try, we will echo out these errors if any were created.
      throw new PDOException("Item $itemID could not be added to package $packageID.");
    }
  }
 
  catch(PDOException $e) {
    echo '{"error": {"text":"' . $e->getMessage() . '"}}';
  }

}