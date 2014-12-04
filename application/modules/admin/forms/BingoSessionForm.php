<?php
class Admin_BingoSessionForm extends Zend_Form
{
	public function getForm($sessionData = NULL)
	{
		Zend_Dojo::enableForm($this);

		if($sessionData)
		{
			$sessionName = $this->createElement('hidden', 'sessionName');
			$sessionName->setLabel($sessionData['name']);
		}
		else
		{
			$sessionName = $this->createElement('text', 'sessionName');
			$sessionName->setLabel('Bingo Session Name*')
					->setRequired(true);
		}
		$this->addElement($sessionName);
		
		if($sessionData)
		{
			$this->addElement(
				'SimpleTextarea',
				'description',
				array(
        				'label' => 'Description',
       					'style' => 'width: 30em; height: 10em;',
						'value' => $sessionData['description'],
    				)
    		);
		}
		else
		{
			$this->addElement(
				'SimpleTextarea',
				'description',
				array(
        				'label' => 'Description',
       					'style' => 'width: 30em; height: 10em;'
    				)
    		);
		}
    		
    	$listOfGames = $this->createElement('hidden', 'listOfGames');
    	$listOfGames->setLabel('Select games to add in this session');
    	$this->addElement($listOfGames);
    	
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
					$submit,
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
		foreach($allBingoGameData as $index => $bingoGameData)
		{
			$option = $form->createElement('checkbox', $bingoGameData['id']);
			$orderNumber = $form->createElement('select', 'orderNumber_' . $bingoGameData['id']);
			$orderNumber->addMultiOptions(array('-1' => 'Select Order'));
			for($noOfGames = 1; $noOfGames <= $totalBingoGames; $noOfGames++)
			{
				$orderNumber->setLabel($bingoGameData['name']);
				$orderNumber->addMultiOptions(array(
								$noOfGames => 'Order - ' . $noOfGames,
								));
			}
			
			if($bingoGamesData)
			{
				foreach($bingoGamesData as $gameData)
				{
					if($gameData['game_id'] == $bingoGameData['id'])
					{
						$option->setValue(1);
						$orderNumber->setValue($gameData[$gameData['game_id']]['sequence']);
					}
				}
			}
			
			$form->addElements(array(
							$option,
							$orderNumber));
			
			$option->setDecorators($decorator->openingTagDecorator);
			$orderNumber->setDecorators($decorator->closingTagDecorator);
			$option->addDecorators($decorator->nextLineDecorator);
		}
		return $form;
	}
	
	public function setForm($sessionData)
	{
		
	}
}