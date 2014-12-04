<?php
class Admin_DateSelectionForm extends Zend_Form
{
	public function init()
	{
		$date = new Zend_Date();
		$today = $date->get('YYYY-MM-dd');
		
		$front = Zend_Controller_Front::getInstance();
		$controller = $front->getRequest()->getControllerName();
		$action = $front->getRequest()->getActionName();
		$pageAddress = $controller . '-' . $action;
		switch($pageAddress)
		{
			case 'rummyreport-gamehistory':
			case 'withdrawal-request':
			case 'rummyreport-transaction':
			case 'report-transaction':
				$playerId = $this->createElement('text','playerId');
				$playerId->setLabel($this->getView()->translate('Player Id'));
				$this->addElement($playerId);
				$paymentmethode = $this->createElement('select', 'paymentmethod');
				$paymentmethode->setLabel('Payment Method')
				->addMultiOptions(array(
						'ALL' => 'ALL',
						'CREDIT' => 'CREDIT',
						'DEBIT' => 'DEBIT',
						'NETBANKING' => 'NETBANKING',
						'MOBILE' => 'MOBILE',
						'CASH' => 'CASH',
						'MOL' => 'MOL'
				));
				$this->addElement($paymentmethode);
				break;
			case 'rummyreport-gamelog':
			case 'gamelog-keno':
			case 'gamelog-slot':
			case 'gamelog-roulette':
				$currentPlayerId = $front->getRequest()->getParam('playerId');
				$playerId = $this->createElement('text','playerId');
				$playerId->setLabel($this->getView()->translate('Player Id'));
				if($currentPlayerId)
				{
					$playerId->setValue($currentPlayerId);
				}
				$this->addElement($playerId);
				break;
			case 'rummyreport-registration':
			case 'report-registration':
				$accountTypes = $this->createElement('select', 'accountType');
				$accountTypes->setLabel('Select Account Type')
						->addMultiOptions(array(
								'confirmed' => 'Confirmed',
								'uconfirmed' => 'Unconfirmed'
					));
				$affiliateTracker = new AffiliateTracker();
				$allTrackers = $affiliateTracker->getAlltAffiliateTrackers();
				
				$trackerId = $this->createElement('select', 'trackerId');
				$trackerId->setLabel('Select Tracker')
						->addMultiOptions(array('' => 'All'))
						->addMultiOptions(array('-1' => 'Default Tracker'));
				
				foreach($allTrackers as $tracker)
				{
					$trackerId->addMultiOptions(array($tracker['tracker_id'] => $tracker['tracker_name']));
				}
				
				$this->addElements(array($accountTypes, $trackerId));
				break;
			case 'rummyreport-regular':
			case 'rummyreport-online':	
				$authSession = new Zend_Auth_Storage_Session();
				$sessionData = $authSession->read();
				$csrId = $sessionData['id'];
				$csrfrontendids = $sessionData['frontend_ids'];
				
				$frontendobject = new Frontend();
				$frontends = $frontendobject->getFrontendById($csrfrontendids);
				$length = count($frontends);
				$index = 0;
				while($index < $length )
				{
					$newfrontendlist[$frontends[$index]['id']] = $frontends[$index]['name'];
					$index++;
				}
				//ontText->addMultiOptions(array($frontend_id => $frontend_name));
				
				$frontend = $this->createElement('select', 'frontend');
				$frontend->setLabel('Select Frontend')
						->addMultiOptions($newfrontendlist);
				$this->addElement($frontend);
			
				break;
			case 'report-topplayers':
				$playerId = $this->createElement('text','player_id');
				$playerId->setLabel($this->getView()->translate('Player Id (optional)'));

				/*$gameflavour = $this->createElement('select','game_flavour');
				$gameflavour->setLabel($this->getView()->translate('Game Flavour *'))
							->setRequired(true)
							->addMultiOptions(array(
								'bingo' => 'Bingo',
								'slots' => 'Slots',
								'roulette' => 'Roulette',
								'keno' => 'Keno'
					));*/
					
				$playertransactionsobj  = new PlayerTransactions();
				$flavourData = $playertransactionsobj->getdistinctgameflavours();
				//Zenfox_Debug::dump($flavourData);exit;
				$gameFlavour = $this->createElement('select', 'gameFlavour');
				$gameFlavour->setLabel($this->getView()->translate('Game Flavour'));
				foreach($flavourData as $flavour)
				{
					$gameFlavour->addMultiOption($flavour['GameFlavours'], $flavour['GameFlavours']);
				}
				
				
				$transactiontypedata = $playertransactionsobj->getdistincttransactiontypes();
				$transactiontype = $this->createElement('select','transaction_type');
				$transactiontype->setLabel($this->getView()->translate('Transaction Type *'))
							->setRequired(true);
				foreach($transactiontypedata as $typedata)
				{
					$transactiontype->addMultiOption($typedata['TransactionType'], $typedata['TransactionType']);
				}
				
				$this->addElements(array(
        			$playerId,
        			$gameFlavour,
        			$transactiontype
        		));
				break;
			case 'withdrawal-listall':
        		$playerId = $this->createElement('text','player_id');
				$playerId->setLabel($this->getView()->translate('Player Id (optional)'));
				$this->addElement($playerId);
        		break;
        	
        		
		}
		
		$from_date = new ZendX_JQuery_Form_Element_DatePicker('from_date');
		$from_date->setLabel($this->getView()->translate('From Date'))
				->setRequired(true)
				->setJQueryParam('dateFormat', 'yy-mm-dd')
				->setValue($today);
				
		$from_time = new Zenfox_JQuery_Form_Element_TimePicker('from_time');
		$from_time->setLabel($this->getView()->translate('Time'));
		
        $to_date = new ZendX_JQuery_Form_Element_DatePicker('to_date');
		$to_date->setLabel($this->getView()->translate('To Date'))
				->setRequired(true)
				->setJQueryParam('dateFormat', 'yy-mm-dd')
				->setValue($today);
		
		$to_time = new Zenfox_JQuery_Form_Element_TimePicker('to_time');
        $to_time->setLabel($this->getView()->translate('Time'));
        
        $this->addElements(array(
        		$from_date,
        		$from_time,
        		$to_date,
        		$to_time,
        	));
        
        switch($pageAddress)
        {
        	case 'withdrawal-request':
        	case 'withdrawal-listall':
        		$withdrawal_type = $this->createElement('multiCheckbox', 'withdrawal_type');
        		$withdrawal_type->setLabel($this->getView()->translate('Withdrawal Status'))
        					->addMultiOption('PROCESSED', $this->getView()->translate('Processed'))
        					->addMultiOption('NOT_PROCESSED', $this->getView()->translate('Not processed'))
        					->addMultiOption('PARTIALLY_PROCESSED', $this->getView()->translate('Partially processed'));
        		$this->addElement($withdrawal_type);
        		break;
        }
		
		$page = $this->createElement('select', 'items');
		$page->setLabel($this->getView()->translate('Result per page'))
			->addMultiOptions(array(
				'10' => $this->getView()->translate('10'),
				'20' => $this->getView()->translate('20'),
				'30' => $this->getView()->translate('30'),
				'40' => $this->getView()->translate('40'),
				'50' => $this->getView()->translate('50'),
				'50000' => $this->getView()->translate('ALL')));
			
		//TODO Use for withdrawal controller
		/*$withdrawal_type = $this->createElement('multiCheckbox', 'withdrawal_type');
        $withdrawal_type->setLabel($this->getView()->translate('Withdrawal Status'))
        				->addMultiOption('PROCESSED', $this->getView()->translate('Processed'))
        				->addMultiOption('NOT_PROCESSED', $this->getView()->translate('Not processed'))
        				->addMultiOption('PARTIALLY_PROCESSED', $this->getView()->translate('Partially processed'));
        $player_id = $this->createElement('text','player_id');
        $player_id->setLabel( $this->getView()->translate('Player Id'));*/
	
        				
			
		$submit = $this->createElement('submit', 'submitButton');
		$submit->setLabel($this->getView()->translate('Submit'))
				->setIgnore(true);
			
		$this->addElements(array(
				/* $from_date,
				$from_time,
				$to_date,
				$to_time, */
				$page,
				//$withdrawal_type,
				//$player_id,
				$submit));
				
		$this->setAttrib('id', 'admin-date-selection-form');
		$this->setAttrib('name', 'date-selection-form');
		$this->setAction('/' . $controller . '/' . $action);
	}
}
