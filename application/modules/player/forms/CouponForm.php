<?php
class Player_CouponForm extends Zend_Form
{
	public function init()
	{			
		$code = $this->createElement('text', 'code');
		$code->setLabel('Enter your coupon code')
			->setAttrib('class', 'text');
		
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel('Submit');
		
		$front = Zend_Controller_Front::getInstance()->getRequest();
		$language = $front->getParam('lang');
		if($language)
		{
			$homeLink = '/' . $language . '/game';
		}
		else
		{
			$homeLink = '/game';
		}
		$loginDescription = '<a href = "' . $homeLink . '">' . $this->getView()->translate('No Thanks') . '</a>';
				
		$login = $this->createElement('hidden','login');
		$login->setDescription($loginDescription);
		
		$this->addElements(array(
				$code,
				$submit,
				$login,
			));
			
		$decorator = new Zenfox_DecoratorForm();
		$login->setDecorators($decorator->linkDecorator);
		
		$this->setAction('/coupon/redeem');
		$this->setAttrib('id', 'player-coupon-form');
		
		$decorator = new Zenfox_DecoratorForm();
		$code->setDecorators($decorator->openingUlTagDecorator);
		$submit->setDecorators($decorator->closingUlButtonTagDecorator);
	}
}