<?php
class Zenfox_Controller_Plugin_BonusScheme extends Zend_Controller_Plugin_Abstract
{
	private $_login;
	private $_playerId;
	public function __construct($playerId)
	{
		$this->_playerId = $playerId;
	}
	public function dispatchLoopShutdown()
	{
		$error = false;
		$player = new Player();
		$playerId = $this->_playerId;
		if(!$playerId)
		{
			$error = true;
		}
//		echo "playerId-". $playerId;
		$frontendId = Zend_Registry::get('frontendId');
		$frontend = new Frontend();
		if(!$schemeId = $frontend->getBonusSchemeId($frontendId))
		{
			$error = true;
		}
		$bonusLevel = new BonusLevel();
		if(!$amount = $bonusLevel->getAmount($schemeId, -1))
		{
			$error = true;
		}
//		Zenfox_Debug::dump($amount, 'amount', true, true);
		$accountDetail = $player->getAccountDetails($playerId);
		$baseCurrency = $accountDetail[0]['base_currency'];
		$playerTransaction = new PlayerTransactions();
		if(!$playerTransaction->creditBonus($playerId, $amount['bonus'], $baseCurrency))
		{
			$error = true;
		}

		$data['playerId'] = $playerId;
		$data['variableName'] = 'freeMoney';
		$data['variableValue'] = 5000;		
		$accountVariable = new AccountVariable();
		if(!$accountVariable->insert($data))
		{
			$error = true;
		}
		
		if(isset($accountDetail[0]['buddy_id']))
		{
			$data['playerId'] = $playerId;
			$data['variableName'] = 'is-credited-master';
			$data['variableValue'] = 0;
			/* $conn = Zenfox_Partition::getInstance()->getMasterConnection();
			Doctrine_Manager::getInstance()->setCurrentConnection($conn); */
			$accountVariable = new AccountVariable();
			$accountVariable->insert($data);
		}

		if($error)
		{
			$filePath = '/home/zenfox/backup_player/error_logs.txt';
			$fh = fopen($filePath, 'a');
			fwrite($fh, "Error in plugin for playerId -> " . $playerId);
			fclose($fh);
			
			$registration = new Registration();
			$registration->joiningBonus($this->_login);
			//throw new Zenfox_Exception();
		}
		return true;
	}
}
