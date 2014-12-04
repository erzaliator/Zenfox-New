<?php
class Player_TestimonialForm extends Zend_Form
{
	public function init()
	{
		$decorator = new Zenfox_DecoratorForm();
		$session = new Zenfox_Auth_Storage_Session();
		$storedData = $session->read();
		if($storedData)
		{
			$userName = $this->createElement('hidden', 'userName');
			$email = $this->createElement('hidden', 'email');
			$loginName = $storedData['authDetails'][0]['login'];
			$playerEmail = $storedData['authDetails'][0]['email'];
			$userName->setValue($loginName);
			$email->setValue($playerEmail);

			$this->addElements(array(
					$userName,
					$email,
			));
		}
		else
		{
			$this->addElement(
    				'textarea',
    				'userName',
    				array(
        					'label' => $this->getView()->translate('Name*'),
       						'style' => 'width: 15em; height: 1.2em; line-height: 10px;',
    						'required' => true,
    						'value' => 'Anonymous',
    						'decorators' => $decorator->openingUlTagDecorator,
    						'class' => 'text',
    					)
					);
					
			$this->addElement(
    				'textarea',
    				'email',
    				array(
        					'label' => $this->getView()->translate('Email Id* (Will not be displayed)'),
       						'style' => 'width: 15em; height: 1.2em; line-height: 12px;',
    						'required' => true,
    						'decorators' => $decorator->changeUlTagDecorator,
    						'validators' => array(array(
    								'EmailAddress', 
    								false, 
    								array(6,50,'messages' => array('emailAddressInvalidFormat' => $this->getView()->translate("Email Address should be in format username@hostname")))
    						)),
    						'class' => 'text',
    					)
					);
		}
		
		$this->addElement(
    				'textarea',
    				'comment',
    				array(
        					'label' => $this->getView()->translate('Testimonial'),
       						'style' => 'width: 30em; height: 10em; line-height: 10px;',
    						'decorators' => $decorator->changeUlTagDecorator,
    						'class' => 'text',
    					)
					);
					
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel('Submit')
				->setIgnore(true);
				
		$this->addElements(array(
					$submit,
			));
		
		$userName->setDecorators($decorator->openingUlTagDecorator);
		$email->setDecorators($decorator->changeUlTagDecorator);
		$submit->setDecorators($decorator->closingUlButtonTagDecorator);
	}
}