<?php

/**
 * BingoGamelogPlayer
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
class BingoGamelogPlayer extends BaseBingoGamelogPlayer
{
	public function getBingoLogs($playerId, $itemsPerPage, $offset, $fromDate = NULL, $toDate = NULL)
	{
		$conn = Zenfox_Partition::getInstance()->getConnections($playerId);
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = "Zenfox_Query::create()
					->from('BingoGamelogPlayer bgp')
					->where('bgp.player_id = ?', '$playerId')
					->andWhere('bgp.start_time BETWEEN ? AND ?', array('$fromDate', '$toDate'))
					->orderBy('bgp.start_time desc')";
		
		
		try
		{
			$adapter = new Zenfox_Paginator_Adapter_DoctrineQuery($query, $playerId);
			$paginatorSession = new Zend_Session_Namespace('paginationCount');
			$paginatorSession->value = false;
			$paginator =  new Zend_Paginator($adapter);
			$paginator->setItemCountPerPage($itemsPerPage);
			$paginator->setPageRange(2);
			$paginator->setCurrentPageNumber($offset);
		}
		catch(Exception $e)
		{
			Zenfox_Debug::dump($e, 'ex');
		}
		$bingoLogs = array();
		if($paginator->getTotalItemCount())
		{
			$index = 0;
			foreach($paginator as $logs)
			{
				switch($logs['game_flavour'])
				{
					case '90':
						$description = "90 Ball Bingo";
						break;
					case '75':
						$description = "75 Ball Bingo";
						break;
				}
				
				switch($logs['amount_type'])
				{
					case 'REAL':
						$amount = $logs['real_spent'];
						break;
					case 'BONUS':
						$amount = $logs['bbs_spent'];
						break;
					case 'BOTH':
						$amount = $logs['real_spent'] + $logs['bbs_spent'];
						break;
				}
				$bingoLogs[$index]['Game Id'] = $logs['gamelog_id'];
				$bingoLogs[$index]['Description'] = $description;
				$bingoLogs[$index]['Amount'] = $amount;
				$bingoLogs[$index]['Amount Type'] = $logs['amount_type'];
				$bingoLogs[$index]['Game Type'] = $logs['game_type'];
				$bingoLogs[$index]['Date'] = $logs['start_time'];
				//$bingoLogs[$index]['Outcome'] = "";
				$index++;
			}
		}
		return array(
			'paginator' => $paginator,
			'gamelogs' => $bingoLogs
		);
	}
}
