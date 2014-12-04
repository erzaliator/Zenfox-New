<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initAppAutoload()
    {
        $autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => '',
            'basePath'  => dirname(__FILE__),
        ));
        $frontController = Zend_Controller_Front::getInstance()->throwExceptions(true);
        $this->getApplication()->getAutoloader()->registerNamespace('Doctrine')
                               ->pushAutoloader(array('Doctrine', 'autoload'));

        //TODO:: Move this to Resource_Defaults.php
        $options = $this->getOptions('defaults');
        $time_zone = isset($options['time_zone'])?$options['time_zone']:"Europe/London";
        date_default_timezone_set($time_zone);
        return $autoloader;
    }

    protected function _initModules()
    {
        //TODO:: Depending on the request initialized modules
        //FIXME:: Can't this be achieved through Zend_Controller_Router?
    }
}