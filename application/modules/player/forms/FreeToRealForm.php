<?php

class Player_FreeToRealForm extends Zend_Form
{
	public function init()
	{
		$freeMoney = $this->createElement('text', 'freeMoney');
		$freeMoney->setLabel('Enter the amount *')
				->addValidator('Digits')
				->setRequired(true);
		
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel('Convert')
			->setIgnore(true);
		
		$this->addElements(array(
				$freeMoney,
				$submit
			));
	}
}