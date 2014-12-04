<?php

/**
 * This class is used to decorate form fields
 */

class Decorator
{
	private $_translate;
	
	public function __construct()
	{
		$this->_translate = Zend_Registry::get('Zend_Translate');
	}
	
	public function addDecorators($formInstance, $formType)
	{
		$frontendName = Zend_Registry::get('frontendName');
		
		switch($formType)
		{
			case 'login':
				return $this->_loginFormDecorator($formInstance, $frontendName);
				break;
			case 'signup':
				return $this->_signupDecorator($formInstance, $frontendName);
				break;
			case 'registration':
				return $this->_registrationDecorator($formInstance, $frontendName);
				break;
			case 'edit':
				return $this->_editDecorator($formInstance, $frontendName);
				break;
		}		
	}
	
	private function _loginFormDecorator($loginForm, $frontend)
	{
		switch($frontend)
		{
			case 'taashtime.com':
				$loginForm->removeElement('signup');
				$decorator = new Zenfox_DecoratorForm_Taashtime();
				$loginForm->getElement('userName')->setDecorators($decorator->openingUlTagDecorator);
				$loginForm->getElement('password')->setDecorators($decorator->changeUlTagDecorator);
				$loginForm->getElement('fgPassword')->setDecorators($decorator->nextLinkDecorator);
				$loginForm->getElement('submit')->setDecorators($decorator->changeUlButtonTagDecorator);
				break;
			case 'ace2jak.com':
				$loginForm->removeElement('signup');
				$decorator = new Zenfox_DecoratorForm_Ace2Jak();
				$loginForm->getElement('userName')->setDecorators($decorator->openingUlTagDecorator);
				$loginForm->getElement('password')->setDecorators($decorator->changeUlTagDecorator);
				$loginForm->getElement('fgPassword')->setDecorators($decorator->nextLinkDecorator);
				$loginForm->getElement('submit')->setDecorators($decorator->changeUlButtonTagDecorator);
				break;
			case 'rummybazaar.com':
				$decorator = new Zenfox_DecoratorForm_RummyBazaar();
				$loginForm->getElement('userName')->setAttrib('placeholder', 'Username');
				$loginForm->getElement('password')->setAttrib('placeholder', 'Password');
				$loginForm->getElement('fgPassword')->setOrder(4);
				$loginForm->getElement('signup')->setOrder(5);
				$loginForm->getElement('submit')->setOrder(3);
				
				$loginForm->addElement('checkbox', 'rememberPassword');
				$loginForm->getElement('rememberPassword')->setLabel('Remeber Me');
				$loginForm->getElement('rememberPassword')->setOrder(2);
				
				$loginForm->getElement('userName')->setDecorators($decorator->openingUlTagDecorator);
				$loginForm->getElement('password')->setDecorators($decorator->changeUlTagDecorator);
				$loginForm->getElement('rememberPassword')->setDecorators($decorator->changeUlTagLabelDecorator);
				$loginForm->getElement('fgPassword')->setDecorators($decorator->fpLinkDecorator);
				$loginForm->getElement('signup')->setDecorators($decorator->suLinkDecorator);
				$loginForm->getElement('submit')->setDecorators($decorator->changeUlButtonTagDecorator);
				break;
			case 'bingocrush.co.uk':
				$loginForm->removeElement('signup');
				$decorator = new Zenfox_DecoratorForm_Bingocrush();
				$loginForm->getElement('userName')->setDecorators($decorator->openingUlTagDecorator);
				$loginForm->getElement('password')->setDecorators($decorator->changeUlTagDecorator);
				$loginForm->getElement('fgPassword')->setDecorators($decorator->nextLinkDecorator);
				$loginForm->getElement('submit')->setDecorators($decorator->changeUlButtonTagDecorator);
				break;
			case 'bingobible.co.uk':
				$loginForm->removeElement('signup');
				$loginForm->getElement('userName')->setAttrib('class', 'form-info');
				$loginForm->getElement('password')->setAttrib('class', 'form-info');
				$loginForm->getElement('submit')->setAttrib('class', 'btn');
				
				$decorator = new Zenfox_DecoratorForm();
				$loginForm->getElement('userName')->setDecorators($decorator->openingUlTagDecorator);
				$loginForm->getElement('password')->setDecorators($decorator->changeUlTagDecorator);
				$loginForm->getElement('fgPassword')->setDecorators($decorator->nextLinkDecorator);
				$loginForm->getElement('submit')->setDecorators($decorator->changeUlButtonTagDecorator);
				break;
		}
		
		return $loginForm;
	}
	
