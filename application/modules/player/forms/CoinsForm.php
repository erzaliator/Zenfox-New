<?php

class Player_CoinsForm extends Zend_Form
{
	public function init()
	{
		$coins = $this->createElement('radio', 'coins');
		$coins->setLabel('Select Coins')
			->addMultiOptions(array(
				'50' => '50 TaashCoins = 50 Ibibo ICoins',
				'100' => '100 TaashCoins = 100 Ibibo ICoins',
				'200' => '200 TaashCoins = 200 Ibibo ICoins',
				'500' => '500 TaashCoins = 500 Ibibo ICoins',
				'1000' => '1000 TaashCoins = 1000 Ibibo ICoins',
				'custom' => 'Custom Icoins'
			));
			
		$customIcoins = $this->createElement('text', 'customIcoins');
		
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel('Submit');
		
		$this->addElements(array(
				$coins,
				$customIcoins,
				$submit
			));
			
		$this->setAttrib('id','player-coin');
	}
}