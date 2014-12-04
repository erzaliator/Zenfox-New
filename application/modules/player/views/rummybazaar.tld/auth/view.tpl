<style>
.profile-structure
{
	width: 100%;
	float: left;
	margin-bottom: 15px;
	max-width: 450px;
	margin-left: 19%;
	margin-top: 5%;
	padding: 4% 0;
	background: #055c35;
	border-radius: 4px;
	border: 1px solid;
	box-shadow: 0 0 15px;
}
.profile-inner
{
	width: 100%;
	float: left;
	padding-bottom: 5px;
	color:#fff;
}
.profile-left
{
	width: 45%;
	float: left;
	text-align: right;
	margin-right: 5%;
}
.profile-right
{
	width: 50%;
	float: left;
}
</style>


<div class="profile-structure">
	<div class="profile-inner">
		<div class="profile-left">Username :</div>
	    <div class="profile-right">
	      	{$playerData.login}
	    </div>
	</div>
	<div class="profile-inner">
		<div class="profile-left">First Name :</div>
	    <div class="profile-right">
	       	{$playerData.firstName}
	    </div>
	</div>
	    <div class="profile-inner">
	        <div class="profile-left">Last Name :</div>
	        <div class="profile-right">
	        	{$playerData.lastName}
	        </div>
	    </div>
	    <div class="profile-inner">
	        <div class="profile-left">Email ID :</div>
	        <div class="profile-right">
	        	{$playerData.email}
	        </div>
	    </div>
	    <div class="profile-inner">
	        <div class="profile-left">Sex :</div>
	        <div class="profile-right">
	        	{if $playerData.sex eq 'M'}
	        		Male
	        	{elseif $playerData.sex eq 'F'}
	        		Female
	        	{/if}
	        </div>
	    </div>
	    <div class="profile-inner">
	        <div class="profile-left">DOB :</div>
	        <div class="profile-right">
	        	{$playerData.dateOfBirth}
	        </div>
	    </div>
	    <div class="profile-inner">
	        <div class="profile-left">Address :</div>
	        <div class="profile-right">
	        	{$playerData.address}
	        </div>
	    </div>
	    <div class="profile-inner">
	        <div class="profile-left">City :</div>
	        <div class="profile-right">
	        	{$playerData.city}
	        </div>
	    </div>
	    <div class="profile-inner">
	        <div class="profile-left">State :</div>
	        <div class="profile-right">
	        	{$playerData.state}
	        </div>
	    </div>
	    <div class="profile-inner">
	        <div class="profile-left">Pincode :</div>
	        <div class="profile-right">
	        	{$playerData.pin}
	        </div>
	    </div>
	    <div class="profile-inner">
	        <div class="profile-left">Country :</div>
	        <div class="profile-right">
	        	<input type="hidden" name="country" id="amount" value="IN">
	        	{$playerData.country}
	        </div>
	    </div>
	    <div class="profile-inner">
	        <div class="profile-left">Phone Number :</div>
	        <div class="profile-right">
	        	{$playerData.phone}
	        </div>
	    </div>
	</div>
