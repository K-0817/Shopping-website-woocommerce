<?php
/**
 * Checkout shipping information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-shipping.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */

defined('ABSPATH') || exit;

add_action( 'woocommerce_before_shipping', 'wpbl_select_field' );


/* add_action( 'woocommerce_before_shipping', 'customer_name_field' );
add_action( 'woocommerce_before_shipping', 'wpbl_checkbox_filed' ); */


$user_location = get_user_meta(get_current_user_id(), 'pickup_location', true);
function wpbl_checkbox_filed( $checkout ) {
	if(!current_user_can('agent')){
    $args = array(
        'taxonomy' => 'location',
        'hide_empty' => false,
    );

    $agent_locations = get_terms($args);

    $array = [];
    $array[''] = 'Select Location';
    foreach ($agent_locations as $location) {
        if (strtolower(bacola_location()) == strtolower($location->name)) {
            $default = $location->name;
        }
        $array[$location->term_id] = $location->name;
    }
    woocommerce_form_field( 'pickup_locations', array(
        'type'          => 'select',
        'required'    => false,
        'label'         => 'Pickup Location <span>*</span>',
        'options'    => $array
    ), $default );
	}else{
	?>
    <div class="form-row customers-aditional-info" style="line-height: 34px;">
        <div class="items-count" style="margin-top:0;">Order will be delivered to your location in:</div>
        <div class="checkout-agent-location" style="margin-left: 5px"><?php echo bacola_location(); ?> </div>
    </div>
	<?php
	}
}
function wpbl_select_field( $checkout ){
	if(!current_user_can('agent')){
		$user_agent = intval(get_user_meta(get_current_user_id(), 'sales_agent', true));
		$args = array(
			'post_type' => 'agent',
			'post_status' => 'publish',
			'posts_per_page' => -1,
		);
		$agents = get_posts($args);
		$array = [];
		$array[''] = 'Select Agent';
		foreach ($agents as $agent) {
			if(intval($user_agent) == intval($agent->ID)){
				//var_dump($agent->ID);
				$default = $agent->post_title;
			}
			$array[$agent->ID] = $agent->post_title;
		}
		woocommerce_form_field( 'sales_agent', array(
			'type'          => 'select',
			'required'    => false,
			'label'         => 'Pickup Location Service Agent <span>*</span>',
			'options'    => $array
		), $default );
	}
}

function customer_name_field( $checkout ){
if(is_user_logged_in()):
	if(current_user_can('agent')){
        woocommerce_form_field( 'customer_name', array(
            'type'          => 'text',
            'required'    => true,
            'label'         => 'Customer name<span>*</span>',
        ) );
        woocommerce_form_field( 'customer_phone', array(
            'type'          => 'tel',
            'required'    => true,
            'label'         => 'Customer phone<span>*</span>',
        ) );
    }
endif;
}

?>
<div class="woocommerce-additional-fields">
    <?php 
    do_action('woocommerce_before_shipping', $checkout);
	if(current_user_can('agent')){
    ?>
 	<!-- <div class="form-row add-customer-btn-block">
		<p class="user-error-msg" style="display: none;">Fill customer fields!</p>
		<span class="add-user-agent-checkout">Add customer</span>
		<span class="msg-user-added" style="display: none;">Customer added!</span>
	</div>  -->
	<?php
	}
	?>
</div>

