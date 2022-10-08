<?php

// Block direct access to file
defined( 'ABSPATH' ) or die( 'Not Authorized!' );

class Kapu_Ops_team_Offline_time {

    private $result = null;

    public function __construct() {

        // Plugin uninstall hook
        register_uninstall_hook( KAPU_OFFLINE_FILE, array('Kapu_Ops_team_Offline_time', 'plugin_uninstall') );

        // Plugin activation/deactivation hooks
        register_activation_hook( KAPU_OFFLINE_FILE, array($this, 'plugin_activate') );
        register_deactivation_hook( KAPU_OFFLINE_FILE, array($this, 'plugin_deactivate') );

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

        $this->result = $wpdb->get_results("SELECT * FROM `wp_kapu_offline_time` WHERE id = '1'");
        
        if(!$this->result){
            $wpdb->insert("wp_kapu_offline_time", array(
                "id" => "1",
                "start_time" => "21:00",
                "end_time" => "06:00",
                "selected_country" => "KE",
                "selected_country_text" => "Kenya",
                "selected_timezone" => "Africa/Nairobi",
                "selected_timezone_text" => "(UTC+03:00) E. Africa",
                "msg_title" => "We're closed for today.",
                "msg_contents" => "Ordering on Kapu is closed for today. 
                Our hours of operations are from 6:00 AM to 9:00 PM Mon-Sun.",
                "offline_state" => "1",
            ));
        }

        wp_register_style( 'wps-settime-style', KAPU_OFFLINE_DIRECTORY_URL . '/assets/css/style.css', array(), null );
        
        wp_enqueue_script('jquery');
        wp_register_script( 'moment-script', KAPU_OFFLINE_DIRECTORY_URL . '/assets/js/moment.js' );
        wp_register_script( 'moment_timezone-script', KAPU_OFFLINE_DIRECTORY_URL . '/assets/js/moment-timezone-with-data.min.js');
        wp_register_script( 'wps-settime-script', KAPU_OFFLINE_DIRECTORY_URL . '/assets/js/main.js', array(), null, true );
        wp_enqueue_style('wps-settime-style');  
        wp_enqueue_script('moment-script');
        wp_enqueue_script('moment_timezone-script');
        wp_enqueue_script('wps-settime-script');
 
    }

    function plugin_admin_menu_function() {

        add_submenu_page( 'options-general.php', 'Set offline time', 'Set offline time', 'manage_options', 'kapu_offline_time_settings_page', array($this, 'kapu_offline_time_settings_page') );
    
    }

