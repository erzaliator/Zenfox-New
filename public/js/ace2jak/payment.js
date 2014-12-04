var depositCounter = 0;

function setDepositCounter(){
	depositCounter = 1;
	document.getElementById("deposit-back").style.display = "block";
}

function nextDepositSec(){
	var amountSelected = false;
	amountSelected = this.getAmount();
	
	if(depositCounter == 0){
		if(amountSelected){
			$.ajax({
				  type: "POST",
				  url: "/banking/deposit",
				  data: {amount: amountSelected, ajax:true, formName:'amount'},
				  success: function(data){
					  	var response = data.split('&');
					  	if(response[0] == 'error'){
					  		alert(response[1]);
					  	}
					  	else{
							document.getElementById("deposit-section-"+depositCounter).style.display = "none";
							
							depositCounter++;
							
							if(data == 1){
								depositCounter++;
							}
							
							document.getElementById("selected-amount-"+depositCounter).textContent = "You have selected Rs. " + amountSelected + "";
							document.getElementById("deposit-section-"+depositCounter).style.display = "block";
					  	}
				  	}
				});
		}
		else{
			alert("please select amount");
		}
	}
	else if(depositCounter == 1){
		var firstName = document.getElementById("firstName").value;
		var lastName = document.getElementById("lastName").value;
		var sex = document.getElementById("sex").value;
		var dob = document.getElementById("datepicker").value;
		var contactNo = document.getElementById("contactNo").value;
		var email = document.getElementById("emailAddress").value;
		var address = document.getElementById("address").value;
		var city = document.getElementById("city").value;
		var pin = document.getElementById("pin").value;
		var state = document.getElementById("state").value;
		var country = document.getElementById("country").value;
		
		var post_vars = "ajax="+true+"&formName=profile&firstName=" + firstName + "&lastName=" + lastName + "&sex=" + sex + "&dob=" + dob + "&contactNo=" + contactNo + "&email=" + email + "&address=" + address + "&city=" + city + "&pin=" + pin + "&state=" + state + "&country=" + country;
		$.ajax({
			  type: "POST",
			  url: "/banking/deposit",
			  data: post_vars,
			  success: function(data){
					var response = data.split('&');
				  	if(response[0] == 'error'){
				  		alert(response[1]);
				  	}
				  	else{
						document.getElementById("deposit-section-"+depositCounter).style.display = "none";
						
						depositCounter++;
						
						document.getElementById("deposit-section-"+depositCounter).style.display = "block";
					}
			  	}
			});
	}
}
function prevDepositSec(completed){
	document.getElementById("deposit-section-"+depositCounter).style.display = "none";
	
	depositCounter--;
	if(completed && depositCounter == 1){
		depositCounter--;
	}
	
	document.getElementById("deposit-section-"+depositCounter).style.display = "block";
}
function getAmount(){
	var amountChecked = false;
	var amount = 0;
	var amountOptions = document.getElementById('deposit-section-0').getElementsByTagName('input');
	for(var i = 0; i < amountOptions.length; i++){
		if(amountOptions[i].checked){
			amountChecked = true;
			var compareValue = 2;
			if(i == compareValue){
				amount = document.getElementById('custom-amount').value;
			}
			else{
				amount = amountOptions[i].value;;
			}
		}
	}
	if(!amountChecked || (amount == 0)){
		return false;
	}
	return amount;
}
function checkPaymentType(paymentType){
	if(paymentType == 'NETBANKING'){
		document.getElementById("bank-list").style.display = "block";
	}
	else{
		document.getElementById("bank-list").style.display = "none";
	}
}
function confirmOrder(){
	var amount = this.getAmount();
	var paymentType = "";
	var error = false;
	var isPaymentOptionSelected = false;
	var paymentOptions = document.getElementById('deposit-section-2').getElementsByTagName('input');
	var post_vars = "ajax="+true+"&formName=payment";
	for(var i = 0; i < paymentOptions.length; i++){
		if(paymentOptions[i].checked){
			isPaymentOptionSelected = true;
			paymentType = paymentOptions[i].value;
			post_vars += "&paymentType=" + paymentType;
			
			var bankCode = "";
			if(paymentType == 'NETBANKING'){
				bankCode = document.getElementById("bankCode").value;
				post_vars += "&bankCode=" + bankCode;
			}
			break;
		}
	}
	if(!isPaymentOptionSelected){
		error = true;
		alert("Please choose one Mode Of Payment");
		document.getElementById("confirm-order").style.display = "none";
	}
	
	if(!error){
		$.ajax({
			  type: "POST",
			  url: "/banking/deposit",
			  data: post_vars,
			  success: function(data){
				  	var response = data.split('&');
			  		if(response[0] == 'error'){
			  			alert(response[1]);
			  		}
			  		if(response[0] == 'notice'){
			  			alert(response[1]);
			  		}
			  		if(response[0] == 'success'){
			  			window.location = "https://www.ace2jak.com/transaction/index";
			  		}
			  	}
			});
	}
}