	private function _signupDecorator($signupForm, $frontend)
	{
		$frontendController = Zend_Controller_Front::getInstance();
		$controller = $frontendController->getRequest()->getControllerName();
		$action = $frontendController->getRequest()->getActionName();
		
		$pageAddress = $controller . '-' . $action;
		
		switch($frontend)
		{
			case 'taashtime.com':
				$termLink = '/content/terms';
				$termsDescription = 'I agree to <a href = "' . $termLink . '">' . $this->_translate->translate('Terms & Conditions') . '</a>';
				
				$signupForm->getElement('terms')->setDescription($termsDescription);
							
				$decorator = new Zenfox_DecoratorForm_RummyBazaar();
				$signupForm->getElement('login')->setDecorators($decorator->openingUlTagDecorator);
				$signupForm->getElement('password')->setDecorators($decorator->changeUlTagDecorator);
				$signupForm->getElement('confirmPassword')->setDecorators($decorator->changeUlTagDecorator);
				$signupForm->getElement('email')->setDecorators($decorator->changeUlTagDecorator);
				$signupForm->getElement('terms')->setDecorators($decorator->termsDecorator);
				$signupForm->getElement('Signup')->setDecorators($decorator->signupDecorator);
				break;
			case 'ace2jak.com':
				$signupForm->removeElement('affId');
				$signupForm->removeElement('trackerId');
				$signupForm->removeElement('buddyId');
				
				$decorator = new Zenfox_DecoratorForm_RummyBazaar();
				$signupForm->getElement('login')->setDecorators($decorator->openingUlTagDecorator);
				$signupForm->getElement('password')->setDecorators($decorator->changeUlTagDecorator);
				$signupForm->getElement('confirmPassword')->setDecorators($decorator->changeUlTagDecorator);
				$signupForm->getElement('email')->setDecorators($decorator->changeUlTagDecorator);
				$signupForm->getElement('terms')->setDecorators($decorator->termsDecorator);
				$signupForm->getElement('Signup')->setDecorators($decorator->signupDecorator);
				break;
			case 'rummybazaar.com':
				$signupForm->removeElement('confirmPassword');
				$signupForm->removeElement('affId');
				$signupForm->removeElement('trackerId');
				$signupForm->removeElement('buddyId');
				
				$termLink = '/content/terms';
				$termsDescription = '<span id="terms-conditions">I am above 18 years and agree to <br>the <a href = "' . $termLink . '">' . $this->_translate->translate('Terms & Conditions') . '</a></span>';
				
				$signupForm->getElement('terms')->setDescription($termsDescription);
				
				$signupForm->addElement('hidden', 'alreadyMember');
				$alreadyMemberLink = "/auth/login";
				$memberDesc = '<a href = "' . $alreadyMemberLink . '">' . $this->_translate->translate('Already a Member?') . '</a>';
				$signupForm->getElement('alreadyMember')->setDescription($memberDesc);
				$signupForm->getElement('alreadyMember')->setOrder(4);
				$signupForm->getElement('Signup')->setOrder(5);
				$signupForm->getElement('Signup')->setLabel('Join Now!');
				
				$decorator = new Zenfox_DecoratorForm_RummyBazaar();
				$signupForm->getElement('login')->setDecorators($decorator->openingUlTagDecorator);
				$signupForm->getElement('password')->setDecorators($decorator->changeUlTagDecorator);
				$signupForm->getElement('email')->setDecorators($decorator->changeUlTagDecorator);
				$signupForm->getElement('terms')->setDecorators($decorator->termsDecorator);
				$signupForm->getElement('alreadyMember')->setDecorators($decorator->alMembDecorator);
				$signupForm->getElement('Signup')->setDecorators($decorator->signupDecorator);
				break;
			case 'bingocrush.co.uk':
				$termLink = '/content/terms';
				$termsDescription = 'I agree to <a href = "' . $termLink . '">' . $this->_translate->translate('Terms & Conditions') . '</a>';
				
				$signupForm->removeElement('affId');
				$signupForm->removeElement('trackerId');
				$signupForm->removeElement('buddyId');
				$signupForm->getElement('terms')->setDescription($termsDescription);
				
				$signupForm->getElement('login')->addValidator('stringLength', false, array(4,20,'messages' => array('stringLengthTooShort' => $this->_translate->translate("Username too short, make sure your username is atleast 4 characters long"), 'stringLengthTooLong' => $this->_translate->translate("Username too long. Username cannot be longer than 20 characters"))));
				
				if($pageAddress != 'auth-signup')
				{
					$signupForm->removeElement('Signup');
					$signupForm->addElement('button', 'Signup');
					$signupForm->getElement('Signup')->setAttrib('onclick', "goToLogin('player-signup')");
				}
				
				$signupForm->getElement('Signup')->setAttrib('class', 'TTBingoGradentBtn3');
				
				$decorator = new Zenfox_DecoratorForm_RummyBazaar();
				$signupForm->getElement('login')->setDecorators($decorator->openingUlTagDecorator);
				$signupForm->getElement('password')->setDecorators($decorator->changeUlTagDecorator);
				$signupForm->getElement('confirmPassword')->setDecorators($decorator->changeUlTagDecorator);
				$signupForm->getElement('email')->setDecorators($decorator->changeUlTagDecorator);
				$signupForm->getElement('terms')->setDecorators($decorator->termsDecorator);
				$signupForm->getElement('Signup')->setDecorators($decorator->signupDecorator);
				break;
			case 'bingobible.co.uk':
				$termLink = '/content/terms';
				
				$termsDescription = '<div id="iaree"><p>I agree to <a href = "' . $termLink . '">' . $this->_translate->translate('Terms & Conditions') . '</a></p></div>';
				
				$signupForm->removeElement('affId');
				$signupForm->removeElement('trackerId');
				$signupForm->removeElement('buddyId');
				$signupForm->getElement('terms')->setDescription($termsDescription);
				
				$signupForm->getElement('login')->addValidator('stringLength', false, array(4,20,'messages' => array('stringLengthTooShort' => $this->_translate->translate("Username too short, make sure your username is atleast 4 characters long"), 'stringLengthTooLong' => $this->_translate->translate("Username too long. Username cannot be longer than 20 characters"))));
				
				if($pageAddress != 'auth-signup')
				{
					$signupForm->removeElement('Signup');
					$signupForm->addElement('button', 'Signup');
					$signupForm->getElement('Signup')->setAttrib('onclick', "goToLogin('player-signup')");
				}
				
				$signupForm->getElement('login')->setAttrib('class', 'form-info');
				$signupForm->getElement('password')->setAttrib('class', 'form-info');
				$signupForm->getElement('confirmPassword')->setAttrib('class', 'form-info');
				$signupForm->getElement('email')->setAttrib('class', 'form-info');
				$signupForm->getElement('terms')->setAttrib('class', 'form-info-chkbox');
				$signupForm->getElement('Signup')->setAttrib('class', 'TTBingoGradentBtn3');
				$signupForm->setAttrib('id', 'windows-signup-form');
				
				$decorator = new Zenfox_DecoratorForm();
				$signupForm->getElement('login')->setDecorators($decorator->openingUlTagDecorator);
				$signupForm->getElement('password')->setDecorators($decorator->changeUlTagDecorator);
				$signupForm->getElement('confirmPassword')->setDecorators($decorator->changeUlTagDecorator);
				$signupForm->getElement('email')->setDecorators($decorator->changeUlTagDecorator);
				$signupForm->getElement('terms')->setDecorators($decorator->termsDecorator);
				$signupForm->getElement('Signup')->setDecorators($decorator->signupDecorator);
				break;
		}
		
		return $signupForm;
	}
	
