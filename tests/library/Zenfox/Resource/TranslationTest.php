<?php
/**
 * This file contains tests of Zenfox_Resource_Translation class which extends
 * Zend_Application_Resource_ResourceAbstract.
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

require_once('TestHelper.php');
require_once('Zenfox/Resource/Translation.php');

/**
 * This class tests Zenfox_Resource_Translation.
 *
 *
 * Long description for class (if any)...
 *
 * @category   Zenfox
 * @package    Zenfox_Resource
 * @subpackage -
 * @copyright  2009 Yaswanth Narvaneni
 * @since      Class available since v 0.1
 * @group      Libraries
 * @group      Initialization
 */

class Zenfox_Resource_TranslationTest extends Zend_Test_PHPUnit_ControllerTestCase
{
    private $_resourceTranslate;
    private $_translate;

    public function setUp()
    {
        $this->_resourceTranslate = new Zenfox_Resource_Translation();
        $this->_translate = $this->_resourceTranslate->init();
    }

    //Translate from one language to other.
    public function testTextIsGettingTranslatedBetweenDesiredLanguages()
    {
    }

    public function testDefaultLanguageIsSet()
    {
        $defaultLanguage = $this->_translate->getLocale();
        $this->assertTrue(isset($defaultLanguage));
    }

    public function testTranslateObjectTypeIsOfTypeZendTranslate()
    {
        $this->assertEquals('Zend_Translate', get_class($this->_translate));
    }

    public function tearDown()
    {

    }
}

/*
class Zenfox_Resource_Translation extends Zend_Application_Resource_ResourceAbstract
{
    const DEFAULT_REGISTRY_KEY = 'Translation';
    public function init()
    {
        $options = $this->getOptions();
        $locale = isset($options['defaultLanguage'])?$options['defaultLanguage']:'en_GB';
        //TODO:: Make user specific changes here.

        $registry = Zend_Registry::getInstance();
        //$locale = $registry->get('Zend_Locale');
        $translate = new Zend_Translate('gettext', '../languages',$locale,
          array('scan' => Zend_Translate::LOCALE_FILENAME));

        $registry->set('Zend_Translate', $translate);

        return $translate;
    }
}*/