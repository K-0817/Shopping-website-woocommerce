<?php
/**
 * Orders
 *
 * Shows orders on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/orders.php.
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

do_action( 'woocommerce_before_account_orders', $has_orders ); ?>
<div class="back-btn-wrap">
	<a href="/my-account/">order details</a>
</div>
<?php if ( $has_orders ) : ?>

<div class="groupWrapper orders-tab active">
<div class="myAccount ordersWrapper">
	<div class="title">all orders</div>
<?php if(current_user_can('agent')){ ?>
	<?php
        foreach ( $customer_orders->orders  as $customer_order ) {
            $order      = wc_get_order( $customer_order );
            $item_count = $order->get_item_count() - $order->get_item_count_refunded();
            ?>
            <div class="order">
                <div class="info">
					<a href="<?php echo esc_url( $order->get_view_order_url() ); ?>">
                    <?php if( have_rows('group', $order->get_id()) ): ?>
                        <?php while( have_rows('group', $order->get_id()) ): the_row(); ?>
                            <?php 
                            $existing = get_sub_field('existing');
                            foreach($existing as $customer):
                            $user_first_name = get_user_meta( $customer['ID'], 'first_name', true );
                            $user_last_name = get_user_meta( $customer['ID'], 'last_name', true );
                            $user_phone = get_user_meta( $customer['ID'], 'xoo_ml_phone_display', true );
                            ?>
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
                            <div class="cuss_item">
                                <div class="cuss_name"><?php echo $user_first_name; ?> <?php echo $user_last_name; ?></div>
                                <div class="cuss_phone"><?php echo $user_phone; ?></div>
                            </div>
                        <?php 
                                endwhile; endif;
                            endwhile; ?>
                    <?php endif; ?>
					</a>
                    <div class="order-info">Placed: <?php echo esc_html( $order->get_date_created()->date('j M Y \a\t  h:i A') ); ?></div>
					<div class="order-info-total">Total: <?php echo $order->get_formatted_order_total();?></div>
					<a href="<?php echo esc_url( $order->get_view_order_url() ); ?>" class="order-status <?php echo esc_html( get_formatted_order_status( $order->get_status() ) ); ?>"><?php echo esc_html( get_formatted_order_status( $order->get_status() ) ); ?></a>
                </div>
                
            </div>
            <?php
        }
        ?>

<?php }else{ ?>
	<?php
        foreach ( $customer_orders->orders as $customer_order ) {
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
				<div class="order-status <?php echo esc_html( get_formatted_order_status( $order->get_status() ) ); ?>"><?php echo esc_html( get_formatted_order_status( $order->get_status() ) ); ?></div>
            </div>
			</div>	
            <?php
        }
}
        ?>
</div>
	</div>
	<?php /*?><table class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">
		<thead>
			<tr>
				<?php foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) : ?>
					<th class="woocommerce-orders-table__header woocommerce-orders-table__header-<?php echo esc_attr( $column_id ); ?>"><span class="nobr"><?php echo esc_html( $column_name ); ?></span></th>
				<?php endforeach; ?>
			</tr>
		</thead>

		<tbody>
			<?php
			foreach ( $customer_orders->orders as $customer_order ) {
				$order      = wc_get_order( $customer_order ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
				$item_count = $order->get_item_count() - $order->get_item_count_refunded();
				?>
				<tr class="woocommerce-orders-table__row woocommerce-orders-table__row--status-<?php echo esc_attr( $order->get_status() ); ?> order">
					<?php foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) : ?>
						<td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-<?php echo esc_attr( $column_id ); ?>" data-title="<?php echo esc_attr( $column_name ); ?>">
							<?php if ( has_action( 'woocommerce_my_account_my_orders_column_' . $column_id ) ) : ?>
								<?php do_action( 'woocommerce_my_account_my_orders_column_' . $column_id, $order ); ?>

							<?php elseif ( 'order-number' === $column_id ) : ?>
								<a href="<?php echo esc_url( $order->get_view_order_url() ); ?>">
									<?php echo esc_html( _x( '#', 'hash before order number', 'woocommerce' ) . $order->get_order_number() ); ?>
								</a>

							<?php elseif ( 'order-date' === $column_id ) : ?>
								<time datetime="<?php echo esc_attr( $order->get_date_created()->date( 'c' ) ); ?>"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></time>

							<?php elseif ( 'order-status' === $column_id ) : ?>
								<?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?>

							<?php elseif ( 'order-total' === $column_id ) : ?>
								<?php
								
								echo wp_kses_post( sprintf( _n( '%1$s for %2$s item', '%1$s for %2$s items', $item_count, 'woocommerce' ), $order->get_formatted_order_total(), $item_count ) );
								?>

							<?php elseif ( 'order-actions' === $column_id ) : ?>
								<?php
								$actions = wc_get_account_orders_actions( $order );

								if ( ! empty( $actions ) ) {
									foreach ( $actions as $key => $action ) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
										echo '<a href="' . esc_url( $action['url'] ) . '" class="woocommerce-button button ' . sanitize_html_class( $key ) . '">' . esc_html( $action['name'] ) . '</a>';
									}
								}
								?>
							<?php endif; ?>
						</td>
					<?php endforeach; ?>
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>

	<?php do_action( 'woocommerce_before_account_orders_pagination' ); ?>

	<?php if ( 1 < $customer_orders->max_num_pages ) : ?>
		<div class="woocommerce-pagination woocommerce-pagination--without-numbers woocommerce-Pagination">
			<?php if ( 1 !== $current_page ) : ?>
				<a class="woocommerce-button woocommerce-button--previous woocommerce-Button woocommerce-Button--previous button" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page - 1 ) ); ?>"><?php esc_html_e( 'Previous', 'woocommerce' ); ?></a>
			<?php endif; ?>

			<?php if ( intval( $customer_orders->max_num_pages ) !== $current_page ) : ?>
				<a class="woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next button" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page + 1 ) ); ?>"><?php esc_html_e( 'Next', 'woocommerce' ); ?></a>
			<?php endif; ?>
		</div>
	<?php endif; ?><?php */?>

<?php else : ?>
	<div class="woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info">
		<a class="woocommerce-Button button" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>"><?php esc_html_e( 'Browse products', 'woocommerce' ); ?></a>
		<?php esc_html_e( 'No order has been made yet.', 'woocommerce' ); ?>
	</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_account_orders', $has_orders ); ?>
