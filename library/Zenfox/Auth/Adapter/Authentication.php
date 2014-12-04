<?php
/*
 * This class implements Zend_Auth_Adapter_Interface
 */
class Zenfox_Auth_Adapter_Authentication implements Zend_Auth_Adapter_Interface
{
	
	public function init()
	{
		parent::init();
	}
	
	private $_username;
	private $_password;
	
	public function __construct($username,$password)
	{
		$this->_username=$username;
		$this->_password=$password;
	}
	
	public function authenticate()
	{
		/*
		 * Check the authentication through Player model
		 * @return Zend_Auth_Result object
		 * 
		 */
		$authentication = new Player();
		$temp = $authentication->authenticate($this->_username,$this->_password);
		switch($temp)
		{
			case 1:
				$result=new Zend_Auth_Result(
						Zend_Auth_Result::SUCCESS,
						$this->_username,
						array());
				break;
			
			case 2:
				$result=new Zend_Auth_Result(
						Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND,
						$this->_username,
						array('You have entered wrong username.'));
				break;
				
			case 3:
				$result = new Zend_Auth_Result(
						Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID,
						$this->_username,
						array('You have entered incorrect password.'));
				break;
		}
				
		return $result;
	}
}