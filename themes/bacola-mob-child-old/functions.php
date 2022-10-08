<?php

/**s
 * functions.php
 * @package WordPress
 * @subpackage Bacola
 * @since Bacola 1.0
 * 
 */

add_action( 'wp_enqueue_scripts', 'bacola_enqueue_styles', 99 );
function bacola_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_script('bacola-scroll-js', get_stylesheet_directory_uri() . '/assets/js/bacola-scroll.js', array( "jquery" ), "1.1", true );
	wp_enqueue_script('bacola-add-to-cart-js', get_stylesheet_directory_uri() . '/assets/js/bacola-add-to-cart.js', array( "jquery" ), "1.3", true );
	wp_deregister_style('bacola-base');
	wp_enqueue_style( 'bacola-child-base', 			get_stylesheet_directory_uri() . '/assets/css/base.css', false, '1.0');
	wp_enqueue_style( 'bacola-child-main', 			get_stylesheet_directory_uri() . '/assets/css/main.css', false, '1.0');
    wp_enqueue_script('bacola-js-index', get_stylesheet_directory_uri() . '/assets/js/index.js', array( "jquery" ), "3.6", true );
}
function update_user_location_callback() {
	$location = $_POST['pickup_location'];
	$user_agent = $_POST['user_agent'];
	
    $user_id        = get_current_user_id();                            // Get our current user ID
    //$first_name         = sanitize_text_field( $_POST['first_name'] );      // Sanitize our user meta value
    //$last_name  = sanitize_text_field( $_POST['last_name'] );      // Sanitize our user email field

    update_user_meta( $user_id, 'pickup_location', $location );
    update_user_meta( $user_id, 'sales_agent', $user_agent );
    //update_user_meta( $user_id, 'last_name', $last_name );
	$agents = get_posts(array(
      'post_type'   => 'agent',
      'post_status'   => 'publish',
	  'numberposts'  => -1
    ));
	echo '<option value="select_agent" selected>Select agent</option>';
	foreach($agents as $agent):
	$agent_location=get_post_meta($agent->ID, 'assign_location', true);
	//echo $agent_location;
	$loc_term = get_term_by('name', $location, 'location');
	//var_dump($agent_location);
	//var_dump($loc_term->term_id);
	if(intval($agent_location) === intval($loc_term->term_id)){ ?>
		<option value="<?php echo $agent->ID;?>" data-location="<?php echo $agent_location; ?>"><?php echo $agent->post_title;?></option>
	<?php 
		}
	endforeach;
    exit;
}
add_action( 'wp_ajax_nopriv_update_user_location', 'update_user_location_callback' );
add_action( 'wp_ajax_update_user_location', 'update_user_location_callback' );
function update_user_agent_callback() {
	//$location = $_POST['pickup_location'];
	$user_agent = $_POST['user_agent'];
	
    $user_id        = get_current_user_id();                            // Get our current user ID
    //$first_name         = sanitize_text_field( $_POST['first_name'] );      // Sanitize our user meta value
    //$last_name  = sanitize_text_field( $_POST['last_name'] );      // Sanitize our user email field

    //update_user_meta( $user_id, 'pickup_location', $location );
    update_user_meta( $user_id, 'sales_agent', $user_agent );
    
    exit;
}
add_action( 'wp_ajax_nopriv_update_user_agent', 'update_user_agent_callback' );
add_action( 'wp_ajax_update_user_agent', 'update_user_agent_callback' );
function agent_create_customer_callback() {
	$user_login = $_POST['user_login'];
	$user_name = explode(' ', $_POST['user_name']);
	$password = 'password';
	$email_address = 'webmaster@mydomain.com';
	
	if ( ! username_exists( $user_login ) ) {
		$user_id = wp_create_user( $user_login, $password, $email_address );
		$user = new WP_User( $user_id );
		$user->set_role( 'customer' );
		update_user_meta( $user_id, 'first_name', $user_name[0] );
		
		update_user_meta( $user_id, 'xoo-ml-user-reg-phone', $user_login );
		update_user_meta( $user_id, 'last_name', $user_name[1] );
	}else{
		?>
		Customer exist!
		<?php
	}
	
    exit;
}
add_action( 'wp_ajax_nopriv_agent_create_customer', 'agent_create_customer_callback' );
add_action( 'wp_ajax_agent_create_customer', 'agent_create_customer_callback' );


