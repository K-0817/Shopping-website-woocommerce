<?php
$limit = 3;
// Get customer $limit last orders
$customer_orders = wc_get_orders( array(
    'customer'  => get_current_user_id(),
    'limit'     => $limit
) );

$has_orders = false;
if (count($customer_orders) > 0) {
    $has_orders = true;
}

if ( $has_orders ) : ?>
    <div class="myAccount ordersWrapper">
        <?php
        foreach ( $customer_orders as $customer_order ) {
            $order      = wc_get_order( $customer_order );
            $item_count = $order->get_item_count() - $order->get_item_count_refunded();
            ?>
            <div class="order">
                <div class="info">
                    <a href="<?php echo esc_url( $order->get_view_order_url() ); ?>">
                        <?php echo esc_html( _x( '#', 'hash before order number', 'woocommerce' ) . $order->ID ); ?>
                    </a>
					<div class="order-info">Placed: <?php echo esc_html( $order->get_date_created()->date('j M Y \a\t  h:i A') ); ?></div>
					<div class="order-info-total">Total: <?php echo $order->get_formatted_order_total();?></div>
				<a class="order-status <?php echo esc_html( get_formatted_order_status( $order->get_status() ) ); ?>" href="<?php echo esc_url( $order->get_view_order_url() ); ?>"><?php echo esc_html( get_formatted_order_status( $order->get_status() ) ); ?></a>
            </div>
			</div>	
            <?php
        }
        ?>
    
<?php else: ?>
    <span class="noOrders"><?php esc_html_e( 'No order has been made yet.', 'woocommerce' ); ?></span>
<?php endif; ?>
</div>