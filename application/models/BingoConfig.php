<?php
class BingoConfig extends Doctrine_Record
{
	public function __construct()
	{
		parent::__construct();
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
	}
	public function insertData($data)
	{		
		
		//Zenfox_Debug::dump($data);exit;
		
		$bingo = new BingoGame();
		$bingo->name = $data['name'];
		$bingo->description = $data['description'];
		$bingo->game_flavour = $data['gameFlavour'];
		$bingo->game_type = $data['gameType'];
		$bingo->amount_type = $data['amountType'];
		$bingo->pot_type = $data['potType'];
		$bingo->pattern_id = $data['pattern'];
		$bingo->card_price = $data['cardPrice'];
		$bingo->min_cards = $data['minCards'];
		$bingo->max_cards = $data['maxCards'];
		$bingo->free_ratio = $data['freeRatio'];
		$bingo->buy_time = $data['buyTime']*1000;
		$bingo->call_delay = $data['callDelay']*1000;
		$bingo->pjp_enabled = $data['pjpEnabled'];
		$bingo->prebuy_enabled = $data['preBuyEnabled'];
		$bingo->real_return = $data['realReturn'];
		$bingo->bbs_return = $data['bbsReturn'];
		$bingo->min_variable_pot_real = $data['minPotReal'];
		$bingo->min_variable_pot_bbs = $data['minPotBbs'];
		$bingo->max_variable_pot_real = $data['maxPotReal'];
		$bingo->max_variable_pot_bbs = $data['maxPotBbs'];
		
		try
		{
			$bingo->save();
		}
		catch(Exception $e)
		{
			print('Unable to save Bingo data') . $e;
			exit();
		}
		
		if($data["pjpEnabled"] == "ENABLED")
		{
			$gameId = $data['gameId'];
		
			if(!$gameId)
			{
				$bingo1 = new BingoGame();
				$latestInsertedData = $bingo1->getLatestInsData();
				$gameId = $latestInsertedData[0]['id'];
			}
			$bingopjpobj = new BingoPjp();
			$bingopjpobj->game_id = $gameId;
			$bingopjpobj->pjp_id = $data['pjp'];
			$bingopjpobj->percent_real = $data['pjppercentReal'];
			$bingopjpobj->percent_bbs = $data['pjppercentBbs'];
			$bingopjpobj->part_id = 0;
			$bingopjpobj->max_no_of_calls = $data['pjpmaxcalls'];
			$bingopjpobj->fixed_amount_real = $data['pjpfixedReal'];
			$bingopjpobj->fixed_amount_bbs = $data['pjpfixedBbs'];
			
			try
			{
				$bingopjpobj->save();
			}
			catch(Exception $e)
			{
				print('Unable to save pjp data') . $e;
				exit();
			}
			
		}
		
		$index=0;
				
		if(is_array($data["category"]))
		{
			
			foreach($data["category"] as $categoryId)
			{
				$index++;
				$bingogamecategoryobj[$index] = new BingoGameCategory();
				
				$bingogamecategoryobj[$index]->category_id = $categoryId;
				$bingogamecategoryobj[$index]->game_id =  $gameId;
				
				
								
				try
				{
					$bingogamecategoryobj[$index]->save();
				}
				catch(Exception $e)
				{
					print('Unable to update categories') . $e;
					exit();
				}

				
			}
			
		}
		
		return true;
	}
	