function um_modifications_callback() {
    $user_id      = get_current_user_id();                            // Get our current user ID
    $first_name   = sanitize_text_field( $_POST['first_name'] );      // Sanitize our user meta value
    $last_name    = sanitize_text_field( $_POST['last_name'] );      // Sanitize our user email field
    $phone        = sanitize_text_field( $_POST['user_phone'] );      // Sanitize our user email field

    update_user_meta( $user_id, 'first_name', $first_name );
    update_user_meta( $user_id, 'last_name', $last_name );
    update_user_meta( $user_id, 'billing_phone', $phone );

    exit;
}
add_action( 'wp_ajax_nopriv_um_cb', 'um_modifications_callback' );
add_action( 'wp_ajax_um_cb', 'um_modifications_callback' );
// Adding Meta container admin shop_order pages
add_action( 'add_meta_boxes', 'mv_add_meta_boxes' );
if ( ! function_exists( 'mv_add_meta_boxes' ) )
{
    function mv_add_meta_boxes()
    {
        add_meta_box( 'assign_location', __('Assign location','woocommerce'), 'mv_add_other_fields_for_packaging', 'shop_order', 'normal', 'core' );
    }
}

// Adding Meta field in the meta container admin shop_order pages
if ( ! function_exists( 'mv_add_other_fields_for_packaging' ) )
{
    function mv_add_other_fields_for_packaging()
    {
        global $post;

        $meta_field_data = get_post_meta( $post->ID, 'assign_location', true ) ? get_post_meta( $post->ID, 'assign_location', true ) : '';
		$locations = get_terms('location');
        echo '<input type="hidden" name="mv_other_meta_field_nonce" value="' . wp_create_nonce() . '">
        <p style="border-bottom:solid 1px #eee;padding-bottom:13px;">
			<select name="assign_location_field"><option value="Select location">Select location</option>';
		foreach($locations as $location):?>
			<option value="<?php echo $location->name; ?>"<?php if($meta_field_data === $location->name){ ?>selected<?php } ?>><?php echo $location->name; ?></option>
		<?php
		endforeach;
		echo '</select>
		</p>';

    }
}

// Save the data of the Meta field
add_action( 'save_post', 'mv_save_wc_order_other_fields', 10, 1 );
if ( ! function_exists( 'mv_save_wc_order_other_fields' ) )
{

    function mv_save_wc_order_other_fields( $post_id ) {

        // We need to verify this with the proper authorization (security stuff).

        // Check if our nonce is set.
        if ( ! isset( $_POST[ 'mv_other_meta_field_nonce' ] ) ) {
            return $post_id;
        }
        $nonce = $_REQUEST[ 'mv_other_meta_field_nonce' ];

        //Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $nonce ) ) {
            return $post_id;
        }

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }

        // Check the user's permissions.
        if ( 'page' == $_POST[ 'post_type' ] ) {

            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return $post_id;
            }
        } else {

            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return $post_id;
            }
        }
        // --- Its safe for us to save the data ! --- //

        // Sanitize user input  and update the meta field in the database.
        update_post_meta( $post_id, 'assign_location', $_POST[ 'assign_location_field' ] );
    }
}
/*// Admin billing fields
add_filter( 'woocommerce_admin_billing_fields', 'custom_admin_billing_fields', 10, 1 );
function custom_admin_billing_fields( $billing_fields ) {
    global $pagenow;
    if( $pagenow === 'post-new.php' && isset($_GET['post_type']) && $_GET['post_type'] === 'shop_order' ){
        unset($billing_fields['billing_address_1']);
		unset($billing_fields['billing_address_2']); 
    }
    return $billing_fields;
}

// Admin shipping fields
add_filter( 'woocommerce_admin_shipping_fields', 'custom_admin_shipping_fields', 10, 1 );
function custom_admin_shipping_fields( $shipping_fields ) {
    global $pagenow;
    if( $pagenow === 'post-new.php' && isset($_GET['post_type']) && $_GET['post_type'] === 'shop_order' ){
        unset($shipping_fields['country']); // remove shipping country field
    }
    return $shipping_fields;
}*/
/*add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
function custom_override_checkout_fields( $fields ) {
     unset($fields['billing']['billing_address_1']);
     unset($fields['billing']['billing_address_2']);
     unset($fields['billing']['billing_city']);
     unset($fields['billing']['billing_postcode']);
     unset($fields['billing']['billing_country']);
     unset($fields['billing']['billing_state']);
 
     return $fields;
}*/
//Change the 'Billing details' checkout label to 'Contact Information'
function wc_billing_field_strings( $translated_text, $text, $domain ) {
switch ( $translated_text ) {
case 'Billing details' :
$translated_text = __( 'Customer Details', 'woocommerce' );
break;
}
return $translated_text;
}
add_filter( 'gettext', 'wc_billing_field_strings', 20, 3 );
add_action('admin_head', 'custom_changes_css');

