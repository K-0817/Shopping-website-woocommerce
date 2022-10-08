<?php
/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

/*
 * @hooked wc_empty_cart_message - 10
 */
do_action( 'woocommerce_cart_is_empty' );
if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
    <main>
    <section class="basket">
      <div class="basket__top">
        <div class="basket__simple-title simple-title">basket</div>
      </div>
      <div class="center-wrap">
        <div class="basket__body">
          <div class="basket__img-wrap img-wrap">
            <div><img src="<?php echo get_template_directory_uri(); ?>/TimLis/NewCatalogPage/assets/images/svg/basket-icon1.svg" alt=""></div>
          </div>
          <div class="basket__content">
            <p>Your Kapu basket is empty</p>
          </div><a class="basket__link" href="<?php echo get_home_url(); ?>">shop today’s offers</a>
        </div>
      </div>
    </section>
  </main>
<?php endif; ?>
