<?php
require_once dirname(__FILE__).'/../forms/CouponForm.php';
class Player_CouponController extends Zenfox_Controller_Action
{
	public function redeemAction()
	{
		$confirmSession = new Zend_Session_Namespace('confirmSession');
		if(isset($confirmSession->value))
		{
			$confirmSession->unsetAll();
			$this->_helper->FlashMessenger(array('notice' => $this->view->translate("You have been successfully registered. If you have coupon code then enter it.")));
		}
		$form = new Player_CouponForm();
		$this->view->form = $form;
		if($this->getRequest()->isPost())
		{
			$session = new Zenfox_Auth_Storage_Session();
			$store = $session->read();
			$playerId = $store['id'];
			
			$code = $_POST['code'];
			$playerData = $store['authDetails'][0];
			$baseCurrency = $playerData['base_currency'];
			
			$redeemCoupon = new RedeemCoupon();
			$isCouponRedeemed = $redeemCoupon->redeem($playerId, $code, $baseCurrency);

			if($isCouponRedeemed['error'])
			{
				$this->_helper->FlashMessenger(array('error' => $this->view->translate($isCouponRedeemed['message'])));
			}
			else
			{
				$this->view->form = '';
				//$this->view->link = 'http://' . $_SERVER['SERVER_NAME'] . '/game';
				
				$couponActive = $_COOKIE['coupon'];
				setcookie('coupon','',time(),'/','.'.$_SERVER['HTTP_HOST']);
				if(isset($couponActive) && $couponActive)
				{
					$this->_helper->FlashMessenger(array('notice' => $this->view->translate($isCouponRedeemed['message'])));
					$request = clone $this->getRequest();
					$request->setActionName('howtoplay')
							->setControllerName('help')
							->setParams(array('page' => 'confirm'));
					$this->_helper->actionStack($request);
				}
				else
				{
					$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Congratulations!! Your account has been credited. You will be redirected to the games page.")));
					$this->view->link = 'http://' . $_SERVER['SERVER_NAME'] . '/game';
				}
			}
		}
	}
	
	public function indexAction()
	{
		$form = new Player_CouponForm();
		$this->view->form = $form;
	}
	
	public function generateAction()
	{
		Zend_Layout::getMvcInstance()->disableLayout();
		$authSession = new Zenfox_Auth_Storage_Session();
		$sessionData = $authSession->read();
		$playerId = $sessionData['id'];
		$userName = $sessionData['authDetails'][0]['login'];
		
		if($_POST)
		{
			$emailsList = explode(',',$_POST['emails']);
			$emails = array_map('trim', $emailsList);
			$emailValidator = new Zend_Validate_EmailAddress();
			
			foreach($emails as $email)
			{
				if($emailValidator->isValid($email))
				{
					if(!in_array($email, $invitedEmails))
					{
						$date = new Zend_Date();
						$currentTime = $date->get(Zend_Date::W3C);
						
						$codeString = md5($data['code'] . $currentTime);
						$stringLength = strlen($codeString);
						
						$startPos = mt_rand(0, $stringLength - 6);
						
						$code = 'RAKHI-GIFT-' . strtoupper(substr($codeString, $startPos, 5));
						
						$data['code'] = $code;
						$redeemCoupon = new RedeemCoupon();
						$redeemCoupon->generateCoupon($playerId, $data);
						
						$filePath = APPLICATION_PATH . '/site_configs/rum/invitation.html';
						$fh = fopen($filePath, 'r');
						$fileData = fread($fh, filesize($filePath));
						
						$fileData = str_replace("[username]", $userName, $fileData);
						$fileData = str_replace("[COUPON CODE]", $code, $fileData);
						$fileData = str_replace("redeemcoupon/couponId/<couponId>", "coupon/redeem", $fileData);
						
						$subject = 'Rakshabandhan Promotion';
						$textBody = $fileData;
						$htmlBody = $fileData;
						
						$mail = new Mail();
						$mail->sendMails($subject, $textBody, $htmlBody, $email);
						
						$invitedEmails[] = $email;
					}
				}
				else
				{
					$invalidEmailAddresses[] = $email;
				}
			}
			
			$invalidEmailAddresses = implode(', ', $invalidEmailAddresses);
			$invitedEmails = implode(', ', $invitedEmails);
			
			$message = "";
			if($invitedEmails)
			{
				$message .= "Congratulation!! Your gift has been sent to - " . $invitedEmails . ":";
			}
			if($invalidEmailAddresses)
			{
				$message .= "These emails are invalid - " . $invalidEmailAddresses . ":";
			}
			echo $message . "You will be redirected to the games page.";
			
			/* $this->_helper->FlashMessenger(array('notice' => $this->view->translate("Congratulation!! Your gift has been sent to - " . $invitedEmails)));
			$this->_helper->FlashMessenger(array('error' => $this->view->translate("These emails are invalid - " . $invalidEmailAddresses))); */
		}
		/* $this->_helper->FlashMessenger(array('notice' => $this->view->translate("You will be redirected to the games page.")));
		$this->view->link = 'http://' . $_SERVER['SERVER_NAME'] . '/game'; */
	}
}
