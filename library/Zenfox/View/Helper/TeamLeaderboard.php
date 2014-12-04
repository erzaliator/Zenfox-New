<?php
class Zenfox_View_Helper_TeamLeaderboard extends Zend_View_Helper_Abstract
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

	public function teamLeaderboard($leaderboardId,$playerId)
	{
      	
		//echo $teamRummy->teamrummy;
      	$teamRummy = new Zend_Session_Namespace('teamRummy');
      	
      	
      	
		$leaderBoardDataObj = new LeaderBoardData();
		$playerStatus = $leaderBoardDataObj->checkPlayerStatus($leaderboardId,$playerId);
		
		//echo $playerId."leaderboardId:".$playerStatus;
		
		$leaderBoardTeamsObj = new LeaderBoardTeams();
		$teamsData = $leaderBoardTeamsObj->getleaderboardteams($leaderboardId);
		
		if((!$playerStatus) && ($teamRummy->displayteams))
		{
			$teamRummy->displayteams = false ;
		?>

		
		<style type="text/css">
/* popup_box DIV-Styles*/
#popup_box { 
	display:none; /* Hide the DIV */
	position:fixed;  
	_position:absolute; /* hack for internet explorer 6 */  
	height:425px;  
	width:600px;  
	background:#FFFFFF;
	  
	left: 400px;
	top: 150px;
	z-index:100001; /* Layering ( on-top of others), if you have lots of layers: I just maximized, you can change it yourself */
	margin-left: 15px;  
	
	/* additional features, can be omitted */
	border:2px solid #ffffff;  	
	
	font-size:15px;  
	-moz-box-shadow: 0 0 5px #ffffff;
	-webkit-box-shadow: 0 0 5px #ffffff;
	box-shadow: 0 0 5px #000000;
	
}

.overlay {
 	position:absolute;
	display:none; 

    /* color with alpha transparency */
    background-color: rgba(0, 0, 0, 0.7);

    /* stretch to screen edges */
    top: 0;
	left: 0;
    bottom: 0;
    right: 0;
}


a{  
cursor: pointer;  
text-decoration:none;  
} 

/* This is for the positioning of the Close Link */
#popupBoxClose {
	font-size:18px;  
	line-height:14px;  
	right:5px;  
	top:5px;  
	position:absolute;  
	color:#6fa5e2;  
	font-weight:500;
  	
}
.names{text-align:center;font-size:18px;font-weight:bold;font-family:Verdana, Geneva, sans-serif;}
.joinnow{background:url('/css/rummy.tld/images/leaderboards/button-01.png');height:40px;width:130px;color:#000000;font-size:16px;font-family:Verdana, Geneva, sans-serif;font-weight:bold;line-height:35px}
.teams{height:240;width:140px;border:2px solid #004298;background:#CBE8F7;margin-left:15px;float:left}
.heading{border:2px solid #fff}
.moredetails{font-size:10px;text-decoration:underline;color:#004298;text-align:right;font-weight:bold;font-family:Verdana, Geneva, sans-serif}
</style>
<script src="http://jqueryjs.googlecode.com/files/jquery-1.2.6.min.js" type="text/javascript"></script>

<script type="text/javascript">
	
	$(document).ready( function() {
	
		// When site loaded, load the Popupbox First
	loadPopupBox();
	
		$('#popupBoxClose').click( function() {			
			unloadPopupBox();
		});
		
		$('#leaderboardcontainer').click( function() {
			unloadPopupBox();
		});

		function unloadPopupBox() {	// TO Unload the Popupbox
			$('#popup_box').fadeOut("fast");
			$("#leaderboardcontainer").css({ // this is just for style		
				"opacity": "0.5",
				"display":"none"   
			}); 
			$(".overlay").toggle();
		}	
		
		function loadPopupBox() {	// To Load the Popupbox
			$('#popup_box').fadeIn("slow");
			$(".overlay").toggle();			
		}
		
	});
</script>
<div id="popup_box" class="heading" style="width:650px;box-shadow: 10px 10px  10px #555555;border:2px solid #004298;">
		<div style="height:90px;background:#004298;width:650px">
       		<div style="font-family:Copperplate Gothic Bold;font-size:28px;color:#fff;width:335px;margin-left:165px;line-height:35px;text-align:center"> GANESH NAVARATRI 
            <span style="font-family:Copperplate Gothic Bold;font-size:24px;color:#fff;width:300px;margin-left:0px;line-height:20px">TEAM RUMMY</span><br>
             <span style="color:#fff;font-size:12px;font-family:Verdana, Geneva, sans-serif;line-height:40px;"> Dates: 9th September to 19th September</span>	
             <span> <a id="popupBoxClose" style="text-decoration: none;"><font color="white">x</font></a>	</span>
            </div>
            <div>
            	<p style="text-align:center;color:#004298;font-size:18px;font-weight:bold;font-family:Verdana, Geneva, sans-serif">Choose Your Team</p>
            </div>
            <div>
            	<p style="text-align:center;color:#004298;font-size:16px;font-weight:bold;font-family:Verdana, Geneva, sans-serif">Join for FREE , Play More Games and Win More Money</p>
            </div>
    		<div>
    		<?php 
				$noOfTeams = count($teamsData);

				foreach ($teamsData as $data)
				{
					?>
					<div class="teams" align="center" style="padding-top:10px">
                	<span  class="names"><?=$data["name"]?></span>
                    <img src="<?=$data["url"]?>" style="padding:10px 0px 10px 0px" />
                    <div class="joinnow"><a href = "/leaderboard/insertplayer/leaderboardId/<?=$leaderboardId?>/teamId/<?=$data["team_id"]?>" style="text-decoration: none;"> <font color="black">JOIN Free </font></a></div>
                	<p style="text-align:right;padding-right:5px;padding-top:10px"><a  href = "/leaderboard/registerplayer/leaderboardId/<?=$leaderboardId?>/?>" class="moredetails">More Details</a></p>
                	</div>
					<?php 	
				}
    		
    		?>
            
            </div>
        </div>
	
	
</div>
<div class="overlay"></div>
<div id="modalbackground" style=" position: absolute; height:100%; widh:100%; display:none; z-index:10000; background-color: #7F7F7F; opacity: 0.5;"></div>
<div id="leaderboardcontainer"> 
		
		</div>
		<?php 
	}
}
}