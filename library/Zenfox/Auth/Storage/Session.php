<?php
class Zenfox_Auth_Storage_Session extends Zend_Auth_Storage_Session
{
	public function init()
	{
		parent::init();
	}
	
	public function setExpiryTime($seconds)
	{
		$session = new Zend_Session_Namespace('Zend_Auth');
		$session->setExpirationSeconds($seconds);
	}
	
}