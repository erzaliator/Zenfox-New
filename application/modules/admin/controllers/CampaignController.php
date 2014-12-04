<?php
require_once(dirname(__FILE__) . '/../forms/CampaignForm.php');
class Admin_CampaignController extends Zenfox_Controller_Action
{
	public function startcampaignAction()
	{
				$form = new Admin_CampaignForm();
				
				$frontendobject = new Frontend();
				$frontends = $frontendobject->getFrontends();
				
				$length = count($frontends);
				$index = 0;
				$newfrontends["0"] = "-select one-";
				while($index < $length )
				{
					$newfrontends[$frontends[$index]['id']] = $frontends[$index]['name'];
					$index++;
				}
				
				$groupsobj = new PlayerGroups();
				$groups = $groupsobj->getgroups();
				
				$length = count($groups);
				$index = 0;
				$newgroups["0"] = "-select one-";
				while($index < $length )
				{
					$newgroups[$groups[$index]['id']] = $groups[$index]['name'];
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
				$form->setgroup($newgroups);
				
				$this->view->form = $form->getform();
				$data = $this->getRequest()->data;
				
				if ($this->getRequest()->isPost())
				{
					if($form->isValid($_POST))
					{
						$postvalues = $form->getvalues();
						$today = new Zend_Date();
						
						$now = $today->get(Zend_Date::W3C);
						$date = $today->get('YYYY-MM-dd');
						
						
						if($postvalues['group_id'] ==  0)
						{
							$this->_helper->FlashMessenger(array('message' => 'Group ID not selected '));
							
						}
						else 
						{
							if(!empty($postvalues['campaign_name']))
							{
								$campaignname = $postvalues['campaign_name'];
							}
							else
							{
								$campaignname = $newgroups[$postvalues['group_id']]."-".$newtemplate[$postvalues["template_id"]]."-".$postvalues["frontend_id"]."-".$date;
							}
							$postvalues['campaign_name'] = $campaignname;
							
							$detailscheck = array();
							$detailscheck[0]['frontend'] = $postvalues['frontend_id'];
							$detailscheck[0]['template'] = $postvalues['template_id'];
							$detailscheck[0]['group'] = $postvalues['group_id'];
							$detailscheck[0]['message'] = $postvalues['message'];
							$detailscheck[0]['priority'] = $postvalues['Priority'];
							$detailscheck[0]['campaign_name'] = $postvalues['campaign_name'];
							
							$detailscheck[1]['frontend'] = $newfrontends[$postvalues['frontend_id']];
							$detailscheck[1]['template'] = $newtemplate[$postvalues['template_id']];
							$detailscheck[1]['group'] = $newgroups[$postvalues['group_id']];
							$detailscheck[1]['message'] = "";
							$detailscheck[1]['priority'] = "";
							$detailscheck[1]['campaign_name'] = "";
							
							$this->view->data = $detailscheck;
						}
					}
				}
				
				if(!empty($data))
				{
					$data = array_values(unserialize($data));
					
						$postvalues = $data[0];
					
						Zenfox_Debug::dump($postvalues);
						$today = new Zend_Date();
						
						$now = $today->get(Zend_Date::W3C);
						$date = $today->get('YYYY-MM-dd');
					
						$campaignobj = new CampaignList();
						$lastdata = $campaignobj->getlastdata($postvalues['campaign_name'],$postvalues['message'],$postvalues['priority']);
						
						if(!empty($lastdata))
						{
							$this->_helper->FlashMessenger(array('message' => 'Request set already with campaign name ="' .$postvalues['campaign_name'].'" '));
						}
						else 
						{
							if($postvalues["frontend"] == 0)
							{
								$campaignobj->startcampaign($postvalues["group"],NULL,$postvalues["template"],$postvalues["message"],$postvalues["priority"],$now,$postvalues['campaign_name']);
								
							}
							else 
							{
								$campaignobj->startcampaign($postvalues["group"],$postvalues["frontend"],$postvalues["template"],$postvalues["message"],$postvalues["priority"],$now,$postvalues['campaign_name']);
								
							}
							$this->_redirect("/campaign/trackcampaign/campaign_name/".$postvalues['campaign_name']);
						}
				}
				
	}
	
	public function trackcampaignAction()
	{
		$campaignobj = new CampaignList();
		$data = $campaignobj->getallcampaign();
		$this->view->value = $data;
		
		$campaignname = $this->getRequest()->campaign_name;
		
		if(!empty($campaignname))
		{
			$emailqueueobj = new EmailQueue();
			$processlist = $emailqueueobj->getcampaignstatus($campaignname);
			$this->view->list = $processlist;
			$this->view->value = "";
		}
		
		
		
		
	}
}