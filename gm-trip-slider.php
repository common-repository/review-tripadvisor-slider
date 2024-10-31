<?php
/**
 * Plugin Name: Review Slider for Tripadvisor
 * Description: Review Slider for Tripadvisor to get all riview of particular hotel
 * Version:     1.0 
 * Author:      Gravity Master
 * License:     GPLv2 or later
 * Text Domain: gmtrip
 */

/* Stop immediately if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/* All constants should be defined in this file. */
if ( ! defined( 'GMTRIP_PREFIX' ) ) {
	define( 'GMTRIP_PREFIX', 'gmtrip' );
}
if ( ! defined( 'GMTRIP_PLUGIN_DIR' ) ) {
	define( 'GMTRIP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'GMTRIP_PLUGIN_BASENAME' ) ) {
	define( 'GMTRIP_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
}
if ( ! defined( 'GMTRIP_PLUGINURL' ) ) {
	define( 'GMTRIP_PLUGINURL', plugin_dir_url( __FILE__ ) );
}

/* Auto-load all the necessary classes. */
if( ! function_exists( 'gmtrip_class_auto_loader' ) ) {
	
	function gmtrip_class_auto_loader( $class ) {
		
		$includes = GMTRIP_PLUGIN_DIR . 'includes/' . $class . '.php';
		
		if( is_file( $includes ) && ! class_exists( $class ) ) {
			include_once( $includes );
			return;
		}
		
	}
}
spl_autoload_register('gmtrip_class_auto_loader');

/* Initialize all modules now. */
include GMTRIP_PLUGIN_DIR . 'includes/GMTRI_simple_html_dom.php';
global $gmtri_admin;
$gmtri_admin = new GMTRI_Admin();
new GMTRI_Shortcode();
include GMTRIP_PLUGIN_DIR . 'includes/GMTRI_Cron.php';

?>