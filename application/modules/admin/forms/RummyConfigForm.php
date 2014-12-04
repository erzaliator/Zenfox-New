<?php
class Admin_RummyConfigForm extends Zend_Form
{
	/*public function getForm()
	{
		$rummyConfig = new Zend_Form_SubForm();
		
		$initDeck = $rummyConfig->createElement('text', 'InitDecks');
		$initDeck->setLabel('No of decks');
		
		$initJokers = $rummyConfig->createElement('text', 'InitJokers');
		$initJokers->setLabel('No of jokers per deck');
		
		$earlyDrop = $rummyConfig->createElement('text', 'EarlyDropPoints');
		$earlyDrop->setLabel('Early drop points');
		
		$midDrop = $rummyConfig->createElement('text', 'MidDropPoints');
		$midDrop->setLabel('Mid drop points');
		
		$maxPoints = $rummyConfig->createElement('text', 'MaxPoints');
		$maxPoints->setLabel('Maximum points');
		
		$minPoints = $rummyConfig->createElement('text', 'MinPoints');
		$minPoints->setLabel('Minimum points');
		
		$defaultErrorTime = $rummyConfig->createElement('text', 'DefaultErrorTime');
		$defaultErrorTime->setLabel('Error display time');
		
		$turnTimeout = $rummyConfig->createElement('text', 'TurnTimeout');
		$turnTimeout->setLabel('Turn Timeout');
		
		$meldTimeout = $rummyConfig->createElement('text', 'MeldTimeout');
		$meldTimeout->setLabel('Meld Timeout');
		
		$gameStartWait = $rummyConfig->createElement('text', 'GameStartWait');
		$gameStartWait->setLabel('Wait before game start');
		
		$noActivePlayerWait = $rummyConfig->createElement('text', 'NoActivePlayerWait');
		$noActivePlayerWait->setLabel('Wait for no active player');
		
		$showResultWait = $rummyConfig->createElement('text', 'ShowResultWait');
		$showResultWait->setLabel('Wait before showing result');
		
		$matchResultWait = $rummyConfig->createElement('text', 'MatchResultWait');
		$matchResultWait->setLabel('Wait before match result');
		
		$sessionStartWait = $rummyConfig->createElement('text', 'SessionStartWait');
		$sessionStartWait->setLabel('Wait before session start');
		
		$playerJoinSession = $rummyConfig->createElement('select', 'CanPlayerJoinInSession');
		$playerJoinSession->setLabel('Can player join session?')
					->addMultiOptions(array(
							true => "true",
							false => "false"
					));
					
		$loopOverSession = $rummyConfig->createElement('select', 'LoopOverSessions');
		$loopOverSession->setLabel('Loop Over Session')
					->addMultiOptions(array(
							true => 'true',
							false => 'false'
					));
					
		$maxSessionPoints = $rummyConfig->createElement('text', 'MaxSessionPoints');
		$maxSessionPoints->setLabel('Maximum session points');
		
		$houseEdge = $rummyConfig->createElement('text', 'HouseEdge');
		$houseEdge->setLabel('House Edge');
		
		$maxTimeoutLimit = $rummyConfig->createElement('text', 'MaxTimeoutLimit');
		$maxTimeoutLimit->setLabel('Maximum timeout');
		
		$playerSelectTimeout = $rummyConfig->createElement('text', 'PlayerSelectTimeout');
		$playerSelectTimeout->setLabel('Player select timeout');
		
		$minPlayer = $rummyConfig->createElement('text', 'minPlayer');
		$minPlayer->setLabel('Minimum players');
		
		$maxPlayer = $rummyConfig->createElement('text', 'maxPlayer');
		$maxPlayer->setLabel('Maximum players');
		
		$maxSpectators = $rummyConfig->createElement('text', 'maxSpectators');
		$maxSpectators->setLabel('Maximum Spectators');
		
		$amountType = $rummyConfig->createElement('select', 'amountType');
		$amountType->setLabel('Amount type')
				->addMultiOptions(array(
					'REAL' => 'Real',
					'BONUS' => 'Bonus',
					'FREE' => 'Free',
					'BOTH' => 'Both',
					'BOTHREAL' => 'Both Real'
				));
				
		$minBet = $rummyConfig->createElement('text', 'minBet');
		$minBet->setLabel('Minimum bet');
		
		$maxBet = $rummyConfig->createElement('text', 'maxBet');
		$maxBet->setLabel('Maximum bet');
		
		$minActiveRoom = $rummyConfig->createElement('text', 'minActiveRoom');
		$minActiveRoom->setLabel('Minimum active rooms');
		
		$incrementRooms = $rummyConfig->createElement('text', 'incrementRooms');
		$incrementRooms->setLabel('Increment rooms');
		
		$createRooms = $rummyConfig->createElement('text', 'createRooms');
		$createRooms->setLabel('Create rooms');
		
		$maxRooms = $rummyConfig->createElement('text', 'maxRooms');
		$maxRooms->setLabel('Maximum rooms');
		
		$tableName = $rummyConfig->createElement('text', 'tableName');
		$tableName->setLabel('Table name');
		
		$rummyConfig->addElements(array(
			$initDeck,
			$initJokers,
			$earlyDrop,
			$midDrop,
			$maxPoints,
			$minPoints,
			$defaultErrorTime,
			$turnTimeout,
			$meldTimeout,
			$gameStartWait,
			$noActivePlayerWait,
			$showResultWait,
			$matchResultWait,
			$sessionStartWait,
			$playerJoinSession,
			$loopOverSession,
			$maxSessionPoints,
			$houseEdge,
			$maxTimeoutLimit,
			$playerSelectTimeout,
			$minPlayer,
			$maxPlayer,
			$maxSpectators,
			$amountType,
			$minBet,
			$maxBet,
			$minActiveRoom,
			$incrementRooms,
			$createRooms,
			$maxRooms,
			$tableName
		));
			
		return $rummyConfig;
	}
	
	public function setForm($form, $data)
	{
		$form->InitDecks->setValue($data['InitDecks']);
		$form->InitJokers->setValue($data['InitJokers']);
		$form->EarlyDropPoints->setValue($data['EarlyDropPoints']);
		$form->MidDropPoints->setValue($data['MidDropPoints']);
		$form->MaxPoints->setValue($data['MaxPoints']);
		$form->MinPoints->setValue($data['MinPoints']);
		$form->DefaultErrorTime->setValue($data['DefaultErrorTime']);
		$form->TurnTimeout->setValue($data['TurnTimeout']);
		$form->MeldTimeout->setValue($data['MeldTimeout']);
		$form->GameStartWait->setValue($data['GameStartWait']);
		$form->NoActivePlayerWait->setValue($data['NoActivePlayerWait']);
		$form->ShowResultWait->setValue($data['ShowResultWait']);
		$form->MatchResultWait->setValue($data['MatchResultWait']);
		$form->SessionStartWait->setValue($data['SessionStartWait']);
		$form->CanPlayerJoinInSession->setValue($data['CanPlayerJoinInSession']);
		$form->LoopOverSessions->setValue($data['LoopOverSessions']);
		$form->MaxSessionPoints->setValue($data['MaxSessionPoints']);
		$form->HouseEdge->setValue($data['HouseEdge']);
		$form->MaxTimeoutLimit->setValue($data['MaxTimeoutLimit']);
		$form->PlayerSelectTimeout->setValue($data['PlayerSelectTimeout']);
		$form->minPlayer->setValue($data['min_players']);
		$form->maxPlayer->setValue($data['max_players']);
		$form->maxSpectators->setValue($data['max_spectators']);
		$form->amountType->setValue($data['amount_type']);
		$form->minBet->setValue($data['min_bet']);
		$form->maxBet->setValue($data['max_bet']);
		$form->minActiveRoom->setValue($data['min_active_rooms']);
		$form->incrementRooms->setValue($data['increment_rooms']);
		$form->maxRooms->setValue($data['max_rooms']);
		$form->createRooms->setValue($data['create_rooms']);
		$form->tableName->setValue($data['table_name']);
		return $form;		
	}*/
	
