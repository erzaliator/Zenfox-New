<?php

/**
 * TournamentFinalResults
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
class TournamentFinalResults extends BaseTournamentFinalResults
{
	public function getTournamentResult($tournamentId, $ranks)
	{
		$connections = Zenfox_Partition::getInstance()->getConnections(-1);
		$finalResult = array();
		foreach($connections as $conn)
		{
			Doctrine_Manager::getInstance()->setCurrentConnection($conn);
			$query = Zenfox_Query::create()
						->from('TournamentFinalResults tr')
						->where('tr.tournament_id = ?', $tournamentId)
						->andWhere('tr.rank <= ?', $ranks);
			
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
				foreach($result as $data)
				{
					$finalResult[] = $data;
				}
			}
		}
		return $finalResult;
	}
}