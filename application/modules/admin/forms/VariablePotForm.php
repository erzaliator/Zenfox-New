<?php
class Admin_VariablePotForm extends Zend_Form
{	
	public function getForm()
	{
		$variablePotForm = new Zend_Form_SubForm();
		
		$varPotId = $variablePotForm->createElement('hidden', 'varPotId');
		
		$partId = $variablePotForm->createElement('text', 'partId');
		$partId->setLabel('Part Id')
				->addValidator('Digits');
				
		$realReturn = $variablePotForm->createElement('text', 'realReturn');
		$realReturn->setLabel('Real Return');
				
		$bbsReturn = $variablePotForm->createElement('text', 'bbsReturn');
		$bbsReturn->setLabel('Bonus Return');
				
		
		$ntogo = $variablePotForm->createElement('text', 'ntogo');
		$ntogo->setLabel('ntogo( only "0" for now)')
				->setValue('0');
		
		
		$variablePotForm->addElements(array(
						$varPotId,
						$partId,
						$realReturn,
						$bbsReturn,
						$ntogo));
						
		$variablePotForm->setAttrib('id', 'admin-variable-pot-form');
						
		return $variablePotForm;
	}
	
	/*public function setForm($data)
	{
		$variablePotForm = new Zend_Form_SubForm();
		$gameId = $variablePotForm->createElement('text', 'gameId');
		$gameId->setLabel('Game Id')
				->setValue($data['gameId'])
				->addValidator('Digits');
				
		$partId = $variablePotForm->createElement('text', 'partId');
		$partId->setLabel('Part Id')
				->setValue($data['partId'])
				->addValidator('Digits');
				
		$realReturn = $variablePotForm->createElement('text', 'realReturn');
		$realReturn->setLabel('Real Return *')
				->setValue($data['realReturn']);
				
		$bbsReturn = $variablePotForm->createElement('text', 'bbsReturn');
		$bbsReturn->setLabel('Bonus Return *')
				->setValue($data['bbsReturn']);
				
		$minPotReal = $variablePotForm->createElement('text', 'minPotReal');
		$minPotReal->setLabel('Minimum Real Pot *')
				->setValue($data['minPotReal']);
				
		$minPotBbs = $variablePotForm->createElement('text', 'minPotBbs');
		$minPotBbs->setLabel('Minimum Bonus Pot *')
				->setValue($data['minPotBbs']);
				
		$maxPotReal = $variablePotForm->createElement('text', 'maxPotReal');
		$maxPotReal->setLabel('Maximum Real Pot *')
				->setValue($data['maxPotReal']);
				
		$maxPotBbs = $variablePotForm->createElement('text', 'maxPotBbs');
		$maxPotBbs->setLabel('Maximum Bonus Pot *')
				->setValue($data['maxPotBbs']);
				
		
		
		$variablePotForm->addElements(array(
						$gameId,
						$partId,
						$realReturn,
						$bbsReturn,
						$minPotReal,
						$minPotBbs,
						$maxPotReal,
						$maxPotBbs));
						
		return $variablePotForm;
	}*/
	
	public function setForm($form, $data)
	{
		if($data['varPotId'])
		{
			$form->varPotId->setValue($data['varPotId']);
		}
		$form->partId->setValue($data['partId']);
		$form->realReturn->setValue($data['realReturn']);
		$form->bbsReturn->setValue($data['bbsReturn']);
		
		
		return $form;
	}
}