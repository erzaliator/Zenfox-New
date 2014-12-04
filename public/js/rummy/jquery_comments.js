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

function refreshParent(url) 
{
	window.opener.location.href = url;
	if (window.opener.progressWindow)
	{
		window.opener.progressWindow.close()
	}
	window.close();
}

function ShowText(id) {
	document.getElementById(id).style.display = 'block';
	}
	function HideText(id) {
	document.getElementById(id).style.display = 'none';
	}

/*$(window).scroll(function()
{
	$('#message_box').animate({top:($(window).scrollTop()+110)+"px" },{queue: false, duration: 350});
});*/

$(document).ready(function()
{
	$("#help_box").show();
	$("#close_help").hide();
	//$('#help_box').animate({top:100 },{queue: false, duration: 350});
	$("#close_help_strip").hide();
	$("#help_links").hide();
	//$("#display_help").hide();
	$("#open_help").click(function(){
		//$("#help_links").show();
		$("#display_help").show();
		$("#open_help").hide();
		$("#close_help").show();
		$("#close_help_strip").show();
		//$('#message_box').animate({top:170 },{queue: false, duration: 350});
	});
	$("#close_help").click(function(){
		$("#display_help").hide();
		$("#help_links").hide();
		$("#open_help").show();
		$("#close_help").hide();
		$("#close_help_strip").hide();
		//$('#message_box').animate({top:140 },{queue: false, duration: 350});
	});
	/*$(':button').click(function()
	{
		FB.login();
	});*/
	$("#fullcomment").hide();
	$("#lang").change(function () {
		var val = $('#lang :selected').map(function(){return $(this).val();}).get();
		pathArray = location.pathname.split('/');
		newPathname = "/" + val;
		for ( i = 1; i < pathArray.length; i++ ) {
			if((pathArray[i].charAt(2) == '_') || (pathArray[i].length ==2))
			{
				continue;
			}
			newPathname += "/";
			newPathname += pathArray[i];
		}
        var url = location.protocol + "//" + location.host +  newPathname;
        window.location.href = url;
      });
      
	$("#message_box").show();
	$('#message_box').animate({top:110 },{queue: false, duration: 350});
	var count = 0;
	//$("#player-comment-form").hide();
	$(".palys-report-forms").hide();
	//$("a.moreComments").hide();
	$(".pagination").hide();
	$("#close_message").hide();
	$("#close_strip").hide();
	$("a.moreComments").click(function(event)
	{
		$(".palys-report-forms").show();
		$("a.moreComments").hide();
		$(".pagination").show();
		event.preventDefault();
	});
	/*jQuery('#list3').accordion({
		header: 'div.title',
		active: false,
		alwaysOpen: false,
		animated: false,
		autoheight: false
	});*/
	/*$("#open_message").click(function()
	{
		$("a#open_help").css("width", "250px");
		$("#close_message").show();
		$("#close_strip").show();
		$("#open_message").hide();
		$("#player-comment-form").show();
		$("a.moreComments").show();
		$("a.moreComments").click(function(event)
		{
			$(".palys-report-forms").show();
			$("a.moreComments").hide();
			$(".pagination").show();
			event.preventDefault();
		});
	});
	$("#close_message").click(function()
	{
		$("a#open_help").css("width", "75px");
		$("#open_message").show();
		$("#close_message").hide();
		$("#close_strip").hide();
		$("#player-comment-form").hide();
		$(".palys-report-forms").hide();
		$("a.moreComments").hide();
		$(".pagination").hide();
	});*/

});
$("a.comments").click(function(event)
{
	$(".xyz").load(this.href);
	event.preventDefault();
});
$("a.dots").mouseover(function()
{
	
});
$("#fundButton").click(function(event)
{
	$(this).attr("disabled", "true");
	$.browser.chrome = /chrome/.test(navigator.userAgent.toLowerCase());
	if($.browser.chrome)
	{
		var url = location.protocol + '//' + location.host + location.pathname;
		$.post(url, {fund: $(this).val(), browser: 'chrome'}, function(data){
			window.location.href = location.protocol + '//' + location.host + data;
			});
	}
	if($.browser.msie){
		var url = location.protocol + '//' + location.host + location.pathname;
		$.post(url, {fund: $(this).val(), browser: 'msie'}, function(data){
			window.location.href = location.protocol + '//' + location.host + data;
			});
	}
});
/*$("#amount-element").keyup(function(){
	if(!$('#amount').val().match('^(0|[1-9][0-9]*)$'))
    {
		alert("not integer");
    }

});*/
//var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanel1");
//var Accordion1 = new Spry.Widget.Accordion("Accordion1");

