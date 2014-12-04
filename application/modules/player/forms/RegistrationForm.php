<?php
/**
 * This class creates a registration form for the user
 * @author Nikhil Gupta
 * @date January 2, 2010
 */
class Player_RegistrationForm extends Zend_Form
{
	public function registration($addForm = NULL, $playerData = NULL)
	{
		$decorator = new Zenfox_DecoratorForm();
		switch($addForm)
		{
			case 'registration':
				$this->getRegForm($decorator);
				//$this->addCaptcha();
				$this->addTermsAndConditions($decorator);
				$this->setAttrib('name', 'player-signup');
				//$this->addFacebookButton($decorator);
				break;
			case 'completeRegistration':
				$this->getRegForm($decorator, $addForm);
				$this->getEditForm($decorator, $playerData);
				//$this->addCaptcha();
				$this->addTermsAndConditions($decorator);
				break;
			case 'general':
				$this->getGenForm($decorator, $playerData);
				break;
			case 'setting':
				$this->getSetForm($decorator, $playerData);
				break;
			case 'connect':
				$this->getConForm($decorator, $playerData);
				break;
			case 'edit':
				$this->getGenForm($decorator, $playerData);
				$this->getConForm($decorator, $playerData);
				$this->getSetForm($decorator, $playerData);
				break;
			case 'image':
				$this->getImageForm();
				break;
		}
		$this->submitButton($decorator);
		$this->setAttrib('id', 'player-registration-form');
		return $this;
	}
	
	public function getRegForm($decorator, $formType = NULL)
	{
		/*$session = new Zend_Session_Namespace('playerTrackerId');
		$playerTrackerId = $session->trackerId;
		$trackerId = $this->createElement('hidden', 'trackerId');
		if($playerTrackerId)
		{
			$trackerId->setValue($playerTrackerId);
		}*/
		
		$frontendId = Zend_Registry::get('frontendId');
		
		$login = $this->createElement('text','login');
		$login->setRequired(true)
         	//->addValidator(new Zenfox_Validate_UsernameValidator)
         	->setAttrib('class', 'input-block-level')
			->addValidator(new Zenfox_Validate_UsernameValidator);
			//->setLabel($this->getView()->translate('Username *'));
         					
		$password = $this->createElement('password','password');
		$password->setRequired(true)
				->addValidator('stringLength', false, array(6,50,'messages' => array('stringLengthTooShort' => $this->getView()->translate("Password too short, make sure your password is atleast 6 characters long"), 'stringLengthTooLong' => $this->getView()->translate("Password too long. Password cannot be longer than 50 characters"))))
				->setAttrib('class', 'input-block-level');
				//->setLabel($this->getView()->translate('Password *'));
				
				
		if($frontendId == 7)
		{
			$confirmPassword = $this->createElement('text','confirmPassword');
			$confirmPassword->setRequired(true)
							->addValidator('Digits')
							->setAttrib('class', 'input-block-level');
		}
		else
		{
			$confirmPassword = $this->createElement('password','confirmPassword');
			$confirmPassword->setRequired(true)
							->addValidator('stringLength', false, array(6,50,'messages' => array('stringLengthTooShort' => $this->getView()->translate("Password too short, make sure your password is atleast 6 characters long"), 'stringLengthTooLong' => $this->getView()->translate("Password too long. Password cannot be longer than 50 characters"))))
							->setAttrib('class', 'input-block-level');
							//->setLabel($this->getView()->translate('Confirm Password *'));
		}
						
				
		$email = $this->createElement('text','email');
		$email->setRequired(true)
				->addValidator('emailAddress', false, array(6,50,'messages' => array('emailAddressInvalidFormat' => $this->getView()->translate("Email Address should be in format username@hostname"))))
				->setAttrib('class', 'input-block-level');
						//->setLabel($this->getView()->translate('EmailID *'));
				
				

		if($frontendId == 1 && $formType == 'completeRegistration')
		{
			$login->setLabel('Username*');
			$password->setLabel('Password*');
			$confirmPassword->setLabel('Confirm Password*');
			$email->setLabel('Email*');
		}
		else
		{
			$login->setAttrib('placeholder', 'Username');
			$password->setAttrib('placeholder', 'Password');
			if($frontendId == 7)
			{							
				$confirmPassword->setAttrib('placeholder', 'Phone No (Enter Digits Only)');
			}
			else
			{
				$confirmPassword->setAttrib('placeholder', 'Confirm Password');
			}
			$email->setAttrib('placeholder', 'Email');
		}
		//$tracker_id = NULL;
		$buddy_id = NULL;
		$aff_id = NULL;
		/*$request = Zend_Controller_Front::getInstance()->getRequest();
		$tracker_id = $request->getParam('trackerId');
		if(!$tracker_id)
		{
			$trackerSession = new Zend_Session_Namespace('tracker');
    		$tracker_id = $trackerSession->value;
    		//$trackerSession->unsetAll();
    		if(!$tracker_id)
    		{
				$request = Zend_Controller_Front::getInstance()->getRequest();
				$buddy_id = $request->getParam('buddyId');
				if(!$buddy_id)
				{
					$buddySession = new Zend_Session_Namespace('buddy');
    				$buddy_id = $buddySession->value;
				}
				if(!$buddy_id)
				{
					$buddy_id = 4;
				}
    		}
		}*/
		$trackerSession = new Zend_Session_Namespace('tracker');
		$tracker_id = isset($trackerSession->value) ? $trackerSession->value : NULL;
		if(!$tracker_id)
		{
			$buddySession = new Zend_Session_Namespace('buddy');
			$buddy_id = isset($buddySession->value) ? $buddySession->value : NULL;
		}
		else
		{
			$affSession = new Zend_Session_Namespace('affSession');
			$aff_id = $affSession->value;
		}

		$trackerId = $this->createElement('hidden', 'trackerId');
		$trackerId->setValue($tracker_id);
		
		$buddyId = $this->createElement('hidden', 'buddyId');
		$buddyId->setValue($buddy_id);
		
		$affId = $this->createElement('hidden', 'affId');
		$affId->setValue($aff_id);
		
		/*
		 * Facebook specific details
		 */
		
		$this->addElements(array(
				$affId,
				$trackerId,
				$buddyId,
				$login,
				$password,
				$confirmPassword,
				$email,
			)
		);
		
		
		
		/* $login->setDecorators($decorator->openingUlTagDecorator);
		$password->setDecorators($decorator->changeUlTagDecorator);
		$confirmPassword->setDecorators($decorator->changeUlTagDecorator);
		$email->setDecorators($decorator->changeUlTagDecorator); */
		//$captchaElement->setDecorators($decorator->changeUlTagDecorator);
	}
	
