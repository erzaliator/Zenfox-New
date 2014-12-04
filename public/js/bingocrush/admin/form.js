function submitForm(actionName){
	var form = document['date-selection-form'];
	
	if(actionName == '/report/registration'){
		var account_type = document.createElement("select");
		account_type.setAttribute("name", "accountType");
		var acc_type_opt = document.createElement("option");
		acc_type_opt.setAttribute("selected", "selected");
		acc_type_opt.setAttribute("value","confirmed");
		account_type.appendChild(acc_type_opt);
		
		var tracker_id = document.createElement("select");
		tracker_id.setAttribute("name", "trackerId");
		var tracker_opt = document.createElement("option");
                tracker_opt.setAttribute("selected", "selected");
                tracker_opt.setAttribute("value","");
                tracker_id.appendChild(tracker_opt);
		
		form.appendChild(account_type);
		form.appendChild(tracker_id);
	}
	
	document.getElementById("items").value=50;
	form.action = actionName;
	form.submit();
}
