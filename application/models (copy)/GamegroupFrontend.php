<?php
/*
 * This class gets all the details of all the groups that are associated with the selected
 * frontendId.
 */
class GamegroupFrontend extends BaseGamegroupFrontend
{
    public function getAllGroups($frontendId, $partitionKey)
    {
//        $connName = Zenfox_Partition::getInstance()->getConnections($partitionKey);
	if($partitionKey == -1)
        {
        	$connName = Zenfox_Partition::getInstance()->getCommonConnection();
        }
        else
        {
        	$connName = Zenfox_Partition::getInstance()->getConnections(0);
        }
        Doctrine_Manager::getInstance()->setCurrentConnection($connName);
      
        $query = Zenfox_Query::create()
                    ->from('GamegroupFrontend gf')
                    ->where('gf.frontend_id = ? ', $frontendId);
       
        try
        {
            $result = $query->fetchArray();
        }
        catch(Exception $e)
        {
            return false;
        }
        if($result)
        {
        	//$groups = array();
	        //Getting the group details one by one from Gamegroup and then merging all the details.
	        $gameGroup = new Gamegroup();
	        $temp = 0;
	        foreach($result as $group)
	        {
			if($group['gamegroup_id'] != 1)
			{
				$groups[$group['gamegroup_id']] = $gameGroup->getGroupDetails($group['gamegroup_id']);
		                if($groups[$group['gamegroup_id']])
                		{
	                        	$temp++;
        	            	}
			}
	        }
	    	if(!$temp)
	        {
	        	return false;
	        }
	        //Save game group details in cache
	        if(Zend_Registry::getInstance()->isRegistered('Cache'))
	        {
	            $cache = Zend_Registry::getInstance()->get('Cache');
	            $key = 'gameGroup_' . $frontendId;
	            $json = Zend_Json::encode($groups);
	            $cache->save($json, $key);           
	        }
	        /*echo '<pre>';
	        foreach($groups as $gameGroup)
	        {
	            Zenfox_Debug::dump(print_r($gameGroup), 'groups');
	        }
	        exit();*/
	        return $groups;
        }
        return NULL;
    }
}
