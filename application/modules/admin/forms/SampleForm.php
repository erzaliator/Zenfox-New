<?php
class Admin_TicketForm extends Zend_Form
{
	public function init()
	{
		Zend_Dojo::enableForm($this);
		
		$badgeName = $this->createElement('text', 'badgeName');
		$badgeName->setLabel('Badge Name *')
				->setRequired(true)
				->addValidator(new Zenfox_Validate_UsernameValidator);
				
		$this->addElement($badgeName);

		$badgeID = $this->createElement('text', 'badgeID');
		$userName->setLabel('Badge Id *')
				->setRequired(true)
				->addValidator(new Zenfox_Validate_UsernameValidator);
				
		$this->addElement($badgeID);

		$badgeTitle = $this->createElement('text', 'badgeTitle');
		$subject->setLabel($this->getView()->translate('Title *'))
				->setRequired(true);
		$this->addElement($badgeTitle);
		
		$this->addElement(
    				'SimpleTextarea',
    				'reply_msg',
    				array(
        					'label' => $this->getView()->translate('Message'),
       						'style' => 'width: 30em; height: 10em;'
    					)
					);

		$submit = $this->createElement('submit','submit');
		$submit->setLabel($this->getView()->translate('Submit'))
				->setIgnore(true);
		
		$this->addElement($submit);
		$this->setAttrib('id', 'admin-sample-form');
	}
}