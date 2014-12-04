<?php

class EloRating
{
	public function calculateelorating($playerId)
	{
		$accountvariablesobj = new AccountVariable();
		$data = $accountvariablesobj->getData($playerId,"elorating");
		
		//Zenfox_Debug::dump($data['varValue']);
		if(!$data['varValue'])
		{
			$oldelorating = 1400;
		}
		else
		{
			$oldelorating = $data['varValue'];
		}
		
		$opponentsdetailsobj = new OpponentsDetails();
		$newelorating = $opponentsdetailsobj->getelorating($playerId,$oldelorating);
		
		$data["playerId"] = $playerId;
		$data['variableName'] = "elorating";
		$data['varValue'] = $newelorating;
		
		
		$accountvariablesobj->insert($data);
		
		return $newelorating;
	}
}