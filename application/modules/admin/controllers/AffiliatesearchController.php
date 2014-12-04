<?php
require_once dirname(__FILE__).'/../forms/AffiliateSearchForm.php';
require_once dirname(__FILE__).'/../../affiliate/forms/RegistrationForm.php';

class Admin_AffiliatesearchController extends Zenfox_Controller_Action
{
	public function init()
		{
			parent::init();
			$this->_redirector = $this->_helper->getHelper('Redirector');
	        $contextSwitch = $this->_helper->getHelper('contextSwitch');
	       $contextSwitch->setAutoJsonSerialization(false);
			$contextSwitch->addActionContext('index', 'json')				
	              	->initContext();
	      //  Zend_Layout::getMvcInstance()->disableLayout();
		}
	public function indexAction()
	{
		$affiliate = new Affiliate();
		$request = $this->getRequest();
		$form = new Admin_AffiliateSearchForm();		
		$this->view->form = $form;
		$offset = $request->page;
        $itemsPerPage = $request->item;
        
	 	if(!$offset)
        {
        	$offset = 1;
        }
        else
        {
        	$searchField = $request->field;
        	$searchString = $request->str;
        	$match = $request->match;
        	$order = $request->order;
        	//$playersData = $player->getAllPlayers($searchField, $match, $offset, $itemsPerPage, $searchString);
        	$result = $affiliate->getMatchedAffiliates($searchField,$offset,$itemsPerPage,$searchString,$match,$order);        	
        	$this->view->searchField = $searchField;
        	$this->view->searchStr = $searchString;
        	$this->view->match = $match;
        	$this->view->paginator = $result[0];
        	$this->view->contents = $result[1];        	
        }
		
		if($this->getRequest()->isPost())
        {
        	if($form->isValid($_POST))
        	{ //Zend_Debug::dump($_POST, 'timezone', true, true);
        		$data = $form->getValues();        		
        		$result = $affiliate->getMatchedAffiliates($data['searchField'], $offset, $data['items'], $data['searchString'],$data['match'],$data['order']);        		
        		$this->view->searchField = $data['searchField'];
        		$this->view->searchStr = $data['searchString'];        		
        		$this->view->match = $data['match'];
        		$this->view->order = $data['order'];
        		$this->view->paginator = $result[0];
        		$this->view->contents = $result[1]; 
        		//Zend_Debug::dump($result[1], 'timezone', true, true);       		        		        		
        	/*	if(count($result[1]) == 1)
				{
					foreach($result[1] as $data){
						$id = $data['Id'];
					}										
					$this->_redirect("affiliatesearch/view/id/$id");
				}  */      		        		        		        		
        	}
        }
	}
	
	public function viewAction()
	{
		$id = $this->getRequest()->id;
		$affiliate = new Affiliate();
		$account = $affiliate->getAffiliate($id);
		$affiliateTracker = new AffiliateTracker();
		$affiliateTrackers = $affiliateTracker->getAffiliateTrackersByAffiliateId($id);		
		$translate = Zend_Registry::get('Zend_Translate');
		$table[0][$translate->translate('Category')] = 'Affiliate Id';
		$table[0][$translate->translate('Value')] = $account['affiliateId'];
		$table[1][$translate->translate('Category')] = 'Alias';
		$table[1][$translate->translate('Value')] = $account['alias'];
		$table[2][$translate->translate('Category')] = 'Name';
		$table[2][$translate->translate('Value')] = $account['firstName'];
		$table[3][$translate->translate('Category')] = 'Last Name';
		$table[3][$translate->translate('Value')] = $account['lastName'];
		$table[4][$translate->translate('Category')] = 'Company';
		$table[4][$translate->translate('Value')] = $account['company'];
		$table[5][$translate->translate('Category')] = 'Address';
		$table[5][$translate->translate('Value')] = $account['address'].' '.$account['city'].' '.
													$account['state'].' '.$account['country'].' '.
													$account['zip'];
		$table[6][$translate->translate('Category')] = 'payment_type';
		$table[6][$translate->translate('Value')] = $account['paymentType'];
		$table[7][$translate->translate('Category')] = 'Master Id';
		$table[7][$translate->translate('Value')] = $account['masterId'];
		$table[8][$translate->translate('Category')] = 'Created At';
		$table[8][$translate->translate('Value')] = $account['created'];
		$table[9][$translate->translate('Category')] = 'Enabled/Disabled';
		$table[9][$translate->translate('Value')] = $account['enabled'];
		$table[10][$translate->translate('Category')] = 'Balance';
		$table[10][$translate->translate('Value')] = $account['balance'];
		$table[11][$translate->translate('Category')] = 'Master Contribution';
		$table[11][$translate->translate('Value')] = $account['masterContribution'];
		$table[12][$translate->translate('Category')] = 'Master Deduction';
		$table[12][$translate->translate('Value')] = $account['masterDeduction'];
		$table[13][$translate->translate('Category')] = 'Buddy Balance';
		$table[13][$translate->translate('Value')] = $account['buddyBalance'];
		/*
		 * 192.168.10.28,29,30
		 * 255.255.255.192
		 * 192.168.10.1
		 * 192.168.10.1
		 */
		if($affiliateTrackers)
		{				
			foreach($affiliateTrackers as $tracker)
			{				
				$scheme = new AffiliateSchemeDef();
				$trackerDetail = new TrackerDetail();
				$result = $trackerDetail->getTrackerDetails($tracker['tracker_id']);
				$earnings = $trackerDetail->getTrackerEarnings($tracker['tracker_id']);				
				$clicks = $trackerDetail->getTrackerClicks($tracker['tracker_id']);
				$registrations = $trackerDetail->getTrackerRegistrations($tracker['tracker_id']);
				$acquisitions = $trackerDetail->getTrackerAcquisitions($tracker['tracker_id']);
				$schemeDetails = $scheme->getAffiliateSchemeDef($tracker['scheme_id']);				
				$loyalty = $scheme->getLoyalty($tracker['scheme_id'],$schemeDetails[0]['scheme_type'],$earnings,$acquisitions);				
				$trackerTable[$ind][$translate->translate('Link Id')] = $tracker['tracker_id'];
				$trackerTable[$ind][$translate->translate('Tracker Name')] = $tracker['tracker_name'];			
				$trackerTable[$ind][$translate->translate('Scheme Type')] = $schemeDetails[0]['scheme_type'];
				$trackerTable[$ind][$translate->translate('Loyalty')] = $loyalty;								
				$trackerTable[$ind][$translate->translate('Total Earnings')] = $earnings;
				$trackerTable[$ind][$translate->translate('Number of Clicks')] = $clicks;
				$trackerTable[$ind][$translate->translate('Registrations')] = $registrations;
				$trackerTable[$ind][$translate->translate('Acquisitions')] = $acquisitions;				
				$ind++;	
			}
		}
		$this->view->contents = $table;
		$this->view->trackerTable = $trackerTable;
	}
	
}