<?php
/**
 * This file contains Zenfox_Resource_Datetime class which extends
 * Zend_Application_Resource_ResourceAbstract. This class is used to
 * initialize date time and time related issues in the Bootstrap.
 *
 * Long description for file (if any)...
 *
 * LICENSE:
 *
 * @category   Zenfox
 * @package    Zenfox_Resource
 * @subpackage -
 * @copyright  2009 Yaswanth Narvaneni
 * @license    License Link
 * @since      File available since v 0.1
*/

/**
 * This class extends Zend_Application_Resource_ResourceAbstract.
 * This class is used to initialize date time and time related issues in
 * the Bootstrap.
 *
 * Long description for class (if any)...
 *
 * @category   Zenfox
 * @package    Zenfox_Resource
 * @subpackage -
 * @copyright  2009 Yaswanth Narvaneni
 * @since      Class available since v 0.1
 */
class Zenfox_Resource_Datetime extends Zend_Application_Resource_ResourceAbstract
{
    const DEFAULT_REGISTRY_KEY = 'Datetime';
    public function init()
    {
        $options = $this->getOptions();
        $timeServers = isset($options['timeServers'])?$options['timeServers']:"0.europe.pool.ntp.org";

        //TODO:: Set TimeSync for all dates across the server
        //print('options - ' . $options['timeZone']);
        //date_default_timezone_set($options['timeZone']);
        $date = new Zend_Date();
        //print('date - ' . $date->getTimezone());
		//print($date);
		//$date->setTimeZone($options['timeZone']);
		/*print($date->get(Zend_Date::W3C));
		print($options['timeZone']);*/

        $timesync = new Zend_TimeSync($timeServers);
        //TODO:: Set TimeSync for the date object
        /*try
        {
        	$timesync->getDate();
        	$date->setOptions(array('timesync' => $timesync->getServer()));
        }
        catch(Zend_TimeSync_Exception $e)
        {
        	
        }*/
        return $date;

    }
}