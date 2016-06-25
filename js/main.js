// This is a function. It doesn't do anything until you call it.
function getAllItems(){
	$.getJSON( "http://inventorydb.digitalmediauconn.org/api/v2/sample-operations-file.php?operation=getAllItems", function( data ) {
		$.each(data, function(i, item){
			var tr = $("<tr>");
				tr.append(
						$("<td class='vert-align itemnameheader' data-toggle='modal' data-target='#myModal1'>").append(item.Name).attr('data-id',item.ID)
					);
				tr.append(
						$("<td class='vert-align'>").append(item.ID)
					);
				tr.append(
						$("<td class='vert-align'>").append(item.Status_ID)
					);
				tr.append(
						$("<td class='vert-align'>").append(item.Current_Condition)
					);
				tr.append(
						$("<td class='vert-align'>").append(item.Flagged)
					);
				tr.append(
						$("<td class='vert-align'>").append("<button type='button' class='btn btn-default btn-xs addbtn additem'>Add</button>")
					);

			tr.addClass("status-" + item.Status_ID + " flagged-" + item.Flagged + " campus-" + item.Campus_ID);
			$("#allItems").append(tr);
		});
	});
}

function getAllTransactions(){
	$.getJSON( "http://inventorydb.digitalmediauconn.org/api/v2/sample-operations-file.php?operation=getAllTransactions", function( data ) {
	// 3) populate the table the same way you did the items, using Transaction as the object
			$.each(data, function(i, transaction){
			var tr = $("<tr>");
				tr.append(
						$("<td class='vert-align itemnameheader' data-toggle='modal' data-target='#myModal10'>").append(transaction.Primary_User_ID).attr('data-id',transaction.ID)
					);
				tr.append(
						$("<td class='vert-align'>").append(transaction.ID)
					);
				tr.append(
						$("<td class='vert-align'>").append(transaction.Date_Due)
					);
				tr.append(
						$("<td class='vert-align'>").append("<button type='button' class='btn btn-default btn-xs addbtn additem'>Check-in</button>")
					);
				
				tr.addClass()
			
			$("#allTransactions").append(tr);
		});
	});
}

function getallUsers(){
	$.getJSON( "http://inventorydb.digitalmediauconn.org/api/v2/sample-operations-file.php?operation=getUsers", function( data ) {
	// 3) populate the table the same way you did the items, using Transaction as the object
		$.each(data, function(i, user){
			var tr = $("<tr>");
				tr.append(
						$("<td class='vert-align usernameheader' data-toggle='modal' data-target='#myModal11'>").append(user.First_Name).attr('data-id',user.ID)
					);
				tr.append(
						$("<td class='vert-align'>").append(user.Last_Name)
					);
				tr.append(
						$("<td class='vert-align'>").append(user.NetID)
					);
				tr.append(
						$("<td class='vert-align'>").append(user.Email_Primary)
					);
				tr.append(
						$("<td class='vert-align'>").append("<input type='checkbox' value=''></label>")
					);

			
			
			tr.addClass("")
			$("#allUsers").append(tr);
		});
	});
}

function getAllPackages() {
	$.getJSON( "http://inventorydb.digitalmediauconn.org/api/v2/sample-operations-file.php?operation=getAllPackages", function( data ){
		$.each(data, function(i, pkg){
			var li = $("<li>");
			li.append(
					pkg.Name
				);
			
			
			li.addClass("pkg_drop package-" + pkg.ID);
			$("#pkg_drop").append(li);
			
		});
	});
}

function getUserStrikes(userID) {
	$.getJSON( "http://inventorydb.digitalmediauconn.org/api/v2/sample-operations-file.php?operation=getStrikesForUser&id=" + userID, function( data ){
		
	});
}



//------------ Shell functions ------------------
function resetUser(){
	console.log("This resets the current user for item checkout");
}

function continueuser(){
	console.log("This continues the checkout process with a selected user");
}


/*
 * Item Filter Functions
 */


function statusactive(){	
	$(".status-1").show();
	$(".status-2").show();
	console.log("This fiters the items view to all items");
}

function statusavailable(){
	$(".status-2").hide();
	$(".status-1").show();
	console.log("This fiters the items view to available items");
}

function statusout(){
	$(".status-1").hide();
	$(".status-2").show();
	console.log("This fiters the items view to checked-out items");
}

