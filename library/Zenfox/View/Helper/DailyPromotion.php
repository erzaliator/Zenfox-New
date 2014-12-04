<?php
class Zenfox_View_Helper_DailyPromotion extends Zend_View_Helper_Abstract
{
	/**
	 * @var Zend_View_Instance
	 */ 
	public $view; 
	 
	/**
	 * Set view object
	 * 
	 * @param  Zend_View_Interface $view 
	 * @return Zend_View_Helper_Form
	 */ 
	public function setView(Zend_View_Interface $view) 
	{ 
	    $this->view = $view;
	}

	public function DailyPromotion($data)
	{
		$date = Zend_Date::now();
 		$day = $date->get(Zend_Date::WEEKDAY);
		if($day == "Monday")
		{
			$title = "Double Your Deposit!";
		}
		elseif($day = "Tuesday")
		{
			 $title = "Double Your Deposit!";
		}
		elseif($day = "Wednesday")
		{
			 $title = "Claim Rs 50 Free now!";
		}
		elseif($day = "Thursday")
		{
			 $title = "Claim Rs 50 Free now!";
		}
		elseif($day = "Friday")
		{
		 $title = "Deposit Bonanza!";
		}
		elseif($day = "Saturday")
		{
		 $title = "Weekend Free Giveaways!";
		}
		elseif($day = "Sunday")
		{
		 $title = "Weekend Free Giveaways!";
		}
		//Zenfox_Debug::dump($day);
		?>
       <script type="text/javascript">
       
		function closeDailyWinner(){
			document.getElementById("daily-promotion").style.display = "none";
		}
		function displayDailyWinner(){
			
			$('#popup_box').fadeIn("slow");
			$(".overlay").toggle();
			
		}
		function closeDailyPromotions(){	
			$('#popup_box').fadeOut("fast");
			$(".overlay").toggle();
		}
		</script>
		<script src="https://code.jquery.com/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="/countdown/jquery.countdown.js"></script>
      
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" />
		<link rel="stylesheet" href="/countdown/countdown.css" />
		</script>
		<div id="popup_box" class="popup_box" >
			<span id="popupBoxClose" onclick="closeDailyPromotions()">X</span>
			<span id="countdown1" class="on-pop-up"></span>
			<img style="border:0px" src ="/css/rummy.tld/images/dealofthedaypromotions/<?=$day?>.jpg">
			<span id="deposit_now_button" href="/banking/deposit">
				<a href = "/banking/deposit"><span class= "deposit_now_button_text">Deposit Now</span>
				<img class= "deposit_now_button"  src ="/css/rummy.tld/images/dealofthedaypromotions/blank_button.png"></a>
			</span>
		</div>
		<div class = "daily-winner" id="daily-promotion">
				<span style="color:white;" class="daily-winner-close" onclick="closeDailyWinner()">X</span>
				<div style="color:yellow;margin-top:102px;font-weight:bold;font-size:14px;width:215px;position:fixed;" class="daily-winner-heading" ><?=$title?></div></br>
				<span style="color:#f0ff04;font-weight:bold;margin-top:135px;margin-left:-105px;font-size:15px;width:210px;position:fixed;" class="daily-winner-note" >Offer Ends in</span>
				<span id="countdown"></span>
				<div style="margin-top:40px;cursor:pointer;height:20px" onclick="displayDailyWinner()">
					<img  style="margin-top:194px;margin-left:-88px;font-weight:bold;position: fixed;font-size:18px;width:180px;"src ="/css/rummy.tld/images/dealofthedaypromotions/blank_button.png" /></a>
					<span style="color:white;margin-top:200px;margin-left:-48px;position: fixed;font-weight:bold;font-size:21px;align:center;" class= "daily-winner-button-text">Get Now</span>
				</div>
				
		</div>
		<div class="overlay" onclick="closeDailyPromotions()"></div>
		<script type="text/javascript" src="/countdown/countdown.js"></script>
		<script>
		//displayDailyWinner();
		</script>
		<?php 
	}
}
