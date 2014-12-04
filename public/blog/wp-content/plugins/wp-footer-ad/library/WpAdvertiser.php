<?php
/**
 * Copyright 2010 Stefan Des
 *
 * This file is part of WP Footer Ad
 */

/**
 * WP Footer Ad allows to set up banners to be displayed in the footer
 */
class WpAdvertiser
{
	/**
	 * Plugin version
	 */
	const VERSION = '0.1';
	
	/**
	 * The lookup key used to locate the options record in the wp_options table
	 */
	const OPTIONS_KEY = 'wp-advertiser-options';
	
	/**
	 * The hook to be used in all variable actions and filters
	 */
	const HOOK = 'wp-advertiser';
	
	/**
	 * Singleton instance
	 * @var WpAdvertiser
	 */
	protected static $_instance = null;
	
	/**
	 * An instance of the options structure containing all options for this plugin
	 * @var WpAdvertiser_Options
	 */
	protected $_options = null;
	
	/**
	 * View object
	 * @var WpAdvertiser_View
	 */
	protected $_view = null;
	
	/**
	 * Singleton pattern implementation makes "new" unavailable
	 *
	 * @return void
	 */
	protected function __construct()
	{}
	
	/**
	 * Singleton pattern implementation makes "clone" unavailable
	 *
	 * @return void
	 */
	protected function __clone()
	{}
	
	/**
	 * Returns an instance of WpAdvertiser
	 *
	 * Singleton pattern implementation
	 *
	 * @return WpAdvertiser
	 */
	public static function getInstance()
	{
		if (null === self::$_instance)
		{
			self::$_instance = new self();
			self::$_instance->_options = new WpAdvertiser_Options(self::OPTIONS_KEY);
			self::$_instance->_view = new WpAdvertiser_View();
		}
		
		return self::$_instance;
	}
	
	/**
	 * Initializes singleton instance and assigns hooks callbacks
	 *
	 * @param string $bootstrapFile The full path to the plugin bootstrap file
	 * @return WpAdvertiser
	 */
	public static function init($bootstrapFile)
	{
		$instance = self::getInstance();
		
		// Activation callbacks
		register_activation_hook($bootstrapFile, array($instance, 'activate'));
		
		// Action callbacks
		add_action('init', array($instance, 'registerThemeScripts'));
		add_action('wp_footer', array($instance, 'renderAdvertisement'));
		add_action('admin_menu', array($instance, 'registerOptionsPage'));
		add_action(self::HOOK . '-save-options', array($instance, 'saveOptionsPage'));
		
		// Other callbacks
		add_filter('plugin_action_links_' . self::HOOK, array($instance, 'renderSettingsLink'));
		
		return $instance;
	}
	
	/**
	 * Performs installation and upgrade actions if necessary
	 *
	 * @return void
	 */
	public function activate()
	{
		$installedVersion = $this->_options->getOption('version');
		
		// Not installed?
		if (null === $installedVersion)
		{
			$this->_install();
		}
		
		// Old version?
		elseif (version_compare($installedVersion, self::VERSION, '<'))
		{
			$this->_upgrade();
		}
	}
	
	/**
	 * Performs installation when plugin is activated for the first time
	 *
	 * @return void
	 */
	protected function _install()
	{
		$this->_options->setOption('version', self::VERSION)
			->setOption('generalPluginActive', false)
			->setOption('simpleBackgroundColor', '000000')
			->setOption('simpleFontColor', 'ffffff')
			->setOption('simpleFontSize', 12)
			->setOption('simpleLinkTarget', 'external')
			->setOption('simpleDestinationUrl', null)
			->setOption('simpleImageUrl', null)
			->setOption('simplePlainText', null)
			->save();
	}
	
	/**
	 * This method is called when the internal plugin state needs to be upgraded
	 *
	 * @return void
	 */
	protected function _upgrade()
	{
		$this->_options->setOption('version', self::VERSION)
			->save();
	}
	