function custom_changes_css() {
  echo '<style>
    ._billing_company_field, ._billing_address_1_field, ._billing_address_2_field, ._billing_city_field, ._billing_postcode_field, ._billing_state_field, ._billing_country_field, ._billing_email_field, ._transaction_id_field, ._billing_state_field {
        display:none!important;
    }
	#order_data .order_data_column ._billing_state_field, #order_data .order_data_column ._billing_phone_field{
		width:100%;
	}
	#order_data .order_data_column:nth-child(2){
        width:64%;
    }
	#order_data .order_data_column:nth-child(2) h3{
		position:relative;
		color:#fff;
	}
	#order_data .order_data_column:nth-child(2) h3:before{
		content:"Customer Details";
		color:#000;
		position:absolute;
		top:0;
		left:0;
		width:100%;
	}
    .order_data_column:nth-child(3){
        display:none;
    }
  </style>';
}
/*add_action( 'woocommerce_new_order', 'save_billing_info' );
function save_billing_info( $order_id ){
	if ( ! $order_id )
        return;
	$order = wc_get_order( $order_id );
	$user_id = $order->get_customer_id();
	$user_first_name = get_user_meta( $user_id, 'first_name', true );
	$user_last_name = get_user_meta( $user_id, 'last_name', true );
	$agent = get_post_meta( $order_id, 'sales_agent', true );
	$agent_post = get_post($agent);
	$agent_name = get_the_title($agent_post);
	$user_info = get_userdata($user_id);
	$order->update_meta_data( '_billing_first_name', $user_first_name );
 	$order->update_meta_data( '_billing_last_name', $user_last_name );
 	$order->update_meta_data( '_billing_phone', $user_info->user_login );
	$order->update_meta_data( 'sales_agent_name', $agent_name );
	$order->save();
}*/
// add the action 
add_action( 'woocommerce_new_order', 'action_woocommerce_update_order' );
function action_woocommerce_update_order( $order_id ) { 
	if ( ! $order_id )
        return;
    $order = wc_get_order( $order_id );
	$user_id = $order->get_customer_id();
	$user_first_name = get_user_meta( $user_id, 'first_name', true );
	$user_last_name = get_user_meta( $user_id, 'last_name', true );
	$agent = get_post_meta( $order_id, 'sales_agent', true );
	$agent_post = get_post($agent);
	$agent_name = get_the_title($agent_post);
	$user_info = get_userdata($user_id);
	$order_bil_phone = get_post_meta($order_id, '_billing_phone', true );
	if($user_first_name){
		update_post_meta($order_id, '_billing_first_name', $user_first_name );
	}
	if($user_last_name){
		update_post_meta($order_id, '_billing_last_name', $user_last_name );
	}
	if($order_bil_phone){
		update_post_meta($order_id, '_billing_phone', $user_info->user_login );
	}
	update_post_meta($order_id, 'sales_agent_name', $agent_name );
	//$order->update_meta_data( '_billing_first_name', $user_first_name );
 	//$order->update_meta_data( '_billing_last_name', $user_last_name );
 	//$order->update_meta_data( '_billing_phone', $user_info->user_login );
	//$order->update_meta_data( 'sales_agent_name', $agent_name );
	//$order->save();
}; 

         
 
