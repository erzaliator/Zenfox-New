<?php
class BonusConfiguration extends Doctrine_Record
{
	public function __construct()
	{
		parent::__construct();
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
	}
	public function insertSchemeData($data)
	{	
		$bonusScheme = new BonusScheme();
		$bonusScheme->name = $data['name'];
		$bonusScheme->description = $data['description'];
		/*echo "in inserting scheme";
		Zenfox_Debug::dump($data, 'schemeData');*/
		try
		{
			$bonusScheme->save();
		}
		catch(Exception $e)
		{
			print('Unable to save data in Bonus Scheme') . $e;
			exit();
		}
		$bonusScheme = new BonusScheme();
		$schemeId = $bonusScheme->getSchemeId();
		return $schemeId;
	}
	public function updateSchemeData($data)
	{
		$query = Zenfox_Query::create()
						->update('BonusScheme b')
						->set('b.name', '?', $data['name'])
						->set('b.description', '?', $data['description'])
						->where('b.scheme_id = ? ', $data['schemeId']);

		try
		{
			$query->execute();
		}
		catch(Exception $e)
		{
			print('Unable to update data in Bonus Scheme') . $e;
			exit();
		}
		/*echo "in updating scheme";
		Zenfox_Debug::dump($data, 'schemeData');*/
		return true;
	}
	
	public function insertLevelData($data)
	{
		//Zenfox_Debug::dump($data, 'level', true, true);
		$bonusLevel = new BonusLevel();
		/*echo "in inserting level";
		Zenfox_Debug::dump($data, 'levelData');*/
		try
		{
			$bonusLevel->scheme_id = $data['schemeId'];
			$bonusLevel->level_name = $data['levelName'];
			$bonusLevel->min_points = $data['minPoints'];
			$bonusLevel->max_points = $data['maxPoints'];
			$bonusLevel->bonus_percentage = $data['bonusPercent'];
			$bonusLevel->fixed_bonus = $data['fixedBonus'];
			$bonusLevel->min_deposit = $data['minDeposit'];
			$bonusLevel->min_total_deposit = $data['minTotalDeposit'];
			$bonusLevel->reward_times = $data['rewardTimes'];
			$bonusLevel->description = $data['description'];
			$bonusLevel->fixed_real = $data['fixedReal'];
			$bonusLevel->save();
		}
		catch(Exception $e)
		{
			print('Unable to save data in Bonus Level') . $e;
			exit();
		}
		$bonusLevel = new BonusLevel();
		$levelId = $bonusLevel->getLevelId();
		return $levelId;
	}
	
	public function updateLevelData($data, $schemeId)
	{
		$query = Zenfox_Query::create()
						->update('BonusLevel bl')
						->set('bl.level_name', '?', $data['levelName'])
						->set('bl.min_points', '?', $data['minPoints'])
						->set('bl.max_points', '?', $data['maxPoints'])
						->set('bl.bonus_percentage', '?', $data['bonusPercent'])
						->set('bl.fixed_bonus', '?', $data['fixedBonus'])
						->set('bl.min_deposit', '?', $data['minDeposit'])
						->set('bl.min_total_deposit', '?', $data['minTotalDeposit'])
						->set('bl.reward_times', '?', $data['rewardTimes'])
						->set('bl.description', '?', $data['description'])
						->set('bl.fixed_real', '?', $data['fixedReal'])
						->where('bl.level_id = ? ', $data['levelId'])
						->andWhere('bl.scheme_id = ?', $schemeId);
						
		try
		{
			$query->execute();
		}
		catch(Exception $e)
		{
			return false;
			/* print('Unable to update data in Bonus Level') . $e;
			exit(); */
		}
		/*echo "in updating level";
		Zenfox_Debug::dump($data, 'levelData');*/
		return true;
	}
	
	public function insertLoyaltyData($data)
	{
		if($data['gameGroupId'])
		{
			$loyaltyFactor = new LoyaltyFactor();
			$loyaltyFactor->scheme_id = $data['schemeId'];
			$loyaltyFactor->level_id = $data['levelId'];
			$loyaltyFactor->gamegroup_id = $data['gameGroupId'];
			$loyaltyFactor->wager_factor = $data['wagerFactor'];
			$loyaltyFactor->loyalty_per_dollar = $data['loyaltyPerD'];
			try
			{
				$loyaltyFactor->save();
			}
			catch(Exception $e)
			{
				print('Unable to save Loyalty Data') . $e;
				exit();
			}
			/*echo "in inserting loyalty";
			Zenfox_Debug::dump($data, 'loyaltyData');*/
		}
		return true;
	}
	
	public function updateLoyaltyData($data)
	{
		$query = Zenfox_Query::create()
						->update('LoyaltyFactor lf')
						->set('lf.scheme_id', '?', $data['schemeId'])
						->set('lf.level_id', '?', $data['levelId'])
						->set('lf.gamegroup_id', '?', $data['gameGroupId'])
						->set('lf.wager_factor', '?', $data['wagerFactor'])
						->set('lf.loyalty_per_dollar', '?', $data['loyaltyPerD'])
						->where('lf.id = ?', $data['loyaltyFactorId']);
		try
		{
			$query->execute();
		}
		catch(Exception $e)
		{
			print('Unable to update loyalty factor') . $e;
			exit();
		}
		/*echo "in updating loyalty";
		Zenfox_Debug::dump($data, 'loyaltyData');*/
		return true;
	}
}