<?php

/**
 * Kapu Ops team Plugin
 * Plugin Name: Kapu Ops team offline time setting.
 * Description: This plugin set Kapu Ops team offline time.
 * @package WooCommerce\Admin
 */

// Block direct access to file
defined( 'ABSPATH' ) or die( 'Not Authorized!' );

// Plugin Defines
define( "KAPU_OFFLINE_FILE", __FILE__ );
define( "KAPU_OFFLINE_DIRECTORY", dirname(__FILE__) );
define( "KAPU_OFFLINE_TEXT_DOMAIN", dirname(__FILE__) );
define( "KAPU_OFFLINE_DIRECTORY_BASENAME", plugin_basename( KAPU_OFFLINE_FILE ) );
define( "KAPU_OFFLINE_DIRECTORY_PATH", plugin_dir_path( KAPU_OFFLINE_FILE ) );
define( "KAPU_OFFLINE_DIRECTORY_URL", plugins_url( null, KAPU_OFFLINE_FILE ) );

function create_kapu_offline_database_table() {

    global $wpdb;
    $tblname = 'kapu_offline_time';
    $wp_track_table = $wpdb->prefix . "$tblname";
  
    $sql = "CREATE TABLE IF NOT EXISTS $wp_track_table ( ";
    $sql .= "  `id`                       int(11)           NOT NULL auto_increment, ";
    $sql .= "  `start_time`               char(10)	        NOT NULL, ";
    $sql .= "  `end_time`                 char(10)          NOT NULL, ";
    $sql .= "  `selected_country`         text	            NOT NULL, ";
    $sql .= "  `selected_country_text`    text	            NOT NULL, ";
    $sql .= "  `selected_timezone`        text              NOT NULL, ";
    $sql .= "  `selected_timezone_text`   text              NOT NULL, ";
    $sql .= "  `msg_title`                text              NOT NULL, ";
    $sql .= "  `msg_contents`             text              NOT NULL, ";
    $sql .= "  `offline_state`            int(2)            NOT NULL, ";
    $sql .= "  PRIMARY KEY `order_id` (`id`) ";
    $sql .= ") ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ; ";
    require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
    dbDelta($sql);
  
}
register_activation_hook( __FILE__, 'create_kapu_offline_database_table' );

function drop_kapu_offline_database_table()
{
    global $wpdb;
    $tblname = $wpdb->prefix . 'kapu_offline_time';
    $sql = "DROP TABLE IF EXISTS $tblname";
    $rslt=$wpdb->query($sql);

}
register_deactivation_hook( __FILE__, 'drop_kapu_offline_database_table' );

require_once( KAPU_OFFLINE_DIRECTORY . '/include/kapu-set-offline-time-class.php' );
