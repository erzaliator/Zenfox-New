<?php
class Admin_RummyConfigMainForm extends Zend_Form
{
	public function getForm()
	{
		$rummyConfig = new Zend_Form_SubForm();
		
		$gameFlavour = $rummyConfig->createElement('select', 'flavour');
		$gameFlavour->setLabel('Select Game Flavour');
		
		$tableConfig = new TableConfig();
		$tableConfigData = $tableConfig->getAllTableConfig();
		
		foreach($tableConfigData as $tableConfig)
		{
			$gameFlavour->addMultiOption($tableConfig['game_flavour'], $tableConfig['game_flavour']);
		}
		
		$tableConfigId = $rummyConfig->createElement('select', 'tableConfigId');
		$tableConfigId->setLabel('Select Table Config Id');
		
		foreach($tableConfigData as $tableConfig)
		{
			$tableConfigId->addMultiOption($tableConfig['table_config_id'], $tableConfig['table_name'] . '-' . $tableConfig['table_config_id']);
		}
		
		$noOfParts = $rummyConfig->createElement('hidden', 'noOfParts');
		
		$rummyConfig->addElements(array(
				$gameFlavour,
				$tableConfigId,
				$noOfParts
			));
			
		return $rummyConfig;
	}
	
	public function setForm($form, $data)
	{
		/*$gameFlavour = $form->createElement('select', 'flavour');
		$gameFlavour->setLabel('Select Game Flavour');*/
		
		foreach($data as $tableConfig)
		{
			$form->flavour->addMultiOption($tableConfig['game_flavour'], $tableConfig['game_flavour']);
		}
		
		/*$tableConfigId = $form->createElement('select', 'tableConfigId');
		$tableConfigId->setLabel('Select Table Config Id');*/
		
		foreach($data as $tableConfig)
		{
			$form->tableConfigId->addMultiOption($tableConfig['table_config_id'], $tableConfig['table_config_id']);
		}
		
		$form->noOfParts->setValue(1);
		/*$form->addElements(array(
				$gameFlavour,
				$tableConfigId,
			));*/
			
		return $form;
	}
}