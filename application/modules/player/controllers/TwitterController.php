<?php
class Player_TwitterController extends Zenfox_Controller_Action
{
	public function init()
	{
		
	}
	
	public function indexAction()
	{
		//Zend_Layout::getMvcInstance()->disableLayout();
		//$this->_redirect('/transaction/confirm/CRN/INR/PRN/11/ITC/0/AMT/100/BANK/ICICI/PAID/Y/BID/1');
		$config = array(
		    'callbackUrl' => 'http://taashtime.tld/twitter/callback',
		    'siteUrl' => 'http://twitter.com/oauth',
		    'consumerKey' => 'mAwL5GbWOWKLMgGFCmaw',
		    'consumerSecret' => 'UdmvwTUVgQD2RBbMTkyBz1T4cUJJ86TDd2ZrbIdAg'
		);
		
		$consumer = new Zend_Oauth_Consumer($config);
		$token = $consumer->getRequestToken();
		
		$_SESSION['TWITTER_REQUEST_TOKEN'] = serialize($token); 
		$consumer->redirect();
	}
	
	public function callbackAction()
	{
		$config = array(
		    'callbackUrl' => 'http://taashtime.tld/twitter/callback',
		    'siteUrl' => 'http://twitter.com/oauth',
		    'consumerKey' => 'mAwL5GbWOWKLMgGFCmaw',
		    'consumerSecret' => 'UdmvwTUVgQD2RBbMTkyBz1T4cUJJ86TDd2ZrbIdAg'
		);
		
		$consumer = new Zend_Oauth_Consumer($config);
		if (!empty($_GET) && isset($_SESSION['TWITTER_REQUEST_TOKEN']))
		{
			$token = $consumer->getAccessToken(
			         	$_GET,
			         	unserialize($_SESSION['TWITTER_REQUEST_TOKEN'])
			         );
			         
			$_SESSION['TWITTER_ACCESS_TOKEN'] = serialize($token);
			$_SESSION['TWITTER_REQUEST_TOKEN'] = null;
			echo $_SESSION['TWITTER_ACCESS_TOKEN'];
		}
		else
		{
			echo ('Invalid callback request. Oops. Sorry.');
		}
	}
}