function displayCustomField(){
	
	var paymentArrayLen = document.getElementById("player-getpayment-form").paymentType.length;
	for(i = 0; i < paymentArrayLen; i++){
		document.getElementById("player-getpayment-form").paymentType[i].checked = false;
	}
	document.getElementById("city_list").style.display = "none";
	document.getElementById("address_box").style.display = "none";
	document.getElementById("pin_code").style.display = "none";
	document.getElementById("contact_no").style.display = "none";
	document.getElementById("bank_list").style.display = "none";
	document.getElementById("submit").style.display = "none";
	document.getElementById("player_name").style.display = "none";
	document.getElementById("player_contact").style.display = "none";
	document.getElementById("player_email").style.display = "none";
	
	var len = document.getElementById("player-getpayment-form").amount.length;
	for(i = 0; i < len; i++){
		if(document.getElementById("player-getpayment-form").amount[i].checked){
			var value = document.getElementById("player-getpayment-form").amount[i].value;
		}
	}
	if(value == "custom"){
		document.getElementById("customAmt").style.display = "block";
	}
	else{
		document.getElementById("customAmt").style.display = "none";
	}
	document.getElementById("payment").style.display = "block";
}

function displayList(){
	document.getElementById("submit").style.display = "block";
	var len = document.getElementById("player-getpayment-form").paymentType.length;
	for(i = 0; i < len; i++){
		if(document.getElementById("player-getpayment-form").paymentType[i].checked){
			var value = document.getElementById("player-getpayment-form").paymentType[i].value;
		}
	}
	
	var amountArrayLen = document.getElementById("player-getpayment-form").amount.length;
	for(i = 0; i < amountArrayLen; i++){
		if(document.getElementById("player-getpayment-form").amount[i].checked){
			var amount = document.getElementById("player-getpayment-form").amount[i].value;
		}
	}
	if(amount == "custom"){
		amount = document.getElementById("customAmt").value;
	}
	
	switch(value){
		case 'NETBANKING':
			if(amount >= 25){
				document.getElementById("bank_list").style.display = "block";
			}
			else{
				alert('Please deposit minimum Rs 25 or above.');
				document.getElementById("player-getpayment-form").paymentType[0].checked = false;
				document.getElementById("submit").style.display = "none";
			}
			document.getElementById("city_list").style.display = "none";
			document.getElementById("address_box").style.display = "none";
			document.getElementById("pin_code").style.display = "none";
			document.getElementById("contact_no").style.display = "none";
			document.getElementById("player_name").style.display = "none";
			document.getElementById("player_contact").style.display = "none";
			document.getElementById("player_email").style.display = "none";
			break;
		case 'CASH':
			if(amount >= 1000){
				document.getElementById("city_list").style.display = "block";
				document.getElementById("address_box").style.display = "block";
				document.getElementById("pin_code").style.display = "block";
				document.getElementById("contact_no").style.display = "block";
			}
			else{
				alert('Amount must be at least Rs 1000 for Cash Deposit.');
				document.getElementById("player-getpayment-form").paymentType[1].checked = false;
				document.getElementById("submit").style.display = "none";
				/*var parent = document.getElementById("player-getpayment-form").paymentType[1];
				var newdiv = document.createElement('div');
				newdiv.setAttribute('id', 'cash-deposit');
				newdiv.innerHTML = 'Amount must be at least Rs 1000 for Cash Deposit.';
				parent.appendChild(newdiv);*/
			}
			document.getElementById("bank_list").style.display = "none";
			document.getElementById("player_name").style.display = "none";
			document.getElementById("player_contact").style.display = "none";
			document.getElementById("player_email").style.display = "none";
			break;
		case 'DEBIT':
		case 'CREDIT':
			if(amount >= 250){
				document.getElementById("player_name").style.display = "block";
				document.getElementById("player_contact").style.display = "block";
				document.getElementById("player_email").style.display = "block";
			}
			else{
				alert('Please deposit minimum Rs 250 or above.');
				document.getElementById("player-getpayment-form").paymentType[2].checked = false;
				document.getElementById("player-getpayment-form").paymentType[3].checked = false;
				document.getElementById("submit").style.display = "none";
			}
			document.getElementById("city_list").style.display = "none";
			document.getElementById("address_box").style.display = "none";
			document.getElementById("pin_code").style.display = "none";
			document.getElementById("contact_no").style.display = "none";
			document.getElementById("bank_list").style.display = "none";
			break;
		case 'MOL':
			document.getElementById("city_list").style.display = "none";
			document.getElementById("address_box").style.display = "none";
			document.getElementById("pin_code").style.display = "none";
			document.getElementById("contact_no").style.display = "none";
			document.getElementById("bank_list").style.display = "none";
			document.getElementById("player_name").style.display = "none";
			document.getElementById("player_contact").style.display = "none";
			document.getElementById("player_email").style.display = "none";
			break;
	}
}

function goToBankPage(){
	window.location.href = "/banking/deposit";
}

function selectAmount(){
	
}

