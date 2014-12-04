<?php
class Admin_ReplyForm extends Zend_Form
{
	public function init()
	{
		Zend_Dojo::enableForm($this);

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
					
		$ticket_status = $this->createElement('select', 'ticket_status');
		$ticket_status->setLabel($this->getView()->translate('Ticket Status : '));
		$ticket_status->addMultiOptions(array(
							'OPEN'      => $this->getView()->translate('Open'),
							'CLOSE'     => $this->getView()->translate('Closed'),
							'PENDING'   => $this->getView()->translate('Pending'),
							'FORWARDED' => $this->getView()->translate('Forwarded'),
							'DISPATCH'  => $this->getView()->translate('Dispatch')));
		
		$this->addElement($ticket_status);
		
		$csrIds = new CsrIds();
		$ids = $csrIds->getIds();
		$csrId = $this->createElement('select', 'csrId');
		$csrId->setLabel('CsrIds');
		foreach($ids as $csr_id)
		{
			$csrId->addMultiOption($csr_id['id'], $csr_id['alias']);
		}
				
		$this->addElement($csrId);
		
		$submit = $this->createElement('submit','submit');
		$submit->setLabel($this->getView()->translate('Submit'))
				->setIgnore(true);
		
		$this->addElement($submit);
		$this->setAttrib('id', 'admin-reply-form');
	}
}