function flaggedoff(){
	$(".flagged-0").show();
	$(".flagged-1").show();
	console.log("This fiters the items view to all items(no flags)");
}

function flaggedon(){
	$(".flagged-0").hide();
	$(".flagged-1").show();
	console.log("This fiters the items view to items with flags");
}

function pkg1() {
	//if (!$(".pkg_down").hasClass("pkg-1")) {
	//	this.hide();
	//}
	//else {
	//	$(".pkg-1").show();
	//}
	
	$(".package-8").show();
	$(".package-9").hide();
	
}

function allcampus() {
	$(".campus-1").show();
	$(".campus-2").show();
}

function campusstorrs(){
	$(".campus-1").show();
	$(".campus-2").hide();
	console.log("This fiters the items view for the storrs campus");
}

function campusstamford(){
	$(".campus-1").hide();
	$(".campus-2").show();
	console.log("This fiters the items view for the stamford campus");
}


/*
 * Transaction Filter Functions
 */


function transactionall() {
	//
}

function transactioncurrent() {
	//
}

function transactioncompleted() {
	//
}

function transactionpaston() {
	//
}

function transactionpastoff() {
	//
}


/*
 * User Filter Functions
 */

function userstatusall() {
	//
}
function userstatusout() {
	//
}
function userstrikeall() {
	//
}
function userstrike1() {
	//
}
function userstrike2() {
	//
}
function userstrike3() {
	//
}
function userstrike4() {
	//
}
function userstrike5() {
	//
}



function mainitems(){
	$("#allTransactionswrapper").addClass('hide');
	$("#allUserswrapper").addClass('hide');
	$("#transactionfilter").addClass('hide');
	$('#userfilter').addClass('hide');
	$('#packagefilter').addClass('hide');
	$("#allPackageswrapper").addClass('hide');
	$("#allItemswrapper").removeClass('hide');
	$("#itemfilter").removeClass('hide');
}

function maintransactions(){
	$("#allItemswrapper").addClass('hide');
	$("#allUserswrapper").addClass('hide');
	$("#itemfilter").addClass('hide');
	$('#userfilter').addClass('hide');
	$('#packagefilter').addClass('hide');
	$("#allPackageswrapper").addClass('hide');
	$("#allTransactionswrapper").removeClass('hide');
	$("#transactionfilter").removeClass('hide');
}

function mainusers(){
	$("#allItemswrapper").addClass('hide');
	$("#allTransactionswrapper").addClass('hide');
	$("#transactionfilter").addClass('hide');
	$("#itemfilter").addClass('hide');
	$('#packagefilter').addClass('hide');
	$("#allPackageswrapper").addClass('hide');
	$("#allUserswrapper").removeClass('hide');
	$('#userfilter').removeClass('hide');
}

function mainpackages() {
	$("#allItemswrapper").addClass('hide');
	$("#allTransactionswrapper").addClass('hide');
	$("#allUserswrapper").addClass('hide');
	$("#transactionfilter").addClass('hide');
	$("#itemfilter").addClass('hide');
	$('#userfilter').addClass('hide');
	$("#allPackageswrapper").removeClass('hide');
	$('#packagefilter').removeClass('hide');
}

function additem(){
	console.log("This adds an item to the cart");
}

function logout(){
	console.log("This logs the admin out");
}

function allnamesabort(){
	console.log("This aborts choosing a user to checkout from the see all items list");
}

function allnamesadd(){
	console.log("This chooses a user to checkout from the see all items list");
}

function additemabort(){
	console.log("This aborts the modal for adding an item");
}

function additemsave(){
	console.log("This saves the newly created item to the db");
}

function adduserabort(){
	console.log("This aborts the modal for adding a user");
}

function addusersave(){
	console.log("This saves the newly created user to the db");
}

function cartusersabort(){
	console.log("This aborts the modal to change a user in the cart modal");
}

function cartuserchange(){
	console.log("This changes the user in the cart modal");
}

function cartuseradd(){
	console.log("This adds a user to the cart modal (more than one user responsible)");
}

function cartrestart(){
	console.log("clears the cart");
}

function cartfinalize(){
	console.log("finalizes the cart and brings up the signature space");
}

function cartexit(){
	console.log("exits the cart");
}

function cartremoveitem(){
	console.log("removes an item from the cart");
}