	public function addFacebookButton($decorator)
	{
		/*$facebookButton = '<fb:login-button v="2" size="medium" >Connect with Facebook</fb:login-button>';
		$facebookLogin = $this->createElement('hidden','facebookLogin');
		$facebookLogin->setDescription($facebookButton);*/
		$facebookDescription = '<a href = "#" onClick="facebookLogin()"><img src="/images/facebook-login-button.png" /></a>';
		$facebookLogin = $this->createElement('hidden', 'facebookLogin');
		$facebookLogin->setDescription($facebookDescription);
		$this->addElement($facebookLogin);
		$facebookLogin->setDecorators($decorator->facebookLinkDecorator);
	}
	
	public function addTermsAndConditions($decorator)
	{
		$termLink = '/content/terms';
		$termsDescription = '<span id="terms-conditions">I agree to <a href = "' . $termLink . '">' . $this->getView()->translate('Terms & Conditions') . '</a></span>';
		
		$terms = $this->createElement('checkbox','terms');
		$terms//->setLabel($this->getView()->translate('Signing up means you agree to the '))
				//->setAttrib('style', 'width:300px')
				->setAttrib('class', 'text')
				->setDescription($termsDescription)
				->setValue(true);
		$this->addElement($terms);
		//$terms->setDecorators($decorator->termsDecorator);
	}
	
	public function getEditForm($decorator, $playerData = NULL)
	{
		$this->getGenForm($decorator, $playerData);
		$this->getConForm($decorator, $playerData);
		$this->getSetForm($decorator, $playerData);
	}
	
