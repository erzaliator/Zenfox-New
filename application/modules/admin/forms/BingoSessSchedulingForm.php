<?php
class Admin_BingoSessSchedulingForm extends Zend_Form
{
	public function getForm($schedulingForm = NULL, $data = NULL)
	{
		if(!$schedulingForm)
		{
			$schedulingForm = new Zend_Form_SubForm();
		}
		else
		{
			$bingoRoomId = $schedulingForm->createElement('hidden', 'bingoRoomId');
			$bingoRoomId->setValue($data['roomId']);
			$schedulingForm->addElement($bingoRoomId);
		}
		
		for($day = 0; $day < 3; $day++)
		{
			$weekDay = $schedulingForm->createElement('hidden', 'day_' . $day);
			switch($day)
			{
				case 0:
					$weekDay->setLabel('Sunday')
							->setValue('sunday');
					break;
				case 1:
					$weekDay->setLabel('Monday')
							->setValue('monday');
					break;
				case 2:
					$weekDay->setLabel('Tuesday')
							->setValue('tuesday');
					break;
				case 3:
					$weekDay->setLabel('Wednesday')
							->setValue('wednesday');
					break;
				case 4:
					$weekDay->setLabel('Thursday')
							->setValue('thursday');
					break;
				case 5:
					$weekDay->setLabel('Friday')
							->setValue('friday');
					break;
				case 6:
					$weekDay->setLabel('Saturday')
							->setValue('saturday');
					break;			
			}
			if($data)
			{
				$this->addTime($schedulingForm, $day, $weekDay, $data[$day]);
			}
			else
			{
				$this->addTime($schedulingForm, $day, $weekDay);
			}
		}
		
		return $schedulingForm;
	}
	
	public function addTime($schedulingForm, $day, $weekDay, $data = NULL)
	{
		$schedulingForm->addElement($weekDay);
		for($hour = 0; $hour < 4; $hour++)
		{
			$time = $schedulingForm->createElement('hidden', 'hour_' . $day . '_' . ($hour + 1));
			if(($hour % 12) != 0)
			{
				$period = ($hour < 12) ? $hour. 'AM' : ($hour - 12) .'PM';
			}
			else
			{
				$period = ($hour == 12) ? $hour. 'PM' : (12 - $hour) .'AM';
			}
			$time->setLabel($period)
				->setValue($hour);
			$schedulingForm->addElement($time);
			
			$bingoSession = new BingoSession();
			$allBingoSessions = $bingoSession->getAllSessions();
			$session = $schedulingForm->createElement('select', 'sess_' . $day . '_' . ($hour + 1));
			$session->addMultiOptions(array('-1' => 'Select Session'));
			foreach($allBingoSessions as $sessionData)
			{
				$session->addMultiOptions(array(
							$sessionData['id'] => $sessionData['name']));
			}
			if($data)
			{
				$session->setValue($data[$hour+1]);
			}
			$schedulingForm->addElement($session);
		}
	}
	
	public function setForm($form, $data)
	{
		$form = $this->getForm($form, $data);
		return $form;
	}
}