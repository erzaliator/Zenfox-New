<?php
class Admin_RegistrationForm extends Zend_Form
{
	public function init()
	{
		$first_name = $this->createElement('text','first_name');
		$first_name->setLabel('First Name *')
				->setRequired(true)
				->addValidator('Alpha');
			
		$last_name = $this->createElement('text','last_name');
		$last_name->setLabel('Last Name *')
				->setRequired(true)
				->addValidator('Alpha');
				
		$sex = $this->createElement('select','sex');
		$sex->setLabel('Sex')
			->addMultiOptions(array(
					'M'=>'Male',
					'F'=>'Female'
			)
		);
		
		$dateOfBirth = new Zend_Dojo_Form_Element_DateTextBox('dateOfBirth');
		$dateOfBirth->setLabel('Date Of Birth')
					->setRequired(true);
		
		$address = $this->createElement('text','address');
		$address->setLabel('Address');
		
		$city = $this->createElement('text','city');
		$city->setLabel('City')
			->addValidator('Alpha');
		
		$state = $this->createElement('text','state');
		$state->setLabel('State');
		
		$country = $this->createElement('text','country');
		$country->setLabel('Country');
		
		$pin = $this->createElement('text','pin');
		$pin->setLabel('Pin Code')
			->addValidator('Digit');
		
		$phone = $this->createElement('text','phone');
		$phone->setLabel('Phone No');
		
		$securityQuestion = $this->createElement('text','securityQuestion');
		$securityQuestion->setLabel('Security Question')
						->setRequired(true);
				
		$hint = $this->createElement('text','hint');
		$hint->setLabel('Hint');
		
		$securityAnswer = $this->createElement('text','securityAnswer');
		$securityAnswer->setLabel('Answer')
					->setRequired(true);
					
		$newsletter = $this->createElement('checkbox','newsletter');
		$newsletter->setLabel('I regular news updates from the website.');
				
		$submit = $this->createElement('submit','submit');
		$submit->setLabel('Submit')
				->setIgnore(true);
		
		$this->addElements(array(
				$first_name,
				$last_name,
				$sex,
				$dateOfBirth,
				$address,
				$city,
				$state,
				$country,
				$pin,
				$phone,
				$securityQuestion,
				$hint,
				$securityAnswer,
				$newsletter,
				$submit
			)
		);
	}
}
