<?php
class Player_CommentsForm extends Zend_Form
{
	public function init()
	{
		//Zend_Dojo::enableForm($this);
		
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
    						'validators' => array(array(
    								'EmailAddress', 
    								false, 
    								array(6,50,'messages' => array('emailAddressInvalidFormat' => $this->getView()->translate("Email Address should be in format username@hostname")))
    						)),
    						'class' => 'text',
    					)
					);
			/*$userName = $this->createElement('SimpleTextarea', 'userName');
			$userName->setLabel($this->getView()->translate('Name*'))
					->setValue('Anonymous')
					->setAttribs(array('style' => 'width: 15em; height: 1.5em; line-height: 15px;'))
					->setRequired(true);
					
			$email = $this->createElement('SimpleTextarea', 'email');
			$email->setLabel($this->getView()->translate('Email Id* (Will not be displayed)'))
				->setAttribs(array('style' => 'width: 15em; height: 1.5em;'))	
				->addValidator('emailAddress', false, array(6,50,'messages' => array('emailAddressInvalidFormat' => $this->getView()->translate("Email Address should be in format username@hostname"))))
				->setRequired(true);*/
		}

		//TODO set according to the page
		/*$topic = $this->createElement('select', 'topic');
		$topic->setLabel($this->getView()->translate('Select a topic*'))
				->addMultiOptions(array(
							'game' => 'Game',
							'look' => 'Page Look',
				));*/
			
		$this->addElement(
    				'textarea',
    				'comment',
    				array(
        					'label' => $this->getView()->translate('Comments'),
       						'style' => 'width: 22em; height: 6em; line-height: 10px;',
    						'class' => 'text',
    					)
					);
					
		$front = Zend_Controller_Front::getInstance()->getRequest();
		//Zenfox_Debug::dump($front->getParams(), 'params');
		$url = '';
		foreach($front->getParams() as $param => $value)
		{
			if(($param == 'controller') || ($param == 'action') || ($param == 'lang'))
			{
				$url = $url . '/' . $value;
			}
			else if(($param != 'module') && ($param != 'error_handler'))
			{
				$url = $url . '/' . $param . '/' . $value;
			}
		}
		
		$commentsDescription = '<a class = "moreComments" href = "#">' . $this->getView()->translate('Show Comments..') . '</a>';
		$comments = $this->createElement('hidden','comments');
		$comments->setDescription($commentsDescription);

		$urlField = $this->createElement('hidden', 'url');
		$urlField->setValue($url);

		$module = $front->getModuleName();
		$controller = $front->getControllerName();
		$action = $front->getActionName();
		
		$address = $module . '-' . $controller . '-' . $action;
		
		$pageAddress = $this->createElement('hidden', 'page');
		$pageAddress->setValue($address);
		
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel('Submit')
				->setIgnore(true);
				
		$this->addElements(array(
					$submit,
					$pageAddress,
					$urlField,
					$comments,
			));
					
		$this->setAction('/comments');
		$this->setAttrib('id', 'player-comment-form');
		
		$decorator = new Zenfox_DecoratorForm();
		$comments->setDecorators($decorator->linkDecorator);
	}
}