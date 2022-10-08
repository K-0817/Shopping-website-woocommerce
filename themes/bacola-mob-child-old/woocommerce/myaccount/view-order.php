<?php
/**
 * View Order
 *
 * Shows the details of a particular order on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/view-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

defined( 'ABSPATH' ) || exit;

$notes = $order->get_customer_order_notes();
?>

<?php
//printf(
//	/* translators: 1: order number 2: order date 3: order status */
//	esc_html__( 'Order #%1$s was placed on %2$s and is currently %3$s.', 'woocommerce' ),
//	'<mark class="order-number">' . $order->get_order_number() . '</mark>', // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
//	'<mark class="order-date">' . wc_format_datetime( $order->get_date_created() ) . '</mark>', // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
//	'<mark class="order-status">' . wc_get_order_status_name( $order->get_status() ) . '</mark>' // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
//);
?>
<div class="back-btn-wrap">
	<a href="/my-account/orders/">order details</a>
</div>
<div class="order-details-block_wrap">
	<div class="order-num"><p>order #<?php echo $order->get_id();?></p></div>
	<div class="order-details-block">
		<div class="left-block">
			<span>Placed</span>
			<span>Status</span>
			<span>Payment Method</span>
		</div>
		<div class="right-block">
			<span><?php echo esc_html( $order->get_date_created()->date('j M Y \a\t  h:i A') ); ?></span>
			<div class="order-status"><?php echo $order->get_status();?></div>
			<span class="payment_method"><?php echo $order->get_payment_method_title();?></span>
		</div>
	</div>
