<?php

class TPSL_Wrapper {

	//const bridgeURL		= 'http://localhost:8087/JavaBridge/java/Java.inc';
	const bridgeURL     = 'Jar/Java.inc';
	public $appStatus = "FALSE";
	public $checkSum	= "";
	public $errMsg		= "";
	public $responseData;

	function TPSL_Wrapper ()
	{
		if($this->init_Includes()) {
			$this->appStatus = true;
		} else {
			$this->appStatus = false;
		}

	}// function TPSL_Wrapper() Ends Here.


	function init_Includes () {
		$bridgeCheck = file_get_contents(self::bridgeURL);
		if (!preg_match("/404 Not Found/i", $bridgeCheck )) {
			include self::bridgeURL;
			return true;
		}
		
		return false;
		
	}// function init_Includes() Ends Here.
	

	function processRequest () {


		if( isset($_REQUEST['txtTranID']) && isset($_REQUEST['txtMarketCode']) && isset($_REQUEST['txtAcctNo']) && isset($_REQUEST['txtTxnAmount']) && isset($_REQUEST['txtBankCode']) && isset($_REQUEST['txtPropPath']) ) {

			$strTranID		= $_REQUEST['txtTranID'];
			$strMarketCode	= $_REQUEST['txtMarketCode'];
			$strAcctNo		= $_REQUEST['txtAcctNo'];
			$strTxnAmount	= $_REQUEST['txtTxnAmount'];
			$strBankCode	= $_REQUEST['txtBankCode'];
			$strPropPath	= $_REQUEST['txtPropPath'];

			try
			{
				$tpslObj = new java("tpsl_php_wrapper.TPSL_PHP_Wrapper");
				$retStr = $tpslObj->processRequest($strTranID, $strMarketCode, $strAcctNo, $strTxnAmount, $strBankCode, $strPropPath);
			}
			catch(Exception $e)
			{
				//Zenfox_Debug::dump($e, "Exxception:  ");
			}
			return $retStr;
		} else {
			return "Invalid input supplied !";
		}

	}// function processRequest() Ends Here.

	function processResponse ($propertyFilePath) {
		
		if( isset($_REQUEST['msg'])) {

			$tpslObj = new java("tpsl_php_wrapper.TPSL_PHP_Wrapper");
			$retStr = $tpslObj->processResponse($_REQUEST['msg'], $propertyFilePath);
			$this->responseData = explode('|', $_REQUEST['msg']);

			// Response parameters availabe in the bellow class array
			// Index Order sae as in the response msg parameter
			//echo $this->responseData[0];

			return $retStr;
		} else {
			return "Invalid input supplied !";
		}

	}// function processResponse() Ends Here.

	function fetchCheckSum ($checkValue, $tpslKey) {
		$tpslObj = new java("tpsl_php_wrapper.TPSL_PHP_Wrapper");
		$retStr = $tpslObj->checkSum($checkValue, $tpslKey);
		if(preg_match("/^<CHECKSUM_VALUE>(.*)<\/CHECKSUM_VALUE>$/i", self::javaIncludes, $match)) {
			$this->$checkSum = $match[1];
		} elseif (preg_match("^<EXCEPTION>(.*)<\/EXCEPTION>$", self::javaIncludes, $match)) {
			$this->errMsg = $match[1];
		} else {
			$this->errMsg = "Uncaught exception.";
		}
	}


}


?>
