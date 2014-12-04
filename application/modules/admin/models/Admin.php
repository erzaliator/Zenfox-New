<?php 
class Admin extends Doctrine_Record
{
	private $_Csr;
	public function __construct()
	{
		$this->_Csr = new Csr();
	}
	
	public function authenticate($login, $password)
	{
		$csrDetails = array();
		$connName = Zenfox_Partition::getInstance()->getConnections(0);
		Doctrine_Manager::getInstance()->setCurrentConnection($connName);
		
		$query = Zenfox_Query::create()
				->from('Csr c')
				->where(
				'c.alias = ? and c.passwd = ?',
				array($login, $password)
				);
				
		$csrDetails = $query->fetchArray();
		
		$authMessage = array();
		if(count($csrDetails) == 1)
		{
			$authResult = Zend_Auth_Result::SUCCESS;
			
			$frontendName = Zend_Registry::get('frontendName');
			switch($frontendName)
			{
				case 'taashtime.com':
					$language = 'en_GB';
					$baseCurrency = 'INR';
					break;
				case 'bingocrush.co.uk':
					$language = 'en_GB';
					$baseCurrency = 'GBP';
					break;
				default:
					$language = 'en_GB';
				$baseCurrency = 'INR';
				break;
			}
			$csrDetails[0]['base_currency'] = $baseCurrency;
			$csrDetails[0]['language'] = $language;
		}
		else
		{
			$authResult = Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID;
	    	$translate = Zend_Registry::get('Zend_Translate');
	    	$authMessage[] = $translate->translate('Login Failed! The username and password you entered did not match.');
		}
		return array(new Zend_Auth_Result($authResult, null, $authMessage), $csrDetails );
	}
}
