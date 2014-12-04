<?php
class Affiliate_RegistrationForm extends Zend_Form
{
	public function getForm()
	{
		$alias = $this->createElement('text','alias');
		$alias->setLabel($this->getView()->translate('User Name *'))
         	->setRequired(true);
         	//->addValidator(new Zenfox_Validate_UsernameValidator);
         	
        $password = $this->createElement('password','password');
		$password->setLabel($this->getView()->translate('Password *'))
				->setRequired(true);
				//->addValidator('stringLength', false, array(6,20));
				
		$confirmPassword = $this->createElement('password','confirmPassword');
		$confirmPassword->setLabel($this->getView()->translate('Confirm Password *'))
						->setRequired(true);
						//->addValidator('stringLength', false, array(6,20));
						
		$email = $this->createElement('text','email');
		$email->setLabel($this->getView()->translate('Email ID *'))
				->setRequired(true);
				//->addValidator('EmailAddress');
				
		$firstName = $this->createElement('text','firstName');
		$firstName->setLabel($this->getView()->translate('First Name *'))
				->setRequired(true);
				//->addValidator('Alpha');
			
		$lastName = $this->createElement('text','lastName');
		$lastName->setLabel($this->getView()->translate('Last Name *'))
				->setRequired(true);
				//->addValidator('Alpha');
				
		$company = $this->createElement('text','company');
		$company->setLabel($this->getView()->translate('Company *'))
				->setRequired(true);
				
		$address = $this->createElement('text','address');
		$address->setLabel($this->getView()->translate('Address *'))
				->setRequired(true);
				
		$city = $this->createElement('text','city');
		$city->setLabel($this->getView()->translate('City *'))
				->setRequired(true);
				
		$state = $this->createElement('text','state');
		$state->setLabel($this->getView()->translate('State *'))
				->setRequired(true);
		
		$countries = new Country();
		$countriesList = $countries->getAllCountriesList();
		$country = $this->createElement('select','country');
		$country->setLabel($this->getView()->translate('Country'));
		foreach($countriesList as $countryData)
		{
			$country->addMultiOption($countryData['country_code'], $countryData['country']);
		}
				
		$zip = $this->createElement('text','zip');
		$zip->setLabel($this->getView()->translate('Pin Code *'))
			//->addValidator('Digits')
			->setRequired(true);
			
		$phone = $this->createElement('text','phone');
		$phone->setLabel($this->getView()->translate('Phone No *'))
			  //->addValidator('Digits')
			  ->setRequired(true);
		
		$paymentType = $this->createElement('text','paymentType');
		$paymentType->setLabel($this->getView()->translate('Payment Type *'))
					->setRequired(true);
					
		$masterId = $this->createElement('text','masterId');
		$masterId->setLabel($this->getView()->translate('Referer Alias'));

		$languages = new Language();
		$allLanguages = $languages->getLanguages();
		
		/* $language = $this->createElement('select','lang');
		$language->setLabel($this->getView()->translate('Language *'));
		foreach($allLanguages as $lang)
		{
			$language->addMultiOption($lang['locale'], $lang['language']);
		} */
					
		$submit = $this->createElement('submit','submit');
		$submit->setLabel($this->getView()->translate('Submit'))
				->setIgnore(true);
				
		$this->addElements(array(
				$alias,
				$password,
				$confirmPassword,
				$email,
				$firstName,
				$lastName,
				$company,
				$address,
				$city,
				$state,
				$country,
				$zip,
				$phone,
				$paymentType,
				$masterId,
				//$language,
				$submit
			)
		);
		
		$this->setMethod('post');
		
		return $this;
	}
	
	public function setForm($data)
	{
		$form = $this->getForm();
		$form->removeElement('password');
		$form->removeElement('confirmPassword');
		$form->removeElement('alias');
		$form->removeElement('email');
		$form->removeElement('masterId');
		$form->firstName->setValue($data['firstName']);
		$form->lastName->setValue($data['lastName']);
		$form->company->setValue($data['company']);
		$form->address->setValue($data['address']);
		$form->city->setValue($data['city']);
		$form->state->setValue($data['state']);
		$form->country->setValue($data['country']);
		$form->zip->setValue($data['zip']);
		$form->phone->setValue($data['phone']);
		$form->paymentType->setValue($data['paymentType']);
		/*$form->lang->setValue($data['language']);*/
		
		return $form;
		
	}
	
}
