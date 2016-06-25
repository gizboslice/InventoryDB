<?php

function getItemsInTransaction( $id ) {

  //sql calls to save an item, then prepare a response
  // This "try" runs completely unless something gets "caught" by the "catch" portion below.
  try {
    $db = getDatabase(); // Creates a database connection (found in database.php), and returns the connection.
    $query = $db->prepare( "
      SELECT dbTransaction_Item.*,
      dbItem.ID as Item_ID,
      dbItem.Name as Item_Name,
      dbItem.Description as Item_Description,
      dbItem.Barcode as Item_Barcode,
      dbItem.Serial as Item_Serial,
      dbItem.PurchasePrice as Item_Purchase_Price,
      dbItem.Reseller as Item_Reseller,
      dbItem.Reseller_Part_Number as Item_Reseller_Part_Number,
      dbItem.Notes as Item_Notes,
      dbItem.Photo_URL as Item_Photo_URL,
      dbItem.Manufacturer as Item_Manufacturer,
      dbItem.Model_Number as Item_Model_Number,
      dbItem.UC_Tag as Item_UC_Tag,
      dbItem.MAC_TF as Item_MAC_TF,
      dbItem.Campus_ID as Item_Campus_ID,
      dbItem.Building as Item_Building,
      dbItem.Room_Number as Item_Room_Number,
      dbItem.Status_ID as Item_Status_ID,
      dbItem.Current_Condition as Item_Current_Condition,
      dbItem.Category_ID as Item_Category_ID,
      dbItem.Flagged as Item_Flagged,
      dbCampus.campus_name as Item_Campus_Name,
      dbStatus.Status_Name as Item_Status_Name,
      dbCategory.Name as Item_Category_Name
      FROM dbTransaction_Item
      LEFT JOIN dbItem
        LEFT JOIN dbCampus
        ON dbCampus.ID = dbItem.Campus_ID
        LEFT JOIN dbStatus
        ON dbStatus.ID = dbItem.Status_ID
        LEFT JOIN dbCategory
        ON dbCategory.ID = dbItem.Category_ID
      ON dbItem.ID = dbTransaction_Item.Item_ID
      WHERE dbTransaction_Item.Transaction_ID = :id
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
      throw new PDOException("Could not retrieve items for transactionID: $id");
    }
  }
  // Catches any thrown error in the try{}, and returns the error message in JSON form.
  catch(PDOException $e) {
    echo '{"error": {"text":"' . $e->getMessage() . '"}}';
  }

}



function getTransactionsForItem( $id ) {

  //sql calls to save an item, then prepare a response
  // This "try" runs completely unless something gets "caught" by the "catch" portion below.
  try {
    $db = getDatabase(); // Creates a database connection (found in database.php), and returns the connection.
    $query = $db->prepare( "
      SELECT dbTransaction_Item.*,
      dbTransaction.Campus_ID as Transaction_Campus_ID,
      dbTransaction.Primary_User_ID as Transaction_User_ID,
      dbTransaction.Blame_ID as Transaction_Blame_ID,
      dbTransaction.Date_Out as Transaction_Date_Out,
      dbTransaction.Date_Due as Transaction_Date_Due,
      PrimaryUser.First_Name as Primary_User_First_Name,
      PrimaryUser.Last_Name as Primary_User_Last_Name,
      PrimaryUser.NetID as Primary_User_NetID,
      PrimaryUser.Level as Primary_User_Level,
      PrimaryUser.Email_Primary as Primary_User_Email_Primary,
      BlameUser.First_Name as Blame_User_First_Name,
      BlameUser.Last_Name as Blame_User_Last_Name,
      BlameUser.NetID as Blame_User_NetID,
      BlameUser.Level as Blame_User_Level,
      BlameUser.Email_Primary as Blame_User_Email_Primary,
      dbCampus.campus_name as Item_Campus_Name
      FROM dbTransaction_Item
      LEFT JOIN dbTransaction
        LEFT JOIN dbCampus
        ON dbCampus.ID = dbTransaction.Campus_ID
        LEFT JOIN dbUser as PrimaryUser
        ON PrimaryUser.ID = dbTransaction.Primary_User_ID
        LEFT JOIN dbUser as BlameUser
        ON BlameUser.ID = dbTransaction.Blame_ID
      ON dbTransaction.ID = dbTransaction_Item.Transaction_ID
      WHERE dbTransaction_Item.Item_ID = :id
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
      throw new PDOException("Could not retrieve items for transactionID: $id");
    }
  }
  // Catches any thrown error in the try{}, and returns the error message in JSON form.
  catch(PDOException $e) {
    echo '{"error": {"text":"' . $e->getMessage() . '"}}';
  }

}