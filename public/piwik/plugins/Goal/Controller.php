<?php
class Piwik_Goal_Controller extends Piwik_Controller
{
	public function addGoal( $idSite, $name, $matchAttribute, $pattern, $patternType, $caseSensitive = false, $revenue = false)
	{
		// save in db
		$db = Zend_Registry::get('db');
		$idGoal = $db->fetchOne("SELECT max(idgoal) + 1 
								FROM ".Piwik_Common::prefixTable('goal')." 
								WHERE idsite = ?", $idSite);
		if($idGoal == false)
		{
			$idGoal = 1;
		}
		$db->insert(Piwik_Common::prefixTable('goal'),
					array( 
						'idsite' => $idSite,
						'idgoal' => $idGoal,
						'name' => $name,
						'match_attribute' => $matchAttribute,
						'pattern' => $pattern,
						'pattern_type' => $patternType,
						'case_sensitive' => (int)$caseSensitive,
						'revenue' => (float)$revenue,
						'deleted' => 0,
					));
		Piwik_Common::regenerateCacheWebsiteAttributes($idSite);
		return $idGoal;
	}
	
	public function getGoal($idSite, $pattern, $patternType)
	{
		$db = Zend_Registry::get('db');
		$idGoal = $db->fetchOne("SELECT idgoal 
								FROM ".Piwik_Common::prefixTable('goal')." 
								WHERE idsite = ?
									AND pattern = ?
										AND pattern_type = ?", array($idSite, $pattern, $patternType));
		return $idGoal;
	}
}