    function so_enqueue_scripts(){
        wp_register_script( 
          'ajaxHandle', 
          plugins_url(KAPU_OFFLINE_DIRECTORY_URL . 'assets/js/main.js', __FILE__), 
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

        $this->result = $wpdb->get_results("SELECT * FROM `wp_kapu_offline_time` WHERE id = '1'");
        $temp = str_replace( "\'", "'", $_POST["msg_title"]);
        $data = array(
            "id" => "1",
            "start_time" => $_POST["start_time"],
            "end_time" => $_POST["end_time"],
            "selected_country" => $_POST["selected_country"],
            "selected_country_text" => $_POST["selected_country_text"],
            "selected_timezone" => $_POST["selected_timezone"],
            "selected_timezone_text" => $_POST["selected_timezone_text"],
            "msg_title" => $temp,
            "msg_contents" => $_POST["msg_contents"],
        );

        if($this->result && $this->result[0]->offline_state == 1){
           $wpdb->update("wp_kapu_offline_time",  $data, array( "id" => "1"));
           echo '1';
        }

        wp_die(); // ajax call must die to avoid trailing 0 in your response
    }

    function kapu_offline_time_set_state_ajax_function(){
        global $wpdb;
        $wpdb->update("wp_kapu_offline_time", array('offline_state' => $_POST['state']), array( 'id' => '1'));
        wp_die();
    }

    function kapu_offline_time_settings_page() { ?>
        <div class="kapu_offline_container">
            <form>
                <div>
                    <input name="kapu_offline_selected_country" id="kapu_offline_selected_country" value="<?php echo $this->result[0]->selected_country; ?>" hidden>
                    <input name="kapu_offline_path" id="kapu_offline_path" value="<?php echo admin_url( 'admin-ajax.php' ) ?>" hidden />
                    <h1>Set kapuafrica site offline time.</h1>
                    <div class="kapu_offline_container">
                        <label class="switch">
                            <input type="checkbox" name="kapu_offline_set_option" id="kapu_offline_set_option" <?php if($this->result[0]->offline_state == 1){ echo 'checked';}else{echo ' ';}?>>
                            <span class="slider round"></span>
                        </label>
                    </div>
    
                    <div class="kapu_offline_container" style="margin-top: 15px">
                        <div>
                            <label for="kapu_offline_start_off_hour">Start Offline time :</label>
                            <input type="time" class="kapu_offline" id="kapu_offline_start_off_hour" name="kapu_offline_start_off_hour" style="width: 150px; margin-left: 10px;" value="<?php echo $this->result[0]->start_time ?>" <?php if($this->result[0]->offline_state == 1){ echo ' ';}else{echo 'disabled';}?>>
                        </div>
    
                        <div style="margin-top: 10px"> 
                            <label for="kapu_offline_end_off_hour"> End Offline time  : </label>
                            <input type="time" class="kapu_offline" id="kapu_offline_end_off_hour" name="kapu_offline_end_off_hour" style="width: 150px; margin-left: 15px;" value="<?php echo $this->result[0]->end_time ?>" <?php if($this->result[0]->offline_state == 1){ echo ' ';}else{echo 'disabled';}?>>
                        </div>
                    </div>
    
                    <div class="kapu_offline_container">
                        <div>
                            <div>
                                <div id="kapu_offline_calContainer">
                                    <label class=" control-label calendar-legend-section-header-text">Timezone Selector</label>
                                    <div style="margin-top: 15px">
                                        <div>
                                            <select class="kapu_offline form-control timezone-selector" name="kapu_offline_eventsCalCountry" id="kapu_offline_eventsCalCountry" <?php if($this->result[0]->offline_state == 1){ echo ' ';}else{echo 'disabled';}?>><option value="AF">Afghanistan</option><option value="AL">Albania</option><option value="DZ">Algeria</option><option value="AD">Andorra</option><option value="AO">Angola</option><option value="AI">Anguilla</option><option value="AG">Antigua &amp; Barbuda</option><option value="AR">Argentina</option><option value="AM">Armenia</option><option value="AW">Aruba</option><option value="AU">Australia</option><option value="AT">Austria</option><option value="AZ">Azerbaijan</option><option value="BS">Bahamas</option><option value="BH">Bahrain</option><option value="BD">Bangladesh</option><option value="BB">Barbados</option><option value="BY">Belarus</option><option value="BE">Belgium</option><option value="BZ">Belize</option><option value="BJ">Benin</option><option value="BM">Bermuda</option><option value="BT">Bhutan</option><option value="BO">Bolivia</option><option value="BA">Bosnia &amp; Herzegovina</option><option value="BW">Botswana</option><option value="BR">Brazil</option><option value="GB">Britain (UK)</option><option value="IO">British Indian Ocean Territory</option><option value="BN">Brunei</option><option value="BG">Bulgaria</option><option value="BF">Burkina Faso</option><option value="BI">Burundi</option><option value="KH">Cambodia</option><option value="CM">Cameroon</option><option value="CA">Canada</option><option value="CV">Cape Verde</option><option value="BQ">Caribbean NL</option><option value="KY">Cayman Islands</option><option value="CF">Central African Rep.</option><option value="TD">Chad</option><option value="CL">Chile</option><option value="CN">China</option><option value="CX">Christmas Island</option><option value="CC">Cocos (Keeling) Islands</option><option value="CO">Colombia</option><option value="KM">Comoros</option><option value="CD">Congo (Dem. Rep.)</option><option value="CG">Congo (Rep.)</option><option value="CK">Cook Islands</option><option value="CR">Costa Rica</option><option value="HR">Croatia</option><option value="CU">Cuba</option><option value="CW">Curacao</option><option value="CY">Cyprus</option><option value="CZ">Czech Republic</option><option value="CI">Côte d'Ivoire</option><option value="DK">Denmark</option><option value="DJ">Djibouti</option><option value="DM">Dominica</option><option value="DO">Dominican Republic</option><option value="TL">East Timor</option><option value="EC">Ecuador</option><option value="EG">Egypt</option><option value="SV">El Salvador</option><option value="GQ">Equatorial Guinea</option><option value="ER">Eritrea</option><option value="EE">Estonia</option><option value="ET">Ethiopia</option><option value="FK">Falkland Islands</option><option value="FO">Faroe Islands</option><option value="FJ">Fiji</option><option value="FI">Finland</option><option value="FR">France</option><option value="GF">French Guiana</option><option value="PF">French Polynesia</option><option value="GA">Gabon</option><option value="GM">Gambia</option><option value="GE">Georgia</option><option value="DE">Germany</option><option value="GH">Ghana</option><option value="GI">Gibraltar</option><option value="GR">Greece</option><option value="GL">Greenland</option><option value="GD">Grenada</option><option value="GP">Guadeloupe</option><option value="GU">Guam</option><option value="GT">Guatemala</option><option value="GG">Guernsey</option><option value="GN">Guinea</option><option value="GW">Guinea-Bissau</option><option value="GY">Guyana</option><option value="HT">Haiti</option><option value="HN">Honduras</option><option value="HK">Hong Kong</option><option value="HU">Hungary</option><option value="IS">Iceland</option><option value="IN">India</option><option value="ID">Indonesia</option><option value="IR">Iran</option><option value="IQ">Iraq</option><option value="IE">Ireland</option><option value="IM">Isle of Man</option><option value="IL">Israel</option><option value="IT">Italy</option><option value="JM">Jamaica</option><option value="JP">Japan</option><option value="JE">Jersey</option><option value="JO">Jordan</option><option value="KZ">Kazakhstan</option><option value="KE">Kenya</option><option value="KI">Kiribati</option><option value="KP">Korea (North)</option><option value="KR">Korea (South)</option><option value="KW">Kuwait</option><option value="KG">Kyrgyzstan</option><option value="LA">Laos</option><option value="LV">Latvia</option><option value="LB">Lebanon</option><option value="LS">Lesotho</option><option value="LR">Liberia</option><option value="LY">Libya</option><option value="LI">Liechtenstein</option><option value="LT">Lithuania</option><option value="LU">Luxembourg</option><option value="MO">Macau</option><option value="MK">Macedonia</option><option value="MG">Madagascar</option><option value="MW">Malawi</option><option value="MY">Malaysia</option><option value="MV">Maldives</option><option value="ML">Mali</option><option value="MT">Malta</option><option value="MH">Marshall Islands</option><option value="MQ">Martinique</option><option value="MR">Mauritania</option><option value="MU">Mauritius</option><option value="YT">Mayotte</option><option value="MX">Mexico</option><option value="FM">Micronesia</option><option value="MD">Moldova</option><option value="MC">Monaco</option><option value="MN">Mongolia</option><option value="ME">Montenegro</option><option value="MS">Montserrat</option><option value="MA">Morocco</option><option value="MZ">Mozambique</option><option value="MM">Myanmar (Burma)</option><option value="NA">Namibia</option><option value="NR">Nauru</option><option value="NP">Nepal</option><option value="NL">Netherlands</option><option value="NC">New Caledonia</option><option value="NZ">New Zealand</option><option value="NI">Nicaragua</option><option value="NE">Niger</option><option value="NG">Nigeria</option><option value="NU">Niue</option><option value="NF">Norfolk Island</option><option value="MP">Northern Mariana Islands</option><option value="NO">Norway</option><option value="OM">Oman</option><option value="PK">Pakistan</option><option value="PW">Palau</option><option value="PS">Palestine</option><option value="PA">Panama</option><option value="PG">Papua New Guinea</option><option value="PY">Paraguay</option><option value="PE">Peru</option><option value="PH">Philippines</option><option value="PN">Pitcairn</option><option value="PL">Poland</option><option value="PT">Portugal</option><option value="PR">Puerto Rico</option><option value="QA">Qatar</option><option value="RO">Romania</option><option value="RU">Russia</option><option value="RW">Rwanda</option><option value="RE">Réunion</option><option value="AS">Samoa (American)</option><option value="WS">Samoa (western)</option><option value="SM">San Marino</option><option value="ST">Sao Tome &amp; Principe</option><option value="SA">Saudi Arabia</option><option value="SN">Senegal</option><option value="RS">Serbia</option><option value="SC">Seychelles</option><option value="SL">Sierra Leone</option><option value="SG">Singapore</option><option value="SK">Slovakia</option><option value="SI">Slovenia</option><option value="SB">Solomon Islands</option><option value="SO">Somalia</option><option value="ZA">South Africa</option><option value="SS">South Sudan</option><option value="ES">Spain</option><option value="LK">Sri Lanka</option><option value="BL">St Barthelemy</option><option value="SH">St Helena</option><option value="KN">St Kitts &amp; Nevis</option><option value="LC">St Lucia</option><option value="SX">St Maarten (Dutch)</option><option value="MF">St Martin (French)</option><option value="PM">St Pierre &amp; Miquelon</option><option value="VC">St Vincent</option><option value="SD">Sudan</option><option value="SR">Suriname</option><option value="SJ">Svalbard &amp; Jan Mayen</option><option value="SZ">Swaziland</option><option value="SE">Sweden</option><option value="CH">Switzerland</option><option value="SY">Syria</option><option value="TW">Taiwan</option><option value="TJ">Tajikistan</option><option value="TZ">Tanzania</option><option value="TH">Thailand</option><option value="TG">Togo</option><option value="TK">Tokelau</option><option value="TO">Tonga</option><option value="TT">Trinidad &amp; Tobago</option><option value="TN">Tunisia</option><option value="TR">Turkey</option><option value="TM">Turkmenistan</option><option value="TC">Turks &amp; Caicos Is</option><option value="TV">Tuvalu</option><option value="UM">US minor outlying islands</option><option value="UG">Uganda</option><option value="UA">Ukraine</option><option value="AE">United Arab Emirates</option><option value="US">United States</option><option value="UY">Uruguay</option><option value="UZ">Uzbekistan</option><option value="VU">Vanuatu</option><option value="VA">Vatican City</option><option value="VE">Venezuela</option><option value="VN">Vietnam</option><option value="VG">Virgin Islands (UK)</option><option value="VI">Virgin Islands (US)</option><option value="WF">Wallis &amp; Futuna</option><option value="EH">Western Sahara</option><option value="YE">Yemen</option><option value="ZM">Zambia</option><option value="ZW">Zimbabwe</option><option value="AX">Åland Islands</option></select> 
                                        </div>
                                        <div>
                                            <select class="kapu_offline form-control timezone-selector" name="kapu_offline_eventsCalTimezone" id="kapu_offline_eventsCalTimezone" <?php if($this->result[0]->offline_state == 1){ echo ' ';}else{echo 'disabled';}?>><option value="America/New_York">(UTC-05:00) Eastern</option><option value="America/Chicago">(UTC-06:00) Central</option><option value="America/Denver">(UTC-07:00) Mountain</option><option value="America/Phoenix">(UTC-07:00) Mountain - AZ</option><option value="America/Los_Angeles">(UTC-08:00) Pacific</option><option value="America/Anchorage">(UTC-09:00) Alaskan</option><option value="Pacific/Honolulu">(UTC-10:00) Hawaiian</option></select>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                        </div>
                    </div>
    
                    <div class="kapu_offline_container">
                        <div>
                            <label> Message Title </label>
                            <div style="margin-top: 15px"> 
                                <input type="text" class="kapu_offline" name="kapu_offline_msg_title" id="kapu_offline_msg_title" style="width: 250px" value="<?php echo $this->result[0]->msg_title ?> " <?php if($this->result[0]->offline_state == 1){ echo ' ';}else{echo 'disabled';}?>/>
                            </div>
                        </div>
    
                        <div style="margin-top: 15px">
                            <label> Message Contents </label>
                            <div style="margin-top: 15px"> 
                                <textarea class="kapu_offline" name="kapu_offline_msg_contents" id="kapu_offline_msg_contents" <?php if($this->result[0]->offline_state == 1){ echo ' ';}else{echo 'disabled';}?>><?php echo $this->result[0]->msg_contents ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="margin-left: 120px;">
                    <input type="button" name="kapu_offline_btn_save" id="kapu_offline_btn_save" class="kapu_offline kapu_offline_save_btn" value="Set offline time" <?php if($this->result[0]->offline_state == 1){ echo ' ';}else{echo 'disabled';}?>/>
                </div>
            </form>
        </div>
    <?php } 

}

new Kapu_Ops_team_Offline_time;

