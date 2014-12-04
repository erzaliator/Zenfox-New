<?php
class Player_IptvController extends Zend_Controller_Action
{
	public function init()
	{
		parent::init();
        $contextSwitch = Zend_Controller_Action_HelperBroker::getStaticHelper('ContextSwitch');
        $contextSwitch->addActionContext('getconfigs', 'json')
        				->addActionContext('buycards', 'json')
    				->initContext();
	}
	
	public function getconfigsAction()
	{
		$roomId = $this->getRequest()->roomId;
		
		$runningRoomObj = new BingoRunningRoom();
		$roomData = $runningRoomObj->getRunningRoomData($roomId);
		
		
		
		$game["maxVariablePotBbs"] = $roomData[0]["max_variable_pot_bbs"];
		$game["categories"] = $roomData[0]["categories"];
		$game["minVariablePotBbs"] = $roomData[0]["min_variable_pot_bbs"];
		$game["id"] = $roomData[0]["game_id"];
		$game["pjps"] = array();
		$game["noOfCardsPerStrip"] = $roomData[0]["no_of_cards_per_strip"];
		$game["name"] = $roomData[0]["game_name"];
		
		$game["currency"] = $roomData[0]["currency"];
		$game["gameFlavour"] = $roomData[0]["game_flavour"];
		
		$game["maxNoOfStripsPerRequest"] = $roomData[0]["max_no_of_strips_per_request"];
		$game["gameType"] = $roomData[0]["game_type"];
		
		$game["extensionName"] = $roomData[0]["extension_name"];
		
		if($game["gameType"] == "FIXED")
		{
			$fixedPotPaymentObj = new BingoFixedPotPayment();
			$game["fixedPotPayments"] = $fixedPotPaymentObj->getData($game["id"]);
			
		}
		elseif($game["gameType"] == "VARIABLE")
		{
			$variablePotPaymentObj = new BingoVariablePotPayment();
			$game["variablePotPayments"] = $variablePotPaymentObj->getData($game["id"]);
			
			
		}
		
		$game["potType"] = $roomData[0]["pot_type"];
		$game["amountType"] = $roomData[0]["amount_type"];
		
		$game["realReturn"] = $roomData[0]["real_return"];
		$game["pjpEnabled"] = $roomData[0]["pjp_enabled"];
		$game["maxVariablePotReal"] = $roomData[0]["max_variable_pot_real"];
		
		$game["maxCards"] = $roomData[0]["max_cards"];
		$game["gameState"] = $roomData[0]["game_state"];
		$game["minCards"] = $roomData[0]["min_cards"];
		$game["minVariablePotReal"] = $roomData[0]["min_variable_pot_real"];
		$game["callDelay"] = $roomData[0]["call_delay"];
		$game["description"] = $roomData[0]["description"];
		$game["gamelogId"] = $roomData[0]["gamelog_id"];
		$game["freeRatio"] = $roomData[0]["free_ratio"];
	
		$pattern["name"] =  $roomData[0]["pattern_name"];
		$pattern["pattern"] =  $roomData[0]["pattern"];
		$pattern["description"] =  $roomData[0]["pattern_description"];
		
		$game["pattern"] = $pattern;
		
		$currencyobj = new Currency();
		$currency = $currencyobj->getCurrencybyCode($roomData[0]["currency"]);
		
		$game["currency"] = $currency;
		
		
		$this->view->game = $game;
	}
	
	public function buycardsAction()
	{
		
		
	}
}
