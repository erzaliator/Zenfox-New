<?php
class Admin_LeaderboardForm extends Zend_Form
{
	public function getForm($setdata = null)
	{
		//Zenfox_Debug::dump($setdata);
		$roomsobj = new BingoRoom();
			$allrooms = $roomsobj->getAllRooms();
		
       		 $rooms = $this->createElement('select', 'RoomId');
       		 $rooms->setLabel("Room Name ");
       		 foreach($allrooms as $roomdata)
       		 {
       		 	 $rooms->addMultiOption($roomdata["id"],$roomdata["name"]);
      		  }
			$rooms->setRequired(true);
				
				
		if($data["room_id"])
		{
				$rooms->setAttribs(array('disable' => 'disable'));
		}
		
		
		$Title = $this->createElement('text','Title');
		$Title->setLabel($this->getView()->translate('Leader Board Title *'))
				->setRequired(true);

		$PartWiseDisplay = $this->createElement('select','partWisePoints');
		$PartWiseDisplay->setLabel('Part Wise Display *')
					->setMultiOptions(array( 'DISPLAY'=>'DISPLAY','HIDE'=>'HIDE'))
				   ->setRequired(true);
				   
		$bingogamesobj = new BingoGame();
		$allgames = $bingogamesobj->getAllData();
				//Zenfox_Debug::dump($allcategories);exit;
        $selectedgames = $this->createElement('multiCheckbox', 'selectedgames');
        $selectedgames->setLabel($this->getView()->translate('Selected Games'));
        
        foreach($allgames as $data)
        {
        	 $selectedgames->addMultiOption($data["id"],$data["name"])
        	 				->setAttrib('name', 'selectedGames');
        }
      	$selectedgames->setAttrib('onClick', 'appendGame(this)')
      				->setSeparator(' ');
      	
      	$AllowedGames = $this->createElement('text','allowedGames');
		$AllowedGames->setLabel($this->getView()->translate('Allowed Games *'))
				->setRequired(true);
				
		 $StartDate =new ZendX_JQuery_Form_Element_DatePicker('startdate',
		 		array('jQueryParams' => array('dateFormat' => 'yy-mm-dd')));
		 $StartDate->setLabel('Start Date')
		 ->setRequired(true);
		 
		
		 
		 $EndDate =new ZendX_JQuery_Form_Element_DatePicker('enddate',
		 		array('jQueryParams' => array('dateFormat' => 'yy-mm-dd')));
		 $EndDate->setLabel('End Date')
		 ->setRequired(true);

		$Description = $this->createElement('textarea','description');
		$Description->setLabel($this->getView()->translate('Description *'))
				->setRequired(true);
				
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel($this->getView()->translate('Submit'))
				->setIgnore(true);
				
		if($setdata)
		{
			$rooms->setValue($setdata["room_id"]);
			$Title->setValue($setdata["name"]);
			$PartWiseDisplay->setValue($setdata["part_wise_points"]);
			$selectedgames->setValue($setdata["selected_games"]);
			$AllowedGames->setValue($setdata["allowed_games"]);
			$StartDate->setValue($setdata["start_date"]);
			$EndDate->setValue($setdata["end_date"]);
			$Description->setValue($setdata["description"]);
		}
			
		$this->addElements(array(
				$rooms,$Title,$PartWiseDisplay,$AllowedGames,$selectedgames,$StartDate,$EndDate,$Description,
				$submit));
				
		$this->setAttrib('id', 'player-leaderboard-form');
		$this->setAttrib('name', 'player-leaderboard-form');
		
		$decorator = new Zenfox_DecoratorForm();
		$rooms->setDecorators($decorator->openingUlTagDecorator);
		$Title->setDecorators($decorator->openingUlTagDecorator);
		$PartWiseDisplay->setDecorators($decorator->openingUlTagDecorator);
		$AllowedGames->setDecorators($decorator->openingUlTagDecorator);
		$selectedgames->setDecorators($decorator->openingUlTagDecorator);
		$StartDate->setDecorators($decorator->openingJqueryUlTagDecorator);
		$EndDate->setDecorators($decorator->openingJqueryUlTagDecorator);
		$Description->setDecorators($decorator->openingUlTagDecorator);
		$submit->setDecorators($decorator->closingUlButtonTagDecorator);
		
		return $this;
	}
}