	public function getGenForm($decorator, $playerData = NULL)
	{
		$firstName = $this->createElement('text','first_name');
		$firstName->setLabel($this->getView()->translate('First Name *'))
				
				->setRequired(true)
				->setAttrib('class', 'text')
				->addValidator('Alpha');
				//->setAttrib('class', 'text');
			
		$lastName = $this->createElement('text','last_name');
		$lastName->setLabel($this->getView()->translate('Last Name *'))
				->setRequired(true)
				//->setAttrib('style', 'width:300px')
				->addValidator('Alpha');
				//->setAttrib('class', 'text');
				
				  					
		/* $password1 = $this->createElement('password','password1');
		$password1->setLabel($this->getView()->translate('Password *'))
		        ->setRequired(true)
				->addValidator('stringLength', false, array(6,50,'messages' => array('stringLengthTooShort' => $this->getView()->translate("Password too short, make sure your password is atleast 6 characters long"), 'stringLengthTooLong' => $this->getView()->translate("Password too long. Password cannot be longer than 50 characters"))));
				
				 
		$confirmPassword1 = $this->createElement('password','confirmPassword1');
		$confirmPassword1->setLabel($this->getView()->translate('ConfirmPassword *'))
		                ->setRequired(true)
						->addValidator('stringLength', false, array(6,50,'messages' => array('stringLengthTooShort' => $this->getView()->translate("Password too short, make sure your password is atleast 6 characters long"), 'stringLengthTooLong' => $this->getView()->translate("Password too long. Password cannot be longer than 50 characters"))));	
						
		$email1 = $this->createElement('text','email1');
		$email1->setLabel($this->getView()->translate('Email *'))
		     ->setRequired(true)
				->addValidator('emailAddress', false, array(6,50,'messages' => array('emailAddressInvalidFormat' => $this->getView()->translate("Email Address should be in format username@hostname"))));
		 */							
				
		$sex = $this->createElement('select','sex');
		
		$sex->setLabel($this->getView()->translate('Sex'))
			->setRequired(true)
			->addMultiOptions(array(
					'M' => $this->getView()->translate('Male'),
					'F' => $this->getView()->translate('Female')
			)
		);
		
		$dateOfBirth = new ZendX_JQuery_Form_Element_DatePicker('dateofbirth');
		$dateOfBirth->setLabel($this->getView()->translate('Date Of Birth *'))
					->setJQueryParam('dateFormat', 'yy-mm-dd')
					->setJQueryParam('changeMonth',true)
					->setJQueryParam('changeYear',true)
					->setAttrib('id', 'datepicker')
					//TODO:: Replace 18 with frontend specific age limit :-)
					->setJQueryParam('yearRange','1900:' . (Zend_Date::now()->get(Zend_Date::YEAR)-18));
					//->setAttrib('style', 'width:300px')
					//->setRequired(true);
					//->setAttrib('class', 'text');
					
		$controllerName = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
		$actionName = Zend_Controller_Front::getInstance()->getRequest()->getActionName();
					
		if($playerData)
		{
			$tempField = $this->createElement('hidden', 'temp');
			$this->addElement($tempField);
			
			$tempField->setDecorators($decorator->openingUlTagDecorator);
			
			$firstName->setValue($playerData['firstName']);
			$lastName->setValue($playerData['lastName']);
			$sex->setValue($playerData['sex']);
			$dateOfBirth->setValue($playerData['dateOfBirth']);
		}
					
		$this->addElements(array(
				$firstName,
				$lastName,
				//$password1,
				//$confirmPassword1,
				//$email1,
				$sex,
				$dateOfBirth
			));
			
		if($playerData && ($controllerName == 'withdrawal' || $actionName == 'edit'))
		{
			$firstName->setDecorators($decorator->changeWithdrawalUlTagDecorator);
			$lastName->setDecorators($decorator->changeWithdrawalLiTagDecorator);
			/* $password1->setDecorators($decorator->changeUlTagDecorator);
			$confirmPassword1->setDecorators($decorator->changeUlTagDecorator);
			$emai1l->setDecorators($decorator->changeUlTagDecorator); */
			$dateOfBirth->setDecorators($decorator->formJQueryElements);
			$sex->setDecorators($decorator->changeWithdrawalUlTagDecorator);
			//$firstName->setDecorators($decorator->openingUlTagDecorator);
		}
		else
		{
			$firstName->setDecorators($decorator->changeUlTagDecorator);
			$lastName->setDecorators($decorator->changeUlTagDecorator);
			/* $password1->setDecorators($decorator->changeUlTagDecorator);
			$confirmPassword1->setDecorators($decorator->changeUlTagDecorator);
			$email1->setDecorators($decorator->changeUlTagDecorator); */
			$sex->setDecorators($decorator->changeUlTagDecorator);
			$dateOfBirth->setDecorators($decorator->formJQueryElements);
		}
	}
	
