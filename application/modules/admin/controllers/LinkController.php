<?php
require_once(dirname(__FILE__) . '/../forms/LinkConfirmationForm.php');
require_once(dirname(__FILE__) . '/../forms/LinkForgotpwdForm.php');
require_once(dirname(__FILE__) . '/../../player/models/PasswordRecovery.php');
require_once(dirname(__FILE__) . '/../../player/models/generated/BasePasswordRecovery.php');
class Admin_LinkController extends Zenfox_Controller_Action
{
	public function confirmationAction()
	{
		 
		$form = new Admin_LinkConfirmationForm();
		$this->view->form=$form->getform2();
		
		if ($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$this->view->form="";
				$postvalues = $form->getValues();
				
				
				if((!empty($postvalues["playerentry"])&&((!empty($postvalues["value"])))) or (!!empty($postvalues["playerentry"])&&((!!empty($postvalues["value"])))))
				{
					
						$getdetails = new AccountUnconfirm();
						$details = $getdetails->getcodeDetail($postvalues["playerentry"],$postvalues["value"],$postvalues["affiliate"]);
						if(!!empty($details))
						{
							$details=0;
							$this->view->form=$form->getform2();
						}
						$length=count($details);
						
						while($length>0)
						{
							$playerid[$length-1]=$details[$length-1]["player_id"];
							$email[$length-1]=$details[$length-1]["email"];
							$login[$length-1]=$details[$length-1]["login"];
							$code[$length-1]=$details[$length-1]["code"];
							$confirmation[$length-1]=$details[$length-1]["confirmation"];
							$length--;
						}
						
						
						$this->view->id=$playerid;
						$this->view->email=$email;
						$this->view->login=$login;
						$this->view->code=$code;
						$this->view->confirmation=$confirmation;
					
					
				}
				else 
				{
					$this->view->form=$form->getform2();
					$this->view->empty="input field empty";
					
				}
			}
			
		}
	}
	public function forgotpwdAction()
	{
		$form = new Admin_LinkForgotpwdForm();
		$this->view->form=$form->getform();
		//echo "in controller";
		//exit();
		if ($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$this->view->form="";
				$postvalues = $form->getValues();
				$getdetails = new PasswordRecovery();
				$details = $getdetails->getcodeDetail($postvalues["playerentry"],$postvalues["value"],$postvalues["user_type"]);
				if(!!empty($details))
					{
						$details=0;
						$this->view->empty="empty array";
					}
					
						
						
						$date = new Zend_Date();
						$date->setTimezone('Asia/Kolkata');
						$today = $date->get(Zend_Date::W3C)	;
						
				$this->view->time = $today;
				$this->view->expirytime = $details[0]["expiry_time"];
				$this->view->id=$details[0]["user_id"];
				$this->view->email=$details[0]["email"];
				$this->view->playertype=$details[0]["user_type"];
				$this->view->code=$details[0]["code"];
				$this->view->status=$details[0]["status"];
					
						
// 					
						
				}
				
				
		
		}
	}
}
