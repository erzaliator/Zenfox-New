<?php
class Player_TicketReplyForm extends Zend_Form
{
	public function init()
	{
		//Zend_Dojo::enableForm($this);

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
        					'label' => $this->getView()->translate('Message'),
       						'style' => 'width: 30em; height: 10em; line-height: 12px;',
    						'class' => 'text',
    					)
					);
					
		$ticket_status = $this->createElement('select', 'ticket_status');
		$ticket_status->setLabel($this->getView()->translate('Ticket Status : '));
		$ticket_status->addMultiOptions(array(
							'OPEN'      => $this->getView()->translate('Open'),
							'CLOSE'     => $this->getView()->translate('Closed')));
		
		$this->addElement($ticket_status);
		
		$submit = $this->createElement('submit','submit');
		$submit->setLabel($this->getView()->translate('Submit'))
				->setIgnore(true);
		
		$this->addElement($submit);
		$this->setAttrib('id', 'player-ticket-reply-form');
	}
}