	public function getConForm($decorator, $playerData = NULL)
	{
		/* $address = $this->createElement('text','address');
		$address->setLabel($this->getView()->translate('Address')); */
		
		$address = $this->createElement('text','address');
		$address->setLabel($this->getView()->translate('Address'))	
				->setRequired(true)
				->setAttrib('class', 'text');
				//->addValidator('Alnum');
		
		$city = $this->createElement('text','city');
		$city->setLabel($this->getView()->translate('City'))
		//->setAttrib('style', 'width:300px')
		->addValidator('Alpha');
		//->setAttrib('class', 'text');
		
		$state = $this->createElement('text','state');
		$state->setLabel($this->getView()->translate('State'));
		//->setAttrib('style', 'width:300px')
		//->setAttrib('class', 'text'); */
				
		//$address =new Zend_Form_Element_Textarea('address');
//		$address->setLabel($this->getView()->translate('Address * '))
//				->setAttrib('rows','5')
//				->setAttrib('cols','10')
//				->addValidator('NotEmpty', true, array('messages' => 'Value is required'))
//				->setValue($data['address'])
//				->addValidator(new Zenfox_Validate_CharactercheckValidator)
//				->setRequired(true) ;
			//->setAttrib('style', 'width:300px')
			//->setAttrib('class', 'text');
		
		/* $address_two = $this->createElement('text','address_two');
		$address_two->setLabel($this->getView()->translate('Address2 * '))
			->setRequired(true)
				->setAttrib('class', 'text')
				->addValidator('Alpha');
				
		
		$address_3= $this->createElement('text','address_3');
		$address_3->setLabel($this->getView()->translate('Address3 * '))
			->setRequired(true)
				->setAttrib('class', 'text')
				->addValidator('Alpha'); */
		
//		$country = $this->createElement('text','country');
//		$country->setLabel($this->getView()->translate('Country'));

		$countries = new Country();
		$countriesList = $countries->getAllCountriesList();
		$country = $this->createElement('select','country');
		$country->setLabel($this->getView()->translate('Country'));
		foreach($countriesList as $countryData)
		{
			$country->addMultiOption($countryData['country_code'], $countryData['country']);
		}
		
		$pin = $this->createElement('text','pin');
		$pin->setLabel($this->getView()->translate('Zip Code'))
			//->setAttrib('style', 'width:300px')
			->addValidator(new Zenfox_Validate_CharactercheckValidator);
			//->setAttrib('class', 'text');
		
		$phone = $this->createElement('text','phone');
		$phone->setLabel($this->getView()->translate('Phone No (Enter Digits Only)'))
			->addValidator('Digits');
			//->addValidator('stringLength', false, array(10,10,'messages' => array('stringLengthTooShort' => $this->getView()->translate("Phone number must be in 10 digits only."), 'stringLengthTooLong' => $this->getView()->translate("Phone number must be in 10 digits only."))));
			//->setAttrib('style', 'width:300px')
			//->setAttrib('class', 'text');
		
		if($playerData)
		{
			$address->setValue($playerData['address']);
			$city->setValue($playerData['city']);
			$state->setValue($playerData['state']);
			$country->setValue($playerData['country']);
			$pin->setValue($playerData['pin']);
			$phone->setValue($playerData['phone']);
		}
		
		$this->addElements(array(
				$address,
// 				$address_two,
// 				$address_3,
				$city,
				$state,
				$country,
				$pin,
				$phone
			));
			
		$controllerName = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
		$actionName = Zend_Controller_Front::getInstance()->getRequest()->getActionName();
		if($playerData && ($controllerName == 'withdrawal' || $actionName == 'edit'))
		{
			//$address->setDecorators($decorator->openingUlTagDecorator);
			$address->setDecorators($decorator->changeClearUlTagDecorator);
// 			$address_two->setDecorators($decorator->changeClearUlTagDecorator);
// 			$address_3->setDecorators($decorator->changeClearUlTagDecorator);
			$city->setDecorators($decorator->changeWithdrawalUlTagDecorator);
			$state->setDecorators($decorator->changeWithdrawalUlTagDecorator);
			$country->setDecorators($decorator->changeWithdrawalUlTagDecorator);
			$pin->setDecorators($decorator->changeWithdrawalLiTagDecorator);
			$phone->setDecorators($decorator->changeClearUlTagDecorator);
		}
		else
		{
			$address->setDecorators($decorator->changeUlTagDecorator);
// 			$address_two->setDecorators($decorator->changeUlTagDecorator);
// 			$address_3->setDecorators($decorator->changeUlTagDecorator);
			$city->setDecorators($decorator->changeUlTagDecorator);
			$state->setDecorators($decorator->changeUlTagDecorator);
			$country->setDecorators($decorator->changeUlTagDecorator);
			$pin->setDecorators($decorator->changeUlTagDecorator);
			$phone->setDecorators($decorator->changeUlTagDecorator);
		}
		
	}
	