	public function updateData($data)
	{
		
		//Zenfox_Debug::dump($data);exit;
		$query = Zenfox_Query::create()
					->update('BingoGame bg')
					->set('bg.name', '?', $data['name'])
					->set('bg.description', '?', $data['description'])
					->set('bg.game_flavour', '?', $data['gameFlavour'])
					->set('bg.game_type', '?', $data['gameType'])
					->set('bg.amount_type', '?', $data['amountType'])
					->set('bg.pot_type', '?', $data['potType'])
					->set('bg.pattern_id', '?', $data['pattern'])
					//->set('bg.no_of_parts', '?', $data['noOfParts'])
					->set('bg.card_price', '?', $data['cardPrice'])
					->set('bg.min_cards', '?', $data['minCards'])
					->set('bg.max_cards', '?', $data['maxCards'])
					->set('bg.free_ratio', '?', $data['freeRatio'])
					->set('bg.buy_time', '?', $data['buyTime']*1000)
					->set('bg.call_delay', '?', $data['callDelay']*1000)
					->set('bg.pjp_enabled', '?', $data['pjpEnabled'])
					->set('bg.prebuy_enabled', '?', $data['preBuyEnabled'])
					->set('bg.real_return', '?', $data['realReturn'])
					->set('bg.bbs_return', '?', $data['bbsReturn'])
					->set('bg.min_variable_pot_real', '?', $data['minPotReal'])
					->set('bg.min_variable_pot_bbs', '?', $data['minPotBbs'])
					->set('bg.max_variable_pot_real', '?', $data['maxPotReal'])
					->set('bg.max_variable_pot_bbs', '?', $data['maxPotBbs'])
					->where('bg.id = ?', $data['bingoGameId']);
					
		try
		{
			$query->execute();
		}
		catch(Exception $e)
		{
			print('Unable to update Bingo data') . $e;
			exit();
		}
		
		$bingopjpobj = new BingoPjp();
		$pjpdata = $bingopjpobj->getPjpDataByGameId($data['bingoGameId']);
		
		if($pjpdata)
		{
			if($data["pjpEnabled"] == "ENABLED")
			{
		
				$query = Zenfox_Query::create()
					->update('BingoPjp bp')
					->set('bp.pjp_id', '?', $data['pjp'])
					->set('bp.percent_real', '?', $data['pjppercentReal'])
					->set('bp.percent_bbs', '?', $data['pjppercentBbs'])
					->set('bp.max_no_of_calls', '?', $data['pjpmaxcalls'])
					->set('bp.fixed_amount_real', '?', $data['pjpfixedReal'])
					->set('bp.fixed_amount_bbs', '?', $data['pjpfixedBbs'])
					->where('bp.game_id = ?', $data['bingoGameId']);
			
			
				try
				{
					$query->execute();
				}
				catch(Exception $e)
				{
					print('Unable to update PJP data') . $e;
					exit();
				}
			
			}
			else 
			{
				$query = Zenfox_Query::create()
					->delete('BingoPjp bp')
					->where('bp.game_id = ?', $data['bingoGameId']);
					
				try
				{
					$query->execute();
				}
				catch(Exception $e)
				{
					print('Unable to update PJP data') . $e;
					exit();
				}
					
			}
		}
		else
		{
			if($data["pjpEnabled"] == "ENABLED")
			{
		
				$bingopjpobj->game_id = $data['bingoGameId'];
				$bingopjpobj->pjp_id = $data['pjp'];
				$bingopjpobj->percent_real = $data['pjppercentReal'];
				$bingopjpobj->percent_bbs = $data['pjppercentBbs'];
				$bingopjpobj->part_id = 0;
				$bingopjpobj->max_no_of_calls = $data['pjpmaxcalls'];
				$bingopjpobj->fixed_amount_real = $data['pjpfixedReal'];
				$bingopjpobj->fixed_amount_bbs = $data['pjpfixedBbs'];
			
			
				try
				{
					$bingopjpobj->save();
				}
				catch(Exception $e)
				{
					print('Unable to update PJP data') . $e;
					exit();
				}
			
			}
			
		}
		
		
		
		$index=0;
		$bingogamecategoryobj[$index] = new BingoGameCategory();
		$bingogamecategoryobj[$index]->deletecategoriesbygameId($data['bingoGameId']);
		
		if(is_array($data["category"]))
		{
			
			foreach($data["category"] as $categoryId)
			{
				$index++;
				$bingogamecategoryobj[$index] = new BingoGameCategory();
				
				$bingogamecategoryobj[$index]->category_id = $categoryId;
				$bingogamecategoryobj[$index]->game_id =  $data['bingoGameId'];
				
				
								
				try
				{
					$bingogamecategoryobj[$index]->save();
				}
				catch(Exception $e)
				{
					print('Unable to update categories') . $e;
					exit();
				}

				
			}
			
		}
		
		return true;
	}
}
