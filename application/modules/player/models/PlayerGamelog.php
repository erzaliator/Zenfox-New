<?php

/**
 * PlayerGamelog
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
class PlayerGamelog extends BasePlayerGamelog
{	
	public function getPlayerGamelogDetails($playerId, $itemsPerPage, $offset = 0, $fromDateTime = NULL, $toDateTime = NULL)
	{
		$allResults = array();

		$query = "Zenfox_Query::create()
						->from('PlayerGamelog pg')
						->where('pg.player_id = ?', '$playerId')
						->andWhere('pg.start_time BETWEEN ? AND ?', array('$fromDateTime', '$toDateTime'))";
		
		$adapter = new Zenfox_Paginator_Adapter_DoctrineQuery($query, $playerId);
		$paginatorSession = new Zend_Session_Namespace('paginationCount');
		$paginatorSession->value = false;
		$paginator =  new Zend_Paginator($adapter);
		$paginator->setItemCountPerPage($itemsPerPage);
		$paginator->setPageRange(2);
		$paginator->setCurrentPageNumber($offset);
		$translate = Zend_Registry::get('Zend_Translate');
		$date = new Zenfox_Date();
		$currency = new Zenfox_Currency();
		$playerGameLogs = array();
		$index = 0;

		if($paginator->getTotalItemCount())
		{
			foreach($paginator as $logs)
			{
				$playerGameLogs[$index][$translate->translate('Gamelog Id')] = $logs['session_id'] . '-' . $logs['game_id'] . '-' . $logs['game_flavour'];
				$playerGameLogs[$index][$translate->translate('Currency')] = $logs['currency'];
				$playerGameLogs[$index][$translate->translate('Real Bet Amount')] = $currency->setCurrency($logs['currency'], $logs['real_bet']);
				$playerGameLogs[$index][$translate->translate('Bonus Bet Amount')] = $currency->setCurrency($logs['currency'], $logs['bonus_bet']);
				$playerGameLogs[$index][$translate->translate('Real Win Amount')] = $currency->setCurrency($logs['currency'], $logs['real_winnings']);
				$playerGameLogs[$index][$translate->translate('Bonus Win Amount')] = $currency->setCurrency($logs['currency'], $logs['bonus_winnings']);
				$playerGameLogs[$index][$translate->translate('Date & Time')] = $date->setDate($logs['start_time']);
				$playerGameLogs[$index][$translate->translate('Outcome')] = '';
				$index++;
			}
			$paginatorSession->unsetAll();
			return array($paginator, $playerGameLogs);
		}
		return NULL;
	}
}