
function getAllItems(){
	$.getJSON( "http://inventorydb.digitalmediauconn.org/api/v2/sample-operations-file.php?operation=getAllItems", function( data ) {
		$.each(data, function(i, item){
			var tr = $("<tr>");
				tr.append(
						$("<td class='vert-align' data-toggle='modal' data-target='#myModal1'>").append(item.Name)
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
						$("<td class='vert-align'>").append("<button type='button' class='btn btn-default btn-xs addbtn'>Add</button>")
					);
				
			
			$("#allItems").append(tr);
		});
	});
}



$(document).ready(function(){
	getAllItems();
});
