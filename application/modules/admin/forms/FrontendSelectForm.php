<?php
class Admin_FrontendSelectForm extends Zend_Form
{
	public function getform()
	{
				$frontendobject = new Frontend();
				$frontends = $frontendobject->getFrontends();
				$length = count($frontends);
				$index = 0;
				
				while($index < $length )
				{
					$newfrontendlist[$frontends[$index]['id']] = $frontends[$index]['name'];
					$index++;
				}
				//ontText->addMultiOptions(array($frontend_id => $frontend_name));
				
				$frontend = $this->createElement('select', 'frontend_id');
				$frontend->setLabel('Select Frontend')
						->addMultiOptions($newfrontendlist);
				$this->addElement($frontend);	
				
				$submit = $this->createElement('submit', 'submit');
				$submit->setLabel($this->getView()->translate('Submit'))
				->setIgnore(true);
				
				$this->addElement($submit);	
				
				return $this;
	}
}