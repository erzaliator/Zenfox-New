<?php
/**
 * This class is used to show winner list for a special promotion
 * Create promotion
 * Show promotion
 */

require_once dirname(__FILE__) . '/../forms/PromotionForm.php';
require_once dirname(__FILE__) . '/../forms/LoginBonusForm.php';
class Admin_PromotionController extends Zenfox_Controller_Action
{
	public function init()
	{
		parent::init();
	}
	
	public function winnerAction()
	{
		$promotionForm = new Admin_PromotionForm();
		$this->view->form = $promotionForm->getDateForm('2013-04-17', 41);
		
		if($this->getRequest()->isPost())
		{
			if($promotionForm->isValid($_POST))
			{
				$data = $promotionForm->getValues();
				
				$iplFile = APPLICATION_PATH . '/site_configs/rum/ipl.json';
				$fh = fopen($iplFile, 'r');
				$jsonData = fread($fh, filesize($iplFile));
				fclose($fh);
				
				$date = new Zend_Date();
				$today = $date->get(Zend_Date::W3C);
				
				$iplArray = Zend_Json::decode($jsonData);
				$transEndTime = "";
				
				foreach($iplArray as $time => $iplData)
				{
					$date = new Zend_Date($data['allDates']);
					$prevDay = $date->sub(1, Zend_Date::DAY);
					//Zenfox_Debug::dump($prevDay, 'pday');
					$iplTime = new Zend_Date($time);
					//$difference = $prevDay->sub($iplTime)->toValue();
					$difference = $prevDay->compare($iplTime, Zend_Date::DAY);
					//$hour = floor(($difference/60)/60);
					if($difference == 0)
					{
						$varName[] = "'" . $iplArray[$time]['vote']['voteNumber'] . "'";
						$transEndTime = $prevDay;
					}
						
				}
				
				if($transEndTime)
				{
					$year = $transEndTime->get(Zend_Date::YEAR);
					$month = $transEndTime->get(Zend_Date::MONTH);
					$day = $transEndTime->get(Zend_Date::DAY);
					$transEndTime = $year . "-" . $month . "-" . $day;
					
					$varName = implode(",", $varName);
					$accountVariable = new AccountVariable();
					$iplWinners = $accountVariable->getIPLPromotionWinners($varName, 'CREDIT_DEPOSITS', $transEndTime);
					$this->view->iplWinners = $iplWinners;
				}
			}
		}
	}
	

	public function loginbonusAction()
	{
		$formobj = new Admin_LoginBonusForm();
		$frontendvariableobj = new FrontendVariables();
		$frontendId_of_bingocrush = 1;
		$data = $frontendvariableobj->getData($frontendId_of_bingocrush,"LOGINBONUS");
		
		$formData = json_decode($data["variableValue"]);
		
		//Zend_Debug::dump($formData);
		$this->view->form = $formobj->getform($formData);
		
		if($this->getRequest()->isPost())
		{
			if($formobj->isValid($_POST))
			{
				$postvalues = $formobj->getvalues();
				
				 $now = Zend_Date::now();
				 
				 
				$postvalues["from_date"] = $now->get('YYYY-MM-dd');
				$postvalues["from_time"] = $now->get('HH:mm:ss');
				
				$next = $now->addDay(1);
				$postvalues["to_date"] = $next->get('YYYY-MM-dd');
				$postvalues["to_time"] = $next->get('HH:mm:ss');
				
				//echo $postvalues["from_date"]." ".$postvalues["from_time"];
				$jsondata = json_encode($postvalues);
				$data["frontend_id"] = $frontendId_of_bingocrush;
				$data["variableName"] = "LOGINBONUS";
				$data["variableValue"] = $jsondata;
				
				$result = $frontendvariableobj->insert($data);
				
				$data = $frontendvariableobj->getData($frontendId_of_bingocrush,"LOGINBONUS");
		
				$formData = json_decode($data["variableValue"]);
				$this->view->form = $formobj->getform($formData);
				
				if($result)
				{
					$this->_helper->FlashMessenger(array('message' => 'Login Bonus '.$postvalues["status"].' for Today'));
				}
				else
				{
					$this->_helper->FlashMessenger(array('error' => 'Problem Activating Login Bonus'));
				}
			}
		}
				
		$this->_helper->FlashMessenger(array('message' => 'EndTime For LoginBonus =  '.$formData->to_date.' '.$formData->to_time));
	}
	
}