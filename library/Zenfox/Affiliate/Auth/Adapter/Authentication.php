<?php
class Zenfox_Affiliate_Auth_Adapter_Authentication implements Zend_Auth_Adapter_Interface
{
	private $_username = null;
	private $_password = null;
	private $_resultRow = null;
	
	public function init()
	{
		parent::init();
	}
	
	public function __construct($username,$password)
	{
		//TODO Implementation required
		$this->_username=$username;
		$this->_password=$password;
	}
	
	public function authenticate()
	{
		//TODO Implementation required
		$affiliateConfig = new AffiliateConfig();
		$authArray = $affiliateConfig->authenticate($this->_username, $this->_password);
		$zendAuthResult = $authArray[0];
		
		if($zendAuthResult->getCode()== Zend_Auth_Result::SUCCESS)
		{
			$affiliateFrontend = new AffiliateFrontend();
			$affiliateFrontendData = $affiliateFrontend->getAffiliateFrontendById($authArray[1][0]['affiliate_frontend_id']);
			$this->_resultRow['authDetails'] = $authArray[1];
			$this->_resultRow['roleName'] = 'affiliate';
			$this->_resultRow['id'] = $authArray[1][0]['affiliate_id'];
			$this->_resultRow['affiliate_allowed_frontend_ids'] =$affiliateFrontendData['affiliate_allowed_frontend_ids'];
			$this->_resultRow['allowed_frontend_ids'] = $affiliateFrontendData['allowed_frontend_ids']; 
			$this->_resultRow['default_scheme_id'] = $affiliateFrontendData['default_affiliate_scheme_id'];
		}
		return $zendAuthResult;
	}
	
	public function getResultRowObject()
	{
		return $this->_resultRow;
	}
}