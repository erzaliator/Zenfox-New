<?php
/**
 * This class is used to display player testimonial, csr can modify it
 */
class Admin_TestimonialForm extends Zend_Form
{
	public function init()
	{
		Zend_Dojo::enableForm($this);
		
		$testiId = $this->createElement('hidden', 'testiId');
		$this->addElement(
		    	'SimpleTextarea',
		    	'reply_msg',
				array(
   					'label' => $this->getView()->translate('Message'),
					//'style' => 'width: 30em; height: 10em;'
				)
			);
		
		$status = $this->createElement('select', 'status');
		$status->setLabel('Status')
			->addMultiOptions(array(
				'DISABLED' => 'Disable',
				'ENABLED' => 'Enable'
			));
		
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel('Submit')
				->setIgnore(true);
		
		$this->addElements(array(
				$status,
				$submit,
				$testiId
			));
	}
}