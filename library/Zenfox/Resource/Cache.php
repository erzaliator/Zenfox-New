<?php
class Zenfox_Resource_Cache extends Zend_Application_Resource_ResourceAbstract
{
	const DEFAULT_REGISTRY_KEY = 'Cache';
	
	public function init()
	{
		$options = $this->getOptions();
		$cacheConfig = $this->initOptions($options['cacheConfigFile']);
		$bOptions = array('servers' => $cacheConfig['serverList'],
							'compression' => false);

		$backend = new Zend_Cache_Backend_Memcached($bOptions);
		$frontend = new Zend_Cache_Core($cacheConfig['frontEndOptions']);
		$cache = Zend_Cache::factory($frontend, $backend);
		$registry = Zend_Registry::getInstance();
        $registry->set('Cache', $cache);
	}
	
	public function initOptions($cacheConfigFile)
	{
		$fh = fopen($cacheConfigFile, 'r');
        $optionsJson = fread($fh, filesize($cacheConfigFile));
        fclose($fh);
        $cacheConfig = Zend_Json::decode($optionsJson);
        return $cacheConfig;
	}
}