	public function getSetForm($decorator, $playerData = NULL)
	{
		/*$securityQuestion = $this->createElement('text','question');
		$securityQuestion->setLabel($this->getView()->translate('Security Question *'))
						->setAttrib('style', 'width:300px')
						->setRequired(true)
						->setAttrib('class', 'text');
				
		$hint = $this->createElement('text','hint');
		$hint->setLabel($this->getView()->translate('Hint'))
			->setAttrib('style', 'width:300px')
			->setAttrib('class', 'text');
		
		$securityAnswer = $this->createElement('text','answer');
		$securityAnswer->setLabel($this->getView()->translate('Answer *'))
					->setAttrib('style', 'width:300px')
					->setRequired(true)
					->setAttrib('class', 'text');*/
					
		$newsletter = $this->createElement('checkbox','newsletter');
		$newsletter->setLabel($this->getView()->translate('I want regular news updates from the website'))
				->setAttrib('class', 'text');
		
		if($playerData)
		{
			/*$securityQuestion->setValue($playerData['securityQuestion']);
			$hint->setValue($playerData['hint']);
			$securityAnswer->setValue($playerData['securityAnswer']);*/
			$newsletter->setValue($playerData['newsletter']);
			$newsletter->setValue(true);
			
			/*$front = Zend_Controller_Front::getInstance()->getRequest();
			$language = $front->getParam('lang');
			if($language)
			{
				$cpLink = '/' . $language . '/auth/changepwd';
			}
			else
			{
				$cpLink = '/auth/changepwd';
			}
			
			$changePwdDescription = '<a href = "' . $cpLink . '">' . $this->getView()->translate('Change Password') . '</a>';
			
			$changePwd = $this->createElement('hidden', 'changepwd');
			$changePwd->setDescription($changePwdDescription);*/
			
			$decorator = new Zenfox_DecoratorForm();
			//$changePwd->setDecorators($decorator->linkDecorator);
			
			$this->addElements(array(
				/*$securityQuestion,
				$hint,
				$securityAnswer,*/
				$newsletter,
				//$changePwd
			));
		}
		else
		{
			$this->addElements(array(
				/*$securityQuestion,
				$hint,
				$securityAnswer,*/
				$newsletter
			));
		}
		
		/*if($playerData)
		{
			$securityQuestion->setDecorators($decorator->openingUlTagDecorator);
		}
		else
		{
			$securityQuestion->setDecorators($decorator->changeUlTagDecorator);
		}
		$hint->setDecorators($decorator->changeUlTagDecorator);
		$securityAnswer->setDecorators($decorator->changeUlTagDecorator);*/
		$newsletter->setDecorators($decorator->changeNewsLetterDecorator);
	}
	