var isWithdrawalPressed = true;
function withdrawalFlowback(){
	var withdrawalAmount = document.getElementById("flowback-value").textContent;
	if(isWithdrawalPressed){
		isWithdrawalPressed = false;
		$.ajax({
			  type: "POST",
			  url: "/withdrawal/request",
			  data: {amount: withdrawalAmount, ajax:true, withdraw:true},
			  success: function(data){
				  		isWithdrawalPressed = true;
				  		var response = data.split('&');
				  		var errors = document.getElementById("inner-iframe-box").getElementsByTagName("p");
			  			for(var i = 1; i < errors.length; i++){
			  				document.getElementById("inner-iframe-box").removeChild(errors[i-1]);
			  			}
				  		if(response[0] == 'error'){
				  			$('.ttdepol').before('<p class="error">'+response[1]+'</p>');
				  		}
				  		if(response[0] == 'notice'){
				  			$('.ttdepol').before('<p class="notice">'+response[1]+'</p>');
				  		}
			  		}
			});
	}
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
					  		document.getElementById("player-deposit-amount").textContent = "You have selected Rs. " + amountSelected + "";
					  		var aTag = document.getElementById("step-"+depositCounter).getElementsByTagName("a");
							aTag[0].setAttribute("class", "");
							document.getElementById("deposit-section-"+depositCounter).style.display = "none";
							
							depositCounter++;
							document.getElementById("deposit-back").style.display = "block";
							if(depositCounter == 2){
								document.getElementById("deposit-next").style.display = "none";
								document.getElementById("confirm-order").style.display = "block";
							}
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
		var bonusScheme = document.getElementById('banner-ad').getElementsByTagName('input');
		var scheme_id = 1;
		for(var i = 0; i < bonusScheme.length; i++){
			if(bonusScheme[i].checked){
				scheme_id = bonusScheme[i].value;
			}
		}
		var redeemCoupon = document.getElementById("redeem-coupon").value;
		$.ajax({
			  type: "POST",
			  url: "/banking/deposit",
			  data: {couponCode:redeemCoupon, schemeId:scheme_id, ajax:true, formName:'coupon'},
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
						document.getElementById("deposit-back").style.display = "block";
						if(depositCounter == 2){
							document.getElementById("deposit-next").style.display = "none";
							document.getElementById("confirm-order").style.display = "block";
						}
						var aTag = document.getElementById("step-"+depositCounter).getElementsByTagName("a");
						aTag[0].setAttribute("class", "current");
						document.getElementById("deposit-section-"+depositCounter).style.display = "block";
				  	}
			  	}
			});
	}
	else{
		var aTag = document.getElementById("step-"+depositCounter).getElementsByTagName("a");
		aTag[0].setAttribute("class", "");
		document.getElementById("deposit-section-"+depositCounter).style.display = "none";
		
		depositCounter++;
		document.getElementById("deposit-back").style.display = "block";
		if(depositCounter == 2){
			document.getElementById("deposit-next").style.display = "none";
			document.getElementById("confirm-order").style.display = "block";
		}
		var aTag = document.getElementById("step-"+depositCounter).getElementsByTagName("a");
		aTag[0].setAttribute("class", "current");
		document.getElementById("deposit-section-"+depositCounter).style.display = "block";
	}
}
function prevDepositSec(){
	var errors = document.getElementById("deposit-section-2").getElementsByTagName("p");
	for(var i = 1; i <= errors.length; i++){
		document.getElementById("deposit-section-2").removeChild(errors[i-1]);
	}
	var errors = document.getElementById("inner-iframe-box").getElementsByTagName("p");
	for(var i = 1; i < errors.length; i++){
		document.getElementById("inner-iframe-box").removeChild(errors[i-1]);
	}
	document.getElementById("deposit-next").style.display = "block";
	document.getElementById("confirm-order").style.display = "none";
	var aTag = document.getElementById("step-"+depositCounter).getElementsByTagName("a");
	aTag[0].setAttribute("class", "");
	document.getElementById("deposit-section-"+depositCounter).style.display = "none";
	
	depositCounter--;
	if(depositCounter == 0){
		document.getElementById("deposit-back").style.display = "none";
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
function changePaymentType(paymentType){
	var aTag = document.getElementById("payment-type").getElementsByTagName("a");
	for(var i = 0; i < aTag.length; i++){
		aTag[i].setAttribute("class", "");
	}
	var errors = document.getElementById("deposit-section-2").getElementsByTagName("p");
	for(var i = 1; i <= errors.length; i++){
		document.getElementById("deposit-section-2").removeChild(errors[i-1]);
	}
	var amount = this.getAmount();
	switch(paymentType){
		case 'net-banking':
			if(amount < 100){
				$('.ttpaymentnav').before('<p class="error payment-error">Please deposit minimum Rs 100 or above. <a href="#" onclick="changeAmount()">change</a></p>');
				document.getElementById("confirm-order").style.display = "none";
			}
			else{
				document.getElementById("confirm-order").style.display = "block";
			}
			aTag[0].className = "current";
			document.getElementById("cod-form").style.display = "none";
			document.getElementById("debit-form").style.display = "none";
			document.getElementById("credit-form").style.display = "none";
			document.getElementById("bank-list").style.display = "block";
			document.getElementById("mol-form").style.display = "none";
			break;
		case 'cod':
			if(amount < 1000){
				$('.ttpaymentnav').before('<p class="error payment-error">Amount must be at least Rs 1000 for cash deposit.<a href="#" onclick="changeAmount()">change</a></p>');
				document.getElementById("confirm-order").style.display = "none";
			}
			else{
				document.getElementById("confirm-order").style.display = "block";
			}
			aTag[1].className = "current";
			document.getElementById("bank-list").style.display = "none";
			document.getElementById("debit-form").style.display = "none";
			document.getElementById("credit-form").style.display = "none";
			document.getElementById("cod-form").style.display = "block";
			document.getElementById("mol-form").style.display = "none";
			break;
		case 'debit-card':
			if(amount < 250){
				$('.ttpaymentnav').before('<p class="error payment-error">Please deposit minimum Rs 250 or above.<a href="#" onclick="changeAmount()">change</a></p>');
				document.getElementById("confirm-order").style.display = "none";
			}
			else{
				document.getElementById("confirm-order").style.display = "block";
			}
			aTag[2].className = "current";
			document.getElementById("bank-list").style.display = "none";
			document.getElementById("cod-form").style.display = "none";
			document.getElementById("debit-form").style.display = "block";
			document.getElementById("credit-form").style.display = "none";
			document.getElementById("mol-form").style.display = "none";
			break;
		case 'credit-card':
			if(amount < 250){
				$('.ttpaymentnav').before('<p class="error payment-error">Please deposit minimum Rs 250 or above.<a href="#" onclick="changeAmount()">change</a></p>');
				document.getElementById("confirm-order").style.display = "none";
			}
			else{
				document.getElementById("confirm-order").style.display = "block";
			}
			aTag[3].className = "current";
			document.getElementById("bank-list").style.display = "none";
			document.getElementById("cod-form").style.display = "none";
			document.getElementById("debit-form").style.display = "none";
			document.getElementById("credit-form").style.display = "block";
			document.getElementById("mol-form").style.display = "none";
			break;
		case 'mol':
			if(amount < 100){
				$('.ttpaymentnav').before('<p class="error payment-error">Please deposit minimum Rs 250 or above.<a href="#" onclick="changeAmount()">change</a></p>');
				document.getElementById("confirm-order").style.display = "none";
			}
			else if(amount > 8000){
				document.getElementById("confirm-order").style.display = "none";
				alert("You can't deposit more than Rs. 8000");
			}
			else{
				document.getElementById("confirm-order").style.display = "block";
			}
			aTag[4].className = "current";
			document.getElementById("bank-list").style.display = "none";
			document.getElementById("cod-form").style.display = "none";
			document.getElementById("debit-form").style.display = "none";
			document.getElementById("credit-form").style.display = "none";
			document.getElementById("mol-form").style.display = "block";
			break;
	}
}
function confirmOrder(){
	var aTags = document.getElementById("payment-type").getElementsByTagName("a");
	for(var i = 0; i < aTags.length; i++){
		if(aTags[i].className == "current"){
			var currentPaymentType = aTags[i].innerHTML;
		}
	}
	var post_vars = "ajax="+true+"&formName=payment&paymentType=";
	var error = false;
	switch(currentPaymentType){
		case 'Net Banking':
			var bankCode = document.getElementById("bankCode").value;
			var currentForm = document["player-netbanking-form"];
			var selectState = currentForm.getElementsByTagName("select");
			var currentState = selectState[0].value;
			if(currentState == "AS" || currentState == 'OR'){
				error = true;
				alert("Sorry! We are not accepting deposits from your region. Please contact Live Help for more information.");
			}
			post_vars += "NETBANKING&bankCode=" + bankCode;
			break;
		case 'Cash on Delivery':
			var city = document.getElementById("city").value;
			var playerName = document.getElementById("playerName").value;
			var address = document.getElementById("address").value;
			var contact = document.getElementById("contact").value;
			var pin = document.getElementById("pinCode").value;
			var currentForm = document["player-cod-form"];
			var selectState = currentForm.getElementsByTagName("select");
			var currentState = selectState[0].value;
			if(currentState == "AS" || currentState == 'OR'){
				error = true;
				alert("Sorry! We are not accepting deposits from your region. Please contact Live Help for more information.");
			}
			post_vars += "CASH&city="+city+"&playerName="+playerName+"&address="+address+"&contact="+contact+"&pin="+pin;
			break;
		case 'Debit Card':
			var playerName = document.getElementById("playerName").value;
			var contact = document.getElementById("playerContactNo").value;
			var email = document.getElementById("emailAddress").value;
			var playerAddress = document.getElementById("playerAddress").value;
                        var playerCity = document.getElementById("playerCity").value;
                        var playerPin = document.getElementById("playerPin").value;
			var currentForm = document["player-debit-form"];
			var selectState = currentForm.getElementsByTagName("select");
			var currentState = selectState[0].value;
			if(currentState == "AS" || currentState == 'OR'){
				error = true;
				alert("Sorry! We are not accepting deposits from your region. Please contact Live Help for more information.");
			}
//			post_vars += "DEBIT&playerName="+playerName+"&playerContactNo="+contact+"&emailAddress="+email;
			post_vars += "CREDIT&playerName="+playerName+"&playerAddress="+playerAddress+"&playerCity="+playerCity+
                                                "&playerPin="+playerPin+"&playerContactNo="+contact+"&emailAddress="+email+"&state="+currentState;
			break;
		case 'Credit Card':
			var playerName = document.getElementById("player_name").value;
			var playerAddress = document.getElementById("player_address").value;
			var playerCity = document.getElementById("player_city").value;
			var playerPin = document.getElementById("player_pin").value;
			var contact = document.getElementById("player_contact_no").value;
			var email = document.getElementById("email_address").value;
			/*var cardNo = document.getElementById("creditCardNo").value;
			var holderName = document.getElementById("cardHolder").value;
			var cvv = document.getElementById("cardCVV").value;
			var expiryYear = document.getElementById("cardExpiryYear").value;*/
			var currentForm = document["player-credit-form"];
			var selectElements = currentForm.getElementsByTagName("select");
			var currentState = selectElements[0].value;
			//var expiryMonth = selectElements[1].value;
			//var cardType = selectElements[2].value;
			if(currentState == "AS" || currentState == 'OR'){
				error = true;
				alert("Sorry! We are not accepting deposits from your region. Please contact Live Help for more information.");
			}
			if(currentState == 'TN'){
				//error = true;
				//alert("We currently accept Netbanking and Debit Card transactions only. Please use one of these to make the purchase.");
			}
//			post_vars += "CREDIT&playerName="+playerName+"&playerAddress="+playerAddress+"&playerCity="+playerCity+
//						"&playerPin="+playerPin+"&playerContactNo="+contact+"&emailAddress="+email+"&state="+currentState+
//						"&cardNo="+cardNo+"&holderName="+holderName+"&cvv="+cvv+"&expiryM="+expiryMonth+"&expiryY="+expiryYear+
//						"&cardType="+cardType;
			post_vars += "CREDIT&playerName="+playerName+"&playerAddress="+playerAddress+"&playerCity="+playerCity+
                                                "&playerPin="+playerPin+"&playerContactNo="+contact+"&emailAddress="+email+"&state="+currentState;
			break;
		case 'Mol':
			post_vars += "MOL";
			break;
	}
	if(!error){
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
			  			$('.ttpaymentnav').before('<p class="error payment-error">'+response[1]+'</p>');
			  		}
			  		if(response[0] == 'notice'){
			  			$('.ttdepol').before('<p class="notice">'+response[1]+'</p>');
			  		}
			  		if(response[0] == 'success'){
			  			window.location = response[1];
			  		}
			  	}
			});
	}
}

