<?php
class Zenfox_Date extends Zend_Date
{
	public function setDate($date = NULL)
	{
		$timeZone = Zend_Registry::get('userTimeZone');
		$date = new Zend_Date($date, Zend_Date::ISO_8601);
		$date->setTimezone($timeZone);
		return $date;
	}
}