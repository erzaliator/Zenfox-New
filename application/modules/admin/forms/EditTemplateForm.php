<?php
class Admin_EditTemplateForm extends Zend_Form
{
	public function init()
	{
		
	}
	
	public function setFormData($templateList,$frontendList)
	{
		$path = Zend_Registry::getInstance()->get('UploadTemplateFile');
		
		$id = new Zend_Form_Element_Hidden('id');
		$id->setValue($templateList['id']);
						
		$nameText = new Zend_Form_Element_Text('name');
		$nameText->setLabel($this->getView()->translate('Template Name'))
				->setRequired(true)
				->addValidator('NotEmpty')
				->setValue($templateList['name']);
				
		$category = $this->createElement('text', 'category')
			->setLabel($this->getView()->translate('Category'))
			->setValue($templateList['category'])
			->setRequired(true);
		
		$frontText = new Zend_Form_Element_Select('frontend_id');
		$frontText->setLabel($this->getView()->translate('Frontend Name'))
				->setRequired(true)
				->setValue($templateList['frontend_id'])
				->addValidator('NotEmpty');

		foreach ($frontendList as $frontend_id => $frontend_name)
		{
			$frontText->addMultiOptions(array($frontend_id => $frontend_name));
		}		
				

		$subjectText = new Zend_Form_Element_Text('subject');
		$subjectText->setLabel($this->getView()->translate('Subject'))
				->setRequired(true)
				->addValidator('NotEmpty')
				->setValue($templateList['subject']);
				
		$bodytext = new Zend_Form_Element_Textarea('body');
		$bodytext->setLabel($this->getView()->translate('Body(will be edited as below only if no file is uploaded)'))
				->setRequired(true)
				->addValidator('NotEmpty')
				->setValue($templateList['body']);

		$today = new Zend_Date();
		$currentTime = $today->get(Zend_Date::W3C);
		$file1name = "EDITTEMPLATE_".$currentTime.".html";
		
		
		$bodyfile = $this->createElement('file','bodyfile')
						->setDestination($path)
						->addFilter('rename',$file1name)
						->setLabel('Upload Body File');
		
		$domain = new Zend_Form_Element_Select('domain');
		$domain->setLabel('Domain')
				->setRequired(true)
				->addMultiOptions(array("postmaster@taashnetwork.com" => "postmaster@taashnetwork.com" , "promotions@taashnetwork.com" => "promotions@taashnetwork.com", "test@taashnetwork.com" => "test@taashnetwork.com" ,"noreply@taashnetwork.com" => "noreply@taashnetwork.com" ))
				->setValue($templateList['domain'])
				->addValidator('NotEmpty');

		$submit = new Zend_Form_Element_Submit('submit');	
		$submit->setLabel($this->getView()->translate('Save Template'));
							
		
		$this->addElements(array($idText,$nameText,$category,$frontText,$subjectText,$bodytext,$bodyfile,$domain,$submit));
		
	}
}