function changeAmount(){
	var errors = document.getElementById("deposit-section-2").getElementsByTagName("p");
	for(var i = 1; i <= errors.length; i++){
		document.getElementById("deposit-section-2").removeChild(errors[i-1]);
	}
	document.getElementById("deposit-next").style.display = "block";
	document.getElementById("confirm-order").style.display = "none";
	document.getElementById("deposit-back").style.display = "none";
	var aTag = document.getElementById("step-"+depositCounter).getElementsByTagName("a");
	aTag[0].setAttribute("class", "");
	document.getElementById("deposit-section-"+depositCounter).style.display = "none";
	
	depositCounter = 0;
	
	var aTag = document.getElementById("step-"+depositCounter).getElementsByTagName("a");
	aTag[0].setAttribute("class", "current");
	document.getElementById("deposit-section-"+depositCounter).style.display = "block";
}

function getLevels(tournament_id){
	$.ajax({
		  type: "POST",
		  url: "/tournament/current",
		  data: {tournamentId:tournament_id},
		  success: function(data){
			  var response = data.split('&');
			  var objArray = new Object();
			  for(var i=0; i<response.length; i++){
				  var temp = response[i].split("=");
				  objArray[temp[0].trim()] = temp[1].trim();
			  }
			  if(objArray.error == 1){
				  alert(objArray.msg);
			  }
			  else{
				  var currentLevel = objArray.currentLevel;
				  var tournamentId = objArray.tournamentId;
				  var noOfLevels = objArray.noOfLevels;
				  var registeredLevel = objArray.levelId;
				  var entryFee = objArray.entryFee;
				  var amount = objArray.amount;
				  var runningLevel = currentLevel;
				  var tournamentState = objArray.tournamentState;
				  var entryFeeArray = entryFee.split("|");
				  var amountArray = amount.split("|");
				  currentLevel = parseInt(currentLevel);
				  var displayLevels = true;
				  
				  var displayMessage = "";
				  if((currentLevel != -1) && (currentLevel <= noOfLevels)){
					  displayMessage = "Level-" + currentLevel + " is in progress.";
				  }
				  if(registeredLevel != -1){
					  displayMessage += " You are registered for Level-" + registeredLevel + ".";
					  if(registeredLevel > 1){
						  displayMessage += " You can also play ";
						  for(var j = 1; j < registeredLevel; j++){
							  displayMessage += "Level-" + j + " ";
						  }
					  }
				  }

				  if((currentLevel != -1) && (currentLevel <= registeredLevel)){
					  if(currentLevel < registeredLevel){
						  displayLevels = false;
						  window.location = "/game/quickjoin/tournamentId/"+tournamentId+"/level/"+currentLevel;
					  }
					  else{
						  switch(tournamentState){
						  	case 'InProgress':
						  		displayLevels = false;
						  		window.location = "/game/quickjoin/tournamentId/"+tournamentId+"/level/"+currentLevel;
						  		break;
						  	case 'RegAndProgress':
						  		displayLevels = false;
						  		window.location = "/game/quickjoin/tournamentId/"+tournamentId+"/level/"+currentLevel;
						  		break;
						  	case 'InBreak':
						  		displayMessage = "Level-" + currentLevel + " is completed. You were regisered for level-" + currentLevel;
						  		currentLevel++;
						  		break;
						  	case 'Completed':
						  		displayMessage = "Level-" + currentLevel + " is completed. You were regisered for level-" + currentLevel;
						  		currentLevel++;
						  		break;
						  }
					  }
					  //window.location = "/game/quickjoin/tournamentId/"+tournamentId+"/level/"+currentLevel;
				  }
				  else{
					  if(currentLevel == -1){
						  currentLevel = 1;
					  }
					  currentLevel = parseInt(currentLevel);
					  switch(tournamentState){
					  	case 'InProgress':
					  		currentLevel++;
					  		break;
					  	case 'RegAndProgress':
					  		break;
					  	case 'InBreak':
					  		currentLevel++;
					  		break;
					  	case 'Completed':
					  		currentLevel++;
					  		break;
					  }
				  }
				  if(displayLevels){
					  var addMessageDiv = document.getElementById("lgtboxmsg");
					  var onlineTournament = document.getElementById("ttldislevel");
					  onlineTournament.innerHTML = "";
					  var headtr = document.createElement("tr");
					  var levelth = document.createElement("th");
					  levelth.setAttribute("width", "25%");
					  //levelDiv.setAttribute("class", "ttlgtboxlvlcontl");
					  levelth.innerHTML = "Level";
					  
					  var balth = document.createElement("th");
					  balth.setAttribute("width", "25%");
					  //balDiv.setAttribute("class", "ttlgtboxlvlcontm");
					  balth.innerHTML = "Starting<br/>Balance";
					  
					  var feeth = document.createElement("th");
					  feeth.setAttribute("width", "25%");
					  //feeDiv.setAttribute("class", "ttlgtboxlvlcontr");
					  feeth.innerHTML = "Entry Free";
					  
					  var extrath = document.createElement("th");
					  extrath.setAttribute("width", "25%");
					  extrath.innerHTML = "&nbsp;";
					  
					  headtr.appendChild(levelth);
					  headtr.appendChild(balth);
					  headtr.appendChild(feeth);
					  headtr.appendChild(extrath);
					  onlineTournament.appendChild(headtr);
					  
					  addMessageDiv.innerHTML = displayMessage;
					  //addMessageDiv.innerHTML = "Hey";
					  
					  for(var i = currentLevel; i <= noOfLevels; i++){
						  var innertr = document.createElement("tr");
						  /*var mainDiv = document.createElement("div");
						  mainDiv.setAttribute("id", "ttlgtboxlvlcont");*/
						  
						  var td1 = document.createElement("td");
						  //div1.setAttribute("class", "ttlgtboxlvlcontl ttlgtboxlvlsiz");
						  td1.innerHTML = i;
						  
						  var td2 = document.createElement("td");
						  //div2.setAttribute("class", "ttlgtboxlvlcontm ttlgtboxlvlcol");
						  td2.innerHTML = entryFeeArray[i-1];
						  
						  var td3 = document.createElement("td");
						  td3.innerHTML = amountArray[i-1];
						  
						  var td4 = document.createElement("td");
						  //div3.setAttribute("class", "ttlgtboxlvlcontr");
						  
						  var inputButton = document.createElement("input");
						  inputButton.setAttribute("type", "button");
						  inputButton.setAttribute("class", "ttlgtboxlvlbtn");
						  if(runningLevel != -1 && i <= registeredLevel){
							  inputButton.setAttribute("value", "Join");
						  }
						  else{
							  inputButton.setAttribute("value", "Buy");
						  }
						  inputButton.setAttribute("onclick", "registerTournament(" + tournament_id + "," + i + "," + runningLevel + ")");
						  
						  td4.appendChild(inputButton);
						  innertr.appendChild(td1);
						  innertr.appendChild(td2);
						  innertr.appendChild(td3);
						  innertr.appendChild(td4);
						  onlineTournament.appendChild(innertr);
					  }
					  
					  var lasttr = document.createElement("tr");
					  
					  var ltd1 = document.createElement("td");
					  ltd1.innerHTML = "&nbsp;";
					  var ltd2 = document.createElement("td");
					  ltd2.innerHTML = "&nbsp;";
					  var ltd3 = document.createElement("td");
					  ltd3.innerHTML = "&nbsp;";
					  var ltd4 = document.createElement("td");
					  ltd4.innerHTML = "&nbsp;";
					  
					  lasttr.appendChild(ltd1);
					  lasttr.appendChild(ltd2);
					  lasttr.appendChild(ltd3);
					  lasttr.appendChild(ltd4);
					  onlineTournament.appendChild(lasttr);

					 /* $("#ttlight_bg").fadeIn("slow");
					  $("#ttlogin-box").fadeIn("slow");
					  $("body").css("overflow","hidden");*/
				  }
				 
			  }
//			  $("#light_bg").fadeIn("slow");
//			  $("#online-tournament").fadeIn("slow");
//			  $("body").css("overflow","hidden");
		  	}
		});
}
function closeTournamentJoin(){
	$("#ttlight_bg").fadeOut("slow");
	$("#ttlogin-box").fadeOut("slow");
	$("body").css("overflow","visible");
}

