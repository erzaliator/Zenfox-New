<?php

class PartnerLogin
{
	public function authenticate($loginCredentials)
	{
		$zenfoxAuth = new Zenfox_Auth_Adapter_Partner_Authentication(
							$loginCredentials['alias'],
							$loginCredentials['password']
						);
		$zenfoxAuthResult = $zenfoxAuth->authenticate();
		
		if($zenfoxAuthResult->isValid())
		{
			$partners = new Partners();
			$partners->createAuthSession($zenfoxAuth->getResultRowObject());
			
			return array(
				'success' => true
			);
		}
		$messages = $zenfoxAuthResult->getMessages();
		return array(
			'success' => false,
			'message' => $messages[0]
		);
	}
	
	public function checkPartnerExist($alias, $password)
	{
		$connection = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($connection);
		
		$frontendId = Zend_Registry::get('frontendId');
		
		$query = Zenfox_Query::create()
					->from ('Partners p')
					->where('p.alias = ?', $alias)
					->andWhere('p.password = ?', md5($password))
					->andWhere('p.partner_frontend_id = ?', $frontendId);
		
		try
		{
			$partnerDetails = $query->fetchArray();
		}
		catch(Exception $e)
		{
			Zenfox_Debug::dump($e, 'ex', true, true);
		}
		
		$partnerId = "";
		$authMessages = array();
		if(count($partnerDetails) == 1)
		{
			$authResult = Zend_Auth_Result::SUCCESS;
			$partnerId = $partnerDetails[0]['partner_id'];
		}
		else
		{
			$authResult = Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID;
			$authMessages[] = 'Login Failed! The username or password, you entered, did not match.';
		}
		
		return array(new Zend_Auth_Result($authResult, $partnerId, $authMessages), $partnerDetails );
	}
}
