<?php
class Zenfox_Controller_Plugin_TimeZone extends Zend_Controller_Plugin_Abstract
{
	private $_acl = null;
	private $_timeZone;
	private $_roleName;
	private $_csrId;
	
	public function __construct($timeZone = null)
	{
		if($timeZone)
		{
			$this->_timeZone = $timeZone;
		}
		elseif (date_default_timezone_get())
		{
			$this->_timeZone = date_default_timezone_get();
		}
	}
	
	public function setTimeZone($timeZone)
	{
		$this->_timeZone = $timeZone;
		date_default_timezone_set($this->_timeZone);
	}
	
	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		$userTimeZone = Zend_Registry::getInstance()->get('userTimeZone');
		$serverTimeZone = Zend_Registry::getInstance()->get('serverTimeZone');
		if($serverTimeZone != $userTimeZone)
		{
			$this->setTimeZone($userTimeZone);
		}
		/*if($this->_timeZone != $setTimeZone)
		{
//			echo "inside";
//			exit();
			$this->setTimeZone($setTimeZone);
		}*/
	}
}