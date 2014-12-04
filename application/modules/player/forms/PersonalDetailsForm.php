<?php

class Player_personaldetailsForm extends Zend_Form
{
	public function getform($data = null,$rtype = null)
	{
		$decorator = new Zenfox_DecoratorForm();
		
			$completed = true;
			foreach($data as $playerDetail)
			{
				if(!$playerDetail)
				{
					$completed = false;
					break;
				}
			}
			
		
		$tempField = $this->createElement('hidden', 'temp');
		$this->addElement($tempField);
		
		$firstname = $this->createElement('text','first_name');
		$firstname->setLabel($this->getView()->translate('First Name * '))
		->addValidator('NotEmpty', true, array('messages' => 'Value is required'))
		->setValue($data['first_name'])
		->addValidator(new Zenfox_Validate_UsernameValidator)
		->setAttrib('style','width:138px;')
		->setRequired(true);
		
		$lastname = $this->createElement('text','last_name');
		$lastname->setLabel($this->getView()->translate('Last Name * '))
		->addValidator('NotEmpty', true, array('messages' => 'Value is required'))
		->setValue($data['last_name'])
		->addValidator(new Zenfox_Validate_UsernameValidator)
		->setRequired(true);
		
		$sex = new Zend_Form_Element_Select('sex');
		$sex->setLabel('Sex *')
		->setMultiOptions(array('male'=>'MALE', 'female'=>'FEMALE'))
		->addValidator('NotEmpty', true, array('messages' => 'Value is required'))
		->setValue($data['sex'])
		->setAttrib('style','width:138px;')
		->setRequired(true);
		
	
		
		$dob =new ZendX_JQuery_Form_Element_DatePicker('dateofbirth',
				array('jQueryParams' => array('dateFormat' => 'yyyy-mm-dd')));
		$dob->setLabel('Date Of Birth *')
		->addValidator('NotEmpty', true, array('messages' => 'Value is required'))
		->setValue($data['dateofbirth'])
		->setAttrib('id','dateofbirth')
		->setRequired(true);
		
		$address =new Zend_Form_Element_Textarea('address');
		$address->setLabel($this->getView()->translate('Address * '))
				 ->setAttrib('rows','5')
                    ->setAttrib('cols','10')
                    ->addValidator('NotEmpty', true, array('messages' => 'Value is required'))
                    ->setValue($data['address'])
                    ->addValidator(new Zenfox_Validate_CharactercheckValidator)
                    ->setAttrib('style','width:138px;')
						->setRequired(true) ;
		
		$city = $this->createElement('text','city');
		$city->setLabel($this->getView()->translate('City * '))
		->addValidator('NotEmpty', true, array('messages' => 'Value is required'))
		->setValue($data['city'])
		->addValidator(new Zenfox_Validate_CharactercheckValidator)
		->setRequired(true);
		
		$countries = new Country();
		$countriesList = $countries->getAllCountriesList();
		$country = $this->createElement('select','country');
		$country->setLabel($this->getView()->translate('Country'))
		->addValidator('NotEmpty', true, array('messages' => 'Value is required'))
		->setValue($data['country'])
		->setAttrib('style','width:138px;')
		->setRequired(true);
		foreach($countriesList as $countryData)
		{
			$country->addMultiOption($countryData['country_code'], $countryData['country']);
		}
		
		$state = $this->createElement('text','state');
		$state->setLabel($this->getView()->translate('State * '))
		->addValidator('NotEmpty', true, array('messages' => 'Value is required'))
		->setValue($data['state'])
		->addValidator(new Zenfox_Validate_CharactercheckValidator)
		->setRequired(true);
		
		
		$pincode = $this->createElement('text','pin');
		$pincode->setLabel($this->getView()->translate('Pincode * '))
		->addValidator('NotEmpty', true, array('messages' => 'Value is required'))
		->setValue($data['pin'])
		->addvalidator('Digits')
		->setRequired(true);
		
		$email = $this->createElement('text',"email");
		$email->setLabel($this->getView()->translate('Email * '))
		->addValidator('NotEmpty', true, array('messages' => 'Value is required'))
		->addValidator('emailAddress', false, array(6,50,'messages' => array('emailAddressInvalidFormat' => $this->getView()->translate("Email Address should be in format username@hostname"))))
		->setValue($data['email'])
		->setRequired(true);
		
		$phone = $this->createElement('text','phone');
		$phone->setLabel($this->getView()->translate('phone * '))
		->addValidator('NotEmpty', true, array('messages' => 'Value is required'))
		->setValue($data['phone'])
		->addvalidator('Digits')
		->setAttrib('style','width:138px;')
		->setRequired(true);

		
	
		
		
		$tempField->setDecorators($decorator->openingUlTagDecorator);
		$firstname->setDecorators($decorator->changeWithdrawalUlTagDecorator);
 		$lastname->setDecorators($decorator->changeWithdrawalLiTagDecorator);
 		$email->setDecorators($decorator->changeWithdrawalLiTagDecorator);
 		$pincode->setDecorators($decorator->changeWithdrawalLiTagDecorator);
 		$phone->setDecorators($decorator->changeClearUlTagDecorator);
 		$city->setDecorators($decorator->changeWithdrawalLiTagDecorator);
 		$state->setDecorators($decorator->changeWithdrawalLiTagDecorator);
  		$country->setDecorators($decorator->changeWithdrawalUlTagDecorator);
  		$address->setDecorators($decorator->changeClearUlTagDecorator);
 		$dob->setDecorators($decorator->formJQueryElements);
  		$sex->setDecorators($decorator->changeWithdrawalUlTagDecorator);
  		
  		
  		$idproof = new Player_iduploadForm();
  			
  		$addressproof = new Player_addressuploadForm();
  		
  		$bankdetails = new Player_bankdetailsForm();
  		
  		if($completed)
  		{
  			$firstname ->setAttrib('disabled','true');
 			$lastname->setAttrib('disabled','true');
 			$email->setAttrib('disabled','true');
 			$pincode->setAttrib('disabled','true');
 			$phone->setAttrib('disabled','true');
 			$city->setAttrib('disabled','true');
 			$state->setAttrib('disabled','true');
  			$country->setAttrib('disabled','true');
  			$address->setAttrib('disabled','true');
  			
  			$sex->setAttrib('disabled','true');
  			
  			if($data['dateofbirth'] == "0000-00-00")
  			{
  				$data['dateofbirth'] = "";
  				$dob->setValue($data['dateofbirth']);
  				
  			}
  			else
  			{
  				$dob->setAttrib('disabled','true');
  			}
  		}
  		
  		if($rtype == "ID")
  		{
  			//Zenfox_Debug::dump($data); exit();
  			$this->addSubForms(array('idproof_form' => $idproof->getform($data[0]),'address_form' => $addressproof->getform($data[1])));
  		}
  		elseif($rtype == "BANK")
  		{
  			$this->addSubForm($bankdetails->getform(), 'bank_detail_form');
  		}
  		else 
  		{
  			$this->addElements(array( $firstname, $lastname,$sex, $dob,
  					$address, $city,$state,$country,$pincode,$phone,$email));
  			$this->addSubForms(array('idproof_form' => $idproof->getform(),'address_form' => $addressproof->getform(),'bank_detail_form' => $bankdetails->getform()));
  		}
  		
  			
  		$submit = new Zend_Form_Element_Submit('submit');
  		$submit->setLabel('FINISH');
  		
  		$submit->setDecorators($decorator->closingUlButtonTagDecorator);
  		
  		$this->addElement($submit);
  		$this->setAttrib('id',"verification_form");
		return $this;

	}
}