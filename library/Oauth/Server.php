<?php
class Server
{
	private $_hashKey;
	private $_code;
	private $_accessToken;
	private $_secretKey;
	private $_clientId = '98765';
	
	//Set the hash key
	public function setHashKey()
	{
		$code = $this->getCode();
		$secretKey = $this->getSecretKey();
		$this->_hashKey = base64_encode(hash_hmac("sha256", utf8_encode($code), utf8_encode($secretKey), false)); 
	}
	
	/*
	 * Generic function
	 * Generate the hash key from the code and secret key
	 */
	public function getHashKey()
	{
		return $this->_hashKey;
	}
	
	private function _getAccessToken()
	{
		return $this->_accessToken;
	}
	
	//Set the code
	public function setCode($code = NULL)
	{
		$this->_code = ($code)?$this->_code = base64_encode($code) : $this->_code = base64_encode('1234');
	}
	
	//Get the code
	public function getCode()
	{
		return $this->_code;
	}
	
	//Check the hash key generated on the server and passed by client
	public function checkHashKey($token)
	{
		$hashKey = $this->getHashKey($this->_code, $this->_secretKey);
		
		if($hashKey == $token)
		{
			$this->_setAccessToken();
			return true;
		}
		return false;
	}
	
	//Generate the access token here
	//Can use as same as hash key
	private function _setAccessToken()
	{
		$this->_accessToken = '12345';
	}
	
	//Get the access token
	public function getAccessToken()
	{
		return $this->_accessToken;
	}
	
	//Set the secret key
	public function setSecretKey($secretKey)
	{
		$this->_secretKey = $secretKey;
	}
	
	//Get secret key
	public function getSecretKey()
	{
		return $this->_secretKey;
	}
	
	//Get the client id
	public function getClientId()
	{
		return $this->_clientId;
	}
	
	//Set the client id
	public function setClientId($clientId)
	{
		$this->_clientId = $clientId;
	}
}