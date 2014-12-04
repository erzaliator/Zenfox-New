<?php
/**
 * Plugin Name: WP Footer Ad
 * Plugin URI:  http://www.stefandes.com/wordpress-plugin/wp-footer-ad/
 * Description: WP Footer Ad allows to set up banners to be displayed in the footer
 * Version:     0.1
 * Author:      Stefan Des
 * Author URI:  http://www.stefandes.com/
 *
 * Copyright 2010 Stefan Des
 */

//ini_set('display_errors', 'on');
//error_reporting(E_ALL);

require_once 'library/WpAdvertiser/WpAdvertiser_Exception.php';
require_once 'library/WpAdvertiser/WpAdvertiser_Options.php';
require_once 'library/WpAdvertiser/WpAdvertiser_View.php';
require_once 'library/WpAdvertiser.php';

WpAdvertiser::init(__FILE__);