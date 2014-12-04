<?php
class Admin_BingoRoomForm extends Zend_Form
{
	public function getForm()
	{
		$bingoRoom = new Zend_Form_SubForm();
		Zend_Dojo::enableForm($bingoRoom);
		
		$bingoRoomId = $bingoRoom->createElement('hidden', 'bingoRoomId');
		$bingoRoom->addElement($bingoRoomId);
		
		$name = $bingoRoom->createElement('text', 'name');
		$name->setLabel('Room Name');
		$bingoRoom->addElement($name);
		
		$bingoRoom->addElement(
				'SimpleTextarea',
				'description',
				array(
					'label' => 'Description',
       				'style' => 'width: 30em; height: 10em;',
				)
			);
		
		$gameFlavours = $bingoRoom->createElement('multiCheckbox', 'gameFlavours');
		$gameFlavours->setLabel('Select Flavours');
		$flavour = new Flavour();
		$allGamesFlavour = $flavour->getGameFlavours();
		foreach($allGamesFlavour as $game_flavour)
		{
			$gameFlavours->addMultiOption($game_flavour, $game_flavour);
		}
		
		$roomCurrency = $bingoRoom->createElement('select', 'roomCurrency');
		$roomCurrency->setLabel('Currency');
		$currency = new Currency();
		$allCurrencies = $currency->getCurrenies();
		foreach($allCurrencies as $currency)
		{
			$roomCurrency->addMultiOptions(array(
							$currency['currency_code'] => $currency['currency']));
		}
		
		$enabled = $bingoRoom->createElement('checkbox', 'enabled');
		$enabled->setLabel('Enabled')
			->setCheckedValue('ENABLED')
			->setUncheckedValue('DISABLED');
			
		$bingoRoom->addElements(array(
					$gameFlavours,
					$roomCurrency,
					$enabled,
			));
			
		return $bingoRoom;
	}
	
	public function setForm($form, $data)
	{
		if($data['bingoRoomId'])
		{
			$form->bingoRoomId->setValue($data['bingoRoomId']);
		}
		$form->name->setValue($data['name']);
		$form->description->setValue($data['description']);
		if(is_string($data['gameFlavours']))
		{
			$data['gameFlavours'] = explode(',', $data['gameFlavours']);
		}
		$form->gameFlavours->setValue($data['gameFlavours']);
		$form->roomCurrency->setValue($data['roomCurrency']);
		$form->enabled->setValue($data['enabled']);
		return $form;
	}
}