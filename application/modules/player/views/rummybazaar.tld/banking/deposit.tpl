{if not isset($ajaxReq)}
	<style>
	.sel-amt
	{
		float: left;
		clear: both;
		width: 94%;
		background: #fff;
		color: #000;
		padding: 3% 3%;
	}
	.select-amount
	{
		float:left;
		list-style:none;
		padding:0;
		margin:0;
	}
	.select-amount li
	{
		padding-bottom:15px;
	}
	#amt-mid
	{
		margin:0 70px;
	}
	.amt-mid
	{
		margin-left:100px;
	}
	.bank-purchase
	{
		background:#000;
		float:left;
	}
	.bank-purchase li
	{
		float:left;
		padding: 0;
	}
	.bank-purchase li a
	{
		color: #fff;
		padding: 10px 67px;
		float:left;
		border-right:1px solid #fff;
		background: none;
	}
	.bank-purchase li a.last
	{
		border-right:none;
	}
	.bank-purchase li a.active,.bank-purchase li a:hover
	{
		background: #7d0705;
	}
	.next
	{
		float: left;
		clear: both;
		background: #000;
		padding: 2% 2%;
		width: 96%;
	}
	.next input[type="button"]
	{
		cursor:pointer;
		margin:0;
		float: right;
	}
	.flow-back
	{
		float: left;
		clear: both;
		background: #000;
		width: 100%;
		padding: 10px 0;
		border-top: 1px solid #fff;
		border-bottom: 1px solid #fff;
	}
	.flow-back .button-green
	{
		float:left;
		cursor:pointer;
	}
	.select-structure
	{
		width: 100%;
		background: #ccc;
		border: 1px solid #fff;
		float: left;
	}
	#bank-list
	{
		display:none;
	}
	.select-structure
	{
		background:none;
	}
	.deposit-form
	{
		border: 1px solid #fff;
		float: left;
		width: 100%;
		margin-bottom: 5%;
		padding-bottom: 2%;
	}
	.flow-back
	{
		float: none;
		text-align: center;
		background: #055c35;
		padding: 2% 0;
	}
	.warning
	{
		padding: 2%;
	}
	#profile-form
	{
		padding: 2%;
	}
	#profile-form .zend_form ul
	{
		float: left;
	}
	#profile-form .zend_form ul li
	{
		float: left;
		width: 100%;
		padding-bottom: 15px;
	}
	#profile-form .zend_form ul li label
	{
		float: left;
		text-align: right;
		width: 150px;
		margin-right: 35px;
		font-size: 15px;
	}
	#profile-form .zend_form ul li input[type="text"]
	{
		float: left;
		height: 28px;
		width: 225px;
		padding-left:5px;
	}
	#profile-form .zend_form ul li select
	{
		width: 225px;
		height: 34px;
		padding-left:5px;
	}
	#deposit-section-1 .select-structure
	{
		border:none;
	}
	#profile-form .zend_form
	{
		width: 100%;
	}
	#bank-list
	{
		float: left;
		padding: 3% 5%;
		width: 90%;
		background: #fff;
		color: #000;
		border-top: 3px solid #055c35;
	}
	#bankCode
	{
		padding: 10px;
	}
	#deposit-section-2 .next input[type="button"], #deposit-section-1 .next input[type="button"]
	{
       float:left;
	}
	</style>
	
	<script src="/js/ace2jak/payment.js"></script>
	
	<!------------Structure for Select Amount-------->
	<div id="deposit-section-0" style="display:{($amount)?'none':'block'};">
		<div class="select-structure">
			<ul class="bank-purchase">
				<li><a href="javascript:void(0)" class="active">Select Amount</a></li>
				<li><a href="javascript:void(0)">Complete Profile</a></li>
				<li><a href="javascript:void(0)" class="last">Mode of Payment</a></li>
			</ul>
			<div class="flow-back"><span id="selected-amount-0"></span></div>
			<form class="sel-amt">
				<ul class="select-amount">
					<li><input type="radio" value="100" id="amount-1" name="radio" /><label>Rs. 100</label></li>
					<li><input type="radio" value="1000" id="amount-4" name="radio" /><label>Rs. 1000</label></li>
					<li><input type="radio" name="radio" /><label>Custom Rs&nbsp;<input id="custom-amount" type="text" style="width:100px" name=""></label></li>
				</ul>
	    		<ul class="select-amount" id="amt-mid">
					<li><input type="radio" value="250" id="amount-2" name="radio" /><label>Rs. 250</label></li>
					<li><input type="radio" value="2000" id="amount-5" name="radio" /><label>Rs. 2000</label></li>
				</ul>
				<ul class="select-amount">
					<li><input type="radio" value="500" id="amount-3" name="radio" /><label>Rs. 500</label></li>
					<li><input type="radio" value="5000" id="amount-6" name="radio" /><label>Rs. 5000</label></li>
				</ul>
	    	</form>
	    	<div class="next"><input name="" type="button" value="Next" class="button-green" onclick="nextDepositSec()"></div>
		</div>
	</div>
	
	
	<div id="deposit-section-1" style="display:{($amount)?'block':'none'};">
		<div class="select-structure">
			<div class="deposit-form">
				<ul class="bank-purchase">
					<li><a href="javascript:void(0)">Select Amount</a></li>
		    		<li><a href="javascript:void(0)" class="active">Complete Profile</a></li> 
					<li><a href="javascript:void(0)" class="last">Mode of Payment</a></li> 
				</ul>
				<div class="flow-back"><span id="selected-amount-1"></span></div>
				{if not $completed}
					<div class="warning" style="font-size:14px;"><b style="font-size:16px;">Note:</b> It is very essential to provide correct profile information. If found any fraudulent information, management has the right to close account and reset the account balance to zero.!!</div>
				{/if}
				<div class="ttpaymentcont" id="profile-form">
					<form name = "player-profile-form">
	            		<div id="inner-box">
	              			<dl class="zend_form">
	                			<ul>
		                  			<li>
		                    			<label class="optional" for="firstName">First Name*</label>
		                    			<input type="text" value="{$firstName}" id="firstName" name="firstName" {($firstName)?"disabled":""}>
		                  			</li>
						  			<li>
		                    			<label class="optional" for="lastName">Last Name*</label>
		                    			<input type="text" value="{$lastName}" id="lastName" name="lastName" {($lastName)?"disabled":""}>
		                  			</li>
						  			<li>
										<label class="optional" for="sex">Sex*</label>
		                    			<select name="sex" id="sex" style="width:100px" {($sex)?"disabled":""}>
		                      				<option label="Male" value="M" {($sex == 'M')?"selected":""}>Male</option>
							  				<option label="Female" value="F" {($sex == 'F')?"selected":""}>Female</option>
		                     			</select>
						  			</li>
						  			<li>
										<label for="dateofbirth" class="required">Date Of Birth *</label>
										<input type="text" name="dateofbirth" id="datepicker" value="{$dob}" {($this->dob neq '0000-00-00')?"disabled":""}>
									</li>
		                  			<li>
		                    			<label class="optional" for="contactNo">Contact No*</label>
		                    			<input type="text" value="{$phone}" id="contactNo" name="contactNo" {($phone)?"disabled":""}>
		                  			</li>
		                  			<li>
		                    			<label class="optional" for="emailAddress">Email*</label>
		                    			<input type="text" value="{$email}" id="emailAddress" name="emailAddress" {($email)?"disabled":""}>
		                  			</li>
									<li>
		                    			<label class="optional" for="address">Address*</label>
		                    			<input type="text" value="{$address}" id="address" name="address" {($address)?"disabled":""}>
		                  			</li>
									<li>
		                    			<label class="optional" for="city">City*</label>
		                    			<input type="text" value="{$city}" id="city" name="city" {($city)?"disabled":""}>
		                  			</li>
		                  			<li>
		                    			<label class="optional" for="pin">Pincode*</label>
		                    			<input type="text" value="{$pin}" id="pin" name="pin" {($pin)?"disabled":""}>
		                  			</li>
		                  			<li>
		                    			<label class="optional" for="state">Select State*</label>
		                    			<select name="state" id="state" style="width:150px" {($state)?"disabled":""}>
				                      		<option label="Andhra Pradesh" value="AP" {($state == 'AP')?"selected":""}>Andhra Pradesh</option>
					                      	<option label="Andaman and Nicobar Islands" value="AN" {($state == 'AN')?"selected":""}>Andaman and Nicobar Islands</option>
					                      	<option label="Arunachal Pradesh" value="AR" {($state == 'AR')?"selected":""}>Arunachal Pradesh</option>
					                      	<option label="Assam" value="AS" {($state == 'AS')?"selected":""}>Assam</option>
					                      	<option label="Bihar" value="BR" {($state == 'BR')?"selected":""}>Bihar</option>
					                      	<option label="Chandigarh" value="CH" {($state == 'CH')?"selected":""}>Chandigarh</option>
					                      	<option label="Chhattisgarh" value="CT" {($state == 'CT')?"selected":""}>Chhattisgarh</option>
					                      	<option label="Delhi" value="DL" {($state == 'DL')?"selected":""}>Delhi</option>
					                      	<option label="Goa" value="GA" {($state == 'GA')?"selected":""}>Goa</option>
					                      	<option label="Gujarat" value="GJ" {($state == 'GJ')?"selected":""}>Gujarat</option>
					                      	<option label="Haryana" value="HR" {($state == 'HR')?"selected":""}>Haryana</option>
					                      	<option label="Himachal Pradesh" value="HP" {($state == 'HP')?"selected":""}>Himachal Pradesh</option>
					                      	<option label="Jammu and Kashmir" value="JK" {($state == 'JK')?"selected":""}>Jammu and Kashmir</option>
					                      	<option label="Jharkhand" value="JH" {($state == 'JH')?"selected":""}>Jharkhand</option>
					                      	<option label="Karnataka" value="KA" {($state == 'KA')?"selected":""}>Karnataka</option>
					                      	<option label="Kerala" value="KL" {($state == 'KL')?"selected":""}>Kerala</option>
					                      	<option label="Lakshadweep" value="LD" {($state == 'LD')?"selected":""}>Lakshadweep</option>
					                      	<option label="Madhya Pradesh" value="MP" {($state == 'MP')?"selected":""}>Madhya Pradesh</option>
					                      	<option label="Maharashtra" value="MH" {($state == 'MH')?"selected":""}>Maharashtra</option>
					                      	<option label="Manipur" value="MN" {($state == 'MN')?"selected":""}>Manipur</option>
					                      	<option label="Meghalaya" value="ML" {($state == 'ML')?"selected":""}>Meghalaya</option>
					                      	<option label="Mizoram" value="MZ" {($state == 'MZ')?"selected":""}>Mizoram</option>
					                      	<option label="Nagaland" value="NL" {($state == 'NL')?"selected":""}>Nagaland</option>
					                      	<option label="Orissa" value="OR" {($state == 'OR')?"selected":""}>Orissa</option>
					                      	<option label="Puducherry" value="PY" {($state == 'PY')?"selected":""}>Puducherry</option>
					                      	<option label="Punjab" value="PB" {($state == 'PB')?"selected":""}>Punjab</option>
					                      	<option label="Rajasthan" value="RJ" {($state == 'RJ')?"selected":""}>Rajasthan</option>
					                      	<option label="Sikkim" value="SK" {($state == 'SK')?"selected":""}>Sikkim</option>
					                      	<option label="Tamil Nadu" value="TN" {($state == 'TN')?"selected":""}>Tamil Nadu</option>
					                      	<option label="Tripura" value="TR" {($state == 'TR')?"selected":""}>Tripura</option>
					                      	<option label="Uttarakhand" value="UT" {($state == 'UT')?"selected":""}>Uttarakhand</option>
					                      	<option label="Uttar Pradesh" value="UP" {($state == 'UP')?"selected":""}>Uttar Pradesh</option>
					                      	<option label="West Bengal" value="WB" {($state == 'WB')?"selected":""}>West Bengal</option>
		                    			</select>
		                  			</li>
				  					<li><input type="hidden" value="IN" id="country" name="country"></li>
		                		</ul>
	              			</dl>
	            		</div>
	         		</form>
	          		<div class="next">
			          	<input name="" type="button" value="Back" class="button-green" onclick="prevDepositSec('{$completed}')">
			          	<input name="" type="button" value="Next" style="float: right;" class="button-green" onclick="nextDepositSec()">
	          		</div>
	        	</div>
	        </div>
		</div>
	</div>
	
	<!--------------Structure for Mode of Paymemt-------->
	<div id="deposit-section-2" style="display:{($amount)?'block':'none'};">
		<div class="select-structure">
			<ul class="bank-purchase">
				<li><a href="javascript:void(0)">Select Amount</a></li>
	    		<li><a href="javascript:void(0)">Complete Profile</a></li>
				<li><a href="javascript:void(0)" class="active last">Mode of Payment</a></li> 
			</ul>
			<div class="flow-back"><span id="selected-amount-2"></span></div>
			<form class="sel-amt"> 
				{if $gateway neq 'MOBIKWIK'}
					<ul class="select-amount">
						<li><input type="radio" name="payment-option" value="NETBANKING" onclick="checkPaymentType('NETBANKING')" /><label>Net Banking</label></li>
					</ul>
					<ul class="select-amount amt-mid">
						<li><input type="radio" name="payment-option" value="CREDIT" onclick="checkPaymentType('CREDIT')" /><label>Credit</label></li>
					</ul>
					<ul class="select-amount amt-mid">
						<li><input type="radio" name="payment-option" value="DEBIT" onclick="checkPaymentType('DEBIT')" /><label>Debit</label></li>
					</ul>
				{/if}
	    		<!-- ul class="select-amount amt-mid">
				    <li><input type="radio" name="payment-option" value="MOBIKWIK" onclick="checkPaymentType('MOBIKWIK')" /><label>Mobikwik</label></li>       
	    		</ul-->
	    	</form>
	    	<div class="ttpaymentcont" id="bank-list">
	    		<span style="font-weight:bold">Select Bank</span>
	            <select name="bankCode" id="bankCode">
					{if isset($this->banksList)}
						{foreach from=$banksList key=bankName item=code}
							<option label="{$bankName}" value="{$code}">{$bankName}</option>
						{/foreach}
					{/if}
	            </select>
			</div>
	    	<div class="next">
	    		<input name="" type="button" value="Back" class="button-green" onclick="prevDepositSec('{$completed}')">
	    		<input name="" type="button" value="Confirm Order" style="float: right;" class="button-green" onclick="confirmOrder()">
	    	</div>
		</div>
	</div>
{/if}