add_action('woocommerce_thankyou', 'save_order_agent', 10, 1);
function save_order_agent( $order_id ) {
    if ( ! $order_id )
        return;
    // Allow code execution only once 
    if( ! get_post_meta( $order_id, '_thankyou_action_done', true ) ) {
        // Get an instance of the WC_Order object
        $order = wc_get_order( $order_id );
		$user_id = $order->get_user_id();
		$user_data = get_userdata( $user_id );
		$user_roles = $user_data->roles;
		
		
 		

		$user_first_name = get_user_meta( $user_id, 'first_name', true );
		$user_last_name = get_user_meta( $user_id, 'last_name', true );
		$user_info = get_userdata($user_id);
		$total_quantity = $order->get_item_count();
		//$user_phone = get_user_meta( $user_id, 'display_name', true );
		update_user_meta($user_id, '_billing_first_name', $user_first_name);
		update_user_meta($user_id, '_billing_last_name', $user_last_name);
		update_user_meta($user_id, '_billing_phone', $user_info->user_login);
        // Get the order key
        $order_key = $order->get_order_key();
 
        // Get the order number
        $order_key = $order->get_order_number();
 		if ( in_array( 'agent', $user_roles, true ) ) {
			$agents = get_posts(array(
			  'post_type'   => 'agent',
			  'post_status'   => 'publish',
			  'numberposts'  => -1
			));
			foreach($agents as $agent):

			$agent_user=get_post_meta($agent->ID, 'assign_user', true);
			if(intval($user_id) === intval($agent_user)){
				//update_post_meta( $order_id, 'sales_agent', $agent->ID );
				$agent_name = get_the_title($agent);
				$agent_location=get_post_meta($agent->ID, 'assign_location', true);
				$loc_term = get_term($agent_location, 'location');
				$order->update_meta_data( 'sales_agent', $agent->ID );
				$agent_first_last_name = explode(' ', $agent_name);
				$order->update_meta_data( 'sales_agent_first_name', $agent_first_last_name[0]);
				$order->update_meta_data( 'sales_agent_last_name', $agent_first_last_name[1]);
				$agent_phone = get_user_meta( $agent_user, '_billing_phone', true );
				$order->update_meta_data( 'sales_agent_phone', $agent_phone );
				$order->update_meta_data( 'agent_location', $loc_term->name );
				$order->update_meta_data( 'assign_location', $loc_term->name );
				$order->update_meta_data( 'total_items_count', $total_quantity );
			}
			endforeach;
		}else{
			$agent = get_post_meta( $order_id, 'sales_agent', true );
			//$location = get_post_meta( $order_id, 'shipping_address', true );
			$agent_post = get_post($agent);
			$agent_name = get_the_title($agent_post);
			$agent_user=get_post_meta($agent_post->ID, 'assign_user', true);
			$agent_phone = get_user_meta( $agent_user, '_billing_phone', true );
			$agent_tel=get_post_meta($agent_post->ID, 'agent_phone', true);			
			$location=get_post_meta($agent_post->ID, 'assign_location', true);
			update_user_meta($user_id, 'sales_agent', $agent);
			//$sales_agent = $_POST['sales_agent'];
			//$order->update_meta_data('sales_agent', $sales_agent);
			$agent_first_last_name = explode(' ', $agent_name);
			$order->update_meta_data( 'sales_agent_first_name', $agent_first_last_name[0]);
			$order->update_meta_data( 'sales_agent_last_name', $agent_first_last_name[1]);
			$order->update_meta_data( 'sales_agent_phone', $agent_phone );
			$code 	= esc_attr( get_user_meta( $user_id, 'xoo_ml_phone_code', true ) );
			$number = esc_attr( get_user_meta( $user_id, 'xoo_ml_phone_no', true ) );
			$order->update_meta_data( 'customer_phone', $code . $number);
			$order->update_meta_data( 'sales_agent', $agent_post->ID );
 			$order->update_meta_data( 'assign_location', $location );
 			$order->update_meta_data( 'agent_tel', $agent_tel );
			$loc_term = get_term($location, 'location');
 			$order->update_meta_data( 'agent_location', $loc_term->name );
 			$order->update_meta_data( 'assign_location', $loc_term->name );
			$order->update_meta_data( 'total_items_count', $total_quantity );
			//update_user_meta($user_id, 'first_name', $sales_agent);
		}
		//$order->update_meta_data( 'sales_agent_name', $user_first_name . ' ' . $user_last_name);
			
			

 		//$order->update_meta_data( 'billing_first_name', $user_first_name );
 		//$order->update_meta_data( 'billing_last_name', $user_last_name );
 		//$order->update_meta_data( 'billing_phone', $user_info->user_login );
		
        // Flag the action as done (to avoid repetitions on reload for example)
        $order->update_meta_data( '_thankyou_action_done', true );
        $order->save();
    }
}

