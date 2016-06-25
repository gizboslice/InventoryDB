# InventoryDB

Development of the new inventory system for the Digital Media Department.

## API

The most recent version of the API lives within the `api/v2/` directory.

Requests begin with `http://inventorydb.digitalmediauconn.org/api/v2/sample-operations-file.php?operation=` followed by the operation call below, and then any parameters necessary to pass to the operation.

## Table of Contents

1. [Categories](#categories)
1. [Users](#users)
1. [Mac Addresses](#mac-addresses)
1. [Campuses](#campuses)
1. [Items](#items)
1. [Statuses](#statuses)
1. [Permissions](#permissions)
1. [Strikes](#strikes)
1. [Transactions](#transactions)
1. [Packages](#packages)
1. [User Strike Relationships](#user-strike-relationships)
1. [User Permission Relationships](#user-permission-relationships)
1. [Transaction User Relationships](#transaction-user-relationships)
1. [Transaction Item Relationships](#transaction-item-relationships)
1. [Package Item Relationships](#package-item-relationships)

Current operations are as follows:

----
### <a name="categories"></a>Categories

`editCategory` - POST

*Parameters*

1. `id` => Category ID
1. `parent_id` => Category Parent ID (if any)
1. `name` => Category Name
1. `resource_text` => Category Resource Information
1. `image_link` => Link to Category Image
1. `Description` => Category Description

--
`getCategories` - GET

*Parameters*

1. None

--
`getCategoryByID` - GET

*Parameters*

1. `id` => Category ID

--
`deleteCategory` - POST

*Parameters*

1. `id` => Category ID

--
`addCategory` - POST

*Parameters*

1. `id` => Category ID
1. `parent_id` => Category Parent ID (if any)
1. `name` => Category Name
1. `resource_text` => Category Resource Information
1. `image_link` => Link to Category Image
1. `Description` => Category Description

----
### <a name="users"></a>Users

`getUsers` - GET

*Parameters*

None

--
`getUserByID` - GET

*Parameters*

1. `id` => User ID

--
`editUser` - POST

*Parameters*

1. `id` => User ID
1. `first_name` => User First Name
1. `last_name` => User Last Name
1. `email_primary` => User Primary Email
1. `email_secondary` => User Secondary Email
1. `phone_primary` => User Primary Phone Number
1. `mag_stripe` => User Mag Stripe ID
1. `prox_id` => User Proximity ID
1. `affil` => User Affiliation
1. `campus_id` => User Campus ID
1. `netid` => User NetID
1. `level` => User Level

--
`deleteUser` - POST

*Parameters*

1. `id` => User ID

--
`addUser` - POST

*Parameters*

1. `id` => User ID
1. `first_name` => User First Name
1. `last_name` => User Last Name
1. `email_primary` => User Primary Email
1. `email_secondary` => User Secondary Email
1. `phone_primary` => User Primary Phone Number
1. `mag_stripe` => User Mag Stripe ID
1. `prox_id` => User Proximity ID
1. `affil` => User Affiliation
1. `campus_id` => User Campus ID
1. `netid` => User NetID
1. `level` => User Level

----
### <a name="mac-addresses"></a>Mac Addresses

`getMacForItem` - GET

*Parameters*

1. `itemId` => Item ID
1. `macNum` => Item Mac Address Number (not the address itself)

--
`addMacForItem` - POST

*Parameters*

1. `itemId` => Item ID
1. `macNum` => Item Mac Address Number (not the address itself)
1. `macAddress` => Item Mac Address

--
`deleteMacAddress` - POST

*Parameters*

1. `itemId` => Item ID
1. `macNum` => Item Mac Address Number (not the address itself)

--
`editMacAddress` - POST

*Parameters*

1. `itemId` => Item ID
1. `macNum` => Item Mac Address Number (not the address itself)
1. `macAddress` => Item Mac Address

----
### <a name="campuses"></a>Campuses

`getAllCampus` - GET

*Parameters*

None

--
`addCampus` - POST

*Parameters*

1. `campus` => Campus Name

--
`editCampus` - POST

*Parameters*

1. `id` => Campus ID
1. `campus` => Campus Name

--
`deleteCampus` - POST

*Parameters*

1. `id` => Campus ID

--
`getCampusById` - GET

*Parameters*

1. `id` => Campus ID

----
### <a name="items"></a>Items

`getAllItems` - GET

*Parameters*

None

--
`getItemById` - GET

*Parameters*

1. `id` => Item ID

--
`getItemsByCategory` - GET

*Parameters*

1. `cat_id` => Item Category ID

--
`getItemsByStatus` - GET

*Parameters*

1. `status_id` - Item Status ID

--
`addItem` - POST

*Parameters*

1. `id` => Item ID
1. `name` => Item Name
1. `description` => Item Description
1. `barcode` => Item Barcode
1. `serial` => Item Serial Number
1. `purchasePrice` => Item Purchase Price
1. `purchaseDate` => Item Purchase Date
1. `reseller` => Item Reseller
1. `resellerPartNum` => Item Reseller Part Number
1. `manPartNumber` => Item Manufacturer Part Number
1. `notes` => Item Notes
1. `photoURL` => Item Photo URL
1. `manufacturer` => Item Manufacturer
1. `modelNumber` => Item Model Number
1. `ucTag` => Item UConn Tag
1. `macTF` => Item Mac Address (True/False) (1/0)
1. `campusID` => Item Campus ID
1. `building` => Item Building
1. `roomNum` => Item Room Number
1. `statusID` => Item Status ID
1. `currentCondit` => Item Current Condition
1. `catID` => Item Category ID
1. `flagged` => Item Flagged (True/False) (1/0)

--
`editItem` - POST

*Parameters*

1. `id` => Item ID
1. `name` => Item Name
1. `description` => Item Description
1. `barcode` => Item Barcode
1. `serial` => Item Serial Number
1. `purchasePrice` => Item Purchase Price
1. `purchaseDate` => Item Purchase Date
1. `reseller` => Item Reseller
1. `resellerPartNum` => Item Reseller Part Number
1. `manPartNumber` => Item Manufacturer Part Number
1. `notes` => Item Notes
1. `photoURL` => Item Photo URL
1. `manufacturer` => Item Manufacturer
1. `modelNumber` => Item Model Number
1. `ucTag` => Item UConn Tag
1. `macTF` => Item Mac Address (True/False) (1/0)
1. `campusID` => Item Campus ID
1. `building` => Item Building
1. `roomNum` => Item Room Number
1. `statusID` => Item Status ID
1. `currentCondit` => Item Current Condition
1. `catID` => Item Category ID
1. `flagged` => Item Flagged (True/False) (1/0)


--
`deleteItem` - POST

*Parameters*

1. `id` => Item ID


----
### <a name="statuses"></a>Statuses

`addStatus` - POST

*Parameters*

1. `name` => Status Name

--
`editStatus` - POST

*Parameters*

1. `id` => Status ID
1. `name` => Status Name

--
`getAllStatuses` - GET

*Parameters*

None

--
`deleteStatus` - POST

*Parameters*

1. `id` => Status ID

--
`getStatusByID` - GET

*Parameters*

1. `id` => Status ID


----
### <a name="permissions"></a>Permissions

`addPermissions` - POST

*Parameters*

1. `id` => Permission ID
1. `name` => Permission Name
1. `description` => Permission Description

--
`editPermissions` - POST

*Parameters*

1. `id` => Permission ID
1. `name` => Permission Name
1. `description` => Permission Description

--
`deletePermissions` - POST

*Parameters*

1. `id` => Permission ID

--
`getPermissions` - GET

*Parameters*

None

--
`getPermissionsByID` - GET

*Parameters*

1. `id` => Permission ID

----
### <a name="strikes"></a>Strikes

`addStrike` - POST

*Parameters*

1. `id` => Strike ID
1. `strike_name` => Strike Name

--
`editStrike` - POST

*Parameters*

1. `id` => Strike ID
1. `strike_name` => Strike Name

--
`getAllStrike` - GET

*Parameters*

None

--
`deleteStrike` - POST

*Parameters*

1. `id` => Strike ID

--
`getStrikeById` - GET

*Parameters*

1. `id` => Strike ID

----
### <a name="transactions"></a>Transactions

`addTransaction` - POST

*Parameters*

1. `ID` => Transaction ID
1. `Primary_User_ID` => Transaction Primary User ID
1. `Campus_ID` => Transaction Campus ID
1. `Blame_ID` => Transaction Blame User ID
1. `Date_Out` => Transaction Date Out
1. `Date_Due` => Transaction Due Date

--
`editTransaction` - POST

*Parameters*

1. `ID` => Transaction ID
1. `Primary_User_ID` => Transaction Primary User ID
1. `Campus_ID` => Transaction Campus ID
1. `Blame_ID` => Transaction Blame User ID
1. `Date_Out` => Transaction Date Out
1. `Date_Due` => Transaction Due Date

--
`getAllTransactions` - GET

*Parameters*

None

--
`getTransactionsByID` - GET

*Parameters*

1. `ID` => Transaction ID

--
`getTransactionsByUser` - GET

*Parameters*

1. `Primary_User_ID` => Transaction Primary User ID

--
`getTransactionsByCampus` - GET

*Parameters*

1. `Campus_ID` => Transaction Campus ID

--
`getTransactionsByBlame` - GET

*Parameters*

1. `Blame_ID` => Transaction Blame User ID

--
`getTransactionsByDateOut` - GET

*Parameters*

1. `Date_Out` => Transaction Date Out

--
`getTransactionsByDateDue` - GET

*Parameters*

1. `Date_Due` => Transaction Due Date

--
`deleteTransaction` - POST

*Parameters*

1. `ID` => Transaction ID

----
### <a name="packages"></a>Packages

`addPackages` - POST

*Parameters*

1. `id` => Package ID
1. `name` => Package Name
1. `intake_date` => Package Add Date
1. `blameID` => User Blame ID

--
`editPackages` - POST

*Parameters*

1. `id` => Package ID
1. `name` => Package Name
1. `intake_date` => Package Add Date
1. `blameID` => User Blame ID

--
`deletePackage` - POST

*Parameters*

1. `id` => Package ID

--
`getAllPackages` - GET

*Parameters*

None

--
`getPackageByID` - GET

*Packages*

1. `id` => Package ID


----
### <a name="user-strike-relationships"></a>User Strike Relationships

`getStrikesForUser` - GET

*Parameters*

1. `id` => User ID


----
### <a name="user-permission-relationships"></a>User Permission Relationships

`getPermissionsForUser` - GET

*Parameters*

1. `id` => User ID  


----
### <a name="transaction-user-relationships"></a>Transaction User Relationships

`getUsersForTransaction` - GET

*Parameters*

1. `id` => Transaction ID  


----
### <a name="transaction-item-relationships"></a>Transaction Item Relationships


`getItemsInTransaction` - GET

*Parameters*

1. `id` => Transaction ID

--
`getTransactionsForItem` - GET

*Parameters*

1. `id` => Item ID


----
### <a name="package-item-relationships"></a>Package Item Relationships

`getItemsInPackage` - GET

*Parameters*

1. `id` => Package ID

--
`getPackagesForItem` - GET

*Parameters*

1. `id` => Item ID

--
`addItemToPackage` - POST 

*Parameters*

1. `package_id` => Package ID
1. `item_id` => Item ID
1. `blame_id` => Blame User ID