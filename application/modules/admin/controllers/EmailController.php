<?php
require_once(dirname(__FILE__) . '/../forms/SimpleMailForm.php');

class Admin_EmailController extends Zenfox_Controller_Action
{
	public function individualmailsAction()
	{
				$form = new Admin_SimpleMailForm();
		
				$authSession = new Zend_Auth_Storage_Session();
				$sessionData = $authSession->read();
				$csrId = $sessionData['id'];
				$csrfrontendids = $sessionData['frontend_ids'];
				$player = new Player();
				
				$frontendobject = new Frontend();
				$frontends = $frontendobject->getFrontendById($csrfrontendids);
				$length = count($frontends);
				$index = 0;
				while($index < $length )
				{
					$newfrontends[$frontends[$index]['id']] = $frontends[$index]['name'];
					$index++;
				}
				
				$templateobj = new EmailTemplate();
				$template = $templateobj->gettemplate();
				
				$length = count($template);
				$index = 0;
				while($index < $length )
				{
					$newtemplate[$template[$index]['id']] = $template[$index]['name'];
					$index++;
				}
				
				
				$form->setfrontend($newfrontends);
				$form->settemplate($newtemplate);
				
				$this->view->form = $form->getform();
				
				if ($this->getRequest()->isPost())
				{
					if($form->isValid($_POST))
					{
						$postvalues = $form->getValues();
						
						
						$playerlist = explode(",",$postvalues["playerids"]);
						$count = count($playerlist);
						$index = 0;
						$secondindex = 0;
						while($index < $count)
						{
							$playerfrontendid = $player->getfrontendidofplayer($playerlist[$index]);
							if (in_array($playerfrontendid,$csrfrontendids))
 							{
 								$playerids[$secondindex] = $playerlist[$index];
 								$secondindex++;
 							}
 							else
 							{
 								$unknownplayers[$index] = $playerlist[$index];
 							}
							$index++;
						}
						
						$noofplayers = count($playerids);
						$index =0;
						while($noofplayers > 0)
						{
							$accountobj = new Account();
							$playerdetails = $accountobj->getdetails($playerids[$index]);
							$mail = new Mail();
							$mail->sendMails($postvalues['subject'], $postvalues['message'], $postvalues['message'], $playerdetails['email']);
							/* $emailobj[$index] = new EmailQueue();
							$emailobj[$index]->addadminEmailQueue($playerids[$index], $postvalues['usertype'], $playerdetails['email'], $postvalues['template_id'], $postvalues['message'], $postvalues['frontend_id'], $postvalues['Priority'] ); */
								
							$index++;
							$noofplayers--;
						}
						if(!empty($playerids))
						{
							$this->_helper->FlashMessenger(array('message' => 'email will be sent to players with player ids "'.implode(',',$playerids).'" according to priority'));
						}
						if(!empty($unknownplayers))
						{
							$this->_helper->FlashMessenger(array('message' => 'Players with playerIds "' .implode(',',$unknownplayers).'" not found or you are not authorised to send an email to this  players'));
						}
					}
				
				}
	}
	
}