<?php
 //require_once(dirname(__FILE__) . '/../forms/PlayersRegisteredForm.php');
require_once(dirname(__FILE__) . '/../forms/CreatetournamentForm.php');
//require_once(dirname(__FILE__) . '/../../../models/Tournaments.php');
require_once(dirname(__FILE__)  . '/../forms/TournamentAmountDetailsForm.php');

class Admin_TournamentschedulingController extends Zenfox_Controller_Action
{
	public function viewconfigsAction()
	{
		$tournamentconfig = new TournamentConfig();
		$tournamentmini = $tournamentconfig->gettournamentminilist();
		$length=count($tournamentmini);
	
		while($length>0)
		{
			$tournamentdetails[$length-1]['config_id']  = $tournamentmini[$length-1]['tournament_config_id'];
			$tournamentdetails[$length-1]['config_name'] = $tournamentmini[$length-1]['tournament_config_name'];
			$tournamentdetails[$length-1]['description'] = $tournamentmini[$length-1]['description'];
			$tournamentdetails[$length-1]['initial_tournament_chips'] = $tournamentmini[$length-1]['initial_tournament_chips'];
			
			$configdecode = Zend_Json_Decoder::decode($tournamentmini[$length-1]['config']);
			
			$number_of_levels[$length-1] = count($configdecode['tiers']);
			
			while($number_of_levels[$length-1]>0)
			{
// 				$level[$length-1][$number_of_levels[$length-1]-1] = $configdecode['tiers'][$number_of_levels[$length-1]-1]['level'];
// 				$duration[$length-1][$number_of_levels[$length-1]-1] = $configdecode['tiers'][$number_of_levels[$length-1]-1]['duration'];
// 				$timebreak[$length-1][$number_of_levels[$length-1]-1] = $configdecode['tiers'][$number_of_levels[$length-1]-1]['break'];
// 				$gameflavour[$length-1][$number_of_levels[$length-1]-1] = $configdecode['tiers'][$number_of_levels[$length-1]-1]['gameFlavour'];
// 				$eligibilityamount[$length-1][$number_of_levels[$length-1]-1] = $configdecode['tiers'][$number_of_levels[$length-1]-1]['eligibilityCriteria'][0]['amount'];
// 				$eligibilityamounttype[$length-1][$number_of_levels[$length-1]-1] = $configdecode['tiers'][$number_of_levels[$length-1]-1]['eligibilityCriteria'][0]['type'];
				$buyinamount[$length-1][$number_of_levels[$length-1]-1] = $configdecode['tiers'][$number_of_levels[$length-1]-1]['buyinCost'][0]['amount'];
				$buyinamounttype[$length-1][$number_of_levels[$length-1]-1] = $configdecode['tiers'][$number_of_levels[$length-1]-1]['buyinCost'][0]['amountType'];
				
				$number_of_levels[$length-1]--;
			}
			$tournamentdetails[$length-1]['buy_in_ammount'] = $buyinamount[$length-1][$number_of_levels[$length-1]].$buyinamounttype[$length-1][$number_of_levels[$length-1]];
			$length--;
		}
		
		$getidvalue = $this->getRequest()->config_id;
		
		if (!empty($getidvalue))
		{
			
			$tournamentconfig = new TournamentConfig();
			
			
			$configdetails = $tournamentconfig->getTournamentDetails($getidvalue);
				
			$configdecode = Zend_Json_Decoder::decode($configdetails['config']);
			
			
			$length = count($configdecode['tiers']);
			
			
			
			while($length>0)
			{
				$gamedetails[$length-1]["level"] = $configdecode['tiers'][$length-1]['level'];
				$gamedetails[$length-1]["duration"] = $configdecode['tiers'][$length-1]['duration'];
				$gamedetails[$length-1]["timebreak"]= $configdecode['tiers'][$length-1]['break'];
				$gamedetails[$length-1]["gameflavour"] = $configdecode['tiers'][$length-1]['gameFlavour'];
				$gamedetails[$length-1]["eligibilityamount"] = $configdecode['tiers'][$length-1]['eligibilityCriteria'][0]['amount'];
				$gamedetails[$length-1]["eligibilityamounttype"] = $configdecode['tiers'][$length-1]['eligibilityCriteria'][0]['type'];
				$gamedetails[$length-1]["buyinamount"] = $configdecode['tiers'][$length-1]['buyinCost'][0]['amount'];
				$gamedetails[$length-1]["buyinamounttype"] = $configdecode['tiers'][$length-1]['buyinCost'][0]['amountType'];
				$length--;
			
			}
			
		//
			
			
			$rewarddecode = Zend_Json_Decoder::decode($configdetails['rewards']);
				
				
			$length = count($rewarddecode['rewards']);
				
			
			while($length>0)
			{
				$prizedetails[$length-1]['prize'] = $rewarddecode['rewards'][$length][0]['amount'];
				$prizedetails[$length-1]['type'] = $rewarddecode['rewards'][$length][0]['type'];
				$prizedetails[$length-1]['position'] = $length;
				$length--;
			
			}
			
			
			
			$tournamentdetail[0]['config_id'] = $configdetails['tournament_config_id'];
			$tournamentdetail[0]['config_name'] = $configdetails['tournament_config_name'];
			$tournamentdetail[0]['description'] = $configdetails['description'];
			$tournamentdetail[0]['initial_tournament_chips'] = $configdetails['initial_tournament_chips'];
			
			$consolation[0]['no of consolation'] = $rewarddecode['consolationRewards']['numberOfRewards'];
			$consolation[0]['prize'] = $rewarddecode['consolationRewards']['rewards'][1][0]['amount'];
			$consolation[0]['type'] = $rewarddecode['consolationRewards']['rewards'][1][0]['type'];
			$consolation[0]['total worth'] = $rewarddecode['consolationRewards']['rewards'][1][0]['amount'] * $rewarddecode['consolationRewards']['numberOfRewards'];
			
			$this->view->tournamentdetails = $tournamentdetail;
			$this->view->gamedetails = $gamedetails;
			$this->view->prizedetails = $prizedetails;
			$this->view->consolationdetails = $consolation;
			$this->view->check = "not empty"; 
			
		}
		else 
		{
			$this->view->tournamentdetails = $tournamentdetails;
		}
	}
	