	public function getForm($data = NULL)
	{
		$gameFlavour = $this->createElement('hidden', 'flavour');
		
		$gameRules = $this->createElement('hidden', 'gameRules');
						
		$gameType = $this->createElement('select', 'gameType');
		$gameType->setLabel('Select Game Type')
				->addMultiOptions(array(
					'SIMPLE' => 'Simple',
					'BEST' => 'Best Of Games'
				));
				
		$initDeck = $this->createElement('text', 'InitDecks');
		$initDeck->setLabel('No of decks');
		
		$initJokers = $this->createElement('text', 'InitJokers');
		$initJokers->setLabel('No of jokers per deck');
		
		$earlyDrop = $this->createElement('text', 'EarlyDropPoints');
		$earlyDrop->setLabel('Early drop points');
		
		$midDrop = $this->createElement('text', 'MidDropPoints');
		$midDrop->setLabel('Mid drop points');
		
		$maxPoints = $this->createElement('text', 'MaxPoints');
		$maxPoints->setLabel('Maximum points');
		
		$minPoints = $this->createElement('text', 'MinPoints');
		$minPoints->setLabel('Minimum points');
		
		$defaultErrorTime = $this->createElement('text', 'DefaultErrorTime');
		$defaultErrorTime->setLabel('Error display time');
		
		$turnTimeout = $this->createElement('text', 'TurnTimeout');
		$turnTimeout->setLabel('Turn Timeout');
		
		$meldTimeout = $this->createElement('text', 'MeldTimeout');
		$meldTimeout->setLabel('Meld Timeout');
		
		$gameStartWait = $this->createElement('text', 'GameStartWait');
		$gameStartWait->setLabel('Wait before game start');
		
		$noActivePlayerWait = $this->createElement('text', 'NoActivePlayerWait');
		$noActivePlayerWait->setLabel('Wait for no active player');
		
		$showResultWait = $this->createElement('text', 'ShowResultWait');
		$showResultWait->setLabel('Wait before showing result');
		
		$matchResultWait = $this->createElement('text', 'MatchResultWait');
		$matchResultWait->setLabel('Wait before match result');
		
		$sessionStartWait = $this->createElement('text', 'SessionStartWait');
		$sessionStartWait->setLabel('Wait before session start');
		
		$playerJoinSession = $this->createElement('select', 'CanPlayerJoinInSession');
		$playerJoinSession->setLabel('Can player join session?')
					->addMultiOptions(array(
							true => "true",
							false => "false"
					));
					
		$loopOverSession = $this->createElement('select', 'LoopOverSessions');
		$loopOverSession->setLabel('Loop Over Session')
					->addMultiOptions(array(
							true => 'true',
							false => 'false'
					));
					
		$maxSessionPoints = $this->createElement('text', 'MaxSessionPoints');
		$maxSessionPoints->setLabel('Maximum session points');
		
		$houseEdge = $this->createElement('text', 'HouseEdge');
		$houseEdge->setLabel('House Edge');
		
		$maxTimeoutLimit = $this->createElement('text', 'MaxTimeoutLimit');
		$maxTimeoutLimit->setLabel('Maximum timeout');
		
		$playerSelectTimeout = $this->createElement('text', 'PlayerSelectTimeout');
		$playerSelectTimeout->setLabel('Player select timeout');
		
		$minPlayer = $this->createElement('text', 'minPlayer');
		$minPlayer->setLabel('Minimum players');
		
		$maxPlayer = $this->createElement('text', 'maxPlayer');
		$maxPlayer->setLabel('Maximum players');
		
		$maxSpectators = $this->createElement('text', 'maxSpectators');
		$maxSpectators->setLabel('Maximum Spectators');
		
		$amountType = $this->createElement('select', 'amountType');
		$amountType->setLabel('Amount type')
				->addMultiOptions(array(
					'REAL' => 'Real',
					'BONUS' => 'Bonus',
					'FREE' => 'Free',
					'BOTH' => 'Both',
					'BOTHREAL' => 'Both Real'
				));
				
		$minBet = $this->createElement('text', 'minBet');
		$minBet->setLabel('Minimum bet');
		
		$maxBet = $this->createElement('text', 'maxBet');
		$maxBet->setLabel('Maximum bet');
		
		$minActiveRoom = $this->createElement('text', 'minActiveRoom');
		$minActiveRoom->setLabel('Minimum active rooms');
		
		$incrementRooms = $this->createElement('text', 'incrementRooms');
		$incrementRooms->setLabel('Increment rooms');
		
		$createRooms = $this->createElement('text', 'createRooms');
		$createRooms->setLabel('Create rooms');
		
		$maxRooms = $this->createElement('text', 'maxRooms');
		$maxRooms->setLabel('Maximum rooms');
		
		$tableName = $this->createElement('text', 'tableName');
		$tableName->setLabel('Table name');
		
		$tableDesc = $this->createElement('text', 'tableDescription');
		$tableDesc->setLabel('Table Description');
		
		$status = $this->createElement('select', 'status');
		$status->setLabel('Status')
			->addMultiOptions(array(
				'ENABLED' => 'Enabled',
				'DISABLED' => 'Disabled'
			));
			
		if($data)
		{
			$initDeck->setValue($data['InitDecks']);
			$initJokers->setValue($data['InitJokers']);
			$earlyDrop->setValue($data['EarlyDropPoints']);
			$midDrop->setValue($data['MidDropPoints']);
			$maxPoints->setValue($data['MaxPoints']);
			$minPoints->setValue($data['MinPoints']);
			$defaultErrorTime->setValue($data['DefaultErrorTime']);
			$turnTimeout->setValue($data['TurnTimeout']);
			$meldTimeout->setValue($data['MeldTimeout']);
			$gameStartWait->setValue($data['GameStartWait']);
			$noActivePlayerWait->setValue($data['NoActivePlayerWait']);
			$showResultWait->setValue($data['ShowResultWait']);
			$matchResultWait->setValue($data['MatchResultWait']);
			$sessionStartWait->setValue($data['SessionStartWait']);
			$playerJoinSession->setValue($data['CanPlayerJoinInSession']);
			$loopOverSession->setValue($data['LoopOverSessions']);
			$maxSessionPoints->setValue($data['MaxSessionPoints']);
			$houseEdge->setValue($data['HouseEdge']);
			$maxTimeoutLimit->setValue($data['MaxTimeoutLimit']);
			$playerSelectTimeout->setValue($data['PlayerSelectTimeout']);
			$minPlayer->setValue($data['min_players']);
			$maxPlayer->setValue($data['max_players']);
			$maxSpectators->setValue($data['max_spectators']);
			$amountType->setValue($data['amount_type']);
			$minBet->setValue($data['min_bet']);
			$maxBet->setValue($data['max_bet']);
			$minActiveRoom->setValue($data['min_active_rooms']);
			$incrementRooms->setValue($data['increment_rooms']);
			$maxRooms->setValue($data['max_rooms']);
			$createRooms->setValue($data['create_rooms']);
			$tableName->setValue($data['table_name']);
			$tableDesc->setValue($data['table_description']);
			$status->setValue($data['status']);
			$gameFlavour->setValue($data['game_flavour']);
			$gameRules->setValue($data['game_rules']);
		}
		
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel('Submit')
			->setIgnore(true);
		
		$this->addElements(array(
			$gameType,
			$initDeck,
			$initJokers,
			$earlyDrop,
			$midDrop,
			$maxPoints,
			$minPoints,
			$defaultErrorTime,
			$turnTimeout,
			$meldTimeout,
			$gameStartWait,
			$noActivePlayerWait,
			$showResultWait,
			$matchResultWait,
			$sessionStartWait,
			$playerJoinSession,
			$loopOverSession,
			$maxSessionPoints,
			$houseEdge,
			$maxTimeoutLimit,
			$playerSelectTimeout,
			$minPlayer,
			$maxPlayer,
			$maxSpectators,
			$amountType,
			$minBet,
			$maxBet,
			$minActiveRoom,
			$incrementRooms,
			$createRooms,
			$maxRooms,
			$tableName,
			$tableDesc,
			$status,
			$submit,
			$gameFlavour,
			$gameRules,
		));
			
		return $this;
	}
	
	public function getFlavourSelectionForm($gameFlavours)
	{
		$flavour = $this->createElement('select', 'flavour');
		$flavour->setLabel('Select Flavour');
		
		foreach($gameFlavours as $gameFlavour)
		{
			$flavour->addMultiOption($gameFlavour['game_flavour'], $gameFlavour['game_flavour']);
		}
		
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel('Submit')
				->setIgnore(true);
				
		$this->addElements(array(
				$flavour,
				$submit
			));
			
		$this->setAction('/rummyconfig/process');
		return $this;
	}
}