	private function _registrationDecorator($registrationForm, $frontend)
	{
		switch($frontend)
		{
			case 'bingocrush.co.uk':
			case 'bingobible.co.uk':
				$termLink = '/content/terms';
				$termsDescription = 'I agree to <a href = "' . $termLink . '">' . $this->_translate->translate('Terms & Conditions') . '</a>';
			
				$registrationForm->removeElement('affId');
				$registrationForm->removeElement('trackerId');
				$registrationForm->removeElement('buddyId');
				$registrationForm->getElement('terms')->setDescription($termsDescription);
			
				$registrationForm->getElement('login')->addValidator('stringLength', false, array(4,20,'messages' => array('stringLengthTooShort' => $this->_translate->translate("Username too short, make sure your username is atleast 4 characters long"), 'stringLengthTooLong' => $this->_translate->translate("Username too long. Username cannot be longer than 20 characters"))));
			
				$decorator = new Zenfox_DecoratorForm();
				$registrationForm->getElement('login')->setDecorators($decorator->openingUlTagDecorator);
				$registrationForm->getElement('password')->setDecorators($decorator->changeUlTagDecorator);
				$registrationForm->getElement('confirmPassword')->setDecorators($decorator->changeUlTagDecorator);
				$registrationForm->getElement('email')->setDecorators($decorator->changeUlTagDecorator);
				
				$registrationForm->getElement('first_name')->setDecorators($decorator->changeUlTagDecorator);
				$registrationForm->getElement('last_name')->setDecorators($decorator->changeUlTagDecorator);
				$registrationForm->getElement('sex')->setDecorators($decorator->changeUlTagDecorator);
				$registrationForm->getElement('dateofbirth')->setDecorators($decorator->formJQueryElements);
				$registrationForm->getElement('address')->setDecorators($decorator->changeUlTagDecorator);
				$registrationForm->getElement('city')->setDecorators($decorator->changeUlTagDecorator);
				$registrationForm->getElement('state')->setDecorators($decorator->changeUlTagDecorator);
				$registrationForm->getElement('country')->setDecorators($decorator->changeUlTagDecorator);
				$registrationForm->getElement('pin')->setDecorators($decorator->changeUlTagDecorator);
				$registrationForm->getElement('phone')->setDecorators($decorator->changeUlTagDecorator);
				$registrationForm->getElement('newsletter')->setDecorators($decorator->changeUlTagDecorator);
				
				$registrationForm->getElement('terms')->setDecorators($decorator->termsDecorator);
				$registrationForm->getElement('Signup')->setDecorators($decorator->signupDecorator);
				break;
		}
		
		return $registrationForm;
	}
	
