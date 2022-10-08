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

}


function um_modifications_callback() {
    // Ensure we have the data we need to continue
    /*if( ! isset( $_POST ) || empty( $_POST ) || ! is_user_logged_in() ) {

        // If we don't - return custom error message and exit
        header( 'HTTP/1.1 400 Empty POST Values' );
        echo 'Could Not Verify POST Values.';
        exit;
    }*/

    $user_id        = get_current_user_id();                            // Get our current user ID
    $first_name         = sanitize_text_field( $_POST['first_name'] );      // Sanitize our user meta value
    $last_name  = sanitize_text_field( $_POST['last_name'] );      // Sanitize our user email field

    update_user_meta( $user_id, 'first_name', $first_name );
    update_user_meta( $user_id, 'last_name', $last_name );
    /*wp_update_user( array(
        'ID'            => $user_id,
        'user_email'    => $um_user_email,
    ) );*/

    exit;
}
add_action( 'wp_ajax_nopriv_um_cb', 'um_modifications_callback' );
add_action( 'wp_ajax_um_cb', 'um_modifications_callback' );


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
add_filter ( 'woocommerce_account_menu_items', 'misha_remove_my_account_links' );
function misha_remove_my_account_links( $menu_links ){
	
	//	unset( $menu_links['edit-address'] ); // Addresses
	
	
	//unset( $menu_links['dashboard'] ); // Remove Dashboard
	//unset( $menu_links['payment-methods'] ); // Remove Payment Methods
	//unset( $menu_links['orders'] ); // Remove Orders
	 unset( $menu_links['downloads'] ); // Disable Downloads
	//unset( $menu_links['edit-account'] ); // Remove Account details tab
	//unset( $menu_links['customer-logout'] ); // Remove Logout link
	
	return $menu_links;
	
}
add_action( 'parse_request', 'redirect_to_my_account_orders' );
function redirect_to_my_account_orders( $wp ) {
    // All other endpoints such as change-password will redirect to
    // my-account/orders
    $allowed_endpoints = [ 'orders', 'edit-address',  'dashboard', 'edit-account', 'customer-logout' ];

    if (
        is_user_logged_in() &&  preg_match( '%^my\-account(?:/([^/]+)|)/?$%', $wp->request, $m ) &&
        ( empty( $m[1] ) || ! in_array( $m[1], $allowed_endpoints ) )
    ) {
        wp_redirect( '/my-account/orders/' );
        exit;
    } 
}
/* woocommerce_order_number */
add_filter( 'woocommerce_order_number', 'custom_order_number', 1, 2 );
function custom_order_number( $order_id, $order ) {
    // Customer username
    $user = $order->get_user_id();
    $firstname = get_user_meta( $user, 'first_name', true );
    $lastname = get_user_meta( $user, 'last_name', true );

    return $order->id . ' ' . $firstname . ' ' . $lastname . '-' ;
}

/* Functions End */
?>