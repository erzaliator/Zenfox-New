<?php

class Admin_EmailTemplateForm extends Zend_Form
{
	
	public function setFrontend($frontendList)
	{
		$path = Zend_Registry::getInstance()->get('UploadTemplateFile');
		
		$name = $this->createElement('text','name')
					->setLabel($this->getView()->translate('Name of the template'))
					->setRequired(true);
		
		$category = $this->createElement('text', 'category')
			->setLabel($this->getView()->translate('Category'))
			->setRequired(true);
		
		$subject = $this->createElement('text','subject')
						->setLabel($this->getView()->translate('Subject'))
						->setRequired(true);
		
		$today = new Zend_Date();
		$currentTime = $today->get(Zend_Date::W3C);
		$file1name = "CREATETEMPLATE_".$currentTime.".html";
						
		$bodyfile = $this->createElement('file','bodyfile')
						->setDestination($path)
						->addFilter('rename',$file1name)
						->setLabel('Upload Body File');
		
		$submit = $this->createElement('submit','create_template');
		$submit->setLabel($this->getView()->translate('Submit'));

				
		$frontend = $this->createElement('select','frontend_id');
		
		$frontend->setLabel($this->getView()->translate('Frontend'));
		
		foreach ($frontendList as $frontend_id => $frontend_name)
		{
			$frontend->addMultiOptions(array($frontend_id => $frontend_name));
		}
		
		$domain = new Zend_Form_Element_Select('domain');
		$domain->setLabel('Domain')
		->setRequired(true)
		->addMultiOptions(array("postmaster@taashnetwork.com" => "postmaster@taashnetwork.com" , "promotions@taashnetwork.com" => "promotions@taashnetwork.com", "test@taashnetwork.com" => "test@taashnetwork.com" ,"noreply@taashnetwork.com" => "noreply@taashnetwork.com" ))
		->setValue($templateList['domain'])
		->addValidator('NotEmpty');
		
		$this->addElements(
		array($name,$frontend,$category,$subject,$bodyfile,$domain,$submit));
		
		return $this;
	}
}