function popitup(url, parameters)
{
	//newwindow=window.open(url,'name','resizable=1,status=1,scrollbars=1');
	if(parameters)
	{
		newwindow=window.open(url,'name','height=500,width=500,resizable=0,status=1,scrollbars=1');
	}
	else
	{
		newwindow=window.open(url,'name','resizable=1,status=1,scrollbars=1');
	}
	if (window.focus) 
	{
		newwindow.focus()
	}
	return false;
}
function goToBankPage(){
	var d	=	new Date();
	d.setFullYear(d.getFullYear(),d.getMonth(),d.getDate()+1);
	document.cookie = "status=CANCELLED; expires="+d.toGMTString()+"; path=/";
	window.location.href = "/banking/deposit";
}

var depositCounter = 0;

function setDepositCounter(){
	depositCounter = 1;
	document.getElementById("deposit-back").style.display = "block";
}

function nextDepositSec(){
	var errors = document.getElementById("inner-iframe-box").getElementsByTagName("p");
	for(var i = 1; i < errors.length; i++){
		document.getElementById("inner-iframe-box").removeChild(errors[i-1]);
	}
	var errors = document.getElementById("deposit-section-2").getElementsByTagName("p");
	for(var i = 1; i <= errors.length; i++){
		document.getElementById("deposit-section-2").removeChild(errors[i-1]);
	}
	if(depositCounter == 0){
		var amountSelected = false;
		amountSelected = this.getAmount();
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
					  		document.getElementById("player-deposit-amount").textContent = "You have selected £" + amountSelected + "";
					  		var aTag = document.getElementById("step-"+depositCounter).getElementsByTagName("a");
							aTag[0].setAttribute("class", "");
							document.getElementById("deposit-section-"+depositCounter).style.display = "none";
							
							depositCounter++;
							if(data == 1){
								depositCounter++;
								document.getElementById("deposit-next-1").style.display = "none";
								document.getElementById("confirm-order").style.display = "block";

								if(document.getElementById('debit').checked){
									document.getElementById("exist_bank").style.display = "block";
									document.getElementById("deposit_radio").style.display = "block";
									document.getElementById("credit_radio").style.display = "none";
									document.getElementById("addcard_debit").style.display = "none";
									document.getElementById("confirm-order").style.display = "none";
									document.getElementById("deposit-next-1").style.display = "none";
								}
								else if(document.getElementById('credit').checked){
									document.getElementById("exist_bank").style.display = "block";
									document.getElementById("deposit_radio").style.display = "none";
									document.getElementById("credit_radio").style.display = "block";
									document.getElementById("addcard_debit").style.display = "none";
									document.getElementById("confirm-order").style.display = "none";
									document.getElementById("deposit-next-1").style.display = "none";
								}
							}
							else{
								document.getElementById("deposit-next-1").style.display = "block";
							}
							document.getElementById("deposit-back").style.display = "block";
							var aTag = document.getElementById("step-"+depositCounter).getElementsByTagName("a");
							aTag[0].setAttribute("class", "current");
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
		var dob_year = document.getElementById("dob-year").value;
		var dob_month = document.getElementById("dob-month").value;
		var dob_date = document.getElementById("dob-date").value;
		
		if(dob_year == 'year' || dob_month == 'month' || dob_date == 'date'){
			alert("Please fill date of birth");
		}
		else{
			var firstName = document.getElementById("firstName").value;
			var lastName = document.getElementById("lastName").value;
			var sex = document.getElementById("sex").value;
			var dob = dob_year + '-' + dob_month + '-' + dob_date;
			var contactNo = document.getElementById("contactNo").value;
			var email = document.getElementById("emailAddress").value;
			var address = document.getElementById("address").value;
			var city = document.getElementById("city").value;
			var pin = document.getElementById("pin").value;
			var state = document.getElementById("state").value;
			var country = document.getElementById("country").value;
			
			var post_vars = "ajax="+true+"&formName=profile&firstName=" + firstName + "&lastName=" + lastName + "&sex=" + sex 
							+ "&dob=" + dob + "&contactNo=" + contactNo + "&email=" + email + "&address=" + address + 
							"&city=" + city + "&pin=" + pin + "&state=" + state + "&country=" + country;
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
						var aTag = document.getElementById("step-"+depositCounter).getElementsByTagName("a");
						aTag[0].setAttribute("class", "");
						document.getElementById("deposit-section-"+depositCounter).style.display = "none";
							
						depositCounter++;
						if(depositCounter == 2){
							document.getElementById("deposit-next-0").style.display = "none";
							document.getElementById("deposit-next-1").style.display = "none";
							document.getElementById("confirm-order").style.display = "block";
							
							if(document.getElementById('debit').checked){
								document.getElementById("exist_bank").style.display = "block";
								document.getElementById("deposit_radio").style.display = "block";
								document.getElementById("credit_radio").style.display = "none";
								document.getElementById("addcard_debit").style.display = "none";
								document.getElementById("confirm-order").style.display = "none";
								document.getElementById("deposit-next-1").style.display = "none";
							}
							else if(document.getElementById('credit').checked){
								document.getElementById("exist_bank").style.display = "block";
								document.getElementById("deposit_radio").style.display = "none";
								document.getElementById("credit_radio").style.display = "block";
								document.getElementById("addcard_debit").style.display = "none";
								document.getElementById("confirm-order").style.display = "none";
								document.getElementById("deposit-next-1").style.display = "none";
							}
						}
						var aTag = document.getElementById("step-"+depositCounter).getElementsByTagName("a");
						aTag[0].setAttribute("class", "current");
						document.getElementById("deposit-section-"+depositCounter).style.display = "block";
					}
				}
			});
		}
	}
	else{
		var aTag = document.getElementById("step-"+depositCounter).getElementsByTagName("a");
		aTag[0].setAttribute("class", "");
		document.getElementById("deposit-section-"+depositCounter).style.display = "none";
		
		depositCounter++;
		document.getElementById("deposit-back").style.display = "block";
		if(depositCounter == 2){
			document.getElementById("deposit-next-0").style.display = "none";
			document.getElementById("deposit-next-1").style.display = "none";
			document.getElementById("confirm-order").style.display = "block";
		}
		var aTag = document.getElementById("step-"+depositCounter).getElementsByTagName("a");
		aTag[0].setAttribute("class", "current");
		document.getElementById("deposit-section-"+depositCounter).style.display = "block";
	}
}
function prevDepositSec(completed){
	var errors = document.getElementById("deposit-section-2").getElementsByTagName("p");
	for(var i = 1; i <= errors.length; i++){
		document.getElementById("deposit-section-2").removeChild(errors[i-1]);
	}
	var errors = document.getElementById("inner-iframe-box").getElementsByTagName("p");
	for(var i = 1; i < errors.length; i++){
		document.getElementById("inner-iframe-box").removeChild(errors[i-1]);
	}
	document.getElementById("deposit-next-1").style.display = "block";
	document.getElementById("deposit-next-0").style.display = "none";
	document.getElementById("confirm-order").style.display = "none";
	var aTag = document.getElementById("step-"+depositCounter).getElementsByTagName("a");
	aTag[0].setAttribute("class", "");
	document.getElementById("deposit-section-"+depositCounter).style.display = "none";
	document.getElementById("exist_bank").style.display = "none";
	document.getElementById("deposit_radio").style.display = "none";
	document.getElementById("credit_radio").style.display = "none";
	document.getElementById("addcard_debit").style.display = "none";
	
	depositCounter--;
	if(completed && depositCounter == 1){
		depositCounter--;
	}
	if(depositCounter == 0){
		document.getElementById("deposit-back").style.display = "none";
		document.getElementById("deposit-next-1").style.display = "none";
		document.getElementById("deposit-next-0").style.display = "block";
	}
	var aTag = document.getElementById("step-"+depositCounter).getElementsByTagName("a");
	aTag[0].setAttribute("class", "current");
	document.getElementById("deposit-section-"+depositCounter).style.display = "block";
}
function getAmount(){
	var amountChecked = false;
	var amount = 0;
	var amountOptions = document.getElementById('deposit-section-0').getElementsByTagName('input');
	for(var i = 0; i < amountOptions.length; i++){
		if(amountOptions[i].checked){
			amountChecked = true;
			var compareValue = 6;
			if(document.getElementById('flowback-value') != undefined){
				compareValue = 7;
			}
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
	document.getElementById("confirm-order").style.display = "none";
	if(paymentType == 'UKASH'){
		document.getElementById("confirm-order").style.display = "block";
		document.getElementById("exist_bank").style.display = "none";
		document.getElementById("deposit_radio").style.display = "none";
		document.getElementById("credit_radio").style.display = "none";
		document.getElementById("addcard_debit").style.display = "none";
	}
	else if(paymentType == 'DEBIT'){
		document.getElementById("exist_bank").style.display = "block";
		document.getElementById("deposit_radio").style.display = "block";
		document.getElementById("credit_radio").style.display = "none";
		document.getElementById("addcard_debit").style.display = "none";
		document.getElementById("valid_month").id = "card_valid_month";
		document.getElementById("valid_year").id = "card_valid_year";
		document.getElementById("issue_number").id = "issue_no";
	}
	else{
		document.getElementById("exist_bank").style.display = "block";
		document.getElementById("deposit_radio").style.display = "none";
		document.getElementById("credit_radio").style.display = "block";
		document.getElementById("addcard_debit").style.display = "none";
		if(document.getElementById("card_valid_month") != undefined){
			document.getElementById("card_valid_month").id = "valid_month";
		}
		if(document.getElementById("card_valid_year") != undefined){
			document.getElementById("card_valid_year").id = "valid_year";
		}
		if(document.getElementById("issue_no") != undefined){
			document.getElementById("issue_no").id = "issue_number";
		}
	}
}
function confirmOrder(cardId){
	$(".ttdepolback_1").attr('disabled',true);
	$(".ttdepolbackbtns").attr('disabled',true);
	var amount = this.getAmount();
	var paymentType = "";
	var error = false;
	var isPaymentOptionSelected = false;
	var paymentOptions = document.getElementById('deposit-section-2').getElementsByTagName('input');
	var post_vars = "ajax="+true;
	for(var i = 0; i < paymentOptions.length; i++){
		if(paymentOptions[i].checked){
			isPaymentOptionSelected = true;
			paymentType = paymentOptions[i].value;
			var bankCode = "";
			if(paymentType == 'UKASH'){
				//bankCode = document.getElementById("bankCode").value;
			}
			else if(paymentType == 'DEBIT' || paymentType == 'CREDIT'){
				if(cardId){
					post_vars += "&cardId=" + cardId;
				}
				else{
					var firstName = document.getElementById("card_holder_fname").value;
					var lastName = document.getElementById("card_holder_lname").value;
					var cardNo = document.getElementById("card_no").value;
					var expiryMonth = document.getElementById("card_expiry_month").value;
					var expiryYear = document.getElementById("card_expiry_year").value;
					var issueNo = document.getElementById("card_issue_no").value;
					var cvcNo = document.getElementById("card_cvc_no").value;
					var cardSubType = document.getElementById("card_sub_type").value;
					var valMonth = document.getElementById("valid_from_month").value;
					var valYear = document.getElementById("valid_from_year").value;
					
					post_vars += "&firstName=" + firstName + "&lastName=" + lastName + "&cardNo=" + cardNo + "&exMonth=" 
							  + expiryMonth + "&exYear=" + expiryYear + "&issueNo=" + issueNo +	"&cvcNo=" + cvcNo + 
							  "&cardSubType=" + cardSubType + "&valMonth=" + valMonth + "&valYear=" + valYear;
				}
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
		post_vars += "&formName=payment&paymentType=" + paymentType;
		$.ajax({
			  type: "POST",
			  url: "/banking/deposit",
			  data: post_vars,
			  success: function(data){
				  	var response = data.split('&');
			  		var errors = document.getElementById("deposit-section-2").getElementsByTagName("p");
		  			for(var i = 1; i < errors.length; i++){
		  				document.getElementById("deposit-section-2").removeChild(errors[i-1]);
		  			}
			  		if(response[0] == 'error'){
			  			$('#deposit-section-2').prepend('<p class="error payment-error">'+response[1]+'</p>');
			  		}
			  		else if(response[0] == 'notice'){
			  			$('.ttdepol').before('<p class="notice">'+response[1]+'</p>');
			  		}
			  		/*else{
			  			var form = document["lpsredirect-form"];
			  			form.action = response[0];
			  			form.MD.value = response[1];
			  			form.PaReq.value = response[2];
			  			form.TermUrl.value = response[3];
			  			//form.submit();
			  		}*/
			  		/*if(response[0].trim() == 'success'){
			  			window.location = response[1];
			  		}*/
			  		//alert(response[0]);
			  		window.location = response[0];
			  	}
			});
	}
}

function changeAmount(){
	var errors = document.getElementById("deposit-section-2").getElementsByTagName("p");
	for(var i = 1; i <= errors.length; i++){
		document.getElementById("deposit-section-2").removeChild(errors[i-1]);
	}
	document.getElementById("deposit-next-0").style.display = "block";
	document.getElementById("confirm-order").style.display = "none";
	document.getElementById("deposit-back").style.display = "none";
	document.getElementById("deposit-next-1").style.display = "none";
	
	var aTag = document.getElementById("step-"+depositCounter).getElementsByTagName("a");
	aTag[0].setAttribute("class", "");
	document.getElementById("deposit-section-"+depositCounter).style.display = "none";
	
	depositCounter = 0;
	
	var aTag = document.getElementById("step-"+depositCounter).getElementsByTagName("a");
	aTag[0].setAttribute("class", "current");
	document.getElementById("deposit-section-"+depositCounter).style.display = "block";
}
