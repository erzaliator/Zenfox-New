<?php
class Zenfox_Auth_Adapter_Partner_Authentication implements Zend_Auth_Adapter_Interface
{
	private $_alias = null;
	private $_password = null;
	private $_resultRow = null;

	public function __construct($alias,$password)
	{
		$this->_alias=$alias;
		$this->_password=$password;
	}

	/**
	 * This function authenticates against the database
	 * @param none
	 * @return Zend_Auth_Result Returns the result set with set of messages and identity
	 */

	public function authenticate()
	{
		$partnerLogin = new PartnerLogin();
		$authArray = $partnerLogin->checkPartnerExist($this->_alias, $this->_password);
		
		$zendAuthResult = $authArray[0];

		if($zendAuthResult->getCode()== Zend_Auth_Result::SUCCESS)
		{
			$this->_resultRow['authDetails'] = $authArray[1];
			$this->_resultRow['roleName'] = $authArray[1][0]['alias'];
			$this->_resultRow['id'] = $authArray[1][0]['partner_id'];
		}
		return $zendAuthResult;
	}

/*	public function authenticate()
	{
		$authentication = new Frontend();
		$temp = $authentication->valid($this->_username,$this->_password);
		switch($temp)
		{
			case 1:
				$result=new Zenfox_Auth_Result(
						Zenfox_Auth_Result::SUCCESS,
						'',
						array());
				break;

			case 2:
				$result=new Zenfox_Auth_Result(
						Zenfox_Auth_Result::FAILURE_IDENTITY_NOT_FOUND,
						'',
						array('The username is incorrect.'));
				break;

			case 3:
				$result = new Zenfox_Auth_Result(
						Zenfox_Auth_Result::FAILURE_CREDENTIAL_INVALID,
						'',
						array('The password is incorrect.'));
				break;
		}

		return $result;
	}
*/
	public function getResultRowObject()
	{
		/*if (!$this->_resultRow) return false;
		$returnObject = new stdClass();
		foreach ($this->_resultRow as $resultColumn => $resultValue)
		{
  			$returnObject->{$resultColumn} = $resultValue;
  			echo $resultValue;
		}
		return $returnObject;*/
	    //TODO:: Send ROLE along with the result
		return $this->_resultRow;
	}
}