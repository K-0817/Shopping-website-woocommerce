<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="woocommerce-order">

	<?php
	if ( $order ) :

		do_action( 'woocommerce_before_thankyou', $order->get_id() );
		?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
				<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'woocommerce' ); ?></a>
				<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My account', 'woocommerce' ); ?></a>
				<?php endif; ?>
			</p>

		<?php else : ?>

			<?php /*?><p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ), $order ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p><?php */?>
			<div class="order-details-block">
				<div class="left-block">
					<p>order #<?php echo $order->get_id(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
					<span>Order placed</span>
				</div>
				<div class="right-block">
					<div class="order-status"><?php echo $order->get_status();?></div>
					<span><?php echo wc_format_datetime( $order->get_date_created() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
				</div>
			</div>
			<hr class="order-border">
			<?php /*?><ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">

				<li class="woocommerce-order-overview__order order">
					<?php esc_html_e( 'Order number:', 'woocommerce' ); ?>
					<strong><?php echo $order->get_id(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<li class="woocommerce-order-overview__date date">
					<?php esc_html_e( 'Date:', 'woocommerce' ); ?>
					<strong><?php echo wc_format_datetime( $order->get_date_created() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
					<li class="woocommerce-order-overview__email email">
						<?php esc_html_e( 'Email:', 'woocommerce' ); ?>
						<strong><?php echo $order->get_billing_email(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
					</li>
				<?php endif; ?>

				<li class="woocommerce-order-overview__total total">
					<?php esc_html_e( 'Total:', 'woocommerce' ); ?>
					<strong><?php echo $order->get_formatted_order_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<?php if ( $order->get_payment_method_title() ) : ?>
					<li class="woocommerce-order-overview__payment-method method">
						<?php esc_html_e( 'Payment method:', 'woocommerce' ); ?>
						<strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
					</li>
				<?php endif; ?>

			</ul><?php */?>

		<?php endif; ?>

		<?php //do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
		<?php /*?><div class="items-title">items</div><?php */?>
		<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>
		
	<?php else : ?>

		<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ), null ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>

	<?php endif; ?>
<?php /*?><?php if( current_user_can('!!!agent')){ ?>
<h2 class="woocommerce-column__title">Customers chosen to the order</h2>

<?php $userids = get_post_meta($order->ID,'existing',true);
foreach ($userids as $userid) { 
$user = get_user_by( 'id', $userid ); 
echo $user->first_name.' ';
echo $user->user_login.'<br>'; } ?>
<br>
<h2 class="woocommerce-column__title">Customers added to the order</h2>

<?php if( have_rows('or_add_a_new', $order->ID) ):

    // Loop through rows.
    while( have_rows('or_add_a_new', $order->ID ) ) : the_row();
        // Load sub field value.
        $sub_name = get_sub_field('name');
        $sub_phone = get_sub_field('phone');
        echo  $sub_name.' ';
        echo  $sub_phone.'<br>';

    // End loop.
    endwhile;
endif; ?>
<?php } ?>	<?php */?>
</div>
<div class="all-orders-btn-wrapper">
    <a class="all-orders-btn" href="/my-account/">View All Orders</a>
</div>
<div class="confirmation_pop-up_wrapper" id="confirmation_pop-up_wrapper-thank">
	<div class="confirmation_pop-up">
		<div class="content-wraper">
			<div class="top-text">Your order has been placed!</div>
			<div class="bottom-text">Congratulations, your order has been successully placed. Tap on “OK” to view and track latest updates regarding this order.</div>
			<div class="close-btn">OK</div>
		</div>
	</div>
</div>
<style>
	.woocommerce-order-received .woocommerce .woocommerce-order{
		padding: 20px;
		border: 1px solid #F7F8FD;
		margin-bottom: 20px;
	}
	.all-orders-btn-wrapper{
		width: 100%;
		text-align: center;
		min-height: 40px;
		margin-bottom: 60px;
	}
	.all-orders-btn-wrapper a{
		padding: 12px 70px;
		font-size: 12px;
		font-weight: 200;
		min-width: 240px;
		color: #fff;
		background: #FF7700;
		border-radius: 2px;
	}
	address{
		margin: 0;
	}
</style>