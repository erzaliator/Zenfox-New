<?php

class Player_PrebuyForm extends Zend_Form
{
	public $roomId;
	
	public function getform()
	{
		$runningroomsobj = new BingoRunningRoom();
		$allrunningrooms = $runningroomsobj->getAllRunningRooms();
		
        $runningrooms = $this->createElement('select', 'room_id');
        $runningrooms->setLabel($this->getView()->translate('Room Name *'));
        foreach($allrunningrooms as $roomdata)
        {
        	 $runningrooms->addMultiOption($roomdata["game_id"],$roomdata["room_name"]);
        }
		$runningrooms->setValue($this->roomId);
		
		$categoryobj = new BingoCategory();
		$allcategories = $categoryobj->getAllCategories();
				
        $category = $this->createElement('select', 'category_id');
        $category->setLabel($this->getView()->translate('Category *'));
        
        foreach($allcategories as $data)
        {
        	 $category->addMultiOption($data["id"],$data["name"]);
        }
					
		$totalgames = $this->createElement('text', 'total_games');
		$totalgames->setLabel($this->getView()->translate('No Of Games *'))
					->setRequired(true);
					
		$cardspergames = $this->createElement('text', 'cards_per_game');
		$cardspergames->setLabel($this->getView()->translate('Cards per Game *'))
					->setRequired(true);
					
	
					
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel($this->getView()->translate('Submit'))
				->setIgnore(true);
				
		$this->addElements(array(
		$runningrooms,
					$category,
					$totalgames,
					$cardspergames,
					$submit));
					
		$this->setAttrib('id', 'player-Prebuy-form');
		
		$decorator = new Zenfox_DecoratorForm();
		$runningrooms->setDecorators($decorator->openingUlTagDecorator);
		$category->setDecorators($decorator->changeUlTagDecorator);
		$totalgames->setDecorators($decorator->changeUlTagDecorator);
		$cardspergames->setDecorators($decorator->changeUlTagDecorator);
		$submit->setDecorators($decorator->closingUlButtonTagDecorator);
		
		
		return $this;
	}
	
	public function setroomId($roomId)
	{
		$this->roomId = $roomId;
	}
}