<?php

class fraudcheck
{
	public function getfraudcheckreport($playerId)
	{
		$opponentsdetailsobj = new OpponentsDetails();
		
		$accountdetailsobj = new AccountDetail();
		$details = $accountdetailsobj->getDetails($playerId) ;
		
		$mydetails[0]["PLAYER ID"] =   $playerId;
		$mydetails[0]["LOGIN NAME"] =   $details["login"];
		$mydetails[0]["EMAIL"] =   $details["email"];
		$mydetails[0]["No Of Deposits"] = $details["noof_deposits"];
		
	//	$allopponentsids = $opponentsdetailsobj->getopponentIds($playerId);
	//	Zenfox_Debug::dump($allopponentsids);exit;
		
		
		$lasttime = $opponentsdetailsobj->getlastmodifieddate($playerId);
			
		if($lasttime)
		{
			$firsttime = false;
			
		}		
		else 
		{
			$lasttime = $details["created"];
			$firsttime = true;
		}
	
		$playergamelogobj = new PlayerGamelog();
		$now = $playergamelogobj->getlasttimegameplayed($playerId);
			
		
		
		$playerhelathobj = new PlayerHealth();
		$rake = $playerhelathobj->getplayerrake($playerId,$details["created"],$now);
		
		$this->view->mydetails = $mydetails;
		
		
			$sessions = $playergamelogobj->getrealmoneySessionsplayed($playerId , $lasttime ,$now );
			
		if($sessions)
		{
			set_time_limit(600);
			
			$cefgamelogobj = new CefGamelog();
			$cefgamelogdata = $cefgamelogobj->getStartandEndtimes($sessions);
		
			//Zenfox_Debug::dump($sessions);exit;
			$index=0;
			$gametimes = array();
			$length = count($cefgamelogdata);

			while($index < $length)
			{
				if($cefgamelogdata[$index]["game_time"] != NULL)
				{
					$gametimes[$cefgamelogdata[$index]["game_flavour"]][$cefgamelogdata[$index]["session_id"]."-".$cefgamelogdata[$index]["game_id"]] = $cefgamelogdata[$index]["game_time"];
				}
				else
				{
					$gametimes[$cefgamelogdata[$index]["game_flavour"]][$cefgamelogdata[$index]["session_id"]."-".$cefgamelogdata[$index]["game_id"]] = "UNFINISHED";
				}
				$index++;
			}
				
				
				
				$realplayerslist = $playergamelogobj->getsessionplayersdetails($sessions);
			//	Zenfox_Debug::dump($realplayerslist);exit;
				$length = count($realplayerslist);
			$index = 0;
			$tempplayerlist = array();
			$sessionslist = array();
			$gameslist = array();
			while($index < $length)
			{
				
					$tempplayerlist[$realplayerslist[$index]["player_id"]]["player_id"] = $realplayerslist[$index]["player_id"];
					if($realplayerslist[$index]["game_flavour"] == "MPPRummy")
					{
						$tempplayerlist[$realplayerslist[$index]["player_id"]][$realplayerslist[$index]["game_flavour"]]["Opponent Real Won"][$realplayerslist[$index]["session_id"]."-".$realplayerslist[$index]["game_id"]] = $realplayerslist[$index]["real_winnings"];
						$tempplayerlist[$realplayerslist[$index]["player_id"]][$realplayerslist[$index]["game_flavour"]]["Opponent Bonus Won"][$realplayerslist[$index]["session_id"]."-".$realplayerslist[$index]["game_id"]] = $realplayerslist[$index]["bonus_winnings"];
					
					}
					else 
					{
						$tempplayerlist[$realplayerslist[$index]["player_id"]][$realplayerslist[$index]["game_flavour"]]["Opponent Real Won"][$realplayerslist[$index]["session_id"]] += $realplayerslist[$index]["real_winnings"];
						$tempplayerlist[$realplayerslist[$index]["player_id"]][$realplayerslist[$index]["game_flavour"]]["Opponent Bonus Won"][$realplayerslist[$index]["session_id"]] += $realplayerslist[$index]["bonus_winnings"];
					
					}
					
					$tempplayerlist[$realplayerslist[$index]["player_id"]][$realplayerslist[$index]["game_flavour"]]["Opponent Real Bet"][$realplayerslist[$index]["session_id"]."-".$realplayerslist[$index]["game_id"]] = $realplayerslist[$index]["real_bet"];
					$tempplayerlist[$realplayerslist[$index]["player_id"]][$realplayerslist[$index]["game_flavour"]]["Opponent Bonus Bet"][$realplayerslist[$index]["session_id"]."-".$realplayerslist[$index]["game_id"]] = $realplayerslist[$index]["bonus_bet"];
				
					$sessionslist[$realplayerslist[$index]["player_id"]][$realplayerslist[$index]["game_flavour"]][$realplayerslist[$index]["session_id"]][$realplayerslist[$index]["game_id"]] = $realplayerslist[$index]["result"];
			
					$gameslist[$realplayerslist[$index]["player_id"]][$realplayerslist[$index]["game_flavour"]][$realplayerslist[$index]["result"]][$realplayerslist[$index]["session_id"]."-".$realplayerslist[$index]["game_id"]] = $realplayerslist[$index]["session_id"]."-".$realplayerslist[$index]["game_id"];
					
					$tempplayerlist[$realplayerslist[$index]["player_id"]][$realplayerslist[$index]["game_flavour"]]["Sessions Played"] = count($sessionslist[$realplayerslist[$index]["player_id"]][$realplayerslist[$index]["game_flavour"]]);
					$tempplayerlist[$realplayerslist[$index]["player_id"]][$realplayerslist[$index]["game_flavour"]]["Sessions Played list"][$realplayerslist[$index]["session_id"]] = $realplayerslist[$index]["session_id"];
					$tempplayerlist[$realplayerslist[$index]["player_id"]][$realplayerslist[$index]["game_flavour"]]["Opponent Games ".$realplayerslist[$index]["result"]] = array_values($gameslist[$realplayerslist[$index]["player_id"]][$realplayerslist[$index]["game_flavour"]][$realplayerslist[$index]["result"]]);
				
					if(($realplayerslist[$index]["real_winnings"] != 0) or ($realplayerslist[$index]["bonus_winnings"] != 0))
					{
						
						$tempplayerlist[$realplayerslist[$index]["player_id"]][$realplayerslist[$index]["game_flavour"]]["Opponent Sessions Won"][$realplayerslist[$index]["session_id"]] = 1;
					}
					//$tempplayerlist[$realplayerslist[$index]["player_id"]][$realplayerslist[$index]["game_flavour"]]["Time Played"][$realplayerslist[$index]["session_id"]."-".$realplayerslist[$index]["game_id"]] = $gametimes[$realplayerslist[$index]["game_flavour"]][$realplayerslist[$index]["session_id"]."_".$realplayerslist[$index]["game_id"]];
				
				if($realplayerslist[$index]["player_id"] == $playerId)
				{
					$playerDetails[$realplayerslist[$index]["player_id"]]["player_id"] = $realplayerslist[$index]["player_id"];
					
					$playerDetails[$realplayerslist[$index]["player_id"]][$realplayerslist[$index]["game_flavour"]]["Real Won"][$realplayerslist[$index]["session_id"]] += $realplayerslist[$index]["real_winnings"];
					$playerDetails[$realplayerslist[$index]["player_id"]][$realplayerslist[$index]["game_flavour"]]["Bonus Won"][$realplayerslist[$index]["session_id"]] += $realplayerslist[$index]["bonus_winnings"];
				
					$playerDetails[$realplayerslist[$index]["player_id"]][$realplayerslist[$index]["game_flavour"]]["Player Real Bet"] += $realplayerslist[$index]["real_bet"];
					$playerDetails[$realplayerslist[$index]["player_id"]][$realplayerslist[$index]["game_flavour"]]["Player Bonus Bet"] += $realplayerslist[$index]["bonus_bet"];
				
					$playerDetails[$realplayerslist[$index]["player_id"]][$realplayerslist[$index]["game_flavour"]]["Player Real Won"] += $realplayerslist[$index]["real_winnings"];
					$playerDetails[$realplayerslist[$index]["player_id"]][$realplayerslist[$index]["game_flavour"]]["Player Bonus Won"] += $realplayerslist[$index]["bonus_winnings"];
				
					$playerDetails[$realplayerslist[$index]["player_id"]][$realplayerslist[$index]["game_flavour"]]["Real Bet"][$realplayerslist[$index]["session_id"]."-".$realplayerslist[$index]["game_id"]] = $realplayerslist[$index]["real_bet"];
					$playerDetails[$realplayerslist[$index]["player_id"]][$realplayerslist[$index]["game_flavour"]]["Bonus Bet"][$realplayerslist[$index]["session_id"]."-".$realplayerslist[$index]["game_id"]] = $realplayerslist[$index]["bonus_bet"];
					
					$playerDetails[$realplayerslist[$index]["player_id"]][$realplayerslist[$index]["game_flavour"]]["Opponent Games " .$realplayerslist[$index]["result"]] = count($gameslist[$realplayerslist[$index]["player_id"]][$realplayerslist[$index]["game_flavour"]][$realplayerslist[$index]["result"]]); 
					
					$playerDetails[$realplayerslist[$index]["player_id"]][$realplayerslist[$index]["game_flavour"]]["Sessions Played"] = count($sessionslist[$realplayerslist[$index]["player_id"]][$realplayerslist[$index]["game_flavour"]]);
					$playerDetails[$realplayerslist[$index]["player_id"]][$realplayerslist[$index]["game_flavour"]]["Sessions Played list"][$realplayerslist[$index]["session_id"]] = $realplayerslist[$index]["session_id"];
					
					$playerDetails[$realplayerslist[$index]["player_id"]][$realplayerslist[$index]["game_flavour"]]["Player Games ".$realplayerslist[$index]["result"]] = $gameslist[$realplayerslist[$index]["player_id"]][$realplayerslist[$index]["game_flavour"]][$realplayerslist[$index]["result"]];
					
					if(($realplayerslist[$index]["real_winnings"] != 0) or ($realplayerslist[$index]["bonus_winnings"] != 0))
					{
						$playerDetails[$realplayerslist[$index]["player_id"]][$realplayerslist[$index]["game_flavour"]]["Sessions Wonlist"][$realplayerslist[$index]["session_id"]] = $realplayerslist[$index]["session_id"];
						$playerDetails[$realplayerslist[$index]["player_id"]][$realplayerslist[$index]["game_flavour"]]["Sessions Won"] = count($playerDetails[$realplayerslist[$index]["player_id"]][$realplayerslist[$index]["game_flavour"]]["Sessions Wonlist"]);
					}
					
					$playerDetails[$realplayerslist[$index]["player_id"]][$realplayerslist[$index]["game_flavour"]]["Time Played"] += $gametimes[$realplayerslist[$index]["game_flavour"]][$realplayerslist[$index]["session_id"]."-".$realplayerslist[$index]["game_id"]];
				}
				$index++;
			}
			
			$realplayerslist = ""; 
 			$tempplayerlist = array_values($tempplayerlist);
			$length = count($tempplayerlist);
			
			
			//Zenfox_Debug::dump($length);exit;
			
			$flavours = array("BestOfThreeRummy" , "Indian_Rummy" , "MPPRummy");
			$index=0;
			
			while($index < $length)
			{
				
				for($i=0;$i<3;$i++)
				{
							
						$newlist[$index]["player_id"] = $tempplayerlist[$index]["player_id"];
						$newlist[$index][$flavours[$i]] = $tempplayerlist[$index][$flavours[$i]];
						
						$opponentgameslost = array();
						$opponentgameswon = array();
						$opponentgamesplayed = array();
						
						$opponentgameslost = $tempplayerlist[$index][$flavours[$i]]["Opponent Games Lost"];
						$opponentgameswon = $tempplayerlist[$index][$flavours[$i]]["Opponent Games Winner"];
						
						if(!$opponentgameslost){
							$opponentgameslost = array();
						}
						
						if(!$opponentgameswon)
						{
							$opponentgameswon = array();
						}

						$opponentgamesplayed =  array_merge($opponentgameslost ,$opponentgameswon);
					
						$gamescount = count($opponentgamesplayed);
					
						$newlist[$index][$flavours[$i]]["Player Games Winner"] = "";
						$newlist[$index][$flavours[$i]]["Player Games Lost"] = "";
						$newlist[$index][$flavours[$i]]["Opponent Games Played"] = "";
						$newlist[$index][$flavours[$i]]["Opponent Games Winner"] = "";
						$newlist[$index][$flavours[$i]]["Opponent Games Lost"] = "";
						$newlist[$index][$flavours[$i]]["Time Played"] = "";
						$newlist[$index][$flavours[$i]]["Player Real Won"] = "";
						$newlist[$index][$flavours[$i]]["Player Bonus Won"] = "";
						$newlist[$index][$flavours[$i]]["Player Real Bet"] = "";
						$newlist[$index][$flavours[$i]]["Player Bonus Bet"] = "";
						$newlist[$index][$flavours[$i]]["Opponent Real Bet"] = "";
						$newlist[$index][$flavours[$i]]["Opponent Bonus Bet"] = "";
						$newlist[$index][$flavours[$i]]["Opponent Real Won"] = "";
						$newlist[$index][$flavours[$i]]["Opponent Bonus Won"] = "";
						
						while($gamescount > 0)
						{
							
							
							if($playerDetails[$playerId][$flavours[$i]]["Player Games Winner"][$opponentgamesplayed[$gamescount-1]])
							{
								$newlist[$index][$flavours[$i]]["Player Games Winner"] +=1;
								
								
							}
							
							if($playerDetails[$playerId][$flavours[$i]]["Player Games Winner"][$opponentgamesplayed[$gamescount-1]] or $playerDetails[$playerId][$flavours[$i]]["Player Games Lost"][$opponentgamesplayed[$gamescount-1]])
							{
								if(in_array($opponentgamesplayed[$gamescount-1] , $opponentgameswon))
								{
									$newlist[$index][$flavours[$i]]["Opponent Games Winner"] +=1;
								}
								else
								{
									$newlist[$index][$flavours[$i]]["Opponent Games Lost"] +=1;
								}
								
								
								$newlist[$index][$flavours[$i]]["Opponent Games Played"] +=1;
								
								$newlist[$index][$flavours[$i]]["Opponent Real Bet"] += $tempplayerlist[$index][$flavours[$i]]["Opponent Real Bet"][$opponentgamesplayed[$gamescount-1]];
								$newlist[$index][$flavours[$i]]["Opponent Bonus Bet"] += $tempplayerlist[$index][$flavours[$i]]["Opponent Bonus Bet"][$opponentgamesplayed[$gamescount-1]];
								
								
								$newlist[$index][$flavours[$i]]["Player Real Bet"] += $playerDetails[$playerId][$flavours[$i]]["Real Bet"][$opponentgamesplayed[$gamescount-1]];
								$newlist[$index][$flavours[$i]]["Player Bonus Bet"] += $playerDetails[$playerId][$flavours[$i]]["Bonus Bet"][$opponentgamesplayed[$gamescount-1]];
							//	Zenfox_Debug::dump( $gametimes[$flavours[$i]]);
								$newlist[$index][$flavours[$i]]["Time Played"] += $gametimes[$flavours[$i]][$opponentgamesplayed[$gamescount-1]];
								
								if($flavours[$i] == "MPPRummy")
								{
									$newlist[$index][$flavours[$i]]["Opponent Real Won"] += $tempplayerlist[$index][$flavours[$i]]["Opponent Real Won"][$opponentgamesplayed[$gamescount-1]];
									$newlist[$index][$flavours[$i]]["Opponent Bonus Won"] += $tempplayerlist[$index][$flavours[$i]]["Opponent Bonus Won"][$opponentgamesplayed[$gamescount-1]];
							
								}
								 
							}
							
						 	$gamescount--;
						}
						
						//Zenfox_Debug::dump($tempplayerlist[$index][$flavours[$i]]["Sessions Played list"]);
						
						$playersessionsplayed = array_values($tempplayerlist[$index][$flavours[$i]]["Sessions Played list"]);
						
					//	Zenfox_Debug::dump($playersessionsplayed);
						$sessionscount = count($playersessionsplayed);
						
						$newlist[$index][$flavours[$i]]["Player sessions Won"] = "";
						while($sessionscount > 0)
						{
							
							if($playerDetails[$playerId][$flavours[$i]]["Sessions Wonlist"][$playersessionsplayed[$sessionscount-1]] == $playersessionsplayed[$sessionscount-1])
							{
								
								$newlist[$index][$flavours[$i]]["Player sessions Won"] += 1;
								
								$newlist[$index][$flavours[$i]]["Player Real Won"] += $playerDetails[$playerId][$flavours[$i]]["Real Won"][$playersessionsplayed[$sessionscount-1]];
								$newlist[$index][$flavours[$i]]["Player Bonus Won"] += $playerDetails[$playerId][$flavours[$i]]["Bonus Won"][$playersessionsplayed[$sessionscount-1]];
								
							}
					
							if($playerDetails[$playerId][$flavours[$i]]["Sessions Played list"][$playersessionsplayed[$sessionscount-1]] == $playersessionsplayed[$sessionscount-1])
							{
								if(($flavours[$i] == "BestOfThreeRummy") or ($flavours[$i] == "Indian_Rummy"))
								{
									$newlist[$index][$flavours[$i]]["Opponent Real Won"] += $tempplayerlist[$index][$flavours[$i]]["Opponent Real Won"][$playersessionsplayed[$sessionscount-1]];
									$newlist[$index][$flavours[$i]]["Opponent Bonus Won"] += $tempplayerlist[$index][$flavours[$i]]["Opponent Bonus Won"][$playersessionsplayed[$sessionscount-1]];
								}
								
							}
								
							$sessionscount--;
						}
						
				}
				
			
				$index++;
			}
			
			//Zenfox_Debug::dump($tempplayerlist[$index]);exit;
			
			for($i=0;$i<3;$i++)
				{
					
					$playerdata[$i]["Game Flavour"] = $flavours[$i];
					
					$playerdata[$i]["Sessions Played"] = $playerDetails[$playerId][$flavours[$i]]["Sessions Played"];
					$playerdata[$i]["Sessions Won"] = $playerDetails[$playerId][$flavours[$i]]["Sessions Won"];
					$playerdata[$i]["Games Played"] = $playerDetails[$playerId][$flavours[$i]]["Opponent Games Winner"]+$playerDetails[$playerId][$flavours[$i]]["Opponent Games Lost"];
					$playerdata[$i]["Games Won"] = count($playerDetails[$playerId][$flavours[$i]]["Player Games Winner"]);
					$playerdata[$i]["Player Real Bet"] =  round($playerDetails[$playerId][$flavours[$i]]["Player Real Bet"],2);
					$playerdata[$i]["Player Bonus Bet"] = round($playerDetails[$playerId][$flavours[$i]]["Player Bonus Bet"],2);
					$playerdata[$i]["Player Real Won"] = round($playerDetails[$playerId][$flavours[$i]]["Player Real Won"],2);
					$playerdata[$i]["Player Bonus Won"] = round($playerDetails[$playerId][$flavours[$i]]["Player Bonus Won"],2);
					if($playerdata[$i]["Games Played"] == 0)
					{
						$playerdata[$i]["Average Game Time(min)"] = 0;
					}
					else 
					{
						$playerdata[$i]["Average Game Time(min)"] = $playerDetails[$playerId][$flavours[$i]]["Time Played"]/(60*$playerdata[$i]["Games Played"]);
					}				
					
				}
			
				$this->view->playerdata = $playerdata;
			
			$tempplayerlist = $newlist;
			$newlist = "";
			$index =0;
			$secondindex=0;
			$finalreallist = array();
			
			while($index < $length)
			{
				$playerdetails = $accountdetailsobj->getDetails($tempplayerlist[$index][player_id]);
				for($i=0;$i<3;$i++)
				{
					
					if($opponentId != $tempplayerlist[$index]["player_id"])
					{
						$opponentId = $tempplayerlist[$index]["player_id"];
						$finalreallist[$secondindex]["OPPONENT ID"] = $tempplayerlist[$index][player_id];;
						$finalreallist[$secondindex]["LOGIN NAME '(no of Deposits)'"] = $playerdetails["login"]."(".$playerdetails["noof_deposits"].")";
						
					}
					else 
					{
						$finalreallist[$i]["OPPONENT ID"] = "";
						$finalreallist[$secondindex]["LOGIN NAME '(no of Deposits)'"] = "";
					}
					
					$finalreallist[$secondindex]["Game Flavour"] = $flavours[$i];
					
					$finalreallist[$secondindex]["Sessions Played"] = $tempplayerlist[$index][$flavours[$i]]["Sessions Played"];
					$finalreallist[$secondindex]["Opponent Sessions Won"] = count($tempplayerlist[$index][$flavours[$i]]["Opponent Sessions Won"]);
					$finalreallist[$secondindex]["Player Sessions Won"] = $tempplayerlist[$index][$flavours[$i]]["Player sessions Won"];
					
					$finalreallist[$secondindex]["Games Played"] = $tempplayerlist[$index][$flavours[$i]]["Opponent Games Played"];
					$finalreallist[$secondindex]["Opponent Games Won"] = $tempplayerlist[$index][$flavours[$i]]["Opponent Games Winner"];
					$finalreallist[$secondindex]["Player Games Won"] = $tempplayerlist[$index][$flavours[$i]]["Player Games Winner"];
					
					$finalreallist[$secondindex]["Opponent Real Bet"] =  round($tempplayerlist[$index][$flavours[$i]]["Opponent Real Bet"],2);
					$finalreallist[$secondindex]["Opponent Bonus Bet"] = round($tempplayerlist[$index][$flavours[$i]]["Opponent Bonus Bet"],2);
					
					$finalreallist[$secondindex]["Player Real Bet"] =  round($tempplayerlist[$index][$flavours[$i]]["Player Real Bet"],2);
					$finalreallist[$secondindex]["Player Bonus Bet"] = round($tempplayerlist[$index][$flavours[$i]]["Player Bonus Bet"],2);
					
					$finalreallist[$secondindex]["Opponent Real Won"] = round($tempplayerlist[$index][$flavours[$i]]["Opponent Real Won"],2);
					$finalreallist[$secondindex]["Opponent Bonus Won"] = round($tempplayerlist[$index][$flavours[$i]]["Opponent Bonus Won"],2);

					$finalreallist[$secondindex]["Player Real Won"] = round($tempplayerlist[$index][$flavours[$i]]["Player Real Won"],2);
					$finalreallist[$secondindex]["Player Bonus Won"] = round($tempplayerlist[$index][$flavours[$i]]["Player Bonus Won"],2);
					
					if($tempplayerlist[$index][$flavours[$i]]["Opponent Games Played"] == 0)
					{
						$finalreallist[$secondindex]["Average Game Time(min)"] = 0;
					}
					else 
					{
						$finalreallist[$secondindex]["Average Game Time(min)"] = round($tempplayerlist[$index][$flavours[$i]]["Time Played"]/(60*($tempplayerlist[$index][$flavours[$i]]["Opponent Games Played"])),3);
					}				
					$secondindex++;
					
				}
					
				
				$index++;
			}
		
						
		}
		
	//	echo "lasttime".$lasttime."now".$now.$firsttime;
	//	Zenfox_Debug::dump($finalreallist);
		// exit;
		if($firsttime)
		{
			if($finalreallist)
			{
				$opponentsdetailsobj->insertopponentdetails($playerId , $finalreallist , $now);
				
			}
			else
			{
				$this->_helper->FlashMessenger(array('error' => 'No Games Played Till Now'));
			}	
			
		}
		else
		{
			if($finalreallist)
			{
				//Zenfox_Debug::dump($finalreallist);exit;
				
				$index = 0;
				$length = count($finalreallist);
				while($index < $length)
				{
					$data = array();
					$data[0] = $finalreallist[$index++];
					$data[1] = $finalreallist[$index++];
					$data[2] = $finalreallist[$index++];
				
					$opponentlist = $opponentsdetailsobj->getopponentdatabyopponentId($playerId,$data[0]["OPPONENT ID"]);
				
					
					if($opponentlist)
					{
						for($i=0;$i<3;$i++)
						{
							$data[$i]["Average Game Time(min)"] = (($data[$i]["Average Game Time(min)"]*$data[$i]["Games Played"])+ $opponentlist[$i]["total_time_played"])/($opponentlist[$i]["games_played"] + $data[$i]["Games Played"]);
							$data[$i]["Games Played"] += $opponentlist[$i]["games_played"];
							$data[$i]["Opponent Games Won"] += $opponentlist[$i]["opponent_games_won"];
							$data[$i]["Player Games Won"] += $opponentlist[$i]["player_games_won"];
							$data[$i]["Sessions Played"] += $opponentlist[$i]["sessions_played"];
							$data[$i]["Opponent Sessions Won"] += $opponentlist[$i]["opponent_sessions_won"];
							$data[$i]["Player Sessions Won"] += $opponentlist[$i]["player_sessions_won"];
							$data[$i]["Opponent Real Bet"] += $opponentlist[$i]["opponent_real_bet"];
							$data[$i]["Opponent Bonus Bet"] += $opponentlist[$i]["opponent_bonus_bet"];
							$data[$i]["Opponent Real Won"] += $opponentlist[$i]["opponent_real_winnings"];
							$data[$i]["Opponent Bonus Won"] += $opponentlist[$i]["opponent_bonus_winnings"];
							$data[$i]["Player Real Bet"] += $opponentlist[$i]["player_real_bet"];
							$data[$i]["Player Bonus Bet"] += $opponentlist[$i]["player_bonus_bet"];
							$data[$i]["Player Real Won"] += $opponentlist[$i]["player_real_winnings"];
							$data[$i]["Player Bonus Won"] += $opponentlist[$i]["player_bonus_winnings"];
						}
					
					
						$opponentsdetailsobj->updateopponentsdetails($playerId,$data , $now);
						//Zenfox_Debug::dump($data , 'DATA3');exit;
					}
					else 
					{
						$opponentsdetailsobj->insertopponentdetails($playerId , $data , $now);
					}
				}
			}
		}
			set_time_limit(600);
			
				$allopponentslist = $opponentsdetailsobj->getopponentslist($playerId);
				
			//	Zenfox_Debug::dump($allopponentslist,"data");exit;
				$length = count($allopponentslist);
				
				$playerdata = array();
				$opponentsdata = array();
				for($i=0;$i<$length;$i++)
				{
					if($allopponentslist[$i]["opponent_id"] != $playerId)
					{
						if($opponentId != $allopponentslist[$i]["opponent_id"])
						{
							$opponentId = $allopponentslist[$i]["opponent_id"];
							$opponentsdata[$i]["OPPONENT ID"] = $allopponentslist[$i]["opponent_id"];
						
							$playerdetails = $accountdetailsobj->getDetails($allopponentslist[$i]["opponent_id"]);
							$opponentsdata[$i]["LOGIN NAME '(no of Deposits)'"] = $playerdetails["login"]."(".$playerdetails["noof_deposits"].")";
						}
						else 
						{
							$opponentsdata[$i]["OPPONENT ID"] = "";
							$opponentsdata[$i]["LOGIN NAME '(no of Deposits)'"] = "";
						}
					
						$opponentsdata[$i]["Game Flavour"] = $allopponentslist[$i]["game_flavour"];
					
						$opponentsdata[$i]["Sessions Played"] = $allopponentslist[$i]["sessions_played"];
						$opponentsdata[$i]["Opponent Sessions Won"] = $allopponentslist[$i]["opponent_sessions_won"];
						$opponentsdata[$i]["Player Sessions Won"] = $allopponentslist[$i]["player_sessions_won"];
					
					
						$opponentsdata[$i]["Games Played"] = $allopponentslist[$i]["games_played"];
						$opponentsdata[$i]["Opponent Games Won"] = $allopponentslist[$i]["opponent_games_won"];
						$opponentsdata[$i]["Player Games Won"] = $allopponentslist[$i]["player_games_won"];
					
						$opponentsdata[$i]["Opponent Real Bet"] = $allopponentslist[$i]["opponent_real_bet"];
						$opponentsdata[$i]["Opponent Bonus Bet"] = $allopponentslist[$i]["opponent_bonus_bet"];
					
						$opponentsdata[$i]["Player Real Bet"] = $allopponentslist[$i]["player_real_bet"];
						$opponentsdata[$i]["Player Bonus Bet"] = $allopponentslist[$i]["player_bonus_bet"];
					
						$opponentsdata[$i]["Opponent Real Won"] = $allopponentslist[$i]["opponent_real_winnings"];
						$opponentsdata[$i]["Opponent Bonus Won"] = $allopponentslist[$i]["opponent_bonus_winnings"];
										
						$opponentsdata[$i]["Player Real Won"] = $allopponentslist[$i]["player_real_winnings"];
						$opponentsdata[$i]["Player Bonus Won"] = $allopponentslist[$i]["player_bonus_winnings"];
						if($opponentsdata[$i]["Games Played"] == 0)
						{
							$opponentsdata[$i]["Average Game Time(min)"] = 0;
						}
						else 
						{
							$opponentsdata[$i]["Average Game Time(min)"] =  $allopponentslist[$i]["total_time_played"]/$allopponentslist[$i]["games_played"];
						}
					}
					elseif($allopponentslist[$i]["opponent_id"] == $playerId)
					{
						
						$playerdata[$i]["Game Flavour"] = $allopponentslist[$i]["game_flavour"];
					
						$playerdata[$i]["Sessions Played"] = $allopponentslist[$i]["sessions_played"];
						$playerdata[$i]["Sessions Won"] = $allopponentslist[$i]["player_sessions_won"];
						$playerdata[$i]["Games Played"] = $allopponentslist[$i]["games_played"];
						$playerdata[$i]["Games Won"] = $allopponentslist[$i]["player_games_won"];
						$playerdata[$i]["Player Real Bet"] = $allopponentslist[$i]["player_real_bet"];
						$playerdata[$i]["Player Bonus Bet"] = $allopponentslist[$i]["player_bonus_bet"];
						$playerdata[$i]["Player Real Won"] = $allopponentslist[$i]["player_real_winnings"];
						$playerdata[$i]["Player Bonus Won"] = $allopponentslist[$i]["player_bonus_winnings"];
						if($playerdata[$i]["Games Played"] == 0)
						{
							$playerdata[$i]["Average Game Time(min)"] = 0;
						}
						else 
						{
							$playerdata[$i]["Average Game Time(min)"] = $allopponentslist[$i]["total_time_played"]/$allopponentslist[$i]["games_played"];
						}		
					}
				}

				//Zenfox_Debug::dump($opponentsdata);exit;
			//	$this->view->realplayerslist = $opponentsdata;
			//	$this->view->playerdata = $playerdata;
				
				$mydetails[0]["Total Unique Opponents Count"] = ($length/3)-1;
				//$this->view->mydetails = $mydetails;
				
				$fraudcheckreport = array();
				
				$fraudcheckreport["mydetails"] = $mydetails;
				$fraudcheckreport["rake"] = $rake;
				$fraudcheckreport["playerdata"] = $playerdata;
				$fraudcheckreport["realplayerslist"] = $opponentsdata;
				
		return $fraudcheckreport;
		
	}	
}