	public function createtournamentAction()
	{
		$tournamentconfig = new TournamentConfig();
		$tournamentmini = $tournamentconfig->gettournamentminilist();
		$length=count($tournamentmini);
		while($length>0)
		{
			$configid[$tournamentmini[$length-1]['tournament_config_id']] = $tournamentmini[$length-1]['tournament_config_id'] ;
			$length--;
		}
				
		$form = new Admin_CreatetournamentForm();
		
		$form->setvalue($configid);
		$this->view->form = $form->getform();
		
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$postvalues = $form->getvalues();
			
				
				$today = new Zend_Date();
				$currentTime = $today->get(Zend_Date::W3C);
				
				$starttime = $postvalues['startdate']. " " . $postvalues['starttime'];
				
				$newdate = new Zend_Date($starttime);
				$starttime = $newdate->get(Zend_Date::W3C);
				
				
				if ($starttime <= $currentTime)
				{
					$this->_helper->FlashMessenger(array('error' => 'TOURNAMENT can not be CREATED at that Time'));
				}
				else 
				{
					$tournamentobject = new Tournaments();
					$result = $tournamentobject->createtournament($postvalues['type'],$postvalues['name'],$starttime,$postvalues['config_id'],$postvalues['description']);
					if($result)
					{
						$this->view->form = "";
						$this->_helper->FlashMessenger(array('success' => 'TOURNAMENT CREATED'));
					}
					else
					{
						$this->_helper->FlashMessenger(array('error' => 'TOURNAMENT CREATION fAILED'));
					}
					
				}
				
			}
		}
	}
		
		public function playersregisteredAction()
		{
			
				if(!empty($this->getRequest()->page))
				{
					$offset = $this->getRequest()->page;
				}
				else 
				{
					$offset =1;
				}
			
				
					$tournamentobject = new Tournaments();
					$listvalues = $tournamentobject->tournamentminilist($offset);
						
					$list = $listvalues[1];
					$length = count($list);
					$index =0;
						
					$minilist = array();
					while($index<count($list))
					{
						$minilist[$index]['Tournament_Id'] = '';
						$minilist[$index]['Tournament_Name'] = '';
						$minilist[$index]['Start Time'] = '';
						$minilist[$index]['status'] = '';
						$minilist[$index]['Prize'] = '';
					
						$index++;
					}
					$index =0;
					
					while($length>0)
					{
						$minilist[$index]['Tournament_Id'] = $list[$index]['Tournament Id'];
						$minilist[$index]['Tournament_Name'] = $list[$index]['Tournament Name'];
						$minilist[$index]['Start Time'] = $list[$index]['Start Time'];
						$minilist[$index]['status'] = $list[$index]['Status'];
						$minilist[$index]['Prize'] = $list[$index]['Prize'];
					
						$index++;
						$length--;
					}
					
					$postvalue = $this->getRequest()->Tournament_Id;
				
			
				
			if(!empty($postvalue))
			{
					$registrationobject = new TournamentRegistrations();
					$playerlist = $registrationobject->getplayerlist($postvalue);
					
					if(!empty($playerlist))
					{
						
							$length = count($playerlist);
							$index =0;
							while($length > 0)
							{
						
								$playerslists[$index]["playerid"] = $playerlist[$index]["playerid"];
								$playerslists[$index]["login"] = $playerlist[$index]["login"] ;
								$playerslists[$index]["eligibilitylevel"] = $playerlist[$index]["eligibilitylevel"] ;
														
								$index++;
								$length--;
							}
							
					function aasort (&$array, $key) {
							$sorter=array();
							$ret=array();
							reset($array);
							foreach ($array as $ii => $va) {
								$sorter[$ii]=$va[$key];
								}
							asort($sorter);
							foreach ($sorter as $ii => $va) {
							$ret[$ii]=$array[$ii];
							}
							$array=$ret;
						}
						
						aasort($playerslists,'eligibilitylevel');
						$this->_helper->FlashMessenger(array('message' => 'Total Registrations = '.$index));
						$this->view->tablevalues = $playerslists;
						$this->view->tournamentid = $postvalue;
					}
					else
					{
						$this->_helper->FlashMessenger(array('error' => 'No Registrations'));
					}
			}
			else 
			{
				
				$this->view->tournaments = $minilist;
				$this->view->paginator = $listvalues[0];
				
			}
		}
		
		
		
		public function amountdetailsAction()
		{
			$form = new Admin_TournamentAmountDetailsForm();
			$this->view->form = $form->getform();	
			
			if($this->getRequest()->isPost())
			{
				if($form->isValid($_POST))
				{
					$postvalues = $form->getvalues();
						
			
				
					$starttime = $postvalues['startdate'];
					$endtime = $postvalues['enddate'];
					
					if ($starttime >= $endtime)
					{
						$this->_helper->FlashMessenger(array('error' => 'wrong time entered.'));
					}
					else
					{
						$tournamentobject = new Tournaments();
						$maxmin = $tournamentobject->getmaxminids($starttime,$endtime);
						
						
						$registrationobject = new TournamentRegistrations();
						$playerlist = $registrationobject->gettournamentamountdetails($maxmin);
													
						$this->view->table1 = $playerlist[0];
						$this->view->table2 = $playerlist[1];
						
					}
			
				}
			}
			
		}
				
		
		
		
	
}