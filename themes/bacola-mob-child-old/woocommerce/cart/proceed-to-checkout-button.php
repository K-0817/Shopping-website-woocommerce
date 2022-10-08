<?php
/**
 * Proceed to checkout button
 *
 * Contains the markup for the proceed to checkout button on the cart.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/proceed-to-checkout-button.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="tl-cart-345">
		<div class="pp-controll-links">
			<a class="tl-start-checkout xoo-cp-btn-ch xcp-btn" href="<?php echo wc_get_checkout_url(); ?>">Start Checkout</a>
			<div>or</div>
			<a class="tl-continue-shopping" href="<?php echo get_home_url('/'); ?>">continue shopping</a>
		</div>
		</div>

<!-- 
<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="tl-checkout-button checkout-button button alt wc-forward">
START CHECKOUT
	<?php //esc_html_e( 'Proceed to checkout', 'woocommerce' ); ?>
</a> -->