function newPackage(){
	console.log("This creates a brand new package");
}

function itemToCurrent(){
	console.log("This adds checked off items to selected package");
}

function packageView(){
	console.log("This switches the settings view to Packages")
}

function categoryView(){
	console.log("This switches the settings view to Categories")
}

function deletePackage(){
	console.log("This deletes the package on setting page under action.");
}

function actionRemove(){
	console.log("This removes package on the setting page under third table action. ");
}

function itemmodaldelete(){
	console.log("This deletes the item from the item modal in the db ");
}

function itemmodalexit(){
	console.log("This exits the item modal in the main view ");
}

function itemmodalsave(){
	console.log("This saves changes to the item from the item modal in the db ");
}



//function campusstamford(){
//	console.log("This fiters the items view for the stamford campus");
//}
//
//function mainitems(){
//	console.log("This fiters the main view to dispay the item view");
//}
//
//
//function flaggedon(){
//	console.log("This fiters the items view to items with flags");
//}
//
//function campusstorrs(){
//	console.log("This fiters the items view for the storrs campus");
//}
//
//function campusstamford(){
//	console.log("This fiters the items view for the stamford campus");
//}
//
//function mainitems(){
//	console.log("This fiters the main view to dispay the item view");
//}
//
//function maintransactions(){
//	console.log("This fiters the main view to dispay the transaction view");
//}
//
//function mainusers(){
//	console.log("This fiters the main view to dispay the user view");
//}
//
//function additem(){
//	console.log("This adds an item to the cart");
//}
//
//function logout(){
//	console.log("This logs the admin out");
//}
//
//function allnamesabort(){
//	console.log("This aborts choosing a user to checkout from the see all items list");
//}
//
//function allnamesadd(){
//	console.log("This chooses a user to checkout from the see all items list");
//}
//
//function additemabort(){
//	console.log("This aborts the modal for adding an item");
//}
//
//function additemsave(){
//	console.log("This saves the newly created item to the db");
//}
//
//function adduserabort(){
//	console.log("This aborts the modal for adding a user");
//}
//
//function addusersave(){
//	console.log("This saves the newly created user to the db");
//}
//
//function cartusersabort(){
//	console.log("This aborts the modal to change a user in the cart modal");
//}
//
//function cartuserchange(){
//	console.log("This changes the user in the cart modal");
//}
//
//function cartuseradd(){
//	console.log("This adds a user to the cart modal (more than one user responsible)");
//}
//
//function cartrestart(){
//	console.log("clears the cart");
//}
//
//function cartfinalize(){
//	console.log("finalizes the cart and brings up the signature space");
//}
//
//function cartexit(){
//	console.log("exits the cart");
//}
//
//function cartremoveitem(){
//	console.log("removes an item from the cart");
//}
//
//function newPackage(){
//	console.log("This creates a brand new package");
//}
//
//function itemToCurrent(){
//	console.log("This adds checked off items to selected package");
//}
//
//function packageView(){
//	console.log("This switches the settings view to Packages")
//}
//
//function categoryView(){
//	console.log("This switches the settings view to Categories")
//}
//
//function deletePackage(){
//	console.log("This deletes the package on setting page under action.");
//}
//
//function actionRemove(){
//	console.log("This removes package on the setting page under third table action. ");
//}

