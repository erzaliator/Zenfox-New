<?php
class Zenfox_Player_Auth_Adapter_Database implements Zend_Auth_Adapter_Interface
{

/*	public function init()
	{
		parent::init();
	}
	*/
	private $_username = null;
	private $_password = null;
	private $_resultRow = null;

	public function __construct($username,$password)
	{
		$this->_username=$username;
		$this->_password=$password;
	}

	/**
	 * This function authenticates against the database
	 * @param none
	 * @return Zend_Auth_Result Returns the result set with set of messages and identity
	 */

	public function authenticate()
	{
		//FIXME:: Should we check this with Account or Player?
		//Currently checking it with Player
		$player = new Player();
		$authArray = $player->authenticate($this->_username, $this->_password);
		$zendAuthResult = $authArray[0];

		if($zendAuthResult->getCode()== Zend_Auth_Result::SUCCESS)
		{
			$this->_resultRow['authDetails'] = $authArray[1];
			$this->_resultRow['roleName'] = 'player';
			$this->_resultRow['id'] = $authArray[1][0]['player_id'];
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