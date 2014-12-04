<?php
class Zenfox_Applications_Factory
{
	public static function getInstance($platFormName, $userId = NULL)
	{
		switch($platFormName)
		{
			case 'ibibo':
				$instance = new Zenfox_Applications_Platform_Ibibo();
				break;
			case 'rediff':
				$instance = new Zenfox_Applications_Platform_Rediff($userId);
				break;
			case 'zapak':
				$instance = new Zenfox_Applications_Platform_Zapak();
				break;
		}
		return $instance;
	}
}
