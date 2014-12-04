<?php
class Player_LanguageForm extends Zend_Form
{
	public function init()
	{
		$languages = new Language();
		$allLanguages = $languages->getLanguages();
		
		$language = $this->createElement('select', 'lang');
		foreach($allLanguages as $lang)
		{
			$language->addMultiOption($lang['locale'], $lang['language']);
		}
		
		$langSession = new Zend_Session_Namespace('language');
		if($langSession->language)
		{
			$language->setValue($langSession->language);
		}
		
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel($this->getView()->translate('Go'));
	
		$front = Zend_Controller_Front::getInstance()->getRequest();
		$controller = $front->getControllerName();
		$action = $front->getActionName();
		$url = '/' . $controller . '/' . $action;
        //$url = $front->getRequestUri();
		
		$urlField = $this->createElement('hidden', 'url');
		$urlField->setValue($url);
		
		$this->addElements(array(
					$language,
					$submit,
					$urlField));
					
		$this->setAction('/en_GB/language');
		
		$decorator = new Zenfox_DecoratorForm();
		
		$language->setDecorators($decorator->openingTagDecorator);
						
		$submit->setDecorators($decorator->closingButtonTagDecorator);
		
		$this->setAttrib('id', 'player-language-form');
		
		/*$this->setDecorators(array(
					'FormElements',
					array('HtmlTag', array('tag' => 'dl', 'class' => 'player-language-form')),
					'Form'
					));*/
		
	}
}
