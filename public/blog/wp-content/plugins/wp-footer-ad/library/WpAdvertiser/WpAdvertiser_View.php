<?php
/**
 * Copyright 2010 Stefan Des
 *
 * This file is part of WP Footer Ad
 */

/**
 * A basic view rendering class
 */
class WpAdvertiser_View
{
	/**
	 * View variables array
	 * @var array
	 */
	protected $_variables = array();
	
	/**
	 * Absolute path for view
	 * @var string
	 */
	protected $_path = null;
	
	/**
	 * Base directory for views
	 * @var string
	 */
	protected $_directory = 'views';
	
	/**
	 * View script extension
	 * @var string
	 */
	protected $_extension = '.phtml';
	
	/**
	 * Template file name to render
	 * @var string
	 */
	protected $_template = null;
	
	/**
	 * Performs initialization of the absolute path for views
	 */
	public function __construct()
	{
		// Looking for a basic directory where plugin resides
		list($pluginDir) = explode('/', plugin_basename(__FILE__));
		
		// making up an absolute path to views directory
		$pathArray = array(WP_PLUGIN_DIR, $pluginDir, $this->_directory);
		
		$this->_path = implode('/', $pathArray);
	}
	
	/**
	 * Sets a template filename that will be used later in render() method.
	 * Performs a reset of the view variables
	 *
	 * @param string $template The template filename, without extension
	 * @return WpAdvertiser_View
	 */
	public function setTemplate($template)
	{
		$this->_template = $template;
		$this->_variables = array();
		return $this;
	}
	
	/**
	 * Updates the view variable identified by $name with the value provided in $value
	 *
	 * @param string $name The variable name
	 * @param mixed  $value The variable value
	 * @return WpAdvertiser_View
	 */
	public function __set($name, $value)
	{
		$this->_variables[$name] = $value;
		return $this;
	}
	
	/**
	 * Updates the view variable identified by $name with the value provided in $value
	 *
	 * This is an alias for {@link __set()}
	 *
	 * @param string $name The variable name
	 * @param mixed  $value The variable value
	 * @return WpAdvertiser_View
	 */
	public function assign($name, $value)
	{
		return $this->__set($name, $value);
	}
	
	/**
	 * Returns a value of the option identified by $name
	 *
	 * @param string $name The option name
	 * @return mixed|null
	 */
	public function __get($name)
	{
		$value = array_key_exists($name, $this->_variables) ? $this->_variables[$name] : null;
		return $value;
	}
	
	/**
	 * Renders the view script
	 *
	 * @throws WpAdvertiser_Exception
	 * @return WpAdvertiser_View
	 */
	public function render()
	{
		$file = $this->_path . '/' . $this->_template . $this->_extension;
		
		if (!is_readable($file))
		{
			throw new WpAdvertiser_Exception('Can\'t find view template: ' . $file);
		}
		
		include $file;
		
		return $this;
	}
	
	/**
	 * Returns the rendered view script
	 *
	 * @return string
	 */
	public function fetch()
	{
		ob_start();
		
		$this->render();
		$contents = ob_get_contents();
		
		ob_end_clean();
		
		return $contents;
	}
	
	/**
	 * Renders the given message
	 *
	 * @param string $message The message to display
	 * @return void
	 */
	public function messageHelper($message)
	{
		$this->setTemplate('message')
			->assign('message', $message)
			->render();
	}
}