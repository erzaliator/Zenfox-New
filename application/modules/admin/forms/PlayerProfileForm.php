<?php
/**
 * This form is used to edit player profile
 */

class Admin_PlayerProfileForm extends Zend_Form
{
	public function editProfile($playerData)
	{
		$loginName = $this->createElement('text','login');
		$loginName->setLabel($this->getView()->translate('Login Name'))
				->addValidator('Alnum')
				->setAttrib('style', 'background:#ff3535');
				
		$password = $this->createElement('password','password');
		$password->setLabel($this->getView()->translate('Change Password to:'))
				->addValidator('stringLength', false, array(6,50,'messages' => array('stringLengthTooShort' => $this->getView()->translate("Password too short, make sure your password is atleast 6 characters long"), 'stringLengthTooLong' => $this->getView()->translate("Password too long. Password cannot be longer than 50 characters"))))
				->setAttrib('class', 'input-block-level')
				->setAttrib('style', 'background:#ff3535'); 

		$firstName = $this->createElement('text','first_name');
		$firstName->setLabel($this->getView()->translate('First Name'))
				->addValidator('Alnum');
			
		$lastName = $this->createElement('text','last_name');
		$lastName->setLabel($this->getView()->translate('Last Name'))
				->addValidator('Alnum');
		
		$sex = $this->createElement('select','sex');
		$sex->setLabel($this->getView()->translate('Sex'))
			->addMultiOptions(array(
					'M' => $this->getView()->translate('Male'),
					'F' => $this->getView()->translate('Female')
				)
			);
		
		$dateOfBirth = new ZendX_JQuery_Form_Element_DatePicker('dateofbirth');
		$dateOfBirth->setLabel($this->getView()->translate('Date Of Birth'))
				->setJQueryParam('dateFormat', 'yy-mm-dd')
				->setJQueryParam('changeMonth',true)
				->setJQueryParam('changeYear',true)
				//TODO:: Replace 18 with frontend specific age limit :-)
				->setJQueryParam('yearRange','1900:' . (Zend_Date::now()->get(Zend_Date::YEAR)-18));
		
		$address = $this->createElement('text','address');
		$address->setLabel($this->getView()->translate('Address'));
		
		$city = $this->createElement('text','city');
		$city->setLabel($this->getView()->translate('City'))
			->addValidator('Alnum');
		
		$state = $this->createElement('text','state');
		$state->setLabel($this->getView()->translate('State'));
		
		$countries = new Country();
		$countriesList = $countries->getAllCountriesList();
		
		$country = $this->createElement('select','country');
		$country->setLabel($this->getView()->translate('Country'));
		foreach($countriesList as $countryData)
		{
			$country->addMultiOption($countryData['country_code'], $countryData['country']);
		}
		
		$pin = $this->createElement('text','pin');
		$pin->setLabel($this->getView()->translate('Pin Code'))
			->addValidator('Alnum');
		
		$phone = $this->createElement('text','phone');
		$phone->setLabel($this->getView()->translate('Phone No'));
		
		/* $securityQuestion = $this->createElement('text','question');
		$securityQuestion->setLabel($this->getView()->translate('Security Question'));
		
		$hint = $this->createElement('text','hint');
		$hint->setLabel($this->getView()->translate('Hint'));
		
		$securityAnswer = $this->createElement('text','answer');
		$securityAnswer->setLabel($this->getView()->translate('Answer')); */
			
		$newsletter = $this->createElement('checkbox','newsletter');
		$newsletter->setLabel($this->getView()->translate('I want regular news updates from the website'));
		
		if($playerData)
		{
			$loginName->setValue($playerData['login']);
			$firstName->setValue($playerData['firstName']);
			$lastName->setValue($playerData['lastName']);
			$sex->setValue($playerData['sex']);
			$dateOfBirth->setValue($playerData['dateOfBirth']);
			$address->setValue($playerData['address']);
			$city->setValue($playerData['city']);
			$state->setValue($playerData['state']);
			$country->setValue($playerData['country']);
			$pin->setValue($playerData['pin']);
			$phone->setValue($playerData['phone']);
			/* $securityQuestion->setValue($playerData['securityQuestion']);
			$hint->setValue($playerData['hint']);
			$securityAnswer->setValue($playerData['securityAnswer']); */
			$newsletter->setValue($playerData['newsletter']);
		}
		
		$submit = $this->createElement('submit','submit');
		$submit->setLabel($this->getView()->translate('Submit'))
			->setIgnore(true);
		
		$this->addElements(array(
				$loginName,
				$password,
				$firstName,
				$lastName,
				$sex,
				$dateOfBirth,
				$address,
				$city,
				$state,
				$country,
				$pin,
				$phone,
				$newsletter,
				$submit
			)
		);
		$this->setAttrib('id', 'player-edit-form');
		return $this;
	}
}
