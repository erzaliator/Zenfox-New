<?php
class Affiliate_HelpController extends Zend_Controller_Action
{
	public function init()
	{
		parent::init();
	}
	
	public function faqAction()
	{
		
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
				$subject = "Mail From Affiliate Contact Form";
				$textBody = "Name -> " . $name . " Email -> " . $email . " Message -> " . $postMessage;
				$htmlBody = "<b>Name</b> -> " . $name . "<br><b>Email</b> -> " . $email . "<br><b>Message</b> -> " . $postMessage;
				$receiver = "marketing@bingocrush.co.uk";
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
}