	/**
	 * Registers the scripts and styles, in order to display advertisement in formatted container
	 *
	 * @return void
	 */
	public function registerThemeScripts()
	{
		if (!is_admin() || !$this->_options->getOption('generalPluginActive'))
		{
			wp_enqueue_style(self::HOOK . '-footer-theme-css', $this->_getPluginDirUrl() . '/css/wp-theme.css');
			wp_enqueue_script(self::HOOK . '-jquery-tools', $this->_getPluginDirUrl() . '/js/jquery.tools.min.js', array('jquery'));
			wp_enqueue_script(self::HOOK . '-footer-theme-js', $this->_getPluginDirUrl() . '/js/jquery.wp-theme.js', array('jquery'));
		}
	}
	
	/**
	 * Renders advertisement in the footer of the page
	 *
	 * @return void
	 */
	public function renderAdvertisement()
	{
		if (!$this->_options->getOption('generalPluginActive'))
		{
			return;
		}
		
		$this->_view->setTemplate('advertisement')
			->assign('pluginUrl', $this->_getPluginDirUrl());
		
		// Prepare and set the list of required fields
		$fields = array
		(
			'generalPluginActive',
			'simpleBackgroundColor', 'simpleFontColor', 'simpleFontSize', 'simpleLinkTarget', 'simpleDestinationUrl',
			'simpleImageUrl', 'simplePlainText'
		);
		
		foreach ($fields as $field)
		{
			$this->_view->assign($field, $this->_options->getOption($field));
		}
		
		// Display!
		$this->_view->render();
	}
	
	/**
	 * Save the results of a post from the options page
	 *
	 * @return void
	 */
	public function saveOptionsPage()
	{
		if (!isset($_POST['action']) || 'save' != $_POST['action'])
		{
			return;
		}
		
		// Protection
		check_admin_referer(self::OPTIONS_KEY);
		
		if (!current_user_can('manage_options'))
		{
			exit('You cannot change WPFooter Ad settings.');
		}
		
		// General settings
		$generalPluginActive = (bool) $_POST['generalPluginActive'];
		
		// Simple banner settings
		$simpleBackgroundColor = substr($_POST['simpleBackgroundColor'], 0, 6);
		$simpleFontColor = substr($_POST['simpleFontColor'], 0, 6);
		$simpleFontSize = (int) $_POST['simpleFontSize'];
		$simpleLinkTarget = strip_tags($_POST['simpleLinkTarget']);
		$simpleDestinationUrl = strip_tags($_POST['simpleDestinationUrl']);
		$simpleImageUrl = strip_tags($_POST['simpleImageUrl']);
		$simplePlainText = strip_tags(stripslashes($_POST['simplePlainText']));
		
		// Save options
		$this->_options
			->setOption('generalPluginActive', $generalPluginActive)
			->setOption('simpleBackgroundColor', $simpleBackgroundColor)
			->setOption('simpleFontColor', $simpleFontColor)
			->setOption('simpleFontSize', $simpleFontSize)
			->setOption('simpleLinkTarget', $simpleLinkTarget)
			->setOption('simpleDestinationUrl', $simpleDestinationUrl)
			->setOption('simpleImageUrl', $simpleImageUrl)
			->setOption('simplePlainText', $simplePlainText)
			->save();
		
		// Render the message
		$this->_view->messageHelper('Settings have been saved.');
	}
	
	/**
	 * Adds a sub-menu navigation item for this plugin
	 *
	 * @return void
	 */
	public function registerOptionsPage()
	{
		$page = add_submenu_page
		(
			'plugins.php',
			wp_specialchars('WP Footer  Ad'),
			wp_specialchars('WP Footer  Ad'),
			'manage_options',
			self::HOOK,
			array($this, 'renderOptionsPage')
		);
		
		add_action('admin_print_scripts-' . $page, array($this, 'enqueueAdminScripts'));
		add_action('admin_print_styles-' . $page, array($this, 'enqueueAdminStyles'));
	}
	
