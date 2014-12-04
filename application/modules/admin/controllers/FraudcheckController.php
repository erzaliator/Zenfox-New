<?php
class Admin_FraudcheckController extends Zenfox_Controller_Action
{
	public function checkingAction()
	{
		$playerId = $this->getRequest()->playerId;
		
		$fraudcheckobj = new FraudCheck();
		$fraudcheckreport = $fraudcheckobj->getfraudcheckreport($playerId);
		
		$this->view->mydetails = $fraudcheckreport["mydetails"];
		$this->view->rake = $fraudcheckreport["rake"];
		$this->view->playerdata = $fraudcheckreport["playerdata"];
		$this->view->realplayerslist = $fraudcheckreport["realplayerslist"];
	
			
	}	
	
	
	/*public function elorating($playerId)
	{
		
		$opponentsdetailsobj = new OpponentsDetails();
		$allopponentsids = $opponentsdetailsobj->getopponentIds($playerId);
		
		$accountvariableobj = new AccountVariable();
		$eloratingvalue = $accountvariableobj->getData($playerId,"elorating");
		
		$playerelorating = $eloratingvalue["varValue"];
		if(!$playerelorating)
		{
			$data = array();
			$data["playerId"] = $playerId;
			$data["variableName"] = "elorating";
			$data["variableValue"] = 1400;
			
			$accountvariableobj->insert($data);
			
			$playerelorating = 1400;
		}
		
		$length = count($allopponentsids);
		$index = 0;
		
		while($index < $length)
		{
			
			$eloratingvalue = $accountvariableobj->getData($allopponentsids[$index]["opponent_id"],"elorating");
		
			$oppelorating = $eloratingvalue["varValue"];
			if(!$oppelorating)
			{
				$data = array();
				$data["playerId"] = $allopponentsids[$index]["opponent_id"];
				$data["variableName"] = "elorating";
				$data["variableValue"] = 1400;
				$accountvariableobj[$index] = new AccountVariable();
				$accountvariableobj[$index]->insert($data);
			
				$oppelorating = 1400;
			}
			
			$expectation = 1/(1+(10^($oppelorating-$playerelorating)));
			
			$newelorating = $playerelorating + 32*($allopponentsids[$index]["won"]-($allopponentsids[$index]["games"]*$expectation));
			
			
			$playerelorating = $newelorating;
			$index++;
		}
		 
		$data = array();
		$data["playerId"] = $playerId;
		$data["variableName"] = "elorating";
		$data["variableValue"] = $playerelorating;
		
		$accountvariableobj[$index] = new AccountVariable();
		$accountvariableobj[$index]->insert($data);
		
	}*/
}