	public function getImageForm()
	{
		$session = new Zend_Auth_Storage_Session();
		$storedData = $session->read();
		$playerId = $storedData['id'];
		$imageName = md5("image" . $playerId) . '.jpg';
		
		$webConfig = Zend_Registry::getInstance()->isRegistered('webConfig')?Zend_Registry::getInstance()->get('webConfig'):'';
		$imagesDir = isset($webConfig['imagesDir'])?$webConfig['imagesDir']:'zenfox.tld';

		$image = new Zend_Form_Element_File('image');
		$image->setLabel('Upload An Image')
				->setDestination(APPLICATION_PATH . "/../public/images/profiles/")
				->addFilter('Rename', $imageName)
				//->addValidator('Count', false, array('min' => 1, 'max' => 3))
				->addValidator('Extension', false, 'jpg,png,gif')
				//->setMultiFile(3)
				  ->setRequired(true);
				  
		$this->addElement($image);
		$this->setAttrib('enctype', 'multipart/form-data');
		
		$image->setDecorators(array(
				'File',
				'Description',
				'Label',
				'Errors',
				array('HtmlTag', array('tag' => 'li')),
				array(array('row' => 'HtmlTag'), array('tag' => 'ul', 'openOnly' => true))));
	}
	
	public function addCaptcha()
	{
		$captcha = $this->createElement('captcha', 'captcha',
			array('required' => true,
				'captcha' => 
					array('captcha' => 'Dumb',
						'wordLen' => 6,
					)
				)
			);
		
		//$captcha->setLabel('Please type the words shown:');
		$this->addElement($captcha);
	}
	
