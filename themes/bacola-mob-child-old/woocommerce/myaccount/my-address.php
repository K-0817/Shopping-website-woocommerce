<?php
/**
 * My Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-address.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.6.0
 */

defined( 'ABSPATH' ) || exit;

$customer_id = get_current_user_id();

if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing'  => __( 'DELIVERY AGENT', 'woocommerce' ),
			'shipping' => __( 'DELIVERY LOCATION', 'woocommerce' ),
		),
		$customer_id
	);
} else {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing' => __( 'Billing address', 'woocommerce' ),
		),
		$customer_id
	);
}


$oldcol = 1;
$col    = 1;


?>

<p>
	<?php echo apply_filters( 'woocommerce_my_account_my_address_description', esc_html__( 'The following information will be used on the checkout page by default.', 'woocommerce' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</p>
<?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) : ?>
	<div class="u-columns woocommerce-Addresses col2-set addresses">
<?php endif; ?>
		<div class="u-column<?php echo $col < 0 ? 1 : 2; ?> col-<?php echo $oldcol < 0 ? 1 : 2; ?> woocommerce-Address">
			<header class="woocommerce-Address-title title">
				<h3>DELIVERY LOCATION</h3>
			</header>
			<address>
				<select name="pickup_location" id="pickup_location" class="select " data-placeholder="Select Location">
				<?php 
					$user_location = get_user_meta(get_current_user_id(), 'pickup_location', true); 
					if($user_location){
					?>
					<option value="select_location">Select Location</option>
					<?php }else{ ?>
					<option value="select_location" selected>Select Location</option>
				<?php
					}
					//var_dump($user_location);
				   $args = array(
					'hide_empty' => true,
					'taxonomy' => 'location',
				   );
				   $catlist = get_categories($args);
				   foreach($catlist as $categories_item){
					   if($user_location === $categories_item->cat_name){
							echo '<option value="' . $categories_item->cat_name . '" data-locationid="' . $categories_item->term_id . '" selected>' . $categories_item->cat_name . '</option>';
					   }else{
						   echo '<option value="' . $categories_item->cat_name . '" data-locationid="' . $categories_item->term_id . '">' . $categories_item->cat_name . '</option>';
					   }
					}
					?>
				</select>				
			</address>
		</div>
		<div class="u-column<?php echo $col < 0 ? 1 : 2; ?> col-<?php echo $oldcol < 0 ? 1 : 2; ?> woocommerce-Address">
			<header class="woocommerce-Address-title title">
				<h3>DELIVERY AGENT</h3>
			</header>
			<address>
				<select name="sales_agent" id="sales_agent" class="select " data-placeholder="Select Agent">
                  <?php 
                  $user_agent = intval(get_user_meta(get_current_user_id(), 'sales_agent', true));
                  if($user_agent){
                  ?>
					<option value="select_agent">Select agent</option>
					<?php }else{ ?>
					<option value="select_agent" selected>Select agent</option>
				<?php 
				  }
				  $agents = get_posts(array(
				  	'post_type'   => 'agent',
				  	'post_status'   => 'publish',
				  ));
				  //$my_query = new WP_Query('post_type=agent&hide_empty=0');
				  //while ($my_query->have_posts()) : $my_query->the_post();
					foreach($agents as $agent):
				  $do_not_duplicate = $agent->ID; 
				  $location=get_post_meta($agent->ID, 'assign_location', true);
				  $location_term = get_term( intval($location) );
					//echo get_the_title(intval($location));
					//var_dump($location_term);
				if($user_location){
				  if($location_term->name === $user_location){
				?>	
				<option value="<?php echo $agent->ID;?>" data-location="<?php echo $location; ?>" <?php if($user_agent === $agent->ID){ echo 'selected';} ?>><?php echo $agent->post_title;?></option>
				<?php 
				  }
				}else{?>
					<option value="<?php echo $agent->ID;?>" data-location="<?php echo $location; ?>" <?php if($user_agent === $agent->ID){ echo 'selected';} ?>><?php echo $agent->post_title;?></option>
				<?php
				}
				endforeach;
				?>
				 </select>
			 </address>
		</div>
		
	</div>
<script>
	jQuery(document).ready(function() {
		//var location = jQuery('#pickup_location').val();
		//console.log(location);
		jQuery('#pickup_location').change(function(){
			var location = jQuery(this).val();
			var agent = jQuery('#sales_agent').val();
			//var location_id = jQuery(this).find(':selected').data('locationid');
			//var agent_loc = jQuery('#sales_agent').find(':selected').data('location');
			/*if(location_id === agent_loc){}else{
				agent = '';
				jQuery('#sales_agent').find(':selected').removeAttr('selected');
				jQuery('#sales_agent option[value=select_agent]').attr('selected');
			}*/
			jQuery.ajax( {
                url : '<?php echo admin_url( 'admin-ajax.php' ) ?>', 
                type: 'POST',
                data: {
                    action  : 'update_user_location',
                    'pickup_location': location,
                    'user_agent': agent,
                }
            } )
            .success( function( response ) {
                jQuery('#sales_agent').html(response);
				alert( 'Delivery location chenged, plz select delivery agent.' );
            } )
            .fail( function( data ) {
                console.log( data.responseText );
                console.log( 'Request failed: ' + data.statusText );
            } );
		});
		jQuery('#sales_agent').change(function(){
			var agent = jQuery(this).val();
			jQuery.ajax( {
                url : '<?php echo admin_url( 'admin-ajax.php' ) ?>', 
                type: 'POST',
                data: {
                    action  : 'update_user_agent',
                    //'pickup_location': location,
                    'user_agent': agent,
                }
            } )
            .success( function( msg ) {
                console.log( 'User Meta Updated!' );
				alert( 'Delivery agent chenged.' );
            } )
            .fail( function( data ) {
                console.log( data.responseText );
                console.log( 'Request failed: ' + data.statusText );
            } );
		});
	});
</script>
	<?php

