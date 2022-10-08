<?php
/**
 * Order Customer Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-customer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.6.0
 */

defined('ABSPATH') || exit;

$show_shipping = !wc_ship_to_billing_address_only() && $order->needs_shipping_address();
if( current_user_can('agent')){

?>
	<section class="agent-customer-details">
		
		<?php if( have_rows('group', $order->get_id()) ): ?>
    	<?php while( have_rows('group', $order->get_id()) ): the_row(); ?>
			<?php 
			$existing = get_sub_field('existing');
			foreach($existing as $customer):
			$user_first_name = get_user_meta( $customer['ID'], 'first_name', true );
			$user_last_name = get_user_meta( $customer['ID'], 'last_name', true );
			$user_phone = get_user_meta( $customer['ID'], 'xoo_ml_phone_display', true );
			?>
			<div class="cuss-title">customer</div>
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
			<div class="cuss-title">customer</div>
			<div class="cuss_item">
				<div class="cuss_name"><?php echo $user_first_name; ?> <?php echo $user_last_name; ?></div>
				<div class="cuss_phone"><?php echo $user_phone; ?></div>
			</div>
		<?php 
				endwhile; endif;
			endwhile; ?>
		<?php endif; ?>
		<?php if( have_rows('group_pamoja', $order->get_id()) ): ?>
		<div class="pomoja-title">Pomoja item customer</div>
    	<?php while( have_rows('group_pamoja', $order->get_id()) ): the_row(); ?>
			<?php 
			$existing = get_sub_field('existing');
			foreach($existing as $customer):
			$user_first_name = get_user_meta( $customer['ID'], 'first_name', true );
			$user_last_name = get_user_meta( $customer['ID'], 'last_name', true );
			$user_phone = get_user_meta( $customer['ID'], 'xoo_ml_phone_display', true );
			?>
			<div class="cuss-title">customer</div>
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
			<div class="cuss-title">customer</div>
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
<?php } ?>
<section class="woocommerce-customer-details">

    <?php if ($show_shipping) : ?>

    <section class="woocommerce-columns woocommerce-columns--2 woocommerce-columns--addresses col2-set addresses">
        <div class="woocommerce-column woocommerce-column--1 woocommerce-column--billing-address col-1">

            <?php endif; ?>

            <h2 class="woocommerce-column__title pickup_details"><?php esc_html_e('order pickup details', 'woocommerce'); ?></h2>

            <address>
                

                <?php $sales_agent = get_post_meta($order->get_id(), 'sales_agent')[0];
				//var_dump($sales_agent);
                if ($sales_agent && $sales_agent !== 'Select Agent') : 
				$sales_agent_post = get_post($sales_agent);
				?>
                    <p class="woocommerce-customer-details--location">
                        <span class="woocommerce-customer-details--title">Service Agent:</span> <span class="agent-name"><?php echo $sales_agent_post->post_title; ?></span>
                    </p>
                <?php endif; ?>
				<?php $shipping_address = get_post_meta($order->get_id(), 'agent_location');
                if ($shipping_address && $shipping_address !== 'Select Location') : 
				$loc_term = get_term($shipping_address[0]);
				//var_dump($loc_term);
				?>
                    <p class="woocommerce-customer-details--location">
						<span class="woocommerce-customer-details--title">Pickup location:</span> <span class="agent-name"><?php echo esc_html($loc_term->name); ?></span>
                    </p>
                <?php endif; ?>
				
                <?php /*?><?php if ($order->get_billing_phone()) : ?>
                    <p class="woocommerce-customer-details--phone"><?php echo esc_html($order->get_billing_phone()); ?></p>
                <?php endif; ?>

                <?php if ($order->get_billing_email()) : ?>
                    <p class="woocommerce-customer-details--email"><?php echo esc_html($order->get_billing_email()); ?></p>
                <?php endif; ?><?php */?>
            </address>

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

    <?php do_action('woocommerce_order_details_after_customer_details', $order); ?>
	
</section>

<style>
h2.pickup_details{
	font-size: 12px;
    font-weight: 600;
    color: #68A315;
    text-transform: uppercase;
}
.woocommerce-customer-details--location{
	margin: 0;
	font-size: 10px;
    font-weight: 400;
    color: #9B9BB4;
	display: flex;
	justify-content: space-between;
}

</style>