<?php

// Block direct access to file
defined( 'ABSPATH' ) or die( 'Not Authorized!' );

class Get_phone_number {

    private $result = null;

    public function __construct() {

        // Plugin uninstall hook
        register_uninstall_hook( GET_PHONE_FILE, array('Kapu_Ops_team_Offline_time', 'plugin_uninstall') );

        // Plugin activation/deactivation hooks
        register_activation_hook( GET_PHONE_FILE, array($this, 'plugin_activate') );
        register_deactivation_hook( GET_PHONE_FILE, array($this, 'plugin_deactivate') );

        // Plugin Actions
        add_action( 'admin_enqueue_scripts', array($this, 'plugin_init') );
        add_action( 'admin_menu', array($this, 'plugin_admin_menu_function') );
        add_action( 'wp_enqueue_scripts', array($this, 'so_enqueue_scripts') );

        add_action( "wp_ajax_kapu_offline_time_set_data", array($this,"kapu_offline_time_set_data_ajax_function" ));
        add_action( "wp_ajax_nopriv_kapu_offline_time_set_data", array($this,"kapu_offline_time_set_data_ajax_function" ));

        add_action( "wp_ajax_kapu_offline_time_set_state", array($this,"kapu_offline_time_set_state_ajax_function" ));
        add_action( "wp_ajax_nopriv_kapu_offline_time_set_state", array($this,"kapu_offline_time_set_state_ajax_function" ));
    }

    public static function plugin_uninstall() { }

    /**
     * Plugin activation function
     * called when the plugin is activated
     * @method plugin_activate
     */
    public function plugin_activate() { }

    /**
     * Plugin deactivate function
     * is called during plugin deactivation
     * @method plugin_deactivate
     */
    public function plugin_deactivate() { }

    /**
     * Plugin init function
     * init the polugin textDomain
     * @method plugin_init
     */
    function plugin_init() {
        // before all load plugin text domain
        global $wpdb;
        $tblname = 'postmeta';
        $wp_track_table = $wpdb->prefix . "$tblname";

        // // $this->result = $wpdb->get_results("SHOW TABLES LIKE '%'");
        // 07[^0-9]*123[^0-9]*456'm
        // ^[0-9]{12}
        // ^[+][0-9]{12}$
        // (^[+][0-9]+\ )?([0-9]{3}\-[0-9]{3}\-[0-9]{4})(\ x[0-9]+$)
        // [0-9]{1}-[0-9]{3}-[0-9]{3}-[0-9]{4}
        // ^[(][0-9]{3}[)]*[0-9]{3}-[0-9]{4}
        $this->result = $wpdb->get_results("SELECT `meta_value` FROM `$wp_track_table` WHERE `meta_value` REGEXP '(^[+][0-9]+\ )?([0-9]{3}\-[0-9]{3}\-[0-9]{4})(\ x[0-9]+$)'");
        
        wp_register_style( 'wps-settime-style', GET_PHONE_DIRECTORY_URL . '/assets/css/style.css', array(), null );
        
        wp_enqueue_script('jquery');
        wp_register_script( 'moment-script', GET_PHONE_DIRECTORY_URL . '/assets/js/moment.js' );
        wp_register_script( 'moment_timezone-script', GET_PHONE_DIRECTORY_URL . '/assets/js/moment-timezone-with-data.min.js');
        wp_register_script( 'wps-settime-script', GET_PHONE_DIRECTORY_URL . '/assets/js/main.js', array(), null, true );
        wp_enqueue_style('wps-settime-style');  
        wp_enqueue_script('moment-script');
        wp_enqueue_script('moment_timezone-script');
        wp_enqueue_script('wps-settime-script');
 
    }

    

    function plugin_admin_menu_function() {
        add_submenu_page( 'options-general.php', 'Get phone numbers', 'Get phone numbers', 'manage_options', 'Get_phone_numbers_page', array($this, 'kapu_offline_time_settings_page') );
    }

    function so_enqueue_scripts(){
        wp_register_script( 
          'ajaxHandle', 
          plugins_url(GET_PHONE_DIRECTORY_URL . 'assets/js/main.js', __FILE__), 
          array(), 
          false, 
          true 
        );
        wp_enqueue_script( 'ajaxHandle' );
        wp_localize_script( 
          'ajaxHandle', 
          'ajax_object', 
          array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) 
        );
    }
    
    function kapu_offline_time_set_data_ajax_function(){
        
        global $wpdb;

        $this->result = $wpdb->get_results("SELECT `meta_value` FROM `wp_kapu_offline_time` WHERE id = '1'");
        
        wp_die(); // ajax call must die to avoid trailing 0 in your response
    }

    function kapu_offline_time_settings_page() { 

        var_dump($this->result );
        // $phone_numbers = [];
        // foreach($this->result as $index=>$value){
        //     if(preg_match("/^[0-9]{3}-[0-9]{4}-[0-9]{4}$/", $value)) {
        //          $phone_numbers[$index] = $value;
        //     }
        //     if(preg_match('/^[0-9]{ 9,14}\z/', $value)){
        //          $phone_numbers[$index] = $value;
        //     }
        //     if(preg_match('/^[+][0-9]/', $value)){
        //          $phone_numbers[$index] = $value;
        //     }
        // }
        // global $wpdb;
        // foreach($this->result as $index => $value) {
        //     foreach($value as $tableName) {
        //         // echo '<span>'.$index.'</span> '. $tableName . '<br />';
                
        //         // An array of Field names
        //         $existing_columns = $wpdb->get_col("DESC {$tableName}", 0);
        //         var_dump($existing_columns);

        //     }
        // }    
      
    } 

}

new Get_phone_number;

