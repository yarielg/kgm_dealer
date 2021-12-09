<?php
/*
*
* @package yariko


Plugin Name:  Kgm Dealers Step Checkout.
Plugin URI:   https://thomasgbennett.com/
Description:  This plugin create a 4-step checkout depending if the product on cart required a FFL license
Version:      1.0.0
Author:       Bennet Group (Yariel Gordillo)
Author URI:   https://thomasgbennett.com/
Tested up to: 5.3.2
Text Domain:  kgm_dealer
Domain Path:  /languages
*/

defined('ABSPATH') or die('You do not have access, sally human!!!');

define ( 'KGM_PLUGIN_VERSION', '1.0.0');

if( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php') ){
    require_once  dirname( __FILE__ ) . '/vendor/autoload.php';
}
//Change WRPL for plugin's initials
define('KGM_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define('KGM_PLUGIN_URL' , plugin_dir_url(  __FILE__  ) );
define('KGM_ADMIN_URL' , get_admin_url() );
define('KGM_PLUGIN_DIR_BASENAME' , dirname(plugin_basename(__FILE__)) );

//include the helpers
include 'inc/util/helpers.php';
if( class_exists( 'Kgm\\Inc\\Init' ) ){
    register_activation_hook( __FILE__ , array('Kgm\\Inc\\Base\\Activate','activate') );
    Kgm\Inc\Init::register_services();
}



