<?php
class AffiliateFrontendConfig extends Doctrine_Record
{
	public function insertData($data)
	{
		$conn = Zenfox_Partition::getInstance()->getConnections(0);
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$frntendIds = $this->addCommas($data['allowedFrontendIds']);
		$affFrntendIds = $this->addCommas($data['affiliateAllowedFrontendIds']);
		
		$affFrontend = new AffiliateFrontend();
		
		$affFrontend->name = $data['name'];
		$affFrontend->description = $data['description'];
		$affFrontend->affiliate_allowed_frontend_ids = $affFrntendIds;
		$affFrontend->allowed_frontend_ids = $frntendIds;
		$affFrontend->default_affiliate_scheme_id = $data['defaultAffiliateSchemeId'];
		
		$affFrontend->save();
		
		return true;
	}
	
	public function updateData($id,$data)
	{
		$conn = Zenfox_Partition::getInstance()->getConnections(0);
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$frntendIds = $this->addCommas($data['allowedFrontendIds']);
		$affFrntendIds = $this->addCommas($data['affiliateAllowedFrontendIds']);
		
		$affFrontend = Doctrine::getTable('AffiliateFrontend')->findOneById($id);
		$affFrontend->name = $data['name'];
		$affFrontend->description = $data['description'];
		$affFrontend->affiliate_allowed_frontend_ids = $affFrntendIds;
		$affFrontend->allowed_frontend_ids = $frntendIds;
		$affFrontend->default_affiliate_scheme_id = $data['defaultAffiliateSchemeId'];
		
		$affFrontend->save();
		
		return true;
		
	}
	
	public function addCommas($values)
	{
		$string = '';
		foreach($values as $value)
		{
			if($string == '')
			{
				$string = $string.$value;
			}
			else
			{
				$string = $string.','.$value;
			}	
		}
		return $string;
	}
}
