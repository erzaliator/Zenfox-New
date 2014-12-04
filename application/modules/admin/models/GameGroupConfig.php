<?php
class GameGroupConfig extends Doctrine_Record
{
	public function insertGameGroup($data)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$gameGroup = new Gamegroup();
		$gameGroup->name = $data['name'];
		$gameGroup->description = $data['description'];
		$gameGroup->save();
	}
	
	public function insertGameGameGroup($gameFlavour,$runningMachineId,$gameGroupId)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$gameGameGroup = new GameGamegroup();
		$gameGameGroup->running_machine_id = $runningMachineId;
		$gameGameGroup->game_flavour = $gameFlavour;
		$gameGameGroup->gamegroup_id = $gameGroupId;
		$gameGameGroup->save();
	}
	
	public function updateGameGroup($id, $data)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$gameGroup = Doctrine::getTable('Gamegroup')->findOneById($id);
		$gameGroup->name = $data['name'];
		$gameGroup->description = $data['description'];
		
		$gameGroup->save();
	}
	
	public function deleteGameGameGroup($gameGroupId,$flavour,$runningMachineId)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->delete('GameGamegroup')
					->where('gamegroup_id = ?',$gameGroupId)
					->addWhere('game_flavour = ?',$flavour)
					->addWhere('running_machine_id = ?',$runningMachineId);
					
		$query->execute();
	}
}