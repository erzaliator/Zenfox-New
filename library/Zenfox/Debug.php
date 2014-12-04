<?php
/**
 * This file contains Zenfox_Debug class which extends
 * Zend_Debug overrides a static method called dump
 *
 * Long description for file (if any)...
 *
 * LICENSE:
 *
 * @category   Zenfox
 * @package    Zenfox
 * @subpackage -
 * @copyright  2009 Yaswanth Narvaneni
 * @license    License Link
 * @since      December 5 2009
*/

/**
 * This class extends Zend_Debug. This overrides Zend_Debug's static method 'dump'
 * Zenfox_Debug dump takes an extra variable $exit.
 * If $exit is set to true, the program exits after doing var_dump
 *
 *
 * Long description for class (if any)...
 *
 * @category   Zenfox
 * @package    Zenfox
 * @subpackage -
 * @copyright  2009 Yaswanth Narvaneni
 * @since      December 5 2009
 */

class Zenfox_Debug extends Zend_Debug
{
	public static function dump($var , $label=null, $echo=true, $exit=false)
	{

		parent::dump($var, $label, $echo);
		/*
		$output = parent::dump($var, $label, false);
		
		
		$logger = Zend_Registry::getInstance()->get('Zenfox_Logger');
		
		$logger->err($output);
		*/
		if($exit)
		{
			exit();
		}
	}
}