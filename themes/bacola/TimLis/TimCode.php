<?php

require_once get_template_directory() . '/TimLis/TlAddToCartAjax.php';

add_action('wp_enqueue_scripts', 'registerTimLisAssets');
function registerTimLisAssets() {
    wp_enqueue_script('registerTimLisAssets-js', get_template_directory_uri() . '/TimLis/TimLis.js', array('jquery'), filemtime( get_theme_file_path('/TimLis/TimLis.js') ), true);
    wp_enqueue_script('registerTimLisShopFilter-js', get_template_directory_uri() . '/TimLis/js/ShopFilter.js', array('jquery'), filemtime( get_theme_file_path('/TimLis/js/ShopFilter.js') ), true);
    wp_enqueue_script('loginPopup-js', get_template_directory_uri() . '/TimLis/js/loginPopup.js', array('jquery'), filemtime( get_theme_file_path('/TimLis/js/loginPopup.js') ), true);
    
    // wp_enqueue_script('AddToCartAjax-js', get_template_directory_uri() . '/TimLis/js/AddToCartAjax.js', array('jquery'), '1.0', true);
    
    // wp_enqueue_style('registerTimLisAssets-css', get_template_directory_uri() . '/TimLis/TimLisStyle.css');
    wp_enqueue_style('newCatalogStyles-css', get_template_directory_uri() . '/TimLis/app.css', false, filemtime( get_theme_file_path('/TimLis/app.css') ));
}

add_filter( 'wc_order_statuses', 'kapucom_remove_unused_statuses', 20 );
function kapucom_remove_unused_statuses( $statuses ){

    if( isset( $statuses['wc-pending'] ) ){
        unset( $statuses['wc-pending'] );
    }
    if( isset( $statuses['wc-on-hold'] ) ){
        unset( $statuses['wc-on-hold'] );
    }
    if( isset( $statuses['wc-refunded'] ) ){
        unset( $statuses['wc-refunded'] );
    }    
    if( isset( $statuses['wc-failed'] ) ){
        unset( $statuses['wc-failed'] );
    }

    return $statuses;
}

add_filter( 'bulk_actions-edit-shop_order', 'remove_a_bulk_order_action', 20, 1 );
function remove_a_bulk_order_action( $actions ) {
    if( isset( $actions['mark_on-hold'] ) ){
        unset( $actions['mark_on-hold'] );
    }

    return $actions;
}

add_filter( 'wc_order_is_editable', 'kapucom_make_processing_orders_editable', 10, 2 );
function kapucom_make_processing_orders_editable( $is_editable, $order ) {
    if ( $order->get_status() == 'processing' ) {
        $is_editable = true;
    }

    return $is_editable;
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
