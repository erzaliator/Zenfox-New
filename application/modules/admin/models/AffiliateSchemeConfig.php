<?php
class AffiliateSchemeConfig extends Doctrine_Record
{
	public function insertScheme($data)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		$affiliateScheme = new AffiliateScheme();
		$affiliateScheme->name = $data['name'];
		$affiliateScheme->description = $data['description'];
		$affiliateScheme->note = $data['note'];
		$affiliateScheme->save();
		
		$affiliateSchemeDef = new AffiliateSchemeDef();
		$result = $affiliateSchemeDef->createSchemeDef($data);
	}
	
	public function updateScheme($id, $data)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$affiliateScheme = Doctrine::getTable('AffiliateScheme')->findOneById($id);
		$affiliateScheme->name = $data['name'];
		$affiliateScheme->description = $data['description'];
		$affiliateScheme->note = $data['note'];
		$affiliateScheme->save();
	}
}