function registerTournament(tournamentId, levelId, currentLevel){
	if(currentLevel != -1){
		window.location = "/tournament/register/tournamentId/"+tournamentId+"/level/"+levelId+"/currentLevel/"+currentLevel;
	}
	else{
		window.location = "/tournament/register/tournamentId/"+tournamentId+"/level/"+levelId;
	}
}

function changeIdProof()
{
	if(document.getElementById("idproof_form-label") != undefined){
		document.getElementById("idproof_form-label").textContent = "ID Proof";
	}
	if(document.getElementById("address_form-label") != undefined){
		document.getElementById("address_form-label").textContent = "Address Proof";
	}
	if(document.getElementById("bank_detail_form-label") != undefined){
		document.getElementById("bank_detail_form-label").textContent = "Bank Details";
	}
	if(document.getElementById("idproof_form-idproof") != undefined){
		var currentIdProof = document.getElementById("idproof_form-idproof").value;
		if(currentIdProof == 'OTHER'){
			document.getElementById("player_idproofother").style.display = "block";
			document.getElementById("player_idproofnumber").style.display = "block";
			document.getElementById("player_idproofauthority").style.display = "block";
			document.getElementById("player_idproofexpiry").style.display = "block";
		}
		else{
			document.getElementById("player_idproofother").style.display = "none";
			document.getElementById("player_idproofnumber").style.display = "none";
			document.getElementById("player_idproofauthority").style.display = "none";
			document.getElementById("player_idproofexpiry").style.display = "none";
		}
	}
	if(document.getElementById("address_form-addressproof") != undefined){
		var addressProof = document.getElementById("address_form-addressproof").value;
		if(addressProof == 'OTHER'){
			document.getElementById("player_otheraddressproof").style.display = "block";
			document.getElementById("player_addressproofnumber").style.display = "block";
			document.getElementById("player_addressproofauthority").style.display = "block";
			document.getElementById("player_addressproofexpiry").style.display = "block";
		}
		else{
			document.getElementById("player_otheraddressproof").style.display = "none";
			document.getElementById("player_addressproofnumber").style.display = "none";
			document.getElementById("player_addressproofauthority").style.display = "none";
			document.getElementById("player_addressproofexpiry").style.display = "none";
		}
	}
}

