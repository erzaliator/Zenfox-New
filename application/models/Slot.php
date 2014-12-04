<?php
/**
 * This class implements all slot table operations
 * @author nikhil
 * @date January 9, 2010
 */
class Slot extends BaseSlot
{
	/**
	 * This function is used to get all slots details
	 * @return array
	 */
	public function getAllSlotsDetails()
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('Slot');
		
		$result = $query->fetchArray();
		return $result;
	}
	
	/**
	 * This function is used to get the slot details for selected id
	 * @param $machineId
	 * @return array
	 */
	public function getSlotDetails($machineId)
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$result = Doctrine::getTable('Slot')->findOneByMachineId($machineId);
		return $result;
	}
	
	public function getGameFlavour($machineId)
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
						->select('s.game_flavour')
						->from('Slot s')
						->where('s.machine_id = ?', $machineId);
						
		$result = $query->fetchArray();
		return $result[0]['game_flavour'];
	}
	
	public function getFilesPathFromId($id)
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		try
		{
			$result = Doctrine::getTable('Slot')->findOneByMachine_id($id);
		}
		catch(Exception $e)
		{
			return false;
		}
		return array(
			'configFile' => $result['config_file'],
			'swfFile' => $result['swf_file']
		);
	}
}