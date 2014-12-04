<?php

class Admin_CreateVariablesForm extends Zend_Form
{
	public function init()
	{
		Zend_Dojo::enableform($this);
		$variablename=$this->createElement('text','variablename')
						      ->setLabel($this->getView()->translate('VariableName : '))
						      ->setRequired(true);
		$this->addElement($variablename);

		$variableid=$this->createElement('text','variableid')
                             ->setLabel($this->getView()->translate('VariableId : '))
                             ->setRequired(true);
        $this->addElement($variableid);
     
		$vardesc=$this->createElement('SimpleTextarea',
									  'vardesc',
									  array(
        					'label' => $this->getView()->translate('Description : '),
       						'style' => 'width: 30em; height: 5em;')
							);
   
		$this->addElement($vardesc);

		$levelId=$this->createElement('select','levelId');
		$levelId->setLabel('LevelId')
				->setRequired(true);
		$this->addElement($levelId);

		$levelname=$this->createElement('text','levelname');
		$levelname->setLabel('LevelName')
				  ->setRequired(true);
		$this->addElement($levelname);

		$minpoint=$this->createElement('select','minpoint');
		$minpoint->setLabel('Min Point')
				 ->setRequired(true);
		$this->addElement($minpoint);

		$maxpoint=$this->createElement('select','maxpoint');
		$minpoint->setLabel('Max Point')
				 ->setRequired(true);
		$this->addElement($maxpoint);
		
		$message=$this->createElement('SimpleTextarea',
									  'message',
									  array(
        					'label' => $this->getView()->translate('Message'),
       						'style' => 'width: 30em; height: 10em;')
							);
		$this->addElement($message);
		

	}
}