</div>
<?php if ( $notes ) : ?>
	<h2><?php esc_html_e( 'Order updates', 'woocommerce' ); ?></h2>
	<ol class="woocommerce-OrderUpdates commentlist notes">
		<?php foreach ( $notes as $note ) : ?>
		<li class="woocommerce-OrderUpdate comment note">
			<div class="woocommerce-OrderUpdate-inner comment_container">
				<div class="woocommerce-OrderUpdate-text comment-text">
					<p class="woocommerce-OrderUpdate-meta meta"><?php echo date_i18n( esc_html__( 'l jS \o\f F Y, h:ia', 'woocommerce' ), strtotime( $note->comment_date ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
					<div class="woocommerce-OrderUpdate-description description">
						<?php echo wpautop( wptexturize( $note->comment_content ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</div>
		</li>
		<?php endforeach; ?>
	</ol>
<?php endif; ?>
<?php 
if( current_user_can('agent')){
?>
	<section class="agent-customer-details main">
		
		<?php if( have_rows('group', $order->get_id()) ): ?>
    	<?php while( have_rows('group', $order->get_id()) ): the_row(); ?>
			<?php 
			$existing = get_sub_field('existing');
			foreach($existing as $customer):
			$user_first_name = get_user_meta( $customer['ID'], 'first_name', true );
			$user_last_name = get_user_meta( $customer['ID'], 'last_name', true );
			$user_phone = get_user_meta( $customer['ID'], 'xoo_ml_phone_display', true );
			?>
			<div class="cuss-title">Order Customer</div>
			<div class="cuss_item">
				<div class="cuss_name"><?php echo $user_first_name; ?> <?php echo $user_last_name; ?></div>
				<div class="cuss_phone"><?php echo $user_phone; ?></div>
			</div>
			<?php endforeach; ?>
			<?php
				if( have_rows('or_add_a_new') ): while ( have_rows('or_add_a_new') ) : the_row();
				$user_first_name = get_sub_field('name');
				$user_last_name = get_sub_field('last_name');
				$user_phone = get_sub_field('phone');
			?>
			<div class="cuss-title">Order Customer</div>
			<div class="cuss_item">
				<div class="cuss_name"><?php echo $user_first_name; ?> <?php echo $user_last_name; ?></div>
				<div class="cuss_phone"><?php echo $user_phone; ?></div>
			</div>
		<?php 
				endwhile; endif;
			endwhile; ?>
		<div class="cuss-title-pomoja-padding"></div>
		<?php endif; ?>
		<?php if( have_rows('group_pamoja', $order->get_id()) ): ?>
    	<?php while( have_rows('group_pamoja', $order->get_id()) ): the_row(); ?>
			<?php 
			$existing = get_sub_field('existing');
			foreach($existing as $customer):
			$user_first_name = get_user_meta( $customer['ID'], 'first_name', true );
			$user_last_name = get_user_meta( $customer['ID'], 'last_name', true );
			$user_phone = get_user_meta( $customer['ID'], 'xoo_ml_phone_display', true );
			?>
			<div class="cuss-title cuss-title-pomoja">Linked Pamoja Customer</div>
			<div class="cuss_item">
				<div class="cuss_name"><?php echo $user_first_name; ?> <?php echo $user_last_name; ?></div>
				<div class="cuss_phone"><?php echo $user_phone; ?></div>
			</div>
			<?php endforeach; ?>
			<?php
				if( have_rows('or_add_a_new') ): while ( have_rows('or_add_a_new') ) : the_row();
				$user_first_name = get_sub_field('name');
				$user_last_name = get_sub_field('last_name');
				$user_phone = get_sub_field('phone');
			?>
			<div class="cuss-title cuss-title-pomoja">Linked Pamoja Customer</div>
			<div class="cuss_item">
				<div class="cuss_name"><?php echo $user_first_name; ?> <?php echo $user_last_name; ?></div>
				<div class="cuss_phone"><?php echo $user_phone; ?></div>
			</div>
		<?php 
				endwhile; endif;
			endwhile; ?>
		<?php endif; ?>
	</section>
	<hr class="order-border">
<?php 
	}else{ 
	$user_id = get_current_user_id();
	$user_first_name = get_user_meta( $user_id, 'first_name', true );
	$user_last_name = get_user_meta( $user_id, 'last_name', true );
	$user_phone = get_user_meta( $user_id, 'xoo_ml_phone_display', true );
?>
	<section class="agent-customer-details">
		<div class="cuss-title">Order Customer</div>
        <div class="cuss_item">
            <div class="cuss_name"><?php echo $user_first_name; ?> <?php echo $user_last_name; ?></div>
            <div class="cuss_phone"><?php echo $user_phone; ?></div>
        </div>
	</section>
<?php } ?>
<section class="woocommerce-customer-details woocommerce-view-order-sec">

    <?php if ($show_shipping) : ?>

    <section class="woocommerce-columns woocommerce-columns--2 woocommerce-columns--addresses col2-set addresses">
        <div class="woocommerce-column woocommerce-column--1 woocommerce-column--billing-address col-1">

            <?php endif; ?>
			<div class="pickup_details_wrap">
				<h2 class="woocommerce-column__title pickup_details"><?php esc_html_e('pickup details', 'woocommerce'); ?></h2>

				<address>


					<?php $sales_agent = get_post_meta($order->get_id(), 'sales_agent')[0];
					//global $wpdb;
					if ($sales_agent && $sales_agent !== 'Select Agent') : 
					//$postid = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_title = '" . $sales_agent . "'" );
					$sales_agent_post = get_post($sales_agent);
					$shipping_address = get_post_meta($sales_agent_post->ID, 'assign_location', true);
					$agent_phone = get_post_meta($sales_agent_post->ID, 'agent_phone', true);
					$loc_term = get_term($shipping_address);
					//var_dump($loc_term);
					?>
						<p class="woocommerce-customer-details--location">
							<span class="woocommerce-customer-details--title">Agent Name:</span> <span class="agent-name"><?php echo $sales_agent_post->post_title; ?></span>
						</p>
						<p class="woocommerce-customer-details--location">
							<span class="woocommerce-customer-details--title">Agent Mobile Number:</span> <span class="agent-name"><?php echo $agent_phone; ?></span>
						</p>
						<p class="woocommerce-customer-details--location">
							<span class="woocommerce-customer-details--title">Agent Location:</span> <span class="agent-name"><?php echo $loc_term->name; ?></span>
						</p>
					<?php endif; ?>
					<?php /*?><?php 
					if ($shipping_address && $shipping_address !== 'Select Location') : 
					$loc_term = get_term($shipping_address[0]);
					?>
						<p class="woocommerce-customer-details--location">
							<span class="woocommerce-customer-details--title">Pickup location:</span> <span class="agent-name"><?php echo esc_html($loc_term->name); ?></span>
						</p>
					<?php endif; ?><?php */?>
					<?php /*?><?php if ($order->get_billing_phone()) : ?>
						<p class="woocommerce-customer-details--phone"><?php echo esc_html($order->get_billing_phone()); ?></p>
					<?php endif; ?>

					<?php if ($order->get_billing_email()) : ?>
						<p class="woocommerce-customer-details--email"><?php echo esc_html($order->get_billing_email()); ?></p>
					<?php endif; ?><?php */?>
				</address>
			</div>
            <?php if ($show_shipping) : ?>
        </div><!-- /.col-1 -->
        <div class="woocommerce-column woocommerce-column--2 woocommerce-column--shipping-address col-2">
            <h2 class="woocommerce-column__title"><?php esc_html_e('Shipping address', 'woocommerce'); ?></h2>
            <address>
                <?php echo wp_kses_post($order->get_formatted_shipping_address(esc_html__('N/A', 'woocommerce'))); ?>
                <?php if ($order->get_shipping_phone()) : ?>
                    <p class="woocommerce-customer-details--phone"><?php echo esc_html($order->get_shipping_phone()); ?></p>
                <?php endif; ?>
            </address>
        </div><!-- /.col-2 -->
    </section><!-- /.col2-set -->

<?php endif; ?>
	
	
	<?php
	do_action( 'woocommerce_view_order', $order_id );
	
	?>
	<div class="all-orders-btn-wrapper">
    	<a class="all-orders-btn" href="/my-account/">View All Orders</a>
	</div>