	public function submitButton($decorator)
	{
		$frontendName = Zend_Registry::get('frontendName');
		
		$action = Zend_Controller_Front::getInstance()->getRequest()->getActionName();
		$submit = $this->createElement('submit','Signup');
		$submit->setLabel($this->getView()->translate('Submit'))
				->setIgnore(true);
				//->setAttrib('class', 'TTBingoGradentBtn3');
		
		/* if($action != 'signup' && $action != 'registration' && $action != 'edit' && $action != 'image' && $frontendName != 'taashtime.com' && $frontendName != 'ace2jak.com' && $frontendName != 'housie.tv')
		{
			$submit = $this->createElement('button','Signup');
			$submit->setLabel($this->getView()->translate('Submit'))
					->setIgnore(true)
					->setAttrib('class', 'TTBingoGradentBtn3')
					->setAttrib('onclick', "goToLogin('player-signup')");
		}
		
		if($frontendName == 'ace2jak.com' && $action != 'edit')
		{
			$submit->setLabel($this->getView()->translate('Signup'));
		} */
		
		$this->addElement($submit);
		$decorator = new Zenfox_DecoratorForm();
		//$submit->setDecorators($decorator->closingUlButtonTagDecorator);
		return $this;
	}
/*	public function registration($completeRegistration = NULL)
	{
		$session = new Zend_Session_Namespace('playerTrackerId');
		$playerTrackerId = $session->trackerId;
		$trackerId = $this->createElement('hidden', 'trackerId');
		if($playerTrackerId)
		{
			$trackerId->setValue($playerTrackerId);
		}
		$login = $this->createElement('text','login');
		$login->setLabel($this->getView()->translate('Username *'))
         	->setRequired(true)
         	->addValidator(new Zenfox_Validate_UsernameValidator);
				
				
		$password = $this->createElement('password','password');
		$password->setLabel($this->getView()->translate('Password *'))
				->setRequired(true)
				->addValidator('stringLength', false, array(6,50,'messages' => array('stringLengthTooShort' => $this->getView()->translate("Password too short, make sure your password is atleast 6 characters long"), 'stringLengthTooLong' => $this->getView()->translate("Password too long. Password cannot be longer than 50 characters"))));
				
		$confirmPassword = $this->createElement('password','confirmPassword');
		$confirmPassword->setLabel($this->getView()->translate('Confirm Password *'))
						->setRequired(true)
						->addValidator('stringLength', false, array(6,50,'messages' => array('stringLengthTooShort' => $this->getView()->translate("Password too short, make sure your password is atleast 6 characters long"), 'stringLengthTooLong' => $this->getView()->translate("Password too long. Password cannot be longer than 50 characters"))));
				
		$email = $this->createElement('text','email');
		$email->setLabel($this->getView()->translate('EmailID *'))
				->setRequired(true)
				->addValidator('emailAddress', false, array(6,50,'messages' => array('emailAddressInvalidFormat' => $this->getView()->translate("Email Address should be in format username@hostname"))));
				
		$this->addElements(array(
				$trackerId,
				$login,
				$password,
				$confirmPassword,
				$email
			)
		);
				
		if($completeRegistration)
		{
			$this->editForm();
		}
		
		$this->setAttrib('id', 'player-registration-form');
		
		return $this;
	}
	*/
	//These information can be changed by player
	public function editForm($playerData = NULL)
	{
		$firstName = $this->createElement('text','first_name');
		$firstName->setLabel($this->getView()->translate('First Name *'))
				->setRequired(true)
				->addValidator('Alnum');
			
		$lastName = $this->createElement('text','last_name');
		$lastName->setLabel($this->getView()->translate('Last Name *'))
				->setRequired(true)
				->addValidator('Alnum');
				
		$sex = $this->createElement('select','sex');
		$sex->setLabel($this->getView()->translate('Sex'))
			->addMultiOptions(array(
					'M' => $this->getView()->translate('Male'),
					'F' => $this->getView()->translate('Female')
			)
		);
		
		$dateOfBirth = new ZendX_JQuery_Form_Element_DatePicker('dateofbirth');
		$dateOfBirth->setLabel($this->getView()->translate('Date Of Birth *'))
					->setJQueryParam('dateFormat', 'yy-mm-dd')
					->setJQueryParam('changeMonth',true)
					->setJQueryParam('changeYear',true)
					//TODO:: Replace 18 with frontend specific age limit :-)
					->setJQueryParam('yearRange','1900:' . (Zend_Date::now()->get(Zend_Date::YEAR)-18))
					->setRequired(true);
		
		$address = $this->createElement('text','address');
		$address->setLabel($this->getView()->translate('Address'));
		
		$city = $this->createElement('text','city');
		$city->setLabel($this->getView()->translate('City'))
			->addValidator('Alpha');
		
		$state = $this->createElement('text','state');
		$state->setLabel($this->getView()->translate('State'));
		
		$country = $this->createElement('text','country');
		$country->setLabel($this->getView()->translate('Country'));
		
		$pin = $this->createElement('text','pin');
		$pin->setLabel($this->getView()->translate('Pin Code'))
			->addValidator('Digits');
		
		$phone = $this->createElement('text','phone');
		$phone->setLabel($this->getView()->translate('Phone No'));
		
		$securityQuestion = $this->createElement('text','question');
		$securityQuestion->setLabel($this->getView()->translate('Security Question *'))
						->setRequired(true);
				
		$hint = $this->createElement('text','hint');
		$hint->setLabel($this->getView()->translate('Hint'));
		
		$securityAnswer = $this->createElement('text','answer');
		$securityAnswer->setLabel($this->getView()->translate('Answer *'))
					->setRequired(true);
					
		$newsletter = $this->createElement('checkbox','newsletter');
		$newsletter->setLabel($this->getView()->translate('I want regular news updates from the website'));
		
		if($playerData)
		{
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
			$securityQuestion->setValue($playerData['securityQuestion']);
			$hint->setValue($playerData['hint']);
			$securityAnswer->setValue($playerData['securityAnswer']);
			$newsletter->setValue($playerData['newsletter']);
		}
		
		$submit = $this->createElement('submit','submit');
		$submit->setLabel($this->getView()->translate('Submit'))
				->setIgnore(true);
		
		$this->addElements(array(
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
				/* $securityQuestion,
				$hint,
				$securityAnswer, */
				$newsletter,
				$submit
			)
		);
		$this->setAttrib('id', 'player-edit-form');
		return $this;
	}
/*	
	public function submitButton()
	{
		
		$submit = $this->createElement('submit','submit');
		$submit->setLabel($this->getView()->translate('Submit'))
				->setIgnore(true);
		
		$this->addElement($submit);
		return $this;
		
	}*/
	
}
