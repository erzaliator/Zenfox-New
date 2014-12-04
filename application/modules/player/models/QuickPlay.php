<?php
class QuickPlay
{
	public function getFirstRoom()
	{
		$machineId = 2;
		$flavour = 'Indian_Rummy';
		$amountType = 'BONUS';
		
		return array(
			'machineId' => $machineId,
			'flavour' => $flavour,
			'amountType' => $amountType
		);
	}
}