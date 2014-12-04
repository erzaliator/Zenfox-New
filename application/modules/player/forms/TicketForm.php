<?php
class Player_TicketForm extends Zend_Form
{
	public function init()
	{
		//Zend_Dojo::enableForm($this);
		
		$subject = $this->createElement('text', 'subject');
		$subject->setLabel($this->getView()->translate('Subject *'))
				->setRequired(true)
				->setAttrib('class', 'text');
		$this->addElement($subject);
		
		/*$this->addElement(
    				'SimpleTextarea',
    				'reply_msg',
    				array(
        					'label' => $this->getView()->translate('Message'),
       						'style' => 'width: 30em; height: 10em;'
    					)
					);*/
		
		$this->addElement(
    				'textarea',
    				'reply_msg',
    				array(
        					'label' => $this->getView()->translate('Message (What have you got to say/ask) ?'),
       						'style' => 'width: 30em; height: 10em; line-height: 12px;',
    						'class' => 'text',
    					)
					);
		
		$submit = $this->createElement('submit','submit');
		$submit->setLabel($this->getView()->translate('Submit'))
				->setIgnore(true);
		
		$this->addElement($submit);
		$this->setAttrib('id', 'player-ticket-form');
	}
}