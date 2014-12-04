<?php

if (!function_exists('curl_init'))
{
	throw new Exception('OAuth needs the CURL PHP extension.');
}

class OAuth2_Exception extends Exception
{
	protected $result;

	public function __construct($result) 
	{
	    $this->result = $result;
	    $code = isset($result['error_code']) ? $result['error_code'] : 0;
	    if (isset($result['error_description'])) 
	    {
      		$msg = $result['error_description'];
    	}
    	else if (isset($result['error']) && is_array($result['error'])) 
    	{
      		$msg = $result['error']['message'];
    	}
    	else if (isset($result['error_msg'])) 
    	{
      		$msg = $result['error_msg'];
    	} 
    	else 
    	{
      		$msg = 'Unknown Error. Check getResult()';
    	}

    	parent::__construct($msg, $code);
	}

	public function getResult() 
	{
    	return $this->result;
	}

	public function getType() 
	{
    	if (isset($this->result['error'])) 
    	{
      		$error = $this->result['error'];
      		if (is_string($error)) 
      		{
        		return $error;
      		} 
      		else if (is_array($error)) 
      		{	
        		if (isset($error['type'])) 
        		{
          			return $error['type'];
        		}
      		}
    	}
    	return 'Exception';
 	}

 	public function __toString() 
 	{
    	$str = $this->getType() . ': ';
    	if ($this->code != 0) 
    	{
      		$str .= $this->code . ': ';
    	}
    	return $str . $this->message;
	}
}

class Oauth2
{
	//Server Urls
    const authentification_uri = 'http://taashtime.tld/oauth/authorize';
    const access_token_uri = 'http://taashtime.tld/oauth/access';

    protected $_callbackUrl = null;

    protected $_clientId = null;

    protected $_clientSecret = null;
    
    protected $_verificationCode = null;

    protected $_config = null;

    protected static $_localHttpClient = null;

	public function __construct($options = null)
    {
        if (!is_null($options)) {
            $this->setOptions($options);
        }
    }

    public function setOptions(array $options)
    {
        foreach ($options as $key => $value) {
            switch ($key) {
                case 'callbackUrl':
                    $this->setCallbackUrl($value);
                    break;
                case 'clientId':
                    $this->setClientId($value);
                    break;
                case 'clientSecret':
                    $this->setClientSecret($value);
                    break;
            }
        }

        return $this;
    }
    
    public function setCallbackUrl($callbackUrl)
    {
        $this->_callbackUrl = $callbackUrl;
        return $this;
    }

    public function getCallbackUrl()
    {
        return $this->_callbackUrl;
    }

    public function setClientId($clientId)
    {
        $this->_clientId = $clientId;
        return $this;
    }

    public function getClientId()
    {
        return $this->_clientId;
    }

    public function setClientSecret($clientSecret)
    {
        $this->_clientSecret = $clientSecret;
        return $this;
    }

    public function getClientSecret()
    {
        return $this->_clientSecret;
    }
    
    
    public function authorizationRedirect()
    {
    	$callbackUrl = $this->getCallbackUrl();
        $clientId = $this->getClientId();

        $requiredValuesArray = array('callbackUrl', 'clientId');

        // throw exception if one of the required values is missing
        foreach($requiredValuesArray as $requiredValue) {
            if (is_null($$requiredValue)) {
                throw new OAuth2_Exception(array(
                'error_msg' => 'value '. $requiredValue.' is empty, pass '.ucfirst($requiredValue).' as parameter when calling the '.__METHOD__.' method or add it to the options array you pass when creating an instance of the '.get_class($this).' class'
                ));
            }
        }

        //Callback URL for Zenfox
        $callbackUrl = explode('/', $callbackUrl);
        $callbackUrl = implode(',', $callbackUrl);

        $requestUrl = self::authentification_uri.'/clientId/'.$clientId.'/redirectUri/'.$callbackUrl;

        header('Location: '.$requestUrl);
        exit(1);

    }

    public function setVerificationCode($verificationCode)
    {
        $this->_verificationCode = $verificationCode;
        return $this;
    }


    public function getVerificationCode()
    {
        return $this->_verificationCode;
    }

    public function requestAccessToken()
    {
    	$clientId = $this->getClientId();
    	$clientSecret = $this->getClientSecret();
    	$code = $this->getVerificationCode();

        
        $requiredValuesArray = array('clientId', 'clientSecret');

        // throw exception if one of the required values is missing
        foreach($requiredValuesArray as $requiredValue) {
            if (is_null($$requiredValue)) {
                throw new Oauth2_Exception(array(
                'error_msg' => 'value '. $requiredValue.' is empty, pass the '.ucfirst($requiredValue).' as parameter when calling the '.__METHOD__.' method or add it to the options array you pass when creating an instance of the '.get_class($this).' class'
                ));
            }
        }

        $hashKey = base64_encode(hash_hmac("sha256", utf8_encode($code), utf8_encode($clientSecret), false));
		$ch = curl_init(self::access_token_uri);
		$params['clientId'] = $clientId;
		$params['hashKey'] = $hashKey;
		$params['code'] = $code;
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$body = curl_exec($ch);
		if ($body === false) 
		{
      		$e = new OAuth2_Exception(array(
        		'error_code' => curl_errno($ch),
        		'error'      => array(
          		'message' => curl_error($ch),
          		'type'    => 'CurlException',
        		),
      		));
      		curl_close($ch);
      		throw $e;
		}
		curl_close($ch);
        return $body;        
    }

}
