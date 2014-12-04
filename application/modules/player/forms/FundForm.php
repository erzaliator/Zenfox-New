<?php
class Player_FundForm extends Zend_Form
{
	public function init()
	{
		/* $my_currency = new Zend_Currency(
		array(
				        'value'    => 100,
				        'symbol' => '<img src="/css/rummy.tld/images/my-home.png">',
		)
		);
		
		print $my_currency; */
		
		$decorator = new Zenfox_DecoratorForm();
		$currency = new Zend_Currency();
		//$currency->setLocale('en_IN');
		$currency->setValue($this->getView()->translate('100'));
		
		
		$fundCurrency = $this->createElement('hidden', 'currency');
		$fundCurrency->setValue($currency->getShortName());

		

		$fund = $this->createElement('hidden', 'fund');
		$fund->setValue($currency->getValue());
		//$fund->setLabel($this->getView()->translate('Credit Amount By %s', $currency));
		//$this->addElement();
		$fundButton = $this->createElement('submit','fundButton');
		$fundButton->setLabel($this->getView()->translate('Credit Amount By %s', $currency));
		
		
				
		$existingcard = $this->createElement('select','existingcard');
		$existingcard->setLabel($this->getView()->translate('Use existing card '))
				
				->setRequired(true)
				//->setAttrib('class', 'text')
				->addValidator('Alpha');
				
				
				
	    $amount = $this->createElement('text','amount');
		$amount->setLabel($this->getView()->translate('Enter Amount:'))
				->setRequired(true)
				//->setAttrib('class', 'text')
				->addValidator('Alpha');
				
		$ukashvoucher = $this->createElement('text','ukashvoucher');
		$ukashvoucher->setLabel($this->getView()->translate('Enter Ukash voucher Number:'))
				->setRequired(true)
				//->setAttrib('class', 'text')
				->addValidator('Alpha');
				
	   $ukashamount = $this->createElement('text','ukashamount');
		$ukashamount->setLabel($this->getView()->translate('Enter Ukash amount:'))
				->setRequired(true)
				//->setAttrib('class', 'text')
				->addValidator('Alpha');
				
	   $submit = $this->createElement('submit','submit');
	   //$submit->setLabel($this->getView()->translate('submit'));
				
		$cardtype = $this->createElement('text','cardtype');
		$cardtype->setLabel($this->getView()->translate('Card Type'))
				->setRequired(true)
				//->setAttrib('class', 'text')
				->addValidator('Alpha');
				
		$cardnumber = $this->createElement('text','cardnumber');
		$cardnumber->setLabel($this->getView()->translate('Card Number'))
				->setRequired(true)
				//->setAttrib('class', 'text')
				->addValidator('Alpha');
				
		$expirydate = $this->createElement('text','expirydate');
		$expirydate->setLabel($this->getView()->translate('Expiry date'))
				->setRequired(true)
				//->setAttrib('class', 'text')
				->addValidator('Alpha');
				
		$verification = $this->createElement('text','verification');
		$verification->setLabel($this->getView()->translate('Verification Number'))
				->setRequired(true)
				//->setAttrib('class', 'text')
				->addValidator('Alpha');
				
				 $amount1 = $this->createElement('text','amount1');
		         $amount1->setLabel($this->getView()->translate('Enter Amount:'))
				->setRequired(true)
				//->setAttrib('class', 'text')
				->addValidator('Alpha');
				
				$submit1 = $this->createElement('submit','submit_new');
				
		$this->setAttrib('id', 'player-fund-form');
		
				
				
        $this->addElements(array(
		$fundCurrency,
		$fund,
		$fundButton,
		$existingcard,
		$amount,
		$ukashvoucher,
		$ukashamount,
		$submit,
		$cardtype,
		$cardnumber,
		$expirydate,
		$verification,
		$amount1,
		$submit1
		));
		
		$this->setAction('/banking/fundbonus');
		
		
		
		$fundCurrency->setDecorators($decorator->openingUlTagDecorator);
		$fund->setDecorators($decorator->changeUlTagDecorator);
		$existingcard->setDecorators($decorator->changeUlTagDecorator);
		$amount->setDecorators($decorator->changeUlTagDecorator);
		$ukashvoucher->setDecorators($decorator->changeUlTagDecorator);
		$ukashamount->setDecorators($decorator->changeUlTagDecorator);
		$submit->setDecorators($decorator->closingUlButtonTagDecorator);
		$cardtype->setDecorators($decorator->changeUlTagDecorator);
		$cardnumber->setDecorators($decorator->changeUlTagDecorator);
		$expirydate->setDecorators($decorator->changeUlTagDecorator);
		$verification->setDecorators($decorator->changeUlTagDecorator);
		$amount1->setDecorators($decorator->changeUlTagDecorator);
		$submit1->setDecorators($decorator->closingUlButtonTagDecorator);
		$fundButton->setDecorators($decorator->closingUlButtonTagDecorator);
		
		
	}
}
