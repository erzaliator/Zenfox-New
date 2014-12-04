<?php
class Admin_BingoSessionsForm extends Zend_Form
{
	public function getForm($sessionData = NULL)
	{
		Zend_Dojo::enableForm($this);
		If($sessionData)
		{
			$sessionId = $this->createElement('hidden', 'id');
			$sessionId->setLabel('Id = '.$sessionData["id"]);
					
					
			$this->addElement($sessionId);
		}
		else
		{
			$sessionId = $this->createElement('hidden', 'id');
					
					
			$this->addElement($sessionId);
		}
		
			$sessionName = $this->createElement('text', 'name');
			$sessionName->setLabel('Bingo Session Name *')
					->setValue($sessionData["name"])
					->setRequired(true);
		
		$description = $this->createElement('textarea', 'description');
			$description->setLabel('Description')
					->setValue($sessionData["description"]);

					$this->addElements(array(
					$sessionName,$description
				));
				
		if($sessionData)
    	{
    		$this->addSubForm($this->addBingoGames($sessionData['bingo']), 'bingo');
    	}
    	else
    	{
    		$this->addSubForm($this->addBingoGames(), 'bingo');
    	}
					
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel('Submit')
			->setIgnore(true);
		$this->addElements(array(
					$submit
				));
		return $this;
	}
	
	public function addBingoGames($bingoGamesData = NULL)
	{
		
		$form = new Zend_Form_SubForm();
		$bingoGame = new BingoGame();
		$allBingoGameData = $bingoGame->getAllData();
		$totalBingoGames = count($allBingoGameData);
		//Zenfox_Debug::dump($allBingoGameData, 'data');
		$decorator = new Zenfox_DecoratorForm();
		
		if($bingoGamesData)
		{
			$sessiongamescount = count($bingoGamesData) + 5; 
		}
		else
		{
			$sessiongamescount = 15; 
		}
		
		for($ordernumber = 1; $ordernumber <= $sessiongamescount; $ordernumber++)
		{
			
			$option = $form->createElement('checkbox', 'checked'.$ordernumber);
			$gameslist = $form->createElement('select', 'Sequence number'.$ordernumber);
			$gameslist->addMultiOptions(array('-1' => 'Select Game'));
			foreach($allBingoGameData as $index => $bingoGameData)
			{
				$gameslist->setLabel('orderNumber_' . $ordernumber);
				$gameslist->addMultiOptions(array(
								$bingoGameData['id'] => $bingoGameData['name'],
								));
			}
			
			if($bingoGamesData[$ordernumber-1])
			{
				$option->setValue(1);
				$gameslist->setValue($bingoGamesData[$ordernumber-1]['game_id']);
			}
			
			$form->addElements(array(
							$option,
							$gameslist));
			
			//$option->setDecorators($decorator->openingTagDecorator);
		//	$orderNumber->setDecorators($decorator->closingTagDecorator);
			$option->addDecorators($decorator->nextLineDecorator);
		}
		return $form;
	}
	
	public function setForm($sessionData)
	{
		
	}
}