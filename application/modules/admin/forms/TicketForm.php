<?php
class Admin_TicketForm extends Zend_Form
{
	public function init()
	{
		Zend_Dojo::enableForm($this);

		$ticketStatus = $this->createElement('select', 'ticketStatus');
		$ticketStatus->setLabel($this->getView()->translate('Ticket Status : '))
				->addMultiOption('OPEN', 'Open')
				->addMultiOption('FORWARDED', 'Forwarded');
				
		$this->addElement($ticketStatus);
				
		$csrIds = new CsrIds();
		$ids = $csrIds->getIds();
		$csrId = $this->createElement('select', 'csrId');
		$csrId->setLabel('CsrIds');
		foreach($ids as $csr_id)
		{
			$csrId->addMultiOption($csr_id['id'], $this->getView()->translate("CSR-") . $csr_id['id']);
		}
				
		$this->addElement($csrId);
		
		$userName = $this->createElement('text', 'userName');
		$userName->setLabel('User Name *')
				->setRequired(true)
				->addValidator(new Zenfox_Validate_UsernameValidator);
				
		$this->addElement($userName);

		$subject = $this->createElement('text', 'subject');
		$subject->setLabel($this->getView()->translate('Subject *'))
				->setRequired(true);
		$this->addElement($subject);
		
		$this->addElement(
    				'SimpleTextarea',
    				'reply_msg',
    				array(
        					'label' => $this->getView()->translate('Message'),
       						'style' => 'width: 30em; height: 10em;'
    					)
					);
		
		$this->addElement(
    				'SimpleTextarea',
    				'note',
    				array(
        					'label' => $this->getView()->translate('Note'),
       						'style' => 'width: 30em; height: 3em;'
    					)
					);
					
		/*$ticket_status = new Zend_Form_Element_Radio('ticket_status');
		$ticket_status->setLabel('Ticket Status : ');
		$ticket_status->addMultiOptions(array(
							'open'      => 'Open',
							'close'     => 'Closed',
							'pending'   => 'Pending',
							'forwarded' => 'Forwarded',
							'dispatch'  => 'Dispatch'));*/
		
		$submit = $this->createElement('submit','submit');
		$submit->setLabel($this->getView()->translate('Submit'))
				->setIgnore(true);
		
		$this->addElement($submit);
		$this->setAttrib('id', 'admin-ticket-form');
	}
}