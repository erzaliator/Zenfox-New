<?php
class Zenfox_View_Helper_Team extends Zend_View_Helper_Abstract
{
	public $view;
	
	public function setView(Zend_View_Interface $view)
	{
		$this->view = $view;
	}
	
	public function team($team_1_name, $team_2_name, $team_1_image, $team_2_image, $team_1_checked, $team_2_checked, $voteCast, $noTeam, $noPlayerId, $team_1_value, $team_2_value, $loggedIn = false)
	{
		$voteMargin = "265";
		$termsMargin = "255";
		if($loggedIn)
		{
			$voteMargin = "418";
			$termsMargin = "405";
		}
		$error = false;
		if($noPlayerId)
		{
			$error = true;
			setcookie('vote',true,time() + (86400 * 30),'/','.'.$_SERVER['HTTP_HOST']);
			?>
			<div style="height:370px;background:url(/css/rummy.tld/images/home-page-back.png) repeat-x fixed 0 0 transparent;"><div class='team-error-message' style="text-align:center;font-size:25px;padding-top:125px;">You need to be logged in to cast a vote. Please login or signup now to win exciting prizes at taashtime</div></div>
			<?php 
		}
		if($noTeam)
		{
			?>
			<div class='team-error-message' style="background:url(/css/rummy.tld/images/home-page-back.png) repeat-x fixed 0 0 transparent;color:red;font-size: 25px;font-weight: bold;text-align: center;">Please select a team.</div>
			<?php 
		}
		if($voteCast)
		{
			?>
			<div style="background:url(/css/rummy.tld/images/home-page-back.png) repeat-x fixed 0 0 transparent;height:250px;">
			<div class='team-vote-message' style="text-align:center;color:#FFFFFF;font-size:25px;font-weight:bold;padding-top:40px;">Your vote is casted</div>
			<div align="center" class='team-vote-message' style="text-align:center;color:#FFFFFF;font-size:20px;padding-top:5px;">
				<p>
					If your chosen team wins, you will get bonus upto 50% <br>
					You can change your vote anytime before the match ends.<br>
					Please <a href="/" style="color:#FFFFFF;font-weight:bold;">Click Here</a> if you want to change your vote.
				</p>
			</div>
			</div>
			<?php 
		}
		elseif(!$error)
		{
			?>
			<form method="post" action="/" name="ipl-form" style="background:url(/css/rummy.tld/images/home-page-back.png) repeat-x fixed 0 0 transparent; height:370px;">
				<div style="color:#FFFFFF; text-align: center; font-size: 25px; font-weight: bold;" class="team-vote-message">Who will win today?</div>
				<table style="border:0px solid;border-color:black;width:500px;margin:auto;">
					<tbody><tr><td style="background:url(/css/rummy.tld/images/home-page-back.png) repeat-x fixed 0 0 transparent;text-align:center;"><label style="color: rgb(255, 255, 255); font-size: 18px;" id="label-team-1"><?php echo $team_1_name;?></label></td><td style="width: 100px;background:url(/css/rummy.tld/images/home-page-back.png) repeat-x fixed 0 0 transparent;"></td><td style="background:url(/css/rummy.tld/images/home-page-back.png) repeat-x fixed 0 0 transparent; text-align:center;"><label style="font-size: 18px; color:#FFFFFF;" id="label-team-2"><?php echo $team_2_name;?></label></td></tr>
					<tr><td style="background:url(/css/rummy.tld/images/home-page-back.png) repeat-x fixed 0 0 transparent;"><img style="margin-left:20px" src="<?php echo $team_1_image;?>" id="image-team-1"></td><td style="background:url(/css/rummy.tld/images/home-page-back.png) repeat-x fixed 0 0 transparent;"><img style="margin-left:20px" src="/images/rummy.tld/vs.png" id="vs"></td><td style="background:url(/css/rummy.tld/images/home-page-back.png) repeat-x fixed 0 0 transparent;"><img style="margin-left:20px" src="<?php echo $team_2_image;?>" id="image-team-2"></td></tr>
					<tr><td style="background:url(/css/rummy.tld/images/home-page-back.png) repeat-x fixed 0 0 transparent;"><input type="radio" style="margin-left:80px;" value="<?php echo $team_1_value;?>" name="team" id="radio-team-1" <?php echo $team_1_checked;?>></td><td style="background:url(/css/rummy.tld/images/home-page-back.png) repeat-x fixed 0 0 transparent;"></td><td style="background:url(/css/rummy.tld/images/home-page-back.png) repeat-x fixed 0 0 transparent;"><input type="radio" style="margin-left:80px;" value="<?php echo $team_2_value;?>" name="team" id="radio-team-2" <?php echo $team_2_checked;?>></td></tr>
				</tbody></table>
				<input type="submit" value="Vote Now" style="height: 40px; width: 125px; margin-top:-25px; margin-left: <?=$voteMargin ?>px; font-size: 20px; font-weight: bold;" name="submit" src="/images/rummy.tld/vote-now.png" id="cricket-form-submit">
				<div style="margin-top:10px;">
				<a style="color:#FFFFFF; margin-left:<?=$termsMargin ?>px; font-size:16px;" href="/content/terms#ipl">Terms &amp; Conditions</a>
				</div>
				<div style="color:#FFFFFF; text-align: center; font-size: 20px;" class="team-vote-message">Pick the winning team &amp; get bonus upto 50%</div>
			</form>
			<?php
		}
	}
}