<?php
class Admin_FixedPotForm extends Zend_Form
{
	public function getForm()
	{
		$fixedPotForm = new Zend_Form_SubForm();
		
		$fixedPotId = $fixedPotForm->createElement('hidden', 'fixedPotId');
			
		$partId = $fixedPotForm->createElement('text', 'partId');
		$partId->setLabel('Part Id')
			->addValidator('Digits');
			
		$callNumber = $fixedPotForm->createElement('text', 'callNumber');
		$callNumber->setLabel('Call Number')
				->addValidator('Digits');
				
		$realAmount = $fixedPotForm->createElement('text', 'realAmount');
		$realAmount->setLabel('Real Amount');
		
		$bbsAmount = $fixedPotForm->createElement('text', 'bbsAmount');
		$bbsAmount->setLabel('Bonus Amount');
			
		$fixedPotForm->addElements(array(
						$fixedPotId,
						$partId,
						$callNumber,
						$realAmount,
						$bbsAmount));
						
		$fixedPotForm->setAttrib('id', 'admin-fixed-pot-form');
						
		return $fixedPotForm;
	}
	
	public function setForm($form, $data)
	{
		if($data['fixedPotId'])
		{
			$form->fixedPotId->setValue($data['fixedPotId']);
		}
		$form->partId->setValue($data['partId']);
		$form->callNumber->setValue($data['callNumber']);
		$form->realAmount->setValue($data['realAmount']);
		$form->bbsAmount->setValue($data['bbsAmount']);
		
		return $form;
	}
}