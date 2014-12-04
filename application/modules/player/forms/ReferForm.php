<?php
class Player_ReferForm extends Zend_Form
{
	public function getForm()
	{
		$referForm = new Zend_Form();
		Zend_Dojo::enableForm($referForm);
		
		$referForm->addElement(
					'SimpleTextarea',
					'mailIds',
					array(
							'label' => 'Enter mail ids (separate with ,)',
							'style' => 'width: 30em; height: 6em;'
						 )
					);
		$referForm->addElement(
					'SimpleTextarea',
					'msgBody',
					array(
							'label' => 'Type your message',
							'style' => 'width: 30em; height: 6em;'
						 )
					);

		$submit = $referForm->createElement('submit','submit');
		$submit->setLabel($this->getView()->translate('Send Invites'));

	    $referForm->addElement($submit);
	    
		/*$mailIds = $this->createElement('SimpleTextarea','mailIds');
		$mailIds->setLabel($this->getView()->translate('Enter mail ids (separate with ,) *'))
         	->setRequired(true);
         	
        $msgBody = $this->createElement('SimpleTextarea','msgBody');
		$msgBody->setLabel($this->getView()->translate('Type your message *'))
				->setRequired(true);
				
		
				
		$this->addElements(array(
		                 $mailIds,
		                 $msgBody,
		                 $submit));*/
		
		$referForm->setMethod('post');

		return $referForm;		
	}
}