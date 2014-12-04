<?php 
require_once dirname(__FILE__).'/../forms/LeaderboardForm.php';
class Admin_LeaderboardController extends Zenfox_Controller_Action
{
	public function startAction()
	{
		$leaderboardobj = new LeaderBoard();
		$roomId = $this->getRequest()->roomId;
		$createnew = $this->getRequest()->createnew;
		$generateLeaderBoard = $this->getRequest()->generateLeaderBoard;
		if($createnew)
		{
			$form = new Admin_LeaderboardForm();
			$this->view->form = $form->getForm();
			$this->view->alldata = "";
			
			if ($this->getRequest()->isPost())
			{
				if($form->isValid($_POST))
				{
					$postvalues = $form->getValues();
					//Zenfox_Debug::dump($postvalues);exit;
					$leaderboardobj = new LeaderBoard();
					$result = $leaderboardobj->insertdata($postvalues);
					if($result)
					{
						$this->_helper->FlashMessenger(array('message' => 'Insert Successfully'));
					}
					else
					{
						$this->view->form = "";
						$this->_helper->FlashMessenger(array('error' => 'Duplicate Entry for Room Name'));
					}
				}
			}
		}
		elseif($roomId)
		{
        	$leaderboardroomdata = $leaderboardobj->getroomdata($roomId);
			$form = new Admin_LeaderboardForm();
			$this->view->form = $form->getForm($leaderboardroomdata);
			$this->view->alldata = "";
			$this->view->roomId = $roomId;
			
			if ($this->getRequest()->isPost())
			{
				if($form->isValid($_POST))
				{
					$postvalues = $form->getValues();
					$leaderboardobj = new LeaderBoard();
					$result = $leaderboardobj->updatedata($roomId,$postvalues);
					if($result)
					{
						$leaderboardroomdata = $leaderboardobj->getroomdata($roomId);
						$this->view->form = $form->getForm($leaderboardroomdata);
						$this->_helper->FlashMessenger(array('message' => 'Updated Successfully'));
					}
					else
					{
						$this->_helper->FlashMessenger(array('error' => 'Update Failed'));
					}
				}
			}
			elseif($generateLeaderBoard == true) 
			{
				$leaderboarddata = $leaderboardobj->getleaderboard($roomId,$generateLeaderBoard);
				$this->view->leaderboard = $leaderboarddata[0];
			}
			
		}
		else
		{
			$alldata = $leaderboardobj->getalldata();
			$this->view->alldata = $alldata;
		}
		
		
	}
	
	public function teamrummyleaderboardsAction()
	{
		$leaderboadrdconfobj = new LeaderBoardConfig();
		$leaderboards = $leaderboadrdconfobj->getallleaderbords();
		
		$this->view->leaderboards = $leaderboards;
	}
	
	public function teamrummywinnersAction()
	{
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
			$leaderboard[$index]["player_data"] = $leaderboarddataobj->getleaderboardteamdata($leaderboardId,$leaderboardteams[$index]["team_id"],True);
			
			$index++;
		}
		
		//Zenfox_Debug::dump($leaderboard);exit;
		
		
		
		
		$this->view->leaderboardconf = $activeleaderbords[0];
		$this->view->teamsdata = $leaderboard;
		
	}
}