<?php
require_once dirname(__FILE__).'/../forms/InviteFriendForm.php';
class Player_PromotionsController extends Zenfox_Controller_Action
{
	public function indexAction()
	{
		/* $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://bitcoincharts.com/t/weighted_prices.json');
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$file_contents = strstr(curl_exec($ch),'{'); // get everything starting from first curly bracket
		curl_close($ch);
		$bitCoinsValue = Zend_Json::decode($file_contents);
		
		$amount = $bitCoinsValue['USD']['24h'];
		$from_Currency = 'USD';
		$to_Currency = 'INR';
		
		$amount = urlencode($amount);
		$from_Currency = urlencode($from_Currency);
		$to_Currency = urlencode($to_Currency);
		
		$url = "http://www.google.com/finance/converter?a=$amount&from=$from_Currency&to=$to_Currency";
		
		$ch = curl_init();
		$timeout = 0;
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$rawdata = curl_exec($ch);
		curl_close($ch);
		$data = explode('bld>', $rawdata);
		$data = explode($to_Currency, $data[1]); */
		//Zenfox_Debug::dump(round($data[0], 2), 'data');
		//Zend_Layout::getMvcInstance()->disableLayout();
//		$this->_helper->FlashMessenger(array('notice' => 'We are currently in the process of coming up with a wide range of Promotions! Being a TaashTimer not only helps your online life, but your real life! Keep checking this page for more.'));
		/*TODO:: Get all promotions for this frontend and display*/
	}

	public function surveyAction()
	{
		//Zend_Layout::getMvcInstance()->disableLayout();
		//Zend_Layout::getMvcInstance()->setLayout('iframe');
		//echo "in survery";
	}

	public function referfriendAction()
	{
		$form = new Player_InviteFriendForm();
		$this->view->form = $form;
		
		$authSession = new Zenfox_Auth_Storage_Session();
		$sessionData = $authSession->read();
		if($sessionData)
		{
			$buddyId = $sessionData['id'];
			$url = "http://" . $_SERVER['HTTP_HOST'] . '/index/index/buddyId/' . $buddyId;
			$this->view->url = $url;
		}
	}
	
	public function specialAction()
	{

	}
	
	public function loyaltyAction()
	{
		
	}
	
	public function newsletterAction()
	{
		
	}
	
	public function giftAction()
	{
		
	}
}