add_action( 'woocommerce_checkout_update_order_meta', 'save_customer_agent_field' );
function save_customer_agent_field( $order_id ) {
	$order = wc_get_order( $order_id );
	$user = $order->get_user_id();
	//$user_id = get_current_user_id();
    $user_data = get_userdata( $user );
    $user_roles = $user_data->roles;
	
	if ( in_array( 'agent', $user_roles, true ) ) {
	$add_cus_count_main = 0;
	$add_cus = $_POST['acf']['field_61e9cf9f44b38']['field_61e9cfcc44b39'];
	$add_cus_pomoja = $_POST['acf']['field_61fa47104f131']['field_61fa471051444'];
	$add_cus_count = count($add_cus);
	$add_cus_pomoja_count = count($add_cus_pomoja);
	$add_cus_count_main = $add_cus_pomoja_count + $add_cus_count;
	//$sales_agent = $_POST['sales_agent'][1];
	//update_post_meta($order_id, 'sales_agent', $sales_agent);
	if( ! empty( $add_cus ) ) {
		$value_cus = array(
		   'field_61e9cfcc44b39' => $add_cus
		);
		update_field('field_61e9cf9f44b38', $value_cus, $order_id);
	}
	
	if( ! empty( $add_cus_pomoja ) ) {
		$value_cus_pomoja = array(
		   'field_61fa471051444' => $add_cus_pomoja
		);
		update_field('field_61fa47104f131', $value_cus_pomoja, $order_id);
	}
	
	$customers_repeater = $_POST['acf']['field_61e9cf9f44b38']['field_61e9d11a6510d']; 
	foreach($customers_repeater as $customer):
		$add_cus_count_main++;
		$customer_phone = $customer['field_61e9d1476510f'];
		$customer_name = $customer['field_61e9d13d6510e'];
		$customer_lastname = $customer['field_61f8ffe23e0bf'];
		$email_address = $customer_phone . '@mydomain.com';
		if ( ! username_exists( $customer_phone ) ) {
			$user_id = wp_create_user( $customer_phone, 'password', $email_address );
			$user = new WP_User( $user_id );
			$user->set_role( 'customer' );
			update_user_meta( $user_id, 'first_name', $customer_name );
			update_user_meta( $user_id, 'last_name', $customer_lastname );
			update_user_meta( $user_id, 'xoo_ml_phone_no', $customer_phone );
			update_user_meta( $user_id, 'xoo_ml_phone_code', '+254' );
			update_user_meta( $user_id, 'xoo_ml_phone_display', '+254' . $customer_phone );
			update_user_meta( $user_id, 'sales_agent', $user );
		}else{
		}
	endforeach;
	
	if( ! empty( $customers_repeater ) ) {
		$value = array(
		   'field_61e9d11a6510d' => $customers_repeater
		);
		update_field('field_61e9cf9f44b38', $value, $order_id);
	}
	
	$customers_repeater_pomoja = $_POST['acf']['field_61fa47104f131']['field_61fa47105147f']; 
	foreach($customers_repeater_pomoja as $customer_pomoja):
		$add_cus_count_main++;
		$customer_phone = $customer_pomoja['field_61fa47105594b'];
		$customer_name = $customer_pomoja['field_61fa4710558db'];
		$customer_lastname = $customer_pomoja['field_61fa471055914'];
		$email_address = $customer_phone . '@mydomain.com';
		if ( ! username_exists( $customer_phone ) ) {
			$user_id = wp_create_user( $customer_phone, 'password', $email_address );
			$user = new WP_User( $user_id );
			$user->set_role( 'customer' );
			update_user_meta( $user_id, 'first_name', $customer_name );
			update_user_meta( $user_id, 'last_name', $customer_lastname );
			update_user_meta( $user_id, 'xoo_ml_phone_no', $customer_phone );
			update_user_meta( $user_id, 'xoo_ml_phone_code', '+254' );
			update_user_meta( $user_id, 'xoo_ml_phone_display', '+254' . $customer_phone );
			update_user_meta( $user_id, 'sales_agent', $user );
		}else{
		}
	endforeach;
	
	if( ! empty( $customers_repeater_pomoja ) ) {
		$value = array(
		   'field_61fa47105147f' => $customers_repeater_pomoja
		);
		update_field('field_61fa47104f131', $value, $order_id);
	}
	
	update_post_meta($order_id, 'total_count_of_customers', $add_cus_count_main );
	}
	
}


