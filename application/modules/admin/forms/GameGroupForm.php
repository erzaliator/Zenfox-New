<?php
class Admin_GameGroupForm extends Zend_Form
{
	public function getForm()
	{
		$flavourInstance = new Flavour();
		$allGameData = $flavourInstance->getAllGames();
		
		$groupName = $this->createElement('text','name');
		$groupName->setLabel('Group Name *')
				   ->setRequired(true);
		$this->addElement($groupName);
		$this->addElement(
					'text',
					'description',
					array(
						'label' => $this->getView()->translate('Description *'),
						'style' => 'width: 30em; height: 5em;'));
		foreach($allGameData as $flavour => $machines)
		{
			//echo '<b>'.$flavour.'</b>';
			$element = $this->createElement('multiCheckbox',$flavour);
			$element->setLabel($flavour.' *');
			foreach($machines as $machine)
			{
				if($flavour == 'keno')
				{
					$element->addMultiOption($machine['id'],$machine['machine_name']);
				}
				elseif($flavour == 'roulette')
				{
					$element->addMultiOption($machine['id'],$machine['machine_name']);
				}
				elseif($flavour == 'slots')
				{
					$element->addMultiOption($machine['id'],$machine['id']);
				}
			}
			$this->addElement($element);
			
		}
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel($this->getView()->translate('Submit'))
	        		->setIgnore(true);
		$this->addElement($submit);
		$this->setMethod('post');
		
		return $this;
	}
	
	public function setForm($data)
	{
		$form = $this->getForm();
		$form->name->setValue($data['name']);
		$form->description->setValue($data['description']);
		
		$flavourInstance = new Flavour();
		$flavours = $flavourInstance->getGameFlavours();
		foreach($flavours as $flavour)
		{
			$form->$flavour->setValue($data[$flavour]);
		}
		
		return $form;
	}
	
}