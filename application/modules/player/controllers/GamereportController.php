<?php
require_once dirname(__FILE__).'/../forms/GamesPlayedForm.php';

class Player_Gamereportcontroller extends Zend_Controller_Action
{
	public function gamesplayedAction()
	{
		$form = new Player_GamesPlayedForm();
		$this->view->form = $form->getform();
		
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$postvalues = $form->getValues();
				
				$session = new Zend_Auth_Storage_Session();
				$sessionvalues = $session->read();
				$playerid = $sessionvalues['id'];
				
				$gameflavour = $postvalues["flavour"];
				$counttype = $postvalues["counttype"];
				$fromDate = $postvalues['from_date'] . ' ' . $postvalues['from_time'];
				$toDate = $postvalues['to_date'] . ' ' . $postvalues['to_time'];
				
				$playerlogobj = new PlayerGamelog();
				
 				$gamecounts = $playerlogobj->getplayergamesplayedcount($playerid ,$gameflavour, $fromDate , $toDate , $counttype);
				
				$gamesplayed = array();
				$count = count($gameflavour);
				$index =0;
				while( $count > 0)
				{
					$gamesplayed[$gameflavour[$index]]["Game Flavour"] = $gameflavour[$index];
					$gamesplayed[$gameflavour[$index]]["Free Money Games"] = 0;
					$gamesplayed[$gameflavour[$index]]["Real Money Games"] = 0;
					$index++;
					$count--;
				}
				
				$length = count($gamecounts["FREE"]);
				$index =0;
				while($length > 0)
				{
					$gamesplayed[$gamecounts["FREE"][$index]["game_flavour"]]["Game Flavour"] = $gamecounts["FREE"][$index]["game_flavour"];
					$gamesplayed[$gamecounts["FREE"][$index]["game_flavour"]]["Free Money Games"] = $gamecounts["FREE"][$index]["count"];
					
					$length--;
					$index++;
				}
				
				$length = count($gamecounts["REAL"]);
				$index =0;
				
				while($length > 0)
				{
					$gamesplayed[$gamecounts["REAL"][$index]["game_flavour"]]["Game Flavour"] = $gamecounts["REAL"][$index]["game_flavour"];
					$gamesplayed[$gamecounts["REAL"][$index]["game_flavour"]]["Real Money Games"] = $gamecounts["REAL"][$index]["count"];
						
					$length--;
					$index++;
				}
				
				$this->view->table = $gamesplayed;
			}
		}
	}
}