/* Variations add to cart */
function woocommerce_variable_add_to_cart(){
    global $product, $post;
 
    $variations = find_valid_variations();
 
    // Check if the special 'price_grid' meta is set, if it is, load the default template:
    if ( get_post_meta($post->ID, 'price_grid', true) ) {
        // Enqueue variation scripts
        wp_enqueue_script( 'wc-add-to-cart-variation' );
 
        // Load the template
        wc_get_template( 'single-product/add-to-cart/variable.php', array(
                'available_variations'  => $product->get_available_variations(),
                'attributes'            => $product->get_variation_attributes(),
                'selected_attributes'   => $product->get_variation_default_attributes()
            ) );
        return;
    }
 
    // Cool, lets do our own template!
    ?>
    <div class="variations variations-grid" cellspacing="0">

		
            <?php
            foreach ($variations as $key => $value) {
                if( !$value['variation_is_visible'] ) continue;
            ?>
            <p>


                <p>
                    <?php if( $value['is_in_stock'] ) { ?>
                    <form class="cart" action="<?php echo esc_url( $product->add_to_cart_url() ); ?>" method="post" enctype='multipart/form-data'>
                        <?php woocommerce_quantity_input(); ?>

                        <?php
                        if(!empty($value['attributes'])){
                            foreach ($value['attributes'] as $attr_key => $attr_value) {
                            ?>
                            <input type="hidden" name="<?php echo $attr_key?>" value="<?php echo $attr_value?>">
                            <?php
                            }
                        }
                        ?>
                        <button type="submit" class="single_add_to_cart_button btn btn-primary <?php foreach($value['attributes'] as $key => $val ) { echo $val; }?>" id="variadd">
						<p class="attr"><?php foreach($value['attributes'] as $key => $val ) { echo $val; }?>  </p>  
                        <?php echo $value['price_html'];?>
						</button>
					
                        <input type="hidden" name="variation_id" value="<?php echo $value['variation_id']?>" />
                        <input type="hidden" name="product_id" value="<?php echo esc_attr( $post->ID ); ?>" />
                        <input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $post->ID ); ?>" />
                    </form>
                    <?php } else { ?>
                        <p class="stock out-of-stock"><?php _e( 'This product is currently out of stock and unavailable.', 'woocommerce' ); ?></p>
                    <?php } ?>
                </p>
            </p>
            <?php } ?>
    </div>
    <?php
}
function find_valid_variations() {
    global $product;
 
    $variations = $product->get_available_variations();
    $attributes = $product->get_attributes();
    $new_variants = array();
 
    // Loop through all variations
    foreach( $variations as $variation ) {
 
        // Peruse the attributes.
 
        // 1. If both are explicitly set, this is a valid variation
        // 2. If one is not set, that means any, and we must 'create' the rest.
 
        $valid = true; // so far
        foreach( $attributes as $slug => $args ) {
            if( array_key_exists("attribute_$slug", $variation['attributes']) && !empty($variation['attributes']["attribute_$slug"]) ) {
                // Exists
 
            } else {
                // Not exists, create
                $valid = false; // it contains 'anys'
                // loop through all options for the 'ANY' attribute, and add each
                foreach( explode( '|', $attributes[$slug]['value']) as $attribute ) {
                    $attribute = trim( $attribute );
                    $new_variant = $variation;
                    $new_variant['attributes']["attribute_$slug"] = $attribute;
                    $new_variants[] = $new_variant;
                }
 
            }
        }
 
        // This contains ALL set attributes, and is itself a 'valid' variation.
        if( $valid )
            $new_variants[] = $variation;
 
    }
 
    return $new_variants;
}

/* My account tabs */

add_filter("um_change_default_tab","um_092821_change_default_account_tab"); 
function um_092821_change_default_account_tab( $tab ){
    $tab = 'woocommerce-MyAccount-navigation-link--orders'; // change this with your custom tab key
    return $tab;
}
add_filter( 'woocommerce_account_menu_items', 'custom_my_account_menu_items', 22, 1 );
function custom_my_account_menu_items( $items ) {
    $items['edit-address'] = __("SHIPPING / DELIVERY", "woocommerce");
    return $items;
}
add_action( 'parse_request', 'redirect_to_my_account_orders' );
function redirect_to_my_account_orders( $wp ) {
    // All other endpoints such as change-password will redirect to
    // my-account/orders
    $allowed_endpoints = [ 'orders', 'edit-address',  'dashboard', 'edit-account', 'customer-logout' ];

//    if (
//        is_user_logged_in() &&  preg_match( '%^my\-account(?:/([^/]+)|)/?$%', $wp->request, $m ) &&
//        ( empty( $m[1] ) || ! in_array( $m[1], $allowed_endpoints ) )
//    ) {
//        wp_redirect( '/my-account/dashboard/' );
//        exit;
//    }
}
/* woocommerce_order_number */
add_filter( 'woocommerce_order_number', 'custom_order_number', 1, 2 );
function custom_order_number( $order_id, $order ) {
    // Customer username
    $user = $order->get_user_id();
    $firstname = get_user_meta( $user, 'first_name', true );
    $lastname = get_user_meta( $user, 'last_name', true );

    return $order->id . ' ' . $firstname . ' ' . $lastname . ' - ' ;
}
/* Remove add_to_cart_message_html */
add_filter( 'wc_add_to_cart_message_html', '__return_false' );