	private function _editDecorator($editForm, $frontend)
	{
		switch($frontend)
		{
			case 'bingobible.co.uk':
				$editForm->getElement('first_name')->setAttrib('class', 'form-info');
				$editForm->getElement('last_name')->setAttrib('class', 'form-info');
				$editForm->getElement('sex')->setAttrib('class', 'form-info');
				$editForm->getElement('dateofbirth')->setAttrib('class', 'form-info');
				$editForm->getElement('address')->setAttrib('class', 'form-info');
				$editForm->getElement('city')->setAttrib('class', 'form-info');
				$editForm->getElement('state')->setAttrib('class', 'form-info');
				$editForm->getElement('country')->setAttrib('class', 'form-info');
				$editForm->getElement('pin')->setAttrib('class', 'form-info');
				$editForm->getElement('phone')->setAttrib('class', 'form-info');
				$editForm->getElement('newsletter')->setAttrib('class', 'form-info');
				$editForm->getElement('Signup')->setAttrib('id', 'edit-submit');
				$editForm->getElement('Signup')->setAttrib('class', 'btn');
				$editForm->setAttrib('id', 'windows-signup-form');
				
				$decorator = new Zenfox_DecoratorForm();
				
				$editForm->getElement('first_name')->setDecorators($decorator->changeUlTagDecorator);
				$editForm->getElement('last_name')->setDecorators($decorator->changeUlTagDecorator);
				$editForm->getElement('sex')->setDecorators($decorator->changeUlTagDecorator);
				$editForm->getElement('dateofbirth')->setDecorators($decorator->formJQueryElements);
				$editForm->getElement('address')->setDecorators($decorator->changeUlTagDecorator);
				$editForm->getElement('city')->setDecorators($decorator->changeUlTagDecorator);
				$editForm->getElement('state')->setDecorators($decorator->changeUlTagDecorator);
				$editForm->getElement('country')->setDecorators($decorator->changeUlTagDecorator);
				$editForm->getElement('pin')->setDecorators($decorator->changeUlTagDecorator);
				$editForm->getElement('phone')->setDecorators($decorator->changeUlTagDecorator);
				$editForm->getElement('newsletter')->setDecorators($decorator->changeUlTagDecorator);
				break;
			case 'bingocrush.co.uk':
				$decorator = new Zenfox_DecoratorForm();
				
				$editForm->getElement('first_name')->setDecorators($decorator->changeUlTagDecorator);
				$editForm->getElement('last_name')->setDecorators($decorator->changeUlTagDecorator);
				$editForm->getElement('sex')->setDecorators($decorator->changeUlTagDecorator);
				$editForm->getElement('dateofbirth')->setDecorators($decorator->formJQueryElements);
				$editForm->getElement('address')->setDecorators($decorator->changeUlTagDecorator);
				$editForm->getElement('city')->setDecorators($decorator->changeUlTagDecorator);
				$editForm->getElement('state')->setDecorators($decorator->changeUlTagDecorator);
				$editForm->getElement('country')->setDecorators($decorator->changeUlTagDecorator);
				$editForm->getElement('pin')->setDecorators($decorator->changeUlTagDecorator);
				$editForm->getElement('phone')->setDecorators($decorator->changeUlTagDecorator);
				$editForm->getElement('newsletter')->setDecorators($decorator->changeUlTagDecorator);
				break;
		}
		
		return $editForm;
	}
}
