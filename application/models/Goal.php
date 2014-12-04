<?php
class Goal
{
	public function createGoals($goalArray, $idSite)
	{
		$goals = new Piwik_Goals_API();
		foreach($goalArray as $goal)
		{
			switch($goal)
			{
				case 'No Of Depositors':
					$goals->addGoal($idSite, 'No Of Depositors', 'url', 'banking/index', 'contains');
					break;
				case 'Registrations':
					$goals->addGoal($idSite, 'Registrations', 'url', 'auth/confirm', 'contains');
					break;
			}
		}
	}
}