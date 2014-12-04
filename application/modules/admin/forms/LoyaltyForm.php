<?php
class Admin_LoyaltyForm extends Zend_Form
{
	public function getForm($groupName, $groupId)
	{
		$loyaltyForm = new Zend_Form_SubForm();
		$loyaltyFactorId = $loyaltyForm->createElement('hidden', 'loyaltyFactorId');
		$group = $loyaltyForm->createElement('checkbox', 'gameGroupId');
		$group->setLabel($groupName)
			->setCheckedValue($groupId);
		$wagerFactor = $loyaltyForm->createElement('text', 'wagerFactor');
		$wagerFactor->setLabel('Wager Factor');
		$loyaltyPerD = $loyaltyForm->createElement('text', 'loyaltyPerD');
		$loyaltyPerD->setLabel('Loyalty Per Doller');
		$loyaltyForm->addElements(array(
							$loyaltyFactorId,
							$group,
							$wagerFactor,
							$loyaltyPerD));
							
		$loyaltyForm->setAttrib('id', 'admin-loyalty-form');
		return $loyaltyForm;
	}
	
	public function setForm($form, $data)
	{
		if($data['loyaltyFactorId'])
		{
			$form->loyaltyFactorId->setValue($data['loyaltyFactorId']);
		}
		$form->gameGroupId->setValue($data['gameGroupId']);
		$form->wagerFactor->setValue($data['wagerFactor']);
		$form->loyaltyPerD->setValue($data['loyaltyPerD']);
		return $form;
	}
}