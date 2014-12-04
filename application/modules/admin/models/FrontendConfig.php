<?php
class FrontendConfig extends Doctrine_Record
{
	public function insertData($data)
	{
		$conn = Zenfox_Partition::getInstance()->getConnections(0);
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$ids = $this->addCommas($data['allowedFrontendIds']);
		$currencies = $this->addCommas($data['secondaryCurrencies']);
		
		$frontend = new Frontend();
		
		$frontend->name = $data['name'];
		$frontend->description = $data['description'];
		$frontend->site_code = $data['siteCode'];
		$frontend->contact = $data['contact'];
		$frontend->url = $data['url'];
		$frontend->ams_url = $data['amsUrl'];
		$frontend->gms_url = $data['gmsUrl'];
		$frontend->status = $data['status'];
		$frontend->affiliate_frontend_id = $data['affiliateFrontendId'];
		$frontend->allowed_frontend_ids = $ids;
		$frontend->default_currency = $data['defaultCurrency'];
		$frontend->secondary_currencies = $currencies;
		$frontend->default_bonus_scheme_id = $data['defaultBonusSchemeId'];
		
		$frontend->save();
		
		return true;
	}
	
	public function updateData($id,$data)
	{
		$conn = Zenfox_Partition::getInstance()->getConnections(0);
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$ids = $this->addCommas($data['allowedFrontendIds']);
		$currencies = $this->addCommas($data['secondaryCurrencies']);
		
		$frntend = Doctrine::getTable('Frontend')->findOneById($id);
		$frntend->name = $data['name'];
		$frntend->description = $data['description'];
		$frntend->site_code = $data['siteCode'];
		$frntend->contact = $data['contact'];
		$frntend->url = $data['url'];
		$frntend->ams_url = $data['amsUrl'];
		$frntend->gms_url = $data['gmsUrl'];
		$frntend->status = $data['status'];
		$frntend->affiliate_frontend_id = $data['affiliateFrontendId'];
		$frntend->allowed_frontend_ids = $ids;
		$frntend->default_currency = $data['defaultCurrency'];
		$frntend->secondary_currencies = $currencies;
		$frntend->default_bonus_scheme_id = $data['defaultBonusSchemeId'];
		$frntend->save();
		
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
