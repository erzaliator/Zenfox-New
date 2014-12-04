<?php
/**
 * This file contains Zenfox_Resource_Doctrine class which extends
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

/**
 * This class extends Zend_Application_Resource_ResourceAbstract.
 * This class is used to add Doctrine resource to the Bootstrap.
 * Everything that is related to Doctrine initialization is written here.
 *
 *
 * Long description for class (if any)...
 *
 * @category   Zenfox
 * @package    Zenfox_Resource
 * @subpackage -
 * @copyright  2009 Yaswanth Narvaneni
 * @since      Class available since v 0.1
 */


class Zenfox_Resource_Doctrine extends Zend_Application_Resource_ResourceAbstract
{
    const DEFAULT_REGISTRY_KEY = 'Doctrine';
    private $_currentModule = 'player';
    public function init()
    {
        $manager = Doctrine_Manager::getInstance();
        $manager->setAttribute(Doctrine::ATTR_AUTO_ACCESSOR_OVERRIDE, true);
        $manager->setAttribute(
            Doctrine::ATTR_MODEL_LOADING,
            Doctrine::MODEL_LOADING_CONSERVATIVE
        );
        $manager->setAttribute(Doctrine::ATTR_AUTOLOAD_TABLE_CLASSES, false);

        //Get application specific doctrine options
        $doctrine_options = $this->getOptions();

        $defaultModule = Zend_Registry::get('defaultModule', $this->_currentModule);

        //Set Doctrine Config in Zend_Registry
/*        Zend_Registry::set('doctrine_config', array(
                'data_fixtures_path' => $doctrine_options['data_fixtures_path'],
                'models_path'        => $doctrine_options['models_path'],
                'migrations_path'    => $doctrine_options['migrations_path'],
                'sql_path'           => $doctrine_options['sql_path'],
                'yaml_schema_path'   => $doctrine_options['yaml_schema_path']
                ));
*/

          Zend_Registry::set('doctrine_config', array(
                'data_fixtures_path' => APPLICATION_PATH . "/modules/" . $defaultModule . "/doctrine/data/fixtures",
                //Adding main models to the modles path. Currently useful for tickets
                'models_path'        => APPLICATION_PATH . "/modules/" . $defaultModule . "/models:/models",
                'migrations_path'    => APPLICATION_PATH . "/modules/" . $defaultModule . "/doctrine/migrations",
                'sql_path'           => APPLICATION_PATH . "/modules/" . $defaultModule . "/doctrine/data/sql",
                'yaml_schema_path'   => APPLICATION_PATH . "/modules/" . $defaultModule . "/doctrine/schema"
        ));
        //Loading Doctinr Models
        Doctrine::loadModels(APPLICATION_PATH . "/modules/" . $defaultModule . "/models");
        Doctrine::loadModels(APPLICATION_PATH . "/models");

        return $manager;
    }
}