if ( ! defined( 'WPINC' ) ) {
    die;
}

//* Add Logged In/Out class to <body> with WordPress
add_filter( 'body_class', 'login_status_body_class' );
function login_status_body_class( $classes ) {

    if (is_user_logged_in()) {
		if(!current_user_can('agent')){
			$classes[] = 'logged-in';
		}else{
			$classes[] = 'logged-in';
			$classes[] = 'agent';
		}
        
    } else {
        $classes[] = 'logged-out';
    }
    return $classes;

}

if(  is_user_logged_in() && trim( $_SERVER["REQUEST_URI"] , '/' ) == 'my-account' ){
    remove_action(
        'woocommerce_account_navigation',
        'woocommerce_account_navigation'
    );
}

add_filter ( 'woocommerce_account_menu_items', 'remove_my_account_links', 99 );
function remove_my_account_links( $menu_links ){

    unset( $menu_links['dashboard'] ); // Remove Dashboard
    unset( $menu_links['edit-address'] ); // Addresses
    unset( $menu_links['orders'] ); // Remove Orders
    unset( $menu_links['downloads'] ); // Disable Downloads
    unset( $menu_links['edit-account'] ); // Disable Downloads

    //unset( $menu_links['edit-account'] ); // Remove Account details tab
    //unset( $menu_links['payment-methods'] ); // Remove Payment Methods
    //unset( $menu_links['customer-logout'] ); // Remove Logout link

    return $menu_links;

}
/*add_action( 'woocommerce_checkout_update_order_meta', 'save_customer_agent_pomoja_field' );
function save_customer_agent_pomoja_field( $order_id ) {
	
}*/



// For billing email and phone - Make them not required
add_filter( 'woocommerce_billing_fields', 'filter_billing_fields', 20, 1 );
function filter_billing_fields( $billing_fields ) {
    // Only on checkout page
    if( ! is_checkout() ) return $billing_fields;

    //$billing_fields['billing_phone']['required'] = false;
    $billing_fields['billing_email']['required'] = false;
    return $billing_fields;
}

//Rename to basket

apply_filters( 'woocommerce_get_cart_url', wc_get_page_permalink( 'basket' ) );
function gb_change_cart_string($translated_text, $text, $domain) {

    $translated_text = str_replace("cart", "basket", $translated_text);

    $translated_text = str_replace("Cart", "Basket", $translated_text);

    return $translated_text;
}

add_filter('gettext', 'gb_change_cart_string', 100, 3);



/*add_action('woocommerce_checkout_update_order_meta', 'checkout_customer_field_update_order_meta');
function checkout_customer_field_update_order_meta( $order_id ) {
			$field_name = '_billing_first_name';
			$field_value = $_POST['acf']['field_61f7a6ca161b2'];
     if ( ! empty( $field_value ) ) {
       	 	update_post_meta( $order_id, $field_name , $field_value );
    }
				$field_name = '_billing_last_name';
			$field_value = $_POST['acf']['field_61f7a70e9440c'];
     if ( ! empty( $field_value ) ) {
       	 	update_post_meta( $order_id, $field_name , $field_value );
    }			$field_name = '_billing_phone';
			$field_value = $_POST['acf']['field_61f7a71d9440d'];
     if ( ! empty( $field_value ) ) {
       	 	update_post_meta( $order_id, $field_name , $field_value );
    }}*/
/* Functions End */
function create_login_cookie() {
    setcookie("user_logedin", $user_login, time()+3600);
}
add_action( 'woocommerce_login_form_end', 'create_login_cookie', 10, 0 ); 
?>
