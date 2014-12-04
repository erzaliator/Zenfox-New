<?php
class AmsSchemeTypeConfig extends Doctrine_Record
{
	public function insertAmsSchemeType($data)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$amsSchemeType = new AmsSchemeType();
		$amsSchemeType->scheme_type = $data['schemeType'];
		$amsSchemeType->scheme_name = $data['schemeName'];
		$amsSchemeType->scheme_description = $data['schemeDescription'];
		$amsSchemeType->criteria = $data['criteria'];
		$amsSchemeType->crediting_factor = $data['creditingFactor'];
		$amsSchemeType->save();
	}
	
	public function updateAmsSchemeType($id, $data)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$amsSchemeType = Doctrine::getTable('AmsSchemeType')->findOneByScheme_type($id);
		$amsSchemeType->scheme_type = $data['schemeType'];
		$amsSchemeType->scheme_name = $data['schemeName'];
		$amsSchemeType->scheme_description = $data['schemeDescription'];
		$amsSchemeType->criteria = $data['criteria'];
		$amsSchemeType->crediting_factor = $data['creditingFactor'];
		$amsSchemeType->save();
	}
}