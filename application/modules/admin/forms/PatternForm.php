<?php
class Admin_PatternForm extends Zend_Form
{
	public function getForm()
	{
		
		
		$type = $this->createElement('select', 'type');
			$type->setLabel('Select Type') 
		                 ->setMultiOptions(array('0'=>'--Select One--','4x4'=>'4x4 Card', '5x5'=>'5x5 Card','3x9'=>'3x9 Card'))
		                 ->setAttrib('id','patterntype')
		                ->setAttrib('onChange', 'loadpattern()');
								
		$name = $this->createElement('text', 'name');
			$name->setLabel('Pattern Name');
			
			$desc = $this->createElement('textarea', 'description');
			$desc->setLabel('Description');
		                
			$pattern = $this->createElement('hidden', 'pattern');
			$pattern->setAttrib('id','patterndata');
			
		$text = $this->createElement('button', 'text');
			$text->setAttrib('id','flashdata');
		              

		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel('Submit');

		 		$this->addElements(array(
				$name,$desc,$type,$text,$pattern,$submit
				));
		return $this;
	}
	
	
}