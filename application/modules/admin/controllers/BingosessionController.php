<?php
require_once dirname(__FILE__) . '/../forms/BingoSessionForm.php';
class Admin_BingosessionController extends Zenfox_Controller_Action
{
	public function createAction()
	{
		$bingoSessionForm = new Admin_BingoSessionForm();
		$this->view->form = $bingoSessionForm->getForm();
		if($this->getRequest()->isPost())
		{
			if($bingoSessionForm->isValid($_POST))
			{
				$data = $bingoSessionForm->getValues();
				
				//Zenfox_Debug::dump($data, 'formData');
				$storedGameData = $this->checkOrder($data['bingo']);
				if($storedGameData)
				{
					$bingoSessionData['name'] = $data['sessionName'];
					$bingoSessionData['description'] = $data['description'];
					$bingoSessionId = $this->insertBingoSessionData($bingoSessionData);
					
					foreach($storedGameData as $sessionGameData)
					{
						$sessionGameData['sessionId'] = $bingoSessionId;
						$this->insertSessionGameData($sessionGameData);
					}
					echo "Your data is saved";
				}
				else
				{
					echo "Order is not selected or same order";
				}
			}
		}
	}
	
	public function checkOrder($data)
	{
		$temp = 0;
		$gameSelected = false;
		$storedGameData = array();
		$sameOrder = false;
		$orderSelected = true;
		foreach($data as $index => $value)
		{
			if(!($temp%2) && $value)
			{
				$gameSelected = true;
				$gameId = $index;
			}
			if($gameSelected && ($temp%2))
			{
				$gameSelected = false;
				$sequence = $value;
				if($sequence != -1)
				{
					$sessionGameData['gameId'] = $gameId;
					$sessionGameData['sequence'] = $sequence;
					if($storedGameData)
					{
						foreach($storedGameData as $gameData)
						{
							if($gameData['sequence'] == $sequence)
							{
								$sameOrder = true;
								break;
							}
						}
					}
					if(!$sameOrder)
					{
						$storedGameData[] = $sessionGameData;
					}
					else
					{
						break;
					}
				}
				else
				{
					$orderSelected = false;
					break;
				}
			}
			$temp++;
		}
		if(!$sameOrder && $orderSelected)
		{
			return $storedGameData;
		}
		return false;
	}
	
	public function insertBingoSessionData($bingoSessionData)
	{
		$bingoSession = new BingoSessionConfig();
		$bingoSessionId = $bingoSession->insertData($bingoSessionData);
		return $bingoSessionId;
	}
	
	public function insertSessionGameData($sessionGameData)
	{
		$sessionGameConfig = new SessionGameConfig();
		$sessionGameConfig->insertData($sessionGameData);
		return true;
	}
	
	public function viewAction()
	{
		$bingoSession = new BingoSession();
		$allSessions = $bingoSession->getAllSessions();
		$this->view->sessions = $allSessions;
		//Zenfox_Debug::dump($allSessions, 'sessions');
	}
	
	public function editAction()
	{
		$sessionData = array();
		$bingoSessionId = $this->getRequest()->id;
		$bingoSession = new BingoSession();
		$bingoSessionData = $bingoSession->getSessionData($bingoSessionId);
		$sessionData['name'] = $bingoSessionData['name'];
		$sessionData['description'] = $bingoSessionData['description'];
		//Zenfox_Debug::dump($bingoSessionData, 'sessionData'); 
		$sessionGame = new SessionGame();
		$sessionGamesData = $sessionGame->getSessionGames($bingoSessionId);
		//Zenfox_Debug::dump($sessionGamesData, 'gameData');
		foreach($sessionGamesData as $gameData)
		{
			$session = array();
			$session['game_id'] = $gameData['game_id'];
			$session[$gameData['game_id']]['sequence'] = $gameData['sequence'];
			$sessionData['bingo'][] = $session; 
		}
		$form = new Admin_BingoSessionForm();
		$this->view->form = $form->getForm($sessionData);
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				$storedGameData = $this->checkOrder($data['bingo']);
				//Zenfox_Debug::dump($storedGameData, 'data');
				if($storedGameData)
				{
					if($bingoSessionData['description'] != $data['description'])
					{
						$updatedBingoSessData['id'] = $bingoSessionId;
						$updatedBingoSessData['description'] = $data['description'];
						$this->updateBingoSessionData($updatedBingoSessData);
					}
					foreach($sessionGamesData as $sessionGameData)
					{
						$gameIds[] = $sessionGameData['game_id'];
						$gameDeleted = true;
						foreach($storedGameData as $gameData)
						{
							if($gameData['gameId'] == $sessionGameData['game_id'])
							{
								$gameDeleted = false;
								$sequence = $gameData['sequence'];
							}
						}
						if($gameDeleted)
						{
							$gameId = $sessionGameData['game_id'];
							$this->deleteSessionGameData($bingoSessionId, $gameId);
						}
						elseif($sessionGameData['sequence'] != $sequence)
						{
							$sessionGameData['sequence'] = $sequence;
							$this->updateSessionGameData($sessionGameData);
						}
					}
					foreach($storedGameData as $sessionGameData)
					{
						if(!in_array($sessionGameData['gameId'], $gameIds))
						{
							$sessionGameData['sessionId'] = $bingoSessionId;
							$this->insertSessionGameData($sessionGameData);
						}
					}
					echo "Your data is updated";
				}
				else
				{
					echo "Order is not selected or same order";
				}
			}
		}
	}
	
	public function deleteSessionGameData($sessionId, $gameId)
	{
		$sessionGame = new SessionGameConfig();
		$sessionGame->deleteData($sessionId, $gameId);
	}
	
	public function updateSessionGameData($sessionGameData)
	{
		$sessionGame = new SessionGameConfig();
		$sessionGame->updateData($sessionGameData);
	}
	
	public function updateBingoSessionData($bingoSessionData)
	{
		$bingoSession = new BingoSessionConfig();
		$bingoSession->updateData($bingoSessionData);
	}
}