<?php
class Snapshot
{
	
	private $networkSnapshotTags = array(
	'networkRegistrationsDirect' => 'SUM',
	'networkRegistrationsAffiliates' => 'SUM',
	'networkRegistrationsBuddy' => 'SUM',
	'networkConversionToWagerersDirect' => 'SUM',
	'networkConversionToWagerersAffiliates' => 'SUM',
	'networkConversionToWagerersBuddy' => 'SUM',
	'networkConversionToDepositorsDirect' => 'SUM',
	'networkConversionToDepositorsAffiliates' => 'SUM',
	'networkConversionToDepositorsBuddy' => 'SUM',
	'networkDepositorsCount' => 'SUM',
	'networkDepositsCount' => 'SUM',
	'networkDepositsAmount' => 'SUM',
	'networkDepositsPerTransaction' => 'SUM',
	'networkDepositsPerPlayer' => 'SUM',
	'networkOneTimeDepositors' => 'SUM',
	'networkTwoToThreeTimeDepositors' => 'SUM',
	'networkFourToSixTimeDepositors' => 'SUM',
	'networkSevenOrMoreTimeDepositors' => 'SUM',
	);
	
	private $networkSnapshotTableOne = array(
	'networkRegistrationsDirect' => 'SUM',
	'networkRegistrationsAffiliates' => 'SUM',
	'networkRegistrationsBuddy' => 'SUM',
	'networkConversionToWagerersDirect' => 'SUM',
	'networkConversionToWagerersAffiliates' => 'SUM',
	'networkConversionToWagerersBuddy' => 'SUM',
	'networkConversionToDepositorsDirect' => 'SUM',
	'networkConversionToDepositorsAffiliates' => 'SUM',
	'networkConversionToDepositorsBuddy' => 'SUM',);
	
	private $networkSnapshotTableTwo = array(
	'networkDepositorsCount' => 'SUM',
	'networkDepositsCount' => 'SUM',
	'networkDepositsAmount' => 'SUM',
	'networkDepositsPerTransaction' => 'SUM',
	'networkDepositsPerPlayer' => 'SUM',);
	
	private $networkSnapshotTableThree = array(
	'networkOneTimeDepositors' => 'SUM',
	'networkTwoToThreeTimeDepositors' => 'SUM',
	'networkFourToSixTimeDepositors' => 'SUM',
	'networkSevenOrMoreTimeDepositors' => 'SUM',
	);
	
	private $networkSpecialAccumulationTags = array(
	'networkDepositorsCount' => 'INT',
	'networkDepositsPerPlayer' => 'JSON',
	); 
	
	private $networkJsonTags = array(
	'networkDepositorsCount',
	'networkDepositsCount',
	'networkDepositsAmount',
	'networkDepositsPerTransaction',
	'networkDepositsPerPlayer',
//	'networkAllDepositorsCount',
	'networkAllDepositsCount',
	'networkAllDepositsAmount',
	'networkAllDepositsPerTransaction',
	'networkAllDepositsPerPlayer',
	);
	
	
	
	
	private $frontendSnapshotTags = array(
	'frontendRegistrationsDirect' => 'SUM',
	'frontendRegistrationsAffiliates' => 'SUM',
	'frontendRegistrationsBuddy' => 'SUM',
	'frontendConversionToWagerersDirect' => 'SUM',
	'frontendConversionToWagerersAffiliates' => 'SUM',
	'frontendConversionToWagerersBuddy' => 'SUM',
	'frontendConversionToDepositorsDirect' => 'SUM',
	'frontendConversionToDepositorsAffiliates' => 'SUM',
	'frontendConversionToDepositorsBuddy' => 'SUM',
	'frontendDepositorsCount' => 'SUM',
	'frontendDepositsCount' => 'SUM',
	'frontendDepositsAmount' => 'SUM',
	'frontendDepositsPerTransaction' => 'SUM',
	'frontendDepositsPerPlayer' => 'SUM',
	);
	
	private $frontendJsonTags = array(
	'frontendDepositorsCount' => '1',
	'frontendDepositsCount' => '1',
	'frontendDepositsAmount' => '2',
	'frontendDepositsPerTransaction' => '2',
	'frontendDepositsPerPlayer' => '2',
	);
		
	
	public function getNetworkSnapShotTags()
	{
		return $this->networkSnapshotTags;
	}
	
	public function getNetworkJsonTags()
	{
		return $this->networkJsonTags;
	}
	
	public function isNetworkJsonTag($tag)
	{
		if(in_array($tag,$this->networkJsonTags) == true)
			return true;
		return false;	
	}
	
	public function isJsonTag($tag)
	{
		if(in_array($tag,$this->frontendJsonTags) == true || in_array($tag,$this->networkJsonTags) == true)
			return true;
		return false;	
	}
	
	public function getJsonType($tag)
	{
		return $this->networkJsonTags($tag);
	}
			
	public function isSpecialAccumulationTag($tag) {
		if(array_key_exists($tag,$this->networkSpecialAccumulationTags)) {
			return $this->networkSpecialAccumulationTags[$tag];
		}
		return false;
	}
	
	public function getSpecialAccumulationTags()
	{
		return $this->networkSpecialAccumulationTags;
	}
	
	
}