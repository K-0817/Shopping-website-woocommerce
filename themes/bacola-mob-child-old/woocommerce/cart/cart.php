<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>
<div class="row content-wrapper sidebar-right">
	<div class="col-12 col-md-12 col-lg-12 content-primary">
		<div class="cart-wrapper">
		
			<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
				<?php do_action( 'woocommerce_before_cart_table' ); ?>

                <div class="flex-header">
                    <div class="item-fc thumbnail">&nbsp;</div>
                    <div class="item-fc product"><?php esc_html_e( 'Product', 'bacola' ); ?></div>
                    <div class="item-fc price"><?php esc_html_e( 'Price', 'bacola' ); ?></div>
                    <div class="item-fc quantity"><?php esc_html_e( 'Quantity', 'bacola' ); ?></div>
                    <div class="item-fc subtotal"><?php esc_html_e( 'Subtotal', 'bacola' ); ?></div>
                    <div class="item-fc actions">&nbsp;</div>
                </div>
                <?php do_action( 'woocommerce_before_cart_contents' ); ?>

                <?php
                foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                    $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                    $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
                    if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                        $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                        ?>
                        <div class="pp-wrap woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
                            <div class="tl-main-cart-content">
                                <div class="dn">
                                    <div class="item-fc thumbnail">
                                        <?php
                                        $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

                                        if ( ! $product_permalink ) {
                                            echo bacola_sanitize_data($thumbnail); // PHPCS: XSS ok.
                                        } else {
                                            printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
                                        }
                                        ?>
                                    </div>
                                    <div class="item-fc product" data-title="<?php esc_attr_e( 'Product', 'bacola' ); ?>">
                                        <?php
                                        if ( ! $product_permalink ) {
                                            echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
                                        } else {
                                            echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
                                        }

                                        do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

                                        // Meta data.
                                        echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

                                        // Backorder notification.
                                        if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
                                            echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'bacola' ) . '</p>', $product_id ) );
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="pp-item_wrap">
                                    <div>
                                        <div class="catalog__item-img img-wrap">
                                            <div>
                                                <picture>
                                                    <?php echo apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key ); ?>
                                                </picture>
                                            </div>
                                        </div>
                                        <div class="tl-price" style="width: 37px;"></div>
                                    </div>
                                    <div class="tl-item-title" attr-js-selecot="item-title"><?php echo $_product->name; ?></div>
                                </div>

                                <div class="item-fc price" data-title="<?php esc_attr_e( 'Price', 'bacola' ); ?>">
                                    <?php
                                    echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
                                    ?>
                                </div>
                                <div class="df tl-cart-controll">
                                    <div class="item-fc quantity" data-title="<?php esc_attr_e( 'Quantity', 'bacola' ); ?>">
                                        <?php
                                        $max_qnt =  intval( $_product->get_meta('variation_maximum_allowed_quantity'));
                                        $has_qnt = intval( $cart_item['quantity']);
                                        // echo "max " . $max_qnt;
                                        // echo "val " . $has_qnt;
                                        $is_max_amount = $max_qnt == 0
                                            ? false
                                            : $max_qnt === $has_qnt;
                                        // echo $is_max_amount;
                                        if ( $_product->is_sold_individually() ) {
                                            $product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
                                        } else {
                                            $product_quantity = woocommerce_quantity_input(
                                                array(
                                                    'input_name'   => "cart[{$cart_item_key}][qty]",
                                                    'input_value'  => $cart_item['quantity'],
                                                    'max_value'    => $_product->get_max_purchase_quantity(),
                                                    'min_value'    => '1',
                                                    'step'         => '1',
                                                    'product_name' => $_product->get_name(),
                                                ),
                                                $_product,
                                                false
                                            );
                                        }

                                        echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
                                        ?>
                                    </div>
                                    <div class="item-fc actions">
                                        <?php
                                        echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                            'woocommerce_cart_item_remove_link',
                                            sprintf(
                                                '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><i class="icon-cremove"></i>%s</a>',
                                                esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                                esc_html__( 'Remove this item', 'bacola' ),
                                                esc_attr( $product_id ),
                                                esc_attr( $_product->get_sku() ),
                                                esc_html__( 'Remove', 'bacola' )
                                            ),
                                            $cart_item_key
                                        );
                                        ?>
                                    </div>
                                </div>

                            </div>
                            <?php echo tl_get_msg_max_qnt($has_qnt == $max_qnt ? false : true); ?>
                        </div>
                        <?php
                    }
                }
                ?>

                <?php do_action( 'woocommerce_cart_contents' ); ?>

                <td colspan="6" class="actions">
                    <div class="actions-wrapper">
                        <?php if ( wc_coupons_enabled() ) { ?>
                            <div class="coupon">
                                <label for="coupon_code"><?php esc_html_e( 'Coupon:', 'bacola' ); ?></label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'bacola' ); ?>" /> <button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'bacola' ); ?>"><?php esc_attr_e( 'Apply coupon', 'bacola' ); ?></button>
                                <?php do_action( 'woocommerce_cart_coupon' ); ?>
                            </div>
                        <?php } ?>

                        <button type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'bacola' ); ?>"><?php esc_html_e( 'Update cart', 'bacola' ); ?></button>

                        <?php do_action( 'woocommerce_cart_actions' ); ?>

                        <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
                    </div>
                </td>

                <?php do_action( 'woocommerce_after_cart_contents' ); ?>

				<?php do_action( 'woocommerce_after_cart_table' ); ?>
			</form>

			<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

			<div class="cart-collaterals">
				<?php
					/**
					 * Cart collaterals hook.
					 *
					 * @hooked woocommerce_cross_sell_display
					 * @hooked woocommerce_cart_totals - 10
					 */
					do_action( 'woocommerce_cart_collaterals' );
				?>
			</div>
		</div>
	</div>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
 