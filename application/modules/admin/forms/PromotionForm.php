<?php
/**
 * This form provides option to select the time
 */

class Admin_PromotionForm extends Zend_Form
{
	public function getDateForm($startingDay, $noOfDays = NULL)
	{
		$allDates = $this->createElement('select', 'allDates');
		$allDates->setLabel('Select Date');
		for($i = 0; $i < $noOfDays; $i++)
		{
			$date = new Zend_Date($startingDay);
			$nextDay = $date->add($i, Zend_Date::DAY);
			$nextDate = $nextDay->get(Zend_Date::W3C);
			$allDates->addMultiOption($nextDate, $nextDay->get(Zend_Date::DAY) . ' ' . $nextDay->get(Zend_Date::MONTH_NAME));
		}
				
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel('Submit');
		
		$this->addElements(array(
				$allDates,
				$submit
			));
		return $this;
	}
}