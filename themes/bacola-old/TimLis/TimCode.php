<?php

require_once get_template_directory() . '/TimLis/TlAddToCartAjax.php';

add_action('wp_enqueue_scripts', 'registerTimLisAssets');
function registerTimLisAssets() {
    wp_enqueue_script('registerTimLisAssets-js', get_template_directory_uri() . '/TimLis/TimLis.js', array('jquery'), '1.0', true);
    wp_enqueue_script('registerTimLisShopFilter-js', get_template_directory_uri() . '/TimLis/js/ShopFilter.js', array('jquery'), '1.0', true);
    wp_enqueue_script('loginPopup-js', get_template_directory_uri() . '/TimLis/js/loginPopup.js', array('jquery'), '1.0', true);
    
    // wp_enqueue_script('AddToCartAjax-js', get_template_directory_uri() . '/TimLis/js/AddToCartAjax.js', array('jquery'), '1.0', true);
    
    // wp_enqueue_style('registerTimLisAssets-css', get_template_directory_uri() . '/TimLis/TimLisStyle.css');
    wp_enqueue_style('newCatalogStyles-css', get_template_directory_uri() . '/TimLis/app.css');
}

add_action( 'init', 'register_new_order_status' );
function register_new_order_status() {
    function _register_post_status($new_post_status, $label){
        register_post_status( 
            $new_post_status, 
            array(
                'label'                     => $label,
                'public'                    => true,
                'exclude_from_search'       => false,
                'show_in_admin_all_list'    => true,
                'show_in_admin_status_list' => true,
                'label_count'               => _n_noop( $label .' (%s)', $label .' (%s)' )
            ) 
        );
    };
    _register_post_status('wc-gross-order', 'Gross Order');
    _register_post_status('wc-valid-order', 'Valid Order');
}

add_filter( 'wc_order_statuses', 'add_new_order_statuses' );
function add_new_order_statuses( $order_statuses ) {
    $new_order_statuses = array();
    foreach ( $order_statuses as $key => $status ) {
        $new_order_statuses[ $key ] = $status;
        if ( 'wc-processing' === $key ) {
            $new_order_statuses['wc-gross-order'] = 'Gross Order';
            $new_order_statuses['wc-valid-order'] = 'Valid Order';
        } 
    }
    return $new_order_statuses;
}

add_filter( 'bulk_actions-edit-shop_order', 'register_new_bulk_actions' ); 
function register_new_bulk_actions( $bulk_actions ) {
	$bulk_actions['change_status_2_gross_order'] = 'Change status to Gross Order';
	$bulk_actions['change_status_2_valid_order'] = 'Change status to Valid Order';
	return $bulk_actions;
}

add_filter( 'bulk_actions-edit-shop_order', 'tl_remove_bulk_actions', 999 );
function tl_remove_bulk_actions( $actions ) {
    //Remove on hold and processing status from bulk actions
    unset( $actions['mark_on-hold'], $actions['mark_processing'] );
    return $actions;
}

add_filter( 'wc_order_statuses', 'tl_remove_processing_status' );
function tl_remove_processing_status( $statuses ){
    if( isset( $statuses['wc-processing'] ) ){
        unset( $statuses['wc-processing'] );
    }
    if( isset( $statuses['wc-on-hold'] ) ){
        unset( $statuses['wc-on-hold'] );
    }
    return $statuses;
}

add_action( 'admin_action_change_status_2_gross_order', 'action_change_status_2_gross_order' ); // admin_action_{action name}
add_action( 'admin_action_change_status_2_valid_order', 'action_change_status_2_valid_order' ); // admin_action_{action name}

function action_change_status_2_gross_order() {
    change_order_status_2('wc-gross-order');
}

function action_change_status_2_valid_order() {
    change_order_status_2('wc-valid-order');
}

function change_order_status_2($new_status) {
	if( !isset( $_REQUEST['post'] ) && !is_array( $_REQUEST['post'] ) )// if an array with order IDs is not presented, exit the function
		return;
		
	foreach( $_REQUEST['post'] as $order_id ) {
		$order = new WC_Order( $order_id );
		$order_note = 'Edited by bulk:';
		$order->update_status( $new_status, $order_note, true );
	}
	
	$location = add_query_arg( array(
        'post_type' => 'shop_order',
		'ids' => $_REQUEST['post'],
		'post_status' => 'all'
	), 'edit.php' );

	wp_redirect( admin_url( $location ) );
	exit;
}

function get_formatted_order_status( $woo_status, $is_customer = true){
    switch($woo_status){
        case('valid-order'):
            $woo_status = "Confirmed";
            break;
        case('gross-order'):
            $woo_status = "Processing";
            break;
        case('completed'):
            $woo_status = "Delivered";
            break;
        case('cancelled'):
            $woo_status = "Cancelled";
            break;
    }
    return $woo_status;
}

function tl_get_msg_max_qnt(bool $display_none) : string
{
    $visible_class = $display_none === true ? 'dn' : 'df';
    return "<span class='tip-is-max-amount {$visible_class}'>
        Max. quantity for this customer order reached
    </span>";
}

// add_filter( 'formatted_woocommerce_price', 'ts_woo_decimal_price', 999, 5 );
// function ts_woo_decimal_price( $formatted_price, $price, $decimal_places, $decimal_separator, $thousand_separator ) {
// 	$unit = number_format( intval( $price ), 0, $decimal_separator, $thousand_separator );
// 	$decimal = sprintf( '%02d', ( $price - intval( $price ) ) * 100 );
//     print($decimal . "|");
//     if($decimal == "00")
//         $decimal = '00';
//         return 99;
// 	return $unit . '.' . $decimal ;
//     // $has_needle = str_contains($price, ".") ? "has" : "empty";
//     // print($price . "|" . $has_needle);

//     // if(!str_contains($price, "."))
//     //     $price .= ".00";
//     // return $price;
// }


if (! function_exists('dd')) {
    function dd(...$args){
        echo "<pre>";
        echo "<hr>";
        foreach ($args as $val) {
            echo "<hr>";
            var_dump($val);
            echo "<hr>";
        }
        echo "</pre>";
        die;
    }
}

function tl_is_need_login_template(){
    return str_ends_with(get_page_template(),'need-login.php');
}

add_filter( 'show_admin_bar', 'hide_admin_bar' );
function hide_admin_bar(){ return false; }



add_filter( 'loop_shop_per_page', 'tl_lw_loop_shop_per_page', 30 );

function tl_lw_loop_shop_per_page( $products ) {
 $products = get_field('show_products_per_page', 4056) ?? 50;
 return $products;
}