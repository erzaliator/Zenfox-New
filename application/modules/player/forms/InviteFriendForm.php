<?php
class Player_InviteFriendForm extends Zend_Form
{
	public function init()
	{
		/* $emailAddress_1 = $this->createElement('text', 'emailAddress_1');
		$emailAddress_1->setLabel('Email Address 1');
		
		$emailAddress_2 = $this->createElement('text', 'emailAddress_2');
		$emailAddress_2->setLabel('Email Address 2');
		
		$emailAddress_3 = $this->createElement('text', 'emailAddress_3');
		$emailAddress_3->setLabel('Email Address 3');
		
		$emailAddress_4 = $this->createElement('text', 'emailAddress_4');
		$emailAddress_4->setLabel('Email Address 4');
		
		$emailAddress_5 = $this->createElement('text', 'emailAddress_5');
		$emailAddress_5->setLabel('Email Address 5');
		
		$emailAddress_6 = $this->createElement('text', 'emailAddress_6');
		$emailAddress_6->setLabel('Email Address 6');
		
		$emailAddress_7 = $this->createElement('text', 'emailAddress_7');
		$emailAddress_7->setLabel('Email Address 7');
		
		$emailAddress_8 = $this->createElement('text', 'emailAddress_8');
		$emailAddress_8->setLabel('Email Address 8');
		
		$emailAddress_9 = $this->createElement('text', 'emailAddress_9');
		$emailAddress_9->setLabel('Email Address 9');
		
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel('Invite Now!')
			->setIgnore(true);
		
		$this->addElements(array(
				$emailAddress_1,
				$emailAddress_2,
				$emailAddress_3,
				$emailAddress_4,
				$emailAddress_5,
				$emailAddress_6,
				$emailAddress_7,
				$emailAddress_8,
				$emailAddress_9,
				$submit
		));
		
		$decorator = new Zenfox_DecoratorForm();
		
		$emailAddress_1->setDecorators($decorator->openingUlTagDecorator);
		$emailAddress_2->setDecorators($decorator->changeUlTagDecorator);
		$emailAddress_3->setDecorators($decorator->changeUlTagDecorator);
		$emailAddress_4->setDecorators($decorator->changeUlTagDecorator);
		$emailAddress_5->setDecorators($decorator->changeUlTagDecorator);
		$emailAddress_6->setDecorators($decorator->changeUlTagDecorator);
		$emailAddress_7->setDecorators($decorator->changeUlTagDecorator);
		$emailAddress_8->setDecorators($decorator->changeUlTagDecorator);
		$emailAddress_9->setDecorators($decorator->changeUlTagDecorator);
		$submit->setDecorators($decorator->closingUlButtonTagDecorator); */
		
		//Taashtime Invitation
		$decorator = new Zenfox_DecoratorForm();
		$this->addElement(
    				'textarea',
    				'emails',
    				array(
        					'label' => $this->getView()->translate('Email Ids(Comma Seperated)'),
       						'style' => 'height: 40px; line-height: 12px;',
    						'decorators' => $decorator->openingUlTagDecorator,
    						'class' => 'text',
    					)
					);
		
		$frontendName = Zend_Registry::get('frontendName');
		switch($frontendName)
		{
			case 'taashtime.com':
			case 'www.taashtime.com':
				$this->addElement(
				  	'textarea',
				  	'message',
					array(
				    	'label' => $this->getView()->translate('Message'),
				    	'style' => 'height: 40px; line-height: 12px;',
				    	'decorators' => $decorator->changeUlTagDecorator,
				    	'class' => 'text',
					)
				);
			break;				
		}
		/* $this->addElement(
    				'textarea',
    				'message',
    				array(
        					'label' => $this->getView()->translate('Message'),
       						'style' => 'height: 40px; line-height: 12px;',
    						'decorators' => $decorator->changeUlTagDecorator,
    						'class' => 'text',
    					)
					); */
					
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel('Invite Now!')
			->setIgnore(true);
			
		$this->addElements(array(
				//$facebookLogin,
				$submit
			)); 
			
		/*$facebookInviteSess = new Zend_Session_Namespace('facebookInviteSession');
		$facebookInviteSess->value = true;
		//$facebookInviteSess->unsetAll();
		$facebookButton = '<fb:login-button v="2" size="medium" >Invite Friends</fb:login-button>';
		$facebookLogin = $this->createElement('hidden','facebookLogin');
		$facebookLogin->setDescription($facebookButton);*/
		
		//$facebookLogin->setDecorators($decorator->facebookLinkDecorator);
		
		$submit->setDecorators($decorator->closingUlButtonTagDecorator);
		$this->setAttrib('id', 'player-invite-form');
		$this->setAction('/index/invite');
	}
}