// This block means "on page load"
$(document).ready(function(){

	// Now we're calling it...
	getAllItems();
	getAllTransactions();
	getallUsers();
	getAllPackages();
	$("#userfilter").addClass('hide');
	$("#transactionfilter").addClass('hide');
	
	


	//----------Calling Shell Functions------------------
	$( document ).on('click', ".resetuser", (function() {
		resetUser();
	}));

	$( document ).on('click', ".newPackage", (function() {
		newPackage();
	}));

	$( document ).on('click', ".itemToCurrent", (function() {
		itemToCurrent();
	}));

	$( document ).on('click', ".packageView", (function() {
		packageView();
	}));

	$( document ).on('click', ".categoryView", (function() {
		categoryView();
	}));


	$( document ).on('click', ".deletePackage", (function() {
		deletePackage();
	}));

	$( document ).on('click', ".actionRemove", (function() {
		actionRemove();
	}));

	$( document ).on('click', ".continueuser", (function() {
		continueuser();
	}));

	$( document ).on('click', ".statusactive", (function() {
		$("#status .active").removeClass("active");
		$(this).toggleClass("active");
		statusactive();
	}));

	$( document ).on('click', ".statusavailable", (function() {
		$("#status .active").removeClass("active");
		$(this).toggleClass("active");
		statusavailable();
	}));

	$( document ).on('click', ".statusout", (function() {
		$("#status .active").removeClass("active");
		$(this).toggleClass("active");
		statusout();
	}));

	$( document ).on('click', ".flaggedoff", (function() {
		$("#flag .active").removeClass("active");
		$(this).toggleClass("active");
		flaggedoff();
	}));

	$( document ).on('click', ".flaggedon", (function() {
		$("#flag .active").removeClass("active");
		$(this).toggleClass("active");
		flaggedon();
	}));
	
	$( document ).on('click', ".package-8", (function() {
		pkg1();
	}));
	
	$( document ).on('click', ".allcampus", (function() {
		$("#campus .active").removeClass("active");
		$(this).toggleClass("active");
		allcampus();
	}));
	
	$( document ).on('click', ".campusstorrs", (function() {
		$("#campus .active").removeClass("active");
		$(this).toggleClass("active");
		campusstorrs();
	}));

	$( document ).on('click', ".campusstamford", (function() {
		$("#campus .active").removeClass("active");
		$(this).toggleClass("active");
		campusstamford();
	}));

	$( document ).on('click', ".mainitems", (function() {
		$(".active").removeClass("active");
		$(this).toggleClass("active");
		mainitems();
	}));

	$( document ).on('click', ".maintransactions", (function() {
		$(".active").removeClass("active");
		$(this).toggleClass("active");
		maintransactions();
	}));

	$( document ).on('click', ".mainusers", (function() {
		$(".active").removeClass("active");
		$(this).toggleClass("active");
		mainusers();
	}));
	
	$( document ).on('click', ".mainpackages", (function() {
		$(".active").removeClass("active");
		$(this).toggleClass("active");
		mainpackages();
	}));

	$( document ).on('click', ".additem", (function() {
		additem();
	}));

	$( document ).on('click', ".logout", (function() {
		logout();
	}));

	$( document ).on('click', ".allnamesabort", (function() {
		allnamesabort();
	}));

	$( document ).on('click', ".allnamesadd", (function() {
		allnamesadd();
	}));

	$( document ).on('click', ".additemabort", (function() {
		additemabort();
	}));

	$( document ).on('click', ".additemsave", (function() {
		additemsave();
	}));

	$( document ).on('click', ".adduserabort", (function() {
		adduserabort();
	}));

	$( document ).on('click', ".addusersave", (function() {
		addusersave();
	}));

	$( document ).on('click', ".cartusersabort", (function() {
		cartusersabort();
	}));

	$( document ).on('click', ".cartuserchange", (function() {
		cartuserchange();
	}));

	$( document ).on('click', ".cartuseradd", (function() {
		cartuseradd();
	}));

	$( document ).on('click', ".cartrestart", (function() {
		cartrestart();
	}));

	$( document ).on('click', ".cartfinalize", (function() {
		cartfinalize();
	}));

	$( document ).on('click', ".cartexit", (function() {
		cartexit();
	}));

	$( document ).on('click', ".cartremoveitem", (function() {
		cartremoveitem();
	}));
	
	$( document ).on('click', ".itemmodaldelete", (function() {
		itemmodaldelete();
	}));
	
	$( document ).on('click', ".itemmodalexit", (function() {
		itemmodalexit();
	}));
	
	$( document ).on('click', ".itemmodalsave", (function() {
		itemmodalsave();
	}));






	// when the header is clicked...
	$( document ).on('click', ".itemnameheader", (function() {
	  var itemID = ($(this).attr('data-id'));

	  // get item by id
	  var item;
	  $.getJSON( "http://inventorydb.digitalmediauconn.org/api/v2/sample-operations-file.php?operation=getItemById&id=" + itemID, function ( data ) {
			item = data[0];
			console.log( data );

		  $("#myModal1 #item-id").val( item.ID );
		  $("#myModal1 #item-name").val( item.Name);
		  $("#myModal1 #item-description").val(item.Description);
		  $("#myModal1 #item-barcode").val(item.Barcode);
		  $("#myModal1 #item-serial").val(item.Serial);
		  $("#myModal1 #item-purchaseprice").val(item.PurchasePrice);
		  $("#myModal1 #item-purchasedate").val(item.PurchaseDate);
		  $("#myModal1 #item-reseller").val(item.Reseller);
		  $("#myModal1 #item-repartnum").val(item.Reseller_Part_Number);
		  $("#myModal1 #item-manpartnum").val(item.Manufacturer_Part_Number);
		  $("#myModal1 #item-notes").val(item.Notes);
		  $("#myModal1 #item-photo").attr( 'src', item.Photo_URL);
		  $("#myModal1 #item-manufacturer").val(item.Manufacturer);
		  $("#myModal1 #item-modelnum").val(item.Model_Number);
		  $("#myModal1 #item-UCtag").val(item.UC_Tag);
		  $("#myModal1 #item-Mactf").val(item.Mac_TF);
		  $("#myModal1 #item-campus").val(item.Campus_ID);
		  $("#myModal1 #item-building").val(item.Building);
		  $("#myModal1 #item-roomnum").val(item.Room_Number);
		  $("#myModal1 #item-status").val(item.Status_Name);
/*		  
		  $("#myModal1 #item-name").val(item.Name);
		  $("#myModal1 #item-name").val(item.Name);
*/
		});


	}));
	
	
	$( document ).on('click', ".itemnameheader", (function() {
	  var transactionID = ($(this).attr('data-id'));

	  // get item by id
	  var transaction;
	  $.getJSON( "http://inventorydb.digitalmediauconn.org/api/v2/sample-operations-file.php?operation=getTransactionsByID&ID=" + transactionID, function ( data ) {
			transaction = data[0];
			console.log( data );

		  $("#myModal10 #tran-id").val(transaction.Primary_User_ID);
		  $("#myModal10 #tran-campus").val(transaction.Campus_ID);
		  $("#myModal10 #tran-blame").val(transaction.Blame_ID);
		  $("#myModal10 #tran-duedate").val(transaction.Date_Out);
		  $("#myModal10 #tran-dueout").val(transaction.Date_Due);

		});


	}));
	

	// when the header is clicked...
	$( document ).on('click', ".usernameheader", (function() {
	  var UserID = ($(this).attr('data-id'));

	  // get user by id
	  var user;
	  $.getJSON( "http://inventorydb.digitalmediauconn.org/api/v2/sample-operations-file.php?operation=getUserByID&id=" + UserID, function ( data ) {
			user = data[0];
			console.log( data );

		  $("#myModal11 #user-id").val( user.ID );
		  $("#myModal11 #user-first").val( user.First_Name);
		  $("#myModal11 #user-last").val(user.Last_Name);
		  $("#myModal11 #user-email").val(user.Email_Primary);
		  $("#myModal11 #user-email-secondary").val(user.Email_Secondary);
		  $("#myModal11 #user-phone").val(user.Phone_Primary);
		  $("#myModal11 #user-magstripe").val(user.Mag_Stripe);
		  $("#myModal11 #user-proxid").val(user.Prox_ID);
		  $("#myModal11 #user-affilid").val(user.Affil);
		  $("#myModal11 #user-campusid").val(user.Campus_ID);
		  $("#myModal11 #user-netid").val(user.NetID);
		  $("#myModal11 #user-level").val(user.Level);
		});


	}));


});



/*
function getItemByID(){
	$.getJSON( "http://inventorydb.digitalmediauconn.org/api/v2/sample-operations-file.php?operation=getItemByID&item_id=​targetItemsId", function( data ) {

	});
}
*/




/*
function getAllItems(){
	$.getJSON( "http://inventorydb.digitalmediauconn.org/api/v2/sample-operations-file.php?operation=getAllItems", function( data ) {
		$.each(data, function(i, item){
			var tr = $("<tr>");
				tr.append(
						$("<td class='vert-align itemnameheader' data-toggle='modal' data-target='#myModal1'>").append(item.Name).attr('data-id',item.ID)
					);
				tr.append(
						$("<td class='vert-align'>").append(item.ID)
					);
				tr.append(
						$("<td class='vert-align'>").append("<div class="checkbox"><label><input type="checkbox" value=""></label></div>")
					);

			$("#allItems").append(tr);
		});
	});
}
*/