function convertFunCoins(){
	var amountChecked = false;
	var amount = 0;
	var amountOptions = document.getElementById('funcoin-amount').getElementsByTagName('input');
	for(var i = 0; i < amountOptions.length; i++){
		if(amountOptions[i].checked){
			window.location = "/banking/funcoins/amount/" + amountOptions[i].value;
		}
	}
}

function getTicketData(ticketId, ticketSub){
	var cookies = document.cookie.split(";");
	var prevTicketId = "";
	
	for(var i = 0; i < cookies.length; i++){
		if(cookies[i].indexOf("ticketId") != -1){
			var splitCookie = cookies[i].split("=");
			prevTicketId = splitCookie[1];
		}
	}
	var userName = "";
	var subject = "";
	var time = "";
	var cross = "";
	if(prevTicketId){
		userName = document.getElementById("username-" + prevTicketId);
		userName.removeAttribute("class");
		
		subject = document.getElementById("subject-" + prevTicketId);
		subject.removeAttribute("class");
		
		time = document.getElementById("time-" + prevTicketId);
		time.removeAttribute("class");
		
		cross = document.getElementById("cross-" + prevTicketId);
		cross.removeAttribute("class");
	}
	var d	=	new Date();
	d.setFullYear(d.getFullYear(),d.getMonth()+1,d.getDate());
	document.cookie = "ticketId=" + ticketId + "; expires="+d.toGMTString()+"; path=/";
	
	userName = document.getElementById("username-" + ticketId);
	userName.setAttribute("class", "ttcurrentmsg");;
	
	subject = document.getElementById("subject-" + ticketId);
	subject.setAttribute("class", "ttcurrentmsg");;
	
	time = document.getElementById("time-" + ticketId);
	time.setAttribute("class", "ttcurrentmsg");;
	
	cross = document.getElementById("cross-" + ticketId);
	cross.setAttribute("class", "ttcurrentmsg");;
	
	$.ajax({
		  type: "POST",
		  url: "/ticket/view",
		  data: {ticket_id:ticketId},
		  success: function(data){
		  }
		});
	$.ajax({
		  type: "POST",
		  url: "/ticket/reply",
		  data: {ticket_id:ticketId, subject:ticketSub},
		  success: function(data){
			  document.getElementById("view-msg").innerHTML = "";
			  var response = data.split('&');
			  var senders = response[0].split('|');
			  var messages = response[1].split('|');
			  var ticketId = response[2];
			  var subject = response[3];
			  var time = response[4].split('|');
			  var view_message = '<table width="100%" cellspacing="0" cellpadding="0" border="0">';
			  for(var i = 0; i < senders.length - 1; i++){
				  view_message += '<tr><th>' + senders[i] + '</th><th>SUB: '; 
				  subject = response[3];
				  if(i != senders.length - 2){
					  subject = "RE[" + subject + "]";
				  }
				  view_message += subject + '</th><th>Time: ' + time[i] + '</th></tr><tr><td class = "ttfrommsgtdbg">' + messages[i] + '</td></tr>';
			  }
			  view_message += '</table><div class="ttreplaymsg"><textarea id="reply-message" name="" cols="" rows="" class="ttmsgtextarea" placeholder="Reply">' +
  							'</textarea></div><div class="ticket-submit"><input name="" type="button" value="Reply" class="ttdepolnextbackbtn" id="submit" onclick="postTicketReply('+
  							ticketId+')"></div>'
			  document.getElementById("view-msg").innerHTML = view_message;
		  }
		});
}

