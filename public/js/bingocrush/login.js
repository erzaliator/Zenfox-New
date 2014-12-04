function goToLogin(formname){
	removeAllErrors(formname);
	var sUrl	=	'/auth/signup';
	var args	=	"";
	var callback = {
			  success:dataHandler,
			  failure:failurHandler,
			  timeout:30000
			};
	var dform	=	document[formname];
	var input_array	=	dform.getElementsByTagName("input");
	var post_vars	=	"ajax=true&";
	var noerror = true;
	for(var i=0;i<input_array.length;i++){
		if(!input_array[i].value && input_array[i].id != 'affId' && input_array[i].id != 'trackerId' && input_array[i].id != 'buddyId'){
			noerror = false;
			displayError("<b>Value is required</b>", input_array[i].id, formname);
		}
		else if((input_array[i].value.length < 4 || input_array[i].value.length > 20) && (input_array[i].name == 'login')){
			noerror = false;
			displayError("<b>Username must be 4 characters long</b>", input_array[i].id, formname);
		}
		else if((input_array[i].value.length < 6 || input_array[i].value.length > 45) && (input_array[i].name == 'password' || input_array[i].name == 'confirmPassword')){
			noerror = false;
			displayError("<b>Password must be 6 characters long</b>", input_array[i].id, formname);
		}
		else if(input_array[i].name == 'email'){
			if(input_array[i].value.length > 100){
				noerror = false;
				displayError("<b>Email Address length should be less than 100</b>", input_array[i].id, formname);
			}
			else{
				var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;  
				var emailValid = emailPattern.test(input_array[i].value);
				if(!emailValid){
					noerror = false;
					displayError("<b>Please enter valid email address</b>", input_array[i].id, formname);
				}
			}
		}
		post_vars+=input_array[i].name+"="+input_array[i].value+"&";
	}
	if(noerror){
		//dform.submit();
		post_vars	=	post_vars.substr(0,post_vars.length-1);
		var transaction = YAHOO.util.Connect.asyncRequest('POST', sUrl, callback, post_vars);
	}
}

function removeAllErrors(formname){
	var dform =	document[formname];
	var linode = dform.getElementsByTagName('li');
	for(var i = 0; i<linode.length; i++){
		var c = linode[i].getElementsByTagName('div');
		if(c.length > 0){
			linode[i].removeChild(c[0]);
		}
	}
}

function dataHandler(o){
	alert(o.responseText);
	/*var resp_array	=	o.responseText.split("&");
	alert(resp_array[0]);
	window.location = resp_array[1];*/
	/*var resp_array	=	o.responseText.split("&");
	var objArray	=	new Array();
	for(var i=0;i<resp_array.length;i++){
		if(resp_array[i].length>0){
			var temp	=	resp_array[i].split("=");
			objArray[temp[0]]	=	temp[1];
		}
	}
	if(objArray.error!=undefined){
		if(objArray.error==1){
			for(var x in objArray){
				if(x!="error" && x!= "formname"){
					displayError(objArray[x],x+"-element",objArray.formname);
				}
			}
		}
		else{
			if(objArray.message=="success"){
				if(objArray.formname == 'signup'){
//					var msg	=	document.createElement("div");
//					msg.setAttribute("id",objArray.formname+"success_message");
//					msg.innerHTML	=	"Congratulation!! You Have Been Registered Successfully.";
//					document.getElementById(objArray.formname).appendChild(msg);
					window.location = "/";
				}
				else{
					window.location	=	objArray.url;
				}
			}else{
				var form	=	document[objArray.formname];
				var msg	=	document.createElement("div");
				msg.setAttribute("id",objArray.formname+"success_message");
				msg.innerHTML	=	objArray.message;
				document.getElementById(objArray.formname).appendChild(msg);
			}
		}
	}*/
	//hideDataLoader(objArray.formname);
}

function failurHandler(o){
	//alert(o.responseText);
}

function displayError(msg,container,formname){
	//alert(container);
	/*alert(msg);*/
	var md	=	document.createElement("div");
	md.innerHTML	=	msg;
	this.insertAfter(md, document.getElementById(container));
}

function insertAfter(newElement,targetElement) {
	var parent = targetElement.parentNode;
	 
	//if the parents lastchild is the targetElement...
	if(parent.lastchild == targetElement) {
	//add the newElement after the target element.
	parent.appendChild(newElement);
	} else {
	// else the target has siblings, insert the new element between the target and it's next sibling.
	parent.insertBefore(newElement, targetElement.nextSibling);
	}
}
