<?php
/**
 * This class is used to set and create new pjp form
 * @author Nikhil Gupta
 * @date January 2, 2010
 */
class Admin_BingoCategoryForm extends Zend_Form
{

	public function getForm($data)
	{
		$categoryId = $this->createElement('text', 'Id');
		$categoryId->setLabel($this->getView()->translate('Category Id'))
				->setValue($data["id"])
				->addValidator(new Zenfox_Validate_ModifyValidator($data["id"]))
				->setAttrib('disabled','true');

		if($data["id"])
		{
			$this->addElement($categoryId);
			
		}
		
				
		$categoryName = $this->createElement('text', 'Name');
		$categoryName->setLabel($this->getView()->translate('Category Name'))
				->setValue($data["name"])
				->setRequired(true);
		
		$description = $this->createElement('textarea', 'Description');
		$description->setLabel($this->getView()->translate('Description'))
				->setValue($data["description"]);
				
				
		$pre_buy_enabled = $this->createElement('select', 'PreBuyEnabled');
		$pre_buy_enabled->setLabel($this->getView()->translate('PreBuy Enabled'))
					->addMultiOptions(array(
						'ENABLED' => 'ENABLED',
						'DISABLED' => 'DISABLED'))
				->setValue($data["pre_buy_enabled"]);
				
					
		$visible = $this->createElement('select', 'Visible');
		$visible->setLabel($this->getView()->translate('Visible'))
					->addMultiOptions(array(
						'VISIBLE' => 'VISIBLE',
						'INVISIBLE' => 'INVISIBLE'))
				->setValue($data["visible"]);			
				
		$submit = $this->createElement('submit', 'submit');
	    $submit->setLabel($this->getView()->translate('Submit'));
		//Zenfox_Debug::dump($submit->getValue(), 'submit');
				
		$this->addElements(array(
						$categoryName,
						$description,
						$pre_buy_enabled,
						$visible,
						$submit
						));
						
		$this->setAttrib('id', 'admin-bingocategory-form');
		return $this;
	}
	
	
}