function postTicketReply(ticketId){
	var message = document.getElementById("reply-message").value;
	$.ajax({
		  type: "POST",
		  url: "/ticket/reply",
		  data: {ticket_id:ticketId, replyMsg:message},
		  success: function(data){
			  getTicketData(data);
		  }
	});
}

function deletemessage(ticketId){
	$.ajax({
		  type: "POST",
		  url: "/ticket/delete",
		  data: {ticket_id:ticketId},
		  success: function(data){
			  if(data == 1){
				  window.location = '/ticket/view'; 
			  }
			  else{
				  alert("Some problem has been occured while deleting the message.")
			  }
		  }
	});
}
function getLiveTables(){
	$.ajax({
		  type: "POST",
		  url: "/auth/level",
		  data: {variable:'live'},
		  success: function(data){
			  document.getElementById("live-tables").textContent = data;
		  }
	});
}

function showInviteFriend(){	
	var isSet = false;
	var cookies = document.cookie.split(";");
	for(var i = 0; i < cookies.length; i++){
		if(cookies[i].indexOf("inviteFriends") != -1){
			var splitCookie = cookies[i].split("=");
			isSet = splitCookie[1];
		}
	}
	if(!isSet){
		var d	=	new Date();
		d.setFullYear(d.getFullYear(),d.getMonth(),d.getDate()+1);
		document.cookie = "inviteFriends=" + true + "; expires="+d.toGMTString()+"; path=/";
		document.getElementById("invite-friends-form").style.display = "block";
	}
}

function removeInviteFriendCookie(){
	var d	=	new Date();
	d.setFullYear(d.getFullYear(),d.getMonth(),d.getDate());
	document.cookie = "inviteFriends=" + true + "; expires="+d.toGMTString()+"; path=/";
}

function closeInviteForm(){
	document.getElementById("invite-friends-form").style.display = "none";
}
