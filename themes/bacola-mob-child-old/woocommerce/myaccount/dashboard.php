<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if (empty($user)) {
    $user = wp_get_current_user();
}

//var_dump($user);
//die();
function get_user_orders_total($user_id) {
    // Use other args to filter more
    $args = array(
        'customer_id' => $user_id
    );
    // call WC API
    $orders = wc_get_orders($args);

    if (empty($orders) || !is_array($orders)) {
        return false;
    }

    // One implementation of how to sum up all the totals
    $total = array_reduce($orders, function ($carry, $order) {
        $carry += (float)$order->get_total();

        return $carry;
    }, 0.0);

    return $total;
}
$general_action = new WC_Agent_Sales_Grn_All_Actions();
$agent_id       = $general_action->is_agent();
?>
<?php if(is_user_logged_in()): ?>
<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        
    <li class="nav-item" role="presentation" id="ordersSwitch">
        <a class="nav-link active" id="pills-orders-tab" data-toggle="pill" href="#pills-orders" role="tab" aria-controls="pills-orders" aria-selected="false">my orders</a>
    </li>
	<?php  
	if( current_user_can('agent')){ ?>
    <li class="nav-item" role="presentation" id="customersSwitch">
        <a class="nav-link " id="pills-customers-tab" data-toggle="pill" href="#pills-customers" role="tab" aria-controls="pills-customers" aria-selected="true">My Customers</a>
    </li>
	<?php } ?>
	<li class="nav-item" role="presentation" id="editaccSwitch">
        <a class="nav-link " id="pills-editacc-tab" data-toggle="pill" href="#pills-editacc" role="tab" aria-controls="pills-editacc" aria-selected="true">me</a>
    </li>
</ul>
<?php endif; ?>
<div class="groupWrapper orders-tab active">
    <h3>My orders</h3>
    <?php
        if ($agent_id) {
            do_action('woocommerce_account_agent-orders_mobile_endpoint');
            //require(dirname(__FILE__) . '/dashboard-agent-orders.php');
        } else {
            require(dirname(__FILE__) . '/dashboard-orders.php');
        }
    ?>
</div>

<?php if ($agent_id) {
    $args = array(
        'meta_query' => array(
            array(
                'key'     => 'sales_agent',
                'value'   => $agent_id,
                'type'    => 'numeric',
                'compare' => '=',
				
            ),
        ),
    );

    $args = apply_filters( 'list_customers_agent_args', $args );
    // get result and query
    $user_query = new WP_User_Query( $args );
	//var_dump($user_query);
    $users      = $user_query->get_results();
	
	usort($users, function($a, $b) {return strcmp($a->display_name, $b->display_name);});

    // get total of query
    $total_customers = $user_query->get_total();
    $url = site_url( '/my-account/agent-customers/' );
	//var_dump($users[0]);
	$chapter = 'a';
    ?>
    <div class="groupWrapper customers-tab"> 
		<?php 
		if ( ! empty( $user_query->get_results() ) ) {
		foreach ( $users as $user ) :
		
			//var_dump($user);
		$user_first_name = get_user_meta( $user->ID, 'first_name', true );
		$user_chapter = substr($user_first_name, 0, 1);
		if($chapter == $user_chapter){
			
		}else{
			$chapter = $user_chapter;
			echo '<div class="chapter">' . $chapter . '</div>';
		}
        $user_last_name = get_user_meta( $user->ID, 'last_name', true );
        $user_phone = get_user_meta( $user->ID, 'xoo_ml_phone_display', true );
		$numorders = wc_get_customer_order_count( $user->ID );
		$user_total = get_user_orders_total($user->ID);
		?>
        <div class="cuss_item">
            <div class="cuss_name"><?php echo $user_first_name; ?> <?php echo $user_last_name; ?></div>
            <div class="cuss_phone"><?php echo $user_phone; ?></div>
            <div class="cuss_numorders"><?php echo $numorders; ?> Lifetime Orders</div>
            <div class="cuss_total">KSh <?php echo $user_total; ?> Lifetime Sales</div>
        </div>
		<?php endforeach; 
		}else {
			echo 'No users found.';
		} ?>
    </div>
<?php } ?>


<?php if (!$agent_id) { ?>
    <div class="groupWrapper editacc-tab">
        <?php require(dirname(__FILE__) . '/dashboard-address.php') ?>
    </div>
<?php } ?>
<div class="groupWrapper editacc-tab">
    <h3>my account</h3>
    <?php /*?><?php require(dirname(__FILE__) . '/dashboard-account.php'); ?><?php */
	$user_id = get_current_user_id();
	$first_name = get_user_meta( $user_id, 'first_name', true );
    $last_name = get_user_meta( $user_id, 'last_name', true );
	$user_phone = get_user_meta( $user_id, 'xoo_ml_phone_display', true );
	if ($agent_id) {
		$user_location = get_post_meta( $agent_id, 'assign_location', true );
		$term = get_term($user_location);
	}
	?>
	<div class="account-info">
		<div class="name"><?php echo $first_name; ?> <?php echo $last_name; ?></div>
		<div class="phone"><?php echo $user_phone; ?></div>
		<?php if ($agent_id) { ?>
		<div class="location"><?php echo $term->name; ?></div>
		<?php } ?>
		<a href="<?php echo wp_logout_url( home_url() ); ?>" title="Sign Out" class="signOutBtn">Sign Out</a>
	</div>
</div>
<?php if ($agent_id) { ?>
    <div class="groupWrapper editacc-tab">
        <span class="title">my performance</span>
        <?php require(dirname(__FILE__) . '/dashboard-stats.php'); ?>
    </div>
<?php } ?>

<!-- TODO: create method. Visible only for customers -->
<?php if (false && !$agent_id) { ?>
    <div class="groupWrapper editacc-tab">
        <h3>My payment preferences</h3>
    </div>
<?php } ?>