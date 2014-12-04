<?php
class Player_ContentController extends Zenfox_Controller_Action
{
	public function termsAction()
	{
		$this->view->companyName = Zend_Registry::get('companyName');
		$this->view->companyShortName = Zend_Registry::get('companyShortName');
		$this->view->operationsCompanyName = Zend_Registry::get('operationsCompanyName');
		$this->view->frontendName = Zend_Registry::get('frontendName');
		$this->view->operationsJurisdiction = Zend_Registry::get('operationsCompanyJurisdiction');
		$this->view->frontendShortName = Zend_Registry::get('frontendShortName');
		$this->view->frontendCurrency = Zend_Registry::get('frontendCurrency');
		$this->view->frontendMinDeposit = Zend_Registry::get('frontendMinDeposit');
		$this->view->bonusConversionTimePeriod = "within 30 days of receiving the same";
		$this->view->bonusConversionRate = "1";
		$this->view->supportEmailId = Zend_Registry::get('supportEmailId');
		$this->view->certificationCompanyName = "";
	}
	
	public function privacypolicyAction()
	{
		$this->view->companyName = Zend_Registry::get('companyName');
		$this->view->companyShortName = Zend_Registry::get('companyShortName');
	}
	
	public function legalAction()
	{
		$this->view->companyName = Zend_Registry::get('companyName');
		$this->view->companyShortName = Zend_Registry::get('companyShortName');
	}
	
	public function rulesAction()
	{
		$this->view->companyName = Zend_Registry::get('companyName');
		$this->view->companyShortName = Zend_Registry::get('companyShortName');
	}
	
	public function withdrawtermsAction()
	{
		 $this->view->companyName = Zend_Registry::get('companyName');
         $this->view->companyShortName = Zend_Registry::get('companyShortName');
         $this->view->frontendShortName = Zend_Registry::get('frontendShortName');
		 $this->view->minDeposit = Zend_Registry::get('frontendMinDeposit');
         $this->view->companyAddress = Zend_Registry::isRegistered('companyAddress')?Zend_Registry::get('companyAddress'):"<Company Address>";
         $this->view->frontendName = Zend_Registry::isRegistered('frontendName')?Zend_Registry::get('frontendName'):"rummy.tld";
         $this->view->frontendCurrency = Zend_Registry::isRegistered('frontendCurrency')?Zend_Registry::get('frontendCurrency'):"INR";
         $this->view->frontendMinDeposit = Zend_Registry::isRegistered('frontendMinDeposit')?Zend_Registry::get('frontendMinDeposit'):"<Minimum Deposit>";
         $this->view->softwareCompanyName = Zend_Registry::isRegistered('softwareCompanyName')?Zend_Registry::get('softwareCompanyName'):"Logic Dice";
         $this->view->softwareCompanyShortName = Zend_Registry::isRegistered('softwareCompanyShortName')?Zend_Registry::get('softwareCompanyShortName'):"Logic Dice";
         $this->view->operationsCompanyName = Zend_Registry::isRegistered('operationsCompanyName')?Zend_Registry::get('operationsCompanyName'):"<Operations Company>"    ;
         $this->view->operationsCompanyShortName = Zend_Registry::isRegistered('operationsCompanyShortName')?Zend_Registry::get('operationsCompanyShortName'):"<Opera    tions Company>";
         $this->view->operationsCompanyShortName = Zend_Registry::isRegistered('operationsCompanyJurisdiction')?Zend_Registry::get('operationsCompanyJurisdiction'):"    <Operations Jurisdiction>";
         $this->view->licensingJurisdiction = Zend_Registry::isRegistered('licensingJurisdiction')?Zend_Registry::get('licensingJurisdiction'):"<License Jurisdiction    >";
         $this->view->supportEmailId = Zend_Registry::isRegistered('supportEmailId')?Zend_Registry::get('supportEmailId'):"<Support Email>";
         $this->view->advertisingSiteName = Zend_Registry::isRegistered('advertisingSiteName')?Zend_Registry::get('advertisingSiteName'):"<Advertising Site>";
         $this->view->processingDay = Zend_Registry::isRegistered('processingDay')?Zend_Registry::get('processingDay'):"<Processing Day>";
         $this->view->processingPreviousDay = Zend_Registry::isRegistered('processingPreviousDay')?Zend_Registry::get('processingPreviousDay'):"<Processing Previous     Day>";
		 $this->view->minWithdrawAmount = 500;
		 $this->view->maxWithdrawAmount = 5000;
		 $this->view->freeWithdrawTimes = "once";
		 $this->view->processingFee = "";
	}
	
	public function contactAction()
	{
		if($_POST)
		{			
			$name = $_POST['name'];
			$email = $_POST['email'];
			$postMessage = $_POST['message'];
			
			$emailValidator = new Zend_Validate_EmailAddress();
			if(!$emailValidator->isValid($email))
			{
				$this->view->message = "Please enter valid email address";
			}
			else
			{
				$subject = "Mail From Contact Us";
				$textBody = "Name -> " . $name . " Email -> " . $email . " Message -> " . $postMessage;
				$htmlBody = "<b>Name</b> -> " . $name . "<br><b>Email</b> -> " . $email . "<br><b>Message</b> -> " . $postMessage;
				$receiver = "support@bingocrush.co.uk";
				//$receiver = "nikhil@fortuity.in";
				$mail = new Mail();
				$mail->sendMails($subject, $textBody, $htmlBody, $receiver);
				
				$this->view->message = "Thank you for writing us!! We will get back to you very soon.";
			}
			$this->view->name = $name;
			$this->view->email = $email;
			$this->view->postMessage = $postMessage;
		}
	}
	
	public function aboutAction()
	{
		
	}
	
	public function awardsAction()
	{
		
	}
	
	public function blogAction()
	{
		
	}
	
	public function articleAction()
	{
		
	}
}
