<?php
class Player_LeaderboardForm extends Zend_Form
{
	public function init()
	{
		$runningroomsobj = new BingoRunningRoom();
		$allrunningrooms = $runningroomsobj->getAllRunningRooms();
		
        $runningrooms = $this->createElement('select', 'room_id');
        $runningrooms->setLabel("Room Name ");
        $runningrooms->addMultiOption(-1,"--select one--");
        foreach($allrunningrooms as $roomdata)
        {
        	 $runningrooms->addMultiOption($roomdata["game_id"],$roomdata["room_name"]);
        }
		$runningrooms->setValue($this->roomId);
		
		
			
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel($this->getView()->translate('Submit'))
				->setIgnore(true);
			
		$this->addElements(array(
				$runningrooms,
				$submit));
				
		$this->setAttrib('id', 'player-leaderboard-form');
		$this->setAttrib('name', 'player-leaderboard-form');
		
		$decorator = new Zenfox_DecoratorForm();
		$runningrooms->setDecorators($decorator->openingUlTagDecorator);
		$submit->setDecorators($decorator->closingUlButtonTagDecorator);
	}
}

