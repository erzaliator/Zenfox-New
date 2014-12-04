<?php

class Admin_CreateBadgesForm extends Zend_Form
{
	public function init()
	{
		Zend_Dojo::enableform($this);
		$client_id=$this->createElement('text','client_id')
						      ->setLabel($this->getView()->translate('Client Id : '))
						      ->setRequired(true);
		$this->addElement($client_id);

		$app_id=$this->createElement('text','app_id')
						      ->setLabel($this->getView()->translate('App Id : '))
						      ->setRequired(true);
		$this->addElement($app_id);
		
		$badge_id=$this->createElement('text','badge_id')
                             ->setLabel($this->getView()->translate('badge Id : '))
                             ->setRequired(true);
        $this->addElement($badge_id);

        $badge_title=$this->createElement('text','badge_title')
                             ->setLabel($this->getView()->translate('Title : '))
                             ->setRequired(true);
        $this->addElement($badge_title);

        $url=$this->createElement('text','url')
						      ->setLabel($this->getView()->translate('Url : '))
						      ->setRequired(true);
		$this->addElement($url);

		$body=$this->createElement('SimpleTextarea',
									  'body',
									  array(
        					'label' => $this->getView()->translate('Body :'),
       						'style' => 'width: 30em; height: 10em;')
							);
		$this->addElement($body);

		$gamification_variable=$this->createElement('text','gamification_variable')
						      ->setLabel($this->getView()->translate('Gamification_variable : '))
						      ->setRequired(true);
		$this->addElement($gamification_variable);

		$max_value=$this->createElement('text','max_value');
		$max_value->setLabel('Max value :')
				->setRequired(true);
		$this->addElement($max_value);

		$submit = $this->createElement('submit','submit');
		$submit->setLabel($this->getView()->translate('Submit'))
				->setIgnore(true);

		$this->addElement($submit);
		$this->setAttrib('id', 'admin-createbadges-form');

		$this->addElements(array(
				$client_id,
				$app_id,
				$badge_id,
				$badge_title,
				$url,
				$body,
				$gamification_variable,
				$max_value,
				$submit
			));	
	}
}