	/**
	 * Enqueues any javascript needed for this plugin
	 *
	 * @return void
	 */
	public function enqueueAdminScripts()
	{
		wp_enqueue_script('postbox');
		wp_enqueue_script('dashboard');
		wp_enqueue_script('thickbox');
		wp_enqueue_script('media-upload');
		wp_enqueue_script(self::HOOK . '-admin-jscolor', $this->_getPluginDirUrl() . '/js/jscolor/jscolor.js');
		wp_enqueue_script(self::HOOK . '-admin-js', $this->_getPluginDirUrl() . '/js/jquery.wp-admin.js', array('jquery'));
	}
	
	/**
	 * Enqueues any css needed for this plugin
	 *
	 * @return void
	 */
	public function enqueueAdminStyles()
	{
		wp_enqueue_style('thickbox');
		wp_enqueue_style(self::HOOK . '-admin-document-css', $this->_getPluginDirUrl() . '/css/wp-admin.css');
	}
	
	/**
	 * Adds a link to the plugin options page
	 *
	 * @param array $links The array of menu links
	 * @return array
	 */
	public function renderSettingsLink($links)
	{
		$this->_view->setTemplate('settings-link')
			->assign('href', 'plugins.php?page=' . self::HOOK)
			->assign('title', 'WordPress Advertiser Settings')
			->assign('text', 'Settings');
		
		array_unshift($links, $this->_view->fetch());
		
		return $links;
	}
	
	/**
	 * Fires save_options action hook and adds plugin information into admin footer
	 *
	 * @return void
	 */
	public function renderOptionsPage()
	{
		do_action(self::HOOK . '-save-options');
		
		add_action('in_admin_footer', array($this, 'renderAdminFooter'));
		
		// View setup
		$this->_view->setTemplate('settings-page');
		
		// List of fields
		$fields = array
		(
			'generalPluginActive',
			'simpleBackgroundColor', 'simpleFontColor', 'simpleFontSize', 'simpleLinkTarget', 'simpleDestinationUrl',
			'simpleImageUrl', 'simplePlainText'
		);
		
		foreach ($fields as $field)
		{
			$this->_view->assign($field, $this->_options->getOption($field));
		}
		
		// Finalize and render
		$this->_view->assign('heading', 'WP Footer Ad Settings')
			->assign('onceAction', self::OPTIONS_KEY)
			->assign('pluginUrl', $this->_getPluginDirUrl())
			->render();
	}
	
	/**
	 * Renders plugin information into the admin footer
	 *
	 * @return void
	 */
	public function renderAdminFooter()
	{
		$this->_view->setTemplate('settings-footer')
			->assign('pluginHref',   'http://www.stefandes.com/wordpress-plugin/wp-footer-ad')
			->assign('pluginText',   'WP Fotter Ad')
			->assign('pluginVersion', self::VERSION)
			->assign('authorHref',   'http://www.stefandes.com/')
			->assign('authorText',   'Stefan Des')
			->render();
	}
	
	/**
	 * Returns a base directory of plugin
	 *
	 * @return string
	 */
	protected function _getPluginDir()
	{
		static $pluginDir;
		
		if (empty($pluginDir))
		{
			$pluginDir = plugin_basename(__FILE__);
			$pluginDir = substr($pluginDir, 0, stripos($pluginDir, '/'));
		}
		
		return $pluginDir;
	}
	
	/**
	 * Return the URL directory path for plugin
	 *
	 * @return string
	 */
	protected function _getPluginDirUrl()
	{
		static $pluginUrl;
		
		if (empty($pluginUrl))
		{
			$pluginDir = $this->_getPluginDir();
			$pluginUrl = plugin_dir_url($pluginDir) . $pluginDir;
		}
		
		return $pluginUrl;
	}
}