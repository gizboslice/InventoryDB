<?php
/**
* Various functionality Includes
* Include a file per "area" of the app
**/

header( "Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

include_once "items.php";

include_once "campus.php";

include_once "permissions.php";

include_once "status.php";

include_once "strikes.php";

include_once "transaction.php";

include_once "categories.php";

include_once "users.php";

include_once "packages.php";

include_once "user_strike.php";

include_once "user_permission.php";

include_once "transaction_user.php";

include_once "transaction_item.php";

include_once "package_item.php";

include_once "MacAddress.php"; 




/**
*
* 	Fake API Functionality -- listening for a request var called "operation"
*	telling the file which function to run...return items, save an item, etc.
*	A sample URL would be something like http://inventorydb.digitalmediauconn.org/sample-operations-file.php?operation=getAllItems
*
**/

if(isset($_REQUEST['operation'])){

/*
 *
 * use the switch block to establish functionality for
 * each operation you think may be required.
 * create a new function below, called in this switch block
 * $_REQUEST['operation'] is a required variable that must be passed to the file, see the sample URL above.
 *
 **/
	switch ($_REQUEST['operation']){

		/**
		* Category Calls
		* dbCategory
		*/
		case "editCategory":
			prepareResponse(editCategory($_POST['id'], $_POST['parent_id'], $_POST['name'], $_POST['resource_text'], $_POST['image_link'], $_POST['description'])); //add params as needed
		break;

		case 'getCategories':
			prepareResponse(getCategories());
		break;

		case 'getCategoryByID':
			prepareResponse( getCategoryByID( $_GET['id'] ) );
		break;

		case 'deleteCategory':
			prepareResponse(deleteCategory($_POST['id']));
		break;

		case 'addCategory':
			prepareResponse(addCategory($_POST['id'], $_POST['parent_id'], $_POST['name'], $_POST['resource_text'], $_POST['image_link'], $_POST['description']));



		/**
		* User Calls
		* dbUser
		*/
		case "getUsers":
			prepareResponse(getUsers());
		break;

		case "getUserByID":
			prepareResponse( getUserByID( $_GET['id'] ) );
		break;

		case "editUser":
			prepareResponse(editUser($_POST['id'], $_POST['first_name'], $_POST['last_name'], $_POST['email_primary'], $_POST['email_secondary'], $_POST['phone_primary'], $_POST['mag_stripe'], $_POST['prox_id'], $_POST['affil'], $_POST['campus_id'], $_POST['netid'], $_POST['level'])); //add params as needed
		break;

		case 'deleteUser':
			prepareResponse(deleteUser($_POST['id']));
		break;

		case 'addUser':
			prepareResponse(addUser($_POST['id'], $_POST['first_name'], $_POST['last_name'], $_POST['email_primary'], $_POST['email_secondary'], $_POST['phone_primary'], $_POST['mag_stripe'], $_POST['prox_id'], $_POST['affil'], $_POST['campus_id'], $_POST['netid'], $_POST['level'])); //add params as needed
		break;



		/**
		* Mac Address Calls
		* dbMac_Address
		*/
		case "getMacForItem": 
			prepareResponse(getMacForItem($_GET['itemId'], $_GET['macNum']));
		break; 

		case "addMacForItem":
			prepareResponse(addMacForItem($_POST['itemId'], $_POST['macNum'], $_POST['macAddress']));
		break; 

		case "deleteMacAddress": 
			prepareResponse(deleteMacAddress($_POST['itemId'], $_POST['macNum']));
		break; 

		case "editMacAddress":
			prepareResponse(editMacAddress($_POST['itemId'], $_POST['macNum'], $_POST['macAddress']));
		break;



		/**
		* Campus Calls
		* dbCampus
		*/
		case 'getAllCampus':
			prepareResponse(getAllCampus());
		break;

		case 'addCampus':
			prepareResponse(addCampus($_POST['campus']));
		break;

		case 'editCampus':
			$id = $_REQUEST['id'];
			prepareResponse(editCampus($id, $_POST['campus']));
		break;

		case 'deleteCampus':
			$id = $_POST['id'];
			prepareResponse(deleteCampus($id));
		break;

		case 'getCampusById':
			$id = $_REQUEST['id'];
			prepareResponse(getCampusById($id));
		break;



		/**
		* Item Calls
		* dbItem
		*/
		case 'getAllItems':
			prepareResponse(getAllItems());
		break;

		case 'getItemById':
			$id = $_REQUEST['id'];
			prepareResponse(getItemById($id));
		break;

		case 'getItemsByCategory':
			prepareResponse(getItemsByCategory($_GET['cat_id']));
		break;

		case 'getItemsByStatus':
			prepareResponse( getItemsByStatus( $_GET['status_id'] ));
		break;

		case 'addItem':
			prepareResponse(addItem($_POST['id'], $_POST['name'], $_POST['description'], $_POST['barcode'], $_POST['serial'], $_POST['purchasePrice'], $_POST['purchaseDate'], $_POST['reseller'], $_POST['resellerPartNum'], $_POST['manPartNumber'], $_POST['notes'], $_POST['photoURL'], $_POST['manufacturer'], $_POST['modelNumber'], $_POST['ucTag'], $_POST['macTF'], $_POST['campusID'], $_POST['building'], $_POST['roomNum'], $_POST['statusID'], $_POST['currentCondit'], $_POST['catID'], $_POST['flagged'] ));
		break;

		case 'editItem':
			prepareResponse(editItem($_POST['id'], $_POST['name'], $_POST['description'], $_POST['barcode'], $_POST['serial'], $_POST['purchasePrice'], $_POST['purchaseDate'], $_POST['reseller'], $_POST['resellerPartNum'], $_POST['manPartNumber'], $_POST['notes'], $_POST['photoURL'], $_POST['manufacturer'], $_POST['modelNumber'], $_POST['ucTag'], $_POST['macTF'], $_POST['campusID'], $_POST['building'], $_POST['roomNum'], $_POST['statusID'], $_POST['currentCondit'], $_POST['catID'], $_POST['flagged'] ));
		break;

		case 'deleteItem':
			prepareResponse(deleteItem($_POST['id']));
		break;



		/**
		* Status Calls
		* dbStatus
		*/
		case "addStatus":
			$name = $_POST['name'];
			prepareResponse( addStatus( $name ) );
		break;

		case "editStatus":
			$id = $_POST['id'];
			$name = $_POST['name'];
			prepareResponse( editStatus( $id, $name ) );
		break;

		case "getAllStatuses":
			prepareResponse( getAllStatuses() );
		break;

		case "deleteStatus":
			$id = $_POST['id'];
			prepareResponse( deleteStatus( $id ) );
		break;

		case "getStatusByID":
			$id = $_GET['id'];
			prepareResponse( getStatusByID( $id ) );
		break;



		/**
		* Permission Calls
		* dbPermission
		*/
		case"addPermissions":
			prepareResponse(addPermissions($_POST['id'], $_POST['name'], $_POST['description']));
		break;

		case "editPermissions":
			prepareResponse(editPermissions($_REQUEST['id'], $_POST['name'], $_POST['description']));
		break;

		case "deletePermissions":
			prepareResponse(deletePermissions($_POST['id']));
		break;

		case "getPermissions":
			prepareResponse(getPermissions());
		break;

		case "getPermissionsByID":
			prepareResponse(getPermissions($_GET['id']));
		break;



		/**
		* Strike Calls
		* dbStrike
		*/
		case "addStrike":
			prepareResponse( addStrike( $_POST['id'], $_POST['strike_name'] ) );
		break;

		case "editStrike":
			prepareResponse( editStrike( $_POST['id'], $_POST['strike_name'] ) );
		break;

		case "getAllStrike":
			prepareResponse( getAllStrike() );
		break;

		case "deleteStrike":
			prepareResponse( deleteStrike( $_POST['id'] ) );
		break;

		case "getStrikeById":
			prepareResponse( getStrikeById( $_GET['id'] ) );
		break;



		/**
		* Transaction Calls
		* dbTransaction
		*/
		case "addTransaction":
			$out = $_REQUEST['Date_Out'];
			$due = $_REQUEST['Date_Due'];
			prepareResponse(addTransaction($_REQUEST['ID'], $_POST['Primary_User_ID'], $_POST['Campus_ID'], $_POST['Blame_ID'], $out, $due));
		break;

		case "editTransaction":
			prepareResponse(editTransaction($_REQUEST['ID'], $_POST['Primary_User_ID'], $_POST['Campus_ID'], $_POST['Blame_ID'], $_POST['Date_Out'], $_POST['Date_Due']));
		break;

		case "getAllTransactions":
			prepareResponse(getAllTransactions());
		break;

		case "getTransactionsByID":
			$id = $_REQUEST['ID'];
			prepareResponse(getTransactionsByID($id));
		break;

		case "getTransactionsByUser":
			$Primary_User_ID = $_REQUEST['Primary_User_ID'];
			prepareResponse(getTransactionsByUser($Primary_User_ID));
		break;

		case "getTransactionsByCampus":
			$Campus_ID = $_REQUEST['Campus_ID'];
			prepareResponse(getTransactionsByCampus($Campus_ID));
		break;

		case "getTransactionsByBlame":
			$Blame_ID = $_REQUEST['Blame_ID'];
			prepareResponse(getTransactionsByBlame($Blame_ID));
		break;

		case "getTransactionsByDateOut":
			$Date_Out = $_REQUEST['Date_Out'];
			prepareResponse(getTransactionsByDateOut($Date_Out));
		break;

		case "getTransactionByDateDue":
			$Date_Due = $_REQUEST['Date_Due'];
			prepareResponse(getTransactionByDateDue($Date_Due));
		break;

		case "deleteTransaction":
			$id = $_POST['ID'];
			prepareResponse(deleteTransaction($id));
		break;



		/**
		* Package Calls
		* dbPackage
		*/
		case "addPackages":
			prepareResponse(addPackages($_REQUEST['id'], $_POST['name'], $_POST['intake_date'], $_POST['blameID']));
		break;

		case "editPackages":
			prepareResponse(editPackages($_POST['id'], $_POST['name'], $_POST['intake_date'], $_POST['blameID']));
		break;

		case "deletePackage":
			prepareResponse(deletePackage($_POST['id']));
		break;

		case "getAllPackages":
			prepareResponse(getAllPackages());
		break;

		case "getPackageByID":
			prepareResponse(getPackageByID($_GET['id']));
		break;



		/**
		* User Strike Calls
		* dbUser_Strike
		*/
		case "getStrikesForUser":
			prepareResponse( getStrikesForUser( $_GET['id'] ));
		break;



		/**
		* User Permission Calls
		* dbUser_Permission
		*/
		case "getPermissionsForUser":
			prepareResponse( getPermissionsForUser( $_GET['id'] ));
		break;



		/**
		* Transaction User Calls
		* dbTransaction_USer
		*/
		case "getUsersForTransaction":
			prepareResponse( getUsersForTransaction( $_GET['id'] ));
		break;



		/**
		* Transaction Item Calls
		* dbTransaction_Item
		*/
		case "getItemsInTransaction":
			prepareResponse( getItemsInTransaction( $_GET['id'] ));
		break;

		case "getTransactionsForItem":
			prepareResponse( getTransactionsForItem( $_GET['id'] ));
		break;



		/**
		* Package Item Calls
		* dbPackage_Item
		*/
		case "getItemsInPackage":
			prepareResponse( getItemsInPackage( $_GET['id'] ));
		break;

		case "getPackagesForItem":
			prepareResponse( getPackagesForItem( $_GET['id'] ));
		break;

		case "addItemToPackage":
			$package 	= $_POST['package_id'];
			$item 		= $_POST['item_id'];
			$blame 		= $_POST['blame_id'];
			prepareResponse( addItemToPackage( $package, $item, $blame ) );
		break;

	}

}


/** The function for actually spitting out the content to be returned to the page. -- should be called by the functions above and certainly tailored to be a bit more thorough. **/
function prepareResponse($data){
	// do something with the $data variable, like create a JSON object. then echo it out. Include some sort of message indicating the result!
	echo json_encode( $data );
}