<?php
function ajax_qty_cart() {
    $product_id = $_POST['product_id'];
    $variation_id = $_POST['variation_id'];
    $quantity = $_POST['quantity'];
    $_product   = wc_get_product($variation_id);;
    $cart_item_key = tl_get_cart_item_key($product_id, $variation_id);
    $now_in_cart = WC()->cart->get_cart_item( $cart_item_key )['quantity'] ?? 0;
    $max_amoun = intval($_product->get_meta('variation_maximum_allowed_quantity'));
    $max_amoun = $max_amoun == 0 ? 9999 : $max_amoun; 
    $min_amoun = intval($_product->get_meta('variation_minimum_allowed_quantity'));
    $stock_qnt = $_product->get_stock_quantity();
    $quantity = $quantity > $max_amoun ? $max_amoun : $quantity;
    $quantity = $quantity > $stock_qnt ? $stock_qnt : $quantity;
    $opt_2_add = '';
    if($cart_item_key == ''){
        WC()->cart->add_to_cart( $product_id, $quantity, $variation_id);
        $opt_2_add = "create new";
    } else{
        WC()->cart->set_quantity( $cart_item_key, $quantity, true );
        $opt_2_add = "set new qnt";
    }
    $return = array(
        'cart_contents_count'  => WC()->cart->get_cart_contents_count(),
        'newItemQnt' => $quantity,
        'variationId' => $variation_id,
        'opt_2_add' => $opt_2_add,
        'max_amoun' => $max_amoun,
        'stock_qnt' => $stock_qnt,
        'lastClickedChange' => $_POST['lastClickedChange']
    );
    wp_send_json($return);
}

add_action('wp_ajax_qty_cart', 'ajax_qty_cart');
add_action('wp_ajax_nopriv_qty_cart', 'ajax_qty_cart');

function tl_get_cart_item_key($product_id , $variation_id)
{
    $cart_item_key = '';
    foreach(WC()->cart->get_cart_contents() as $cart_item){
        if($cart_item['product_id'] == $product_id && $cart_item['variation_id'] == $variation_id){
            $cart_item_key = $cart_item['key'];
            break;
        }
    }
    return $cart_item_key;
}