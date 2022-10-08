<?php

/**
 * Get all phone number from database Plugin
 * Plugin Name: Get phone number.
 * Description: Get all phone number from wordpress database.
 * @package WooCommerce\Admin
 */

// Block direct access to file
defined( 'ABSPATH' ) or die( 'Not Authorized!' );

// Plugin Defines
define( "GET_PHONE_FILE", __FILE__ );
define( "GET_PHONE_DIRECTORY", dirname(__FILE__) );
define( "GET_PHONE_TEXT_DOMAIN", dirname(__FILE__) );
define( "GET_PHONE_DIRECTORY_BASENAME", plugin_basename( GET_PHONE_FILE ) );
define( "GET_PHONE_DIRECTORY_PATH", plugin_dir_path( GET_PHONE_FILE ) );
define( "GET_PHONE_DIRECTORY_URL", plugins_url( null, GET_PHONE_FILE ) );

require_once( GET_PHONE_DIRECTORY . '/include/get-phone-number-class.php' );
