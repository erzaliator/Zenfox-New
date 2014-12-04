<?php
require_once dirname(__FILE__).'/../forms/LeaderboardForm.php';
class Player_LeaderboardController extends Zenfox_Controller_Action
{
	public function init()
	{
		parent::init();

        $contextSwitch = $this->_helper->getHelper('contextSwitch');
		$contextSwitch->addActionContext('bingo', 'json')
					->initContext();
	}
	
	public function bingoAction()
	{
		$form = new Player_LeaderboardForm();
		$this->view->form = $form;
		
		$leaderboardobj = new LeaderBoard();
		
        if ($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				
				$postvalues = $form->getvalues();
				
				//Zenfox_Debug::dump($postvalues);
				if($postvalues["room_id"] != -1)
				{
					$RoomLeaderboard = $leaderboardobj->getleaderboard($postvalues["room_id"]);
				
					$this->view->data = $RoomLeaderboard[0];
					$this->view->title = $RoomLeaderboard[1];
				}
				else
				{
					$this->view->selectone = true;
				}
				
			}
		}
		else
		{
			$runningroomsobj = new BingoRunningRoom();
			$allrunningrooms = $runningroomsobj->getAllRunningRooms();
		
			//Zenfox_Debug::dump($allrunningrooms);
			$index = 0;
			foreach($allrunningrooms as $roomdata)
       		{
        		$RoomLeaderboard = $leaderboardobj->getleaderboard($roomdata["game_id"]);
        		if($RoomLeaderboard[0])
        		{
        			//Zenfox_Debug::dump($RoomLeaderboard);
        			$allleaderboards[$index] = $RoomLeaderboard;
					
					$index++;
        		}
       		}
       		$this->view->allleaderboards = $allleaderboards;
		}
	}
	
	public function rummyAction()
	{
		$starttime = "2013-06-20";
		$endtime = "2013-06-25";
		
		$playerobj = new Player();
		$playerIds = $playerobj->getdepositedplayerIds($starttime);
		
		
		$playergamelogobj = new PlayerGamelog();
		$leaderboard = $playergamelogobj->getrummyLeaderboard($playerIds,$starttime,$endtime);
		
		
		
		//Zenfox_Debug::dump($leaderboard);exit;
		$this->view->startTime = $starttime;
		$this->view->endTime = $endtime;
		$this->view->leaderboard = $leaderboard;
		
		
		
	}
	
	public function registerplayerAction()
	{
		
		$leaderboardId = $this->getRequest()->leaderboardId;
		
		
		
		$leaderboardteamsobj = new LeaderBoardTeams();
		$leaderboardteams = $leaderboardteamsobj->getleaderboardteams($leaderboardId);
		
		$this->view->leaderboardId = $leaderboardId;
		$this->view->teamsdata = $leaderboardteams;
	}
	
	
	public function insertplayerAction()
	{
		$leaderboardId = $this->getRequest()->leaderboardId;
		$teamId = $this->getRequest()->teamId;
		
		$session = new Zend_Auth_Storage_Session();
		$store = $session->read();
		$playerId = $store['id']?$store['id']:-1;
		
		if($leaderboardId && $teamId)
		{
			$leaderbordDataobj = new LeaderBoardData();
			$insertresult = $leaderbordDataobj->insertnewplayer($playerId,$leaderboardId,$teamId);
			
			if($insertresult)
			{
				$teamRummyMessage = "Thank you for registering to Teaam Rummy Tournament. <br/><b>You can check your team status <a href=\"/leaderboard/rummyteamdata/leaderboardId/". $leaderboardId . "/teamId/".$teamId."\">Click here</a></b>";
				$this->_helper->FlashMessenger(array('success' => $teamRummyMessage));
			}
			else 
			{
				$this->_helper->FlashMessenger(array('error' => 'You are already registered for this tournament<br/>You can check the tournament status <a href="/leaderboard/rummyteams/leaderboardId/'. $leaderboardId.'">Click here</a>'));
				
			}
		}
		
	}
	
	public function rummyteamsAction()
	{
		
		$homePage = $this->getRequest()->home;
		$leaderboardId = $this->getRequest()->leaderboardId;
		
		$leaderboadrdconfobj = new LeaderBoardConfig();
		$activeleaderbords = $leaderboadrdconfobj->getleaderboardconfbyId($leaderboardId);
		
		
		$leaderboardteamsobj = new LeaderBoardTeams();
		$leaderboardteams = $leaderboardteamsobj->getleaderboardteams($leaderboardId);
		
		$leaderboarddataobj = new LeaderBoardData();
		$positions = $leaderboarddataobj->getTeamsTotalScores($leaderboardId);
		
		$length = count($positions);
		$index = 0;
		
		while($index < $length)
		{
			$Teams[$positions[$index]["TeamId"]] = $positions[$index]["Score"];
			$index++;
		}
		
		$no_of_teams = count($leaderboardteams);
		
		$index = 0;
		
		
		while($index < $no_of_teams)
		{
			$leaderboard[$index]["team_id"] = $leaderboardteams[$index]["team_id"];
			$leaderboard[$index]["team_name"] = $leaderboardteams[$index]["name"];
			$leaderboard[$index]["Score"] = $Teams[$leaderboardteams[$index]["team_id"]];			
			$leaderboard[$index]["player_data"] = $leaderboarddataobj->getleaderboardteamdata($leaderboardId,$leaderboardteams[$index]["team_id"]);
			
			$index++;
		}
		
		$length = 0;
		if(isset($leaderboard))
		{
			$length = count($leaderboard);
		}
		
		$index =0;
		$secondindex =0;
		$swaped = false;
		$rank = 1;
		while($index < $length)
		{
			$secondindex = $index +1;
			
			while($secondindex < $length)
			{
				if($leaderboard[$index]["Score"] < $leaderboard[$secondindex]["Score"])
				{
					$temp = $leaderboard[$index];
					$leaderboard[$index] = $leaderboard[$secondindex];
					$leaderboard[$secondindex] = $temp;
					
					$swaped = true;
				}
				
				$secondindex++;
			}
			
			$secondindex = $index +1;
			if(!$leaderboard[$index]["Position"])
			{
				$leaderboard[$index]["Position"] = $rank;
				$rank++;
			}
			
			if(!$swaped)
			{
				
				while(($secondindex < $length))
				{
					if($leaderboard[$index]["Score"] == $leaderboard[$secondindex]["Score"])
					{
						
						$leaderboard[$secondindex]["Position"] = $leaderboard[$index]["Position"];
					
					}
				
					$secondindex++;
				}
			}
			
			
			
			$swaped = false;
			
			$index++;
		}
		
		
		//Zenfox_Debug::dump($leaderboard);exit;
		$this->view->homePage = $homePage;
		$this->view->leaderboardconf = $activeleaderbords[0];
		if(isset($leaderboard))
		{
			$this->view->teamdata = $leaderboard;
		}
		
	}
	
	public function rummyteamdataAction()
	{
		$leaderboardId = $this->getRequest()->leaderboardId;
		$teamId = $this->getRequest()->teamId;
		
		$leaderboadrdconfobj = new LeaderBoardConfig();
		$activeleaderbords = $leaderboadrdconfobj->getleaderboardconfbyId($leaderboardId);
		
		$leaderboardteamsobj = new LeaderBoardTeams();
		$leaderboardteams = $leaderboardteamsobj->getleaderboardteams($leaderboardId);
		
		$leaderboarddataobj = new LeaderBoardData();
		$positions = $leaderboarddataobj->getTeamsTotalScores($leaderboardId);
		
		$length = count($positions);
		$index = 0;
		
		while($index < $length)
		{
			$Teams[$positions[$index]["TeamId"]] = $positions[$index]["Score"];
			$index++;
		}
		
		$no_of_teams = count($leaderboardteams);
		
		$index = 0;
		
		
		while($index < $no_of_teams)
		{
			$leaderboard[$index]["team_id"] = $leaderboardteams[$index]["team_id"];
			$leaderboard[$index]["team_name"] = $leaderboardteams[$index]["name"];
			$leaderboard[$index]["Score"] = $Teams[$leaderboardteams[$index]["team_id"]];			
			$leaderboard[$index]["player_data"] = $leaderboarddataobj->getleaderboardteamdata($leaderboardId,$leaderboardteams[$index]["team_id"]);
			
			$index++;
		}
		
		
		$length = count($leaderboard);
		$index =0;
		$secondindex =0;
		$swaped = false;
		$rank = 1;
		while($index < $length)
		{
			$secondindex = $index +1;
			
			while($secondindex < $length)
			{
				if($leaderboard[$index]["Score"] < $leaderboard[$secondindex]["Score"])
				{
					$temp = $leaderboard[$index];
					$leaderboard[$index] = $leaderboard[$secondindex];
					$leaderboard[$secondindex] = $temp;
					
					$swaped = true;
				}
				
				$secondindex++;
			}
			
			$secondindex = $index +1;
			if(!$leaderboard[$index]["Position"])
			{
				$leaderboard[$index]["Position"] = $rank;
				$rank++;
			}
			
			if(!$swaped)
			{
				
				while(($secondindex < $length))
				{
					if($leaderboard[$index]["Score"] == $leaderboard[$secondindex]["Score"])
					{
						
						$leaderboard[$secondindex]["Position"] = $leaderboard[$index]["Position"];
					
					}
				
					$secondindex++;
				}
			}
			
			
			
			$swaped = false;
			
			$index++;
		}
		
		$index =0;
		while($index < $length)
		{
			if($teamId == $leaderboard[$index]["team_id"])
			{
				$result = $leaderboard[$index];
			}
			$index++;
		}
		
		//Zenfox_Debug::dump($result);exit;
		$this->view->leaderboardconf = $activeleaderbords[0];
		$this->view->teamdata = $result;
		
	}
		
	
}
	
