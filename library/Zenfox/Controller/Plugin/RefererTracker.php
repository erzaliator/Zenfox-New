<?php
class Zenfox_Controller_Plugin_RefererTracker extends Zend_Controller_Plugin_Abstract 
{
	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{		
		$trackerId = isset($_COOKIE['trackerId'])?$_COOKIE['trackerId']:null;
		$buddyId = NULL;
		$affId = NULL;

		if(!$trackerId)
		{
			$trackerId = $request->getParam('trackerId')?$request->getParam('trackerId'):null;
			setcookie('trackerId',$trackerId,time() + (86400),'/','.'.$_SERVER['HTTP_HOST']);
		}
		if(!$trackerId)
		{
			$buddyId = isset($_COOKIE['buddyId'])?$_COOKIE['buddyId']:null;
			if(!$buddyId)
			{
				$buddyId = $request->getParam('buddyId')?$request->getParam('buddyId'):null;
				setcookie('buddyId',$buddyId,time() + (86400 * 30),'/','.'.$_SERVER['HTTP_HOST']);
			}
		}
		else
		{
			$affId = isset($_COOKIE['affId'])?$_COOKIE['affId']:null;
			if(!$affId)
			{
				$affId = $request->getParam('aff_id')?$request->getParam('aff_id'):null;
				setcookie('affId',$affId,time() + (86400 * 30),'/','.'.$_SERVER['HTTP_HOST']);
			}
		}

		$trackerSession = new Zend_Session_Namespace('tracker');
		$trackerSession->value = $trackerId;
		
		$buddySession = new Zend_Session_Namespace('buddy');
		$buddySession->value = $buddyId;
		
		$affSession = new Zend_Session_Namespace('affSession');
		$affSession->value = $affId;
	}
	
	public function postDispatch(Zend_Controller_Request_Abstract $request)
    {
    	if(isset($_COOKIE['referer']))
    	{
	    	$cookie = $_COOKIE['referer'];
	    	if($cookie)
			{
				$refererId = $cookie;
			}
			else
			{
				if($request->affiliateId)
		    	{
		    		$refererId = $request->affiliateId;
		    		//FIXME:: This has to be replaced with appropriate URL
		    		setcookie('referer',$refererId,time() + (86400),'/','.affiliate.zenfox.tld');
		    	}
			}
			//Zenfox_Debug::dump($refererId, 'id');
			if($refererId)
			{
				$csrIds = new CsrIds();
				$refererAlias = $csrIds->getAffiliateAlias($refererId);
				$session = new Zend_Session_Namespace('referer');
				$session->refererAlias = $refererAlias;
			}
    	}
    }
}