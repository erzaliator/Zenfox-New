<?php
class Player_MolController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$MerchantID = '201110042661';//your merchant id
		$MRef_ID = '1';//your order id
		$Amount = 1;
		$Description = 'Testing';
		$Currency = 'INR';
		$SecretPIN = 'fcem2661fcem';//your Secret word
		
		$soap_url = 'http://molv3.molsolutions.com/api/login/s_module/heartbeat.asmx?WSDL';
		//		$soap_url = 'https://www.sandbox.paypal.com/wsdl/PayPalSvc.wsdl';
		$method = 'GetHeartBeat';
		
		$soap_param = array(array('MerchantID' => $MerchantID));
		
		try
		{
			//			$client = new Zend_Soap_Client($soap_url, array('soap_version' => SOAP_1_2));
			/*$client = new SoapClient(NULL,array(
			"location" => $soap_url,
			"uri"      => "",
			"style"    => SOAP_RPC,
			"use"      => SOAP_ENCODED
			)); */
			$client = new SoapClient($soap_url, array('soap_version'   => SOAP_1_1));
			/*			$client = new Zend_Soap_Client();
		$client->setWsdl($soap_url);
			$client->LogIn(array('username' => 'FortuityInfotech_demo_01@gmail.com', 'password' => 'fcem2661'));*/
			}
			catch(Exception $e)
			{
			Zenfox_Debug::dump($e, "Fault String:");
		//echo "exception";
			//print_r($e); //exit();
				}
		
		Zenfox_Debug::dump($client, 'client');
		try
		{
			$client->soap_defencoding = 'UTF-8'; 
			$client->decode_utf8 = false;

			$result = $client->__call($method, $soap_param);
		}
		catch(Exception $e)
		{
			Zenfox_Debug::dump($e, 'callException');
		}
		Zenfox_Debug::dump($result, 'result');
		$HeartBeat = $result->GetHeartBeatResult->HB;
		
		$Signature = sha1(strtolower($MerchantID.$MRef_ID.$Amount.$Currency.$SecretPIN.$HeartBeat));
		
		Zenfox_Debug::dump($HeartBeat, 'beat');
		Zenfox_Debug::dump($Signature, 'sign');
		
		$this->view->merchantID = $MerchantID;
		$this->view->mRef_ID = $MRef_ID;
		$this->view->amount = $Amount;
		$this->view->description = $Description;
		$this->view->currency = $Currency;
		$this->view->heartBeat = $HeartBeat;
		$this->view->signature = $Signature;
	}
	
	public function responseAction()
	{
		
	}
}