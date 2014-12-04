<?php
/**
 * This file contains tests for Zenfox_Resource_Locale class which extends
 * Zend_Application_Resource_ResourceAbstract. This class is used to
 * add Doctrine resource to the Bootstrap. Everything that is related to
 * Doctrine initialization is written here.
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

require_once ('TestHelper.php');
require_once ('Zenfox/Resource/Locale.php');

/**
 * This class tests Zenfox_Resource_Locale.
 *
 *
 * Long description for class (if any)...
 *
 * @category   Zenfox
 * @package    Zenfox_Resource
 * @subpackage -
 * @copyright  2009 Yaswanth Narvaneni
 * @since      Class available since v 0.1
 * @group      Initialization
 * @group      Libraries
 */

class Zenfox_Resource_LocaleTest extends Zend_Test_PHPUnit_ControllerTestCase
{
    public function setUp()
    {
        $localeResource = new Zenfox_Resource_Locale();
        $localeResource->init();
    }

    public function testLocaleConfigSetInZendRegistry()
    {
        $locale = Zend_Registry::get('Zend_Locale');
        $this->assertTrue(isset($locale));
    }
}
