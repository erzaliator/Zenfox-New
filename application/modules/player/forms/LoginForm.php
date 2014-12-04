<?php
class Player_LoginForm extends Zend_Form
{
	public function init()
	{
		$userName = $this->createElement('text','userName');
		$userName->setLabel($this->getView()->translate('Username *'))
				->setRequired(true)
				->setAttrib('class', 'text');
				
		$password = $this->createElement('password','password');
		$password->setLabel($this->getView()->translate('Password *'))
				->setRequired(true)
				->setAttrib('class', 'text');
				
		$submit = $this->createElement('submit','submit');
		$submit->setLabel($this->getView()->translate('Log In'))
				->setIgnore(true);
				
		/*$facebookLogin = $this->createElement('button','facebookLogin');
		$facebookLogin->setLabel($this->getView()->translate('Connect With Facebook'))
				->setIgnore(true);*/

		/*$facebookButton = '<fb:login-button v="2" size="medium" >Connect with Facebook</fb:login-button>';
		$facebookLogin = $this->createElement('hidden','facebookLogin');
		$facebookLogin->setDescription($facebookButton);*/
		/*$facebookButton = '<fb:login-button v="2" size="medium" >Login With Facebook</fb:login-button>';
		$facebookLogin = $this->createElement('hidden','facebookLogin');
		$facebookLogin->setDescription($facebookButton);
		$facebookLoginSess = new Zend_Session_Namespace('facebookLoginSess');
		if($facebookLoginSess->value)
		{
			$facebookLoginSess->unsetAll(); 
		}*/
		$facebookDescription = '<a href = "#" onClick="facebookLogin()"><img src="/images/facebook-login-button.png" /></a>';
		
		$facebookLogin = $this->createElement('hidden', 'facebookLogin');
		$facebookLogin->setDescription($facebookDescription);

		$front = Zend_Controller_Front::getInstance()->getRequest();
		$language = $front->getParam('lang');
		if($language)
		{
			$fpLink = '/' . $language . '/auth/forgotpassword';
			$signupLink = '/' . $language . '/auth/signup';
		}
		else
		{
			$fpLink = '/auth/forgotpassword';
			$signupLink = '/auth/signup';
		}
		$fgPasswordDescription = '<a href = "' . $fpLink . '">' . $this->getView()->translate('Forgot Password') . '</a>';
				
		$fgPassword = $this->createElement('hidden','fgPassword');
		$fgPassword->setDescription($fgPasswordDescription);

		
		$signupDescription = '<a href = "' . $signupLink . '">' . $this->getView()->translate('Sign Up') . '</a>';
		
		$signup = $this->createElement('hidden', 'signup');
		$signup->setDescription($signupDescription);

		/*$previousUrl = $_SERVER['REQUEST_URI'];
		$prevUrl = $this->createElement('hidden', 'prevUrl');
		$prevUrl->setValue($previousUrl);*/
				
		$this->addElements(array(
				$userName,
				$password,
				$submit,
				//$facebookLogin, //XXX: Changes related to Facebook login
				$fgPassword,
				$signup,
				//$prevUrl
			)
		);
				
		/* $decorator = new Zenfox_DecoratorForm();
		$userName->setDecorators($decorator->openingUlTagDecorator);
		$password->setDecorators($decorator->changeUlTagDecorator);
		
		//$decorator = new Zenfox_DecoratorForm();

		//$submit->setDecorators($decorator->changeLineDecorator);
		$facebookLogin->setDecorators($decorator->facebookLinkDecorator);
//		$facebookLogin->setDecorators($decorator->changeUlTagDecorator);
		
//		$fgPassword->setDecorators($decorator->nextLinkDecorator);
		$fgPassword->setDecorators($decorator->nextLinkDecorator);		
//		$fgPassword->setDecorators($decorator->linkDecorator);
		$signup->setDecorators($decorator->signupDecorator);
//		$signup->setDecorators($decorator->closingUlTagDecorator);
		
		$submit->setDecorators($decorator->changeUlButtonTagDecorator); */
		
		$this->setAttrib('id', 'player-login-form');
		
		if($front->getParam('format'))
		{
			$this->setAction('/auth/login/format/' . $front->getParam('format'));
		}
		else
		{
			$this->setAction('/auth/login');
		}
	}
}