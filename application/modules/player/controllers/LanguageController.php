<?php
require_once dirname(__FILE__) . '/../forms/LanguageForm.php';
class Player_LanguageController extends Zenfox_Controller_Action
{
	public function indexAction()
	{
		$language = $_POST['lang'];
		/*$cookie = new Zend_Http_Cookie('language', $language, 'http://testingserver.tld');
		$_SESSION['language'] = $cookie->getValue();*/
    	$session = new Zend_Session_Namespace('language');
    	if($language)
    	{
    		$session->language = $language;
    	}
    	$url = $_POST['url'];
    	$this->_redirect('/'.$language.$url);
	}
}
