<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', esc_html__( 'You must be logged in to checkout.', 'bacola' ) ) );
	return;
}
global $woocommerce;
$cart_items =WC()->cart->get_cart();
foreach($cart_items as $cart_item_promoja){
	if($cart_item_promoja['variation']['attribute_pa_pricing'] == 'pamoja' ){
		$promoja_item = 'true';
	}
}
//$order = wc_get_order( 3960 ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

//$order = wc_get_order( 3960 ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
////var_dump($order);
$user_id = get_current_user_id();
//$agent_post = get_post(3912);
//$agent_location=get_post_meta($agent_post->ID, 'assign_location', true);
//$agent_location_int = intval($agent_location);
//var_dump($agent_post);
//$post_terms = wp_get_post_terms($agent_post->ID, 'location');
//$terms = get_terms('location' );
//var_dump($terms);
//var_dump($agent_location);

/*$location = 'kasarani';
$agents = get_posts(array(
  'post_type'   => 'agent',
  'post_status'   => 'publish',
  'numberposts'  => -1
));
echo '<option value="select_agent" selected>Select agent</option>';
foreach($agents as $agent):
$agent_location=get_post_meta($agent->ID, 'assign_location', true);
//echo $agent_location;
$loc_term = get_term_by('name', $location, 'location');
var_dump($agent_location);
var_dump($loc_term->term_id);
if(intval($agent_location) === intval($loc_term->term_id)){ ?>
    <option value="<?php echo $agent->ID;?>" data-location="<?php echo $agent_location; ?>"><?php echo $agent->post_title;?></option>
<?php 
    }
endforeach;*/
?>
<?php if(!is_user_logged_in()): ?>
<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        
    <li class="nav-item" role="presentation" id="loginSwitch">
        <a class="nav-link active" id="pills-signup-tab" data-toggle="pill" href="#pills-signup" role="tab" aria-controls="pills-signup" aria-selected="false">Sign In</a>
    </li>
    <li class="nav-item" role="presentation" id="registrationSwitch">
        <a class="nav-link " id="pills-register-tab" data-toggle="pill" href="#pills-register" role="tab" aria-controls="pills-register" aria-selected="true">Register</a>
    </li>
</ul>
<?php endif; ?>
<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
	<div class="processing-block">
		<div class="content-wraper">
			<img class="spiner-img" src="/wp-content/themes/bacola-mob-child/assets/img/Spinner-1s-200px.svg" alt="Spinner"/>
			<div class="top-text">Placing your order, please wait.</div>
			<div class="bottom-text">Important! Do not close or navigate away from this window. Otherwise your order will not go through.</div>
		</div>
	</div>
	<div class="cart-form-wrapper">
		<div class="row content-wrapper sidebar-right">
			<div class="col-12 col-md-12 col-lg-12 content-primary">
				<div class="cart-wrapper">			

					<?php if ( $checkout->get_checkout_fields() ) : ?>
						<div class="login-form-block col-12">
							<div class="login-reg-block">
								<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
								<?php if(is_user_logged_in()): ?>
								<?php 
								$current_user_id = get_current_user_id();
								$new_user = get_userdata( get_current_user_id() );
								$first_name = $new_user->display_name;
								//$last_name = $new_user->last_name;
								$phone = $new_user->user_login;
								?>
									<div class="user-info-block">
										<div class='login-form-title'>your info</div>
										<div class='info-block'>
											<div class="acc-created-msg">
												<img src="/wp-content/themes/bacola-mob-child/assets/img/checkmark-circle.svg" alt="checkmark-circle">
											<?php if(isset($_COOKIE['justcreateduser'])): ?>												<span>Account created!</span>
												<?php else:  ?>
												<span>Signed in!</span>
											<?php endif; ?> 
											</div>
											<div class="acc-name"><?php echo $first_name; ?></div>
											<div class="acc-phone"><?php echo $phone; ?></div>
											<div class="acc-logout"><a href="<?php echo wp_logout_url(get_permalink()); ?>">Sign Out</a></div>
										</div>
									</div>
								<?php endif; ?>
							</div>
							
						</div>
						
						<div class="billing col-12">
							<?php if(is_user_logged_in()){	?>
							<?php 
							$user_id = get_current_user_id();
							$user_first_name = get_user_meta( $user_id, 'first_name', true );
							$user_last_name = get_user_meta( $user_id, 'last_name', true );
							$user_phone = get_user_meta( $user_id, 'xoo_ml_phone_display', true );
							?>
								<div class="auto-fill-billing-fields">
									<input type="text" class="cus_first-name hidden" value="<?php echo $user_first_name; ?>">
									<input type="text" class="cus_last-name hidden" value="<?php echo $user_last_name; ?>">
									<input type="text" class="cus_phone hidden" value="<?php echo $user_phone; ?>">
								</div>
							<?php } ?>
							<?php do_action( 'woocommerce_checkout_billing' ); ?>
						</div>
						
						<div class="col2-set" id="customer_details">
							<div class="col-1">
                                <h2 id="order_review_heading"><?php esc_html_e( 'Your order', 'bacola' ); ?></h2>

                                <table>
                                    <thead>
                                    <tr>
                                        <th class="product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
                                        <th class="product-total"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    do_action( 'woocommerce_review_order_before_cart_contents' );

                                    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                                        $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

                                        if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                                            ?>
                                            <tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
                                                <td class="product-name">
                                                    <?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ) . '&nbsp;'; ?>
                                                    <?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times;&nbsp;%s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                                    <?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
													<?php if(current_user_can('agent')){ ?>
														<p class="add-customer-to-prod-msg">Add at least 1 customer to this item</p>
													<?php } ?>
                                                </td>
                                                <td class="product-total">
                                                    <?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
													<?php if(current_user_can('agent')){ ?>
														<!--<p class="add-customer-to-prod" data-product="">Add</p> -->
													<?php } ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }

                                    do_action( 'woocommerce_review_order_after_cart_contents' );
                                    ?>
                                    </tbody>
                                    <tfoot>

                                    <tr class="cart-subtotal">
                                        <th><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
                                        <td><?php wc_cart_totals_subtotal_html(); ?></td>
                                    </tr>

                                    <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
                                        <tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
                                            <th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
                                            <td><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
                                        </tr>
                                    <?php endforeach; ?>

                                    <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

                                        <?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

                                        <?php wc_cart_totals_shipping_html(); ?>

                                        <?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

                                    <?php endif; ?>

                                    <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
                                        <tr class="fee">
                                            <th><?php echo esc_html( $fee->name ); ?></th>
                                            <td><?php wc_cart_totals_fee_html( $fee ); ?></td>
                                        </tr>
                                    <?php endforeach; ?>

                                    <?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
                                        <?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
                                            <?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited ?>
                                                <tr class="tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
                                                    <th><?php echo esc_html( $tax->label ); ?></th>
                                                    <td><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <tr class="tax-total">
                                                <th><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></th>
                                                <td><?php wc_cart_totals_taxes_total_html(); ?></td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

                                    <tr class="order-total">
                                        <th><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
                                        <td><?php wc_cart_totals_order_total_html(); ?></td>
                                    </tr>

                                    <?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

                                    </tfoot>
                                </table>

                            </div>
							<div class="col-2">
						<?php  
								if( current_user_can('agent')){ ?>
								<?php
									if($promoja_item == 'true'){
										acf_form(array('form' => false,'fields' => array('field_61e9cf9f44b38', 'field_61fa47104f131' )));
									}else{
										acf_form(array('form' => false,'fields' => array('field_61e9cf9f44b38')));
									}
								 ?>
								
								<style>
								.woocommerce-billing-fields {
									display: none!important;
								}
								</style>
						<?php }  ?>	
								<div class="shipping-title">how your order will be delivered</div>
								<div class="shipping-aditional-info">
									<div class="items-count"><?php echo $woocommerce->cart->cart_contents_count;?> items</div>
									<div class="pickup-delivery">Pickup  Delivery (Free)</div>
								</div>	 
								<?php do_action( 'woocommerce_checkout_shipping' ); ?>
							</div>
						<?php /*?><?php if(!current_user_can('agent')){ ?>
							<div class="col-2">
								<div class="shipping-title">how your order will be delivered</div>
								<div class="shipping-aditional-info">
									<div class="items-count"><?php echo $woocommerce->cart->cart_contents_count;?> items</div>
									<div class="pickup-delivery">Pickup  Delivery (Free)</div>
								</div>
								<?php do_action( 'woocommerce_checkout_shipping' ); ?>
							</div>
						<?php } else { ?>	
							<div class="col-2">
								<div class="customers-title">Order customers</div>
								<div class="customers-aditional-info">
									<div class="items-count">Add the details for the customers on whole behalf you are placing the order</div>
								</div>
								<div class="cadded"><div class="recust"><a href="#"><i class="icon-cremove"></i></a></div>
								    <div class="cadname">Bob Agent 
								</div>
								    <div class="cadtel">2537777777</div>
								
								</div>	
<div class="field-wrap" style="margin-top:10px;">
    <label for="firstname">Customer Full Name<span>*</span></label>
    <input type="text" name="firstname" value="" id="fma_lwp_firstname" style="width: 60%; display: block;" placeholder="Add" />
</div>
<div class="field-wrap" style="margin-top:10px;">
    <input type="hidden" id="fma_lwp_hide_recap_chkbx_hide" value="on" />
    <input type="hidden" id="fma_lwp_hide_country_code_hide" value=" " />
    <label for="phone_number">Customer Mobile Number<span>*</span></label>
    <div id="display_with_country_code_select_box">
        <select id="country_code" name="gfcountry_code" class="form-control">
            <option selected="selected" value="+254">KE(+254)</option>
            <option value="+376">AD(+376)</option>
            <option value="+971">AE(+971)</option>
            <option value="+93">AF(+93)</option>
            <option value="+1268">AG(+1268)</option>
            <option value="+1264">AI(+1264)</option>
            <option value="+355">AL(+355)</option>
            <option value="+374">AM(+374)</option>
            <option value="+599">AN(+599)</option>
            <option value="+244">AO(+244)</option>
            <option value="+672">AQ(+672)</option>
            <option value="+54">AR(+54)</option>
            <option value="+1684">AS(+1684)</option>
            <option value="+43">AT(+43)</option>
            <option value="+61">AU(+61)</option>
            <option value="+297">AW(+297)</option>
            <option value="+994">AZ(+994)</option>
            <option value="+387">BA(+387)</option>
            <option value="+1246">BB(+1246)</option>
            <option value="+880">BD(+880)</option>
            <option value="+32">BE(+32)</option>
            <option value="+226">BF(+226)</option>
            <option value="+359">BG(+359)</option>
            <option value="+973">BH(+973)</option>
            <option value="+257">BI(+257)</option>
            <option value="+229">BJ(+229)</option>
            <option value="+590">BL(+590)</option>
            <option value="+1441">BM(+1441)</option>
            <option value="+673">BN(+673)</option>
            <option value="+591">BO(+591)</option>
            <option value="+55">BR(+55)</option>
            <option value="+1242">BS(+1242)</option>
            <option value="+975">BT(+975)</option>
            <option value="+267">BW(+267)</option>
            <option value="+375">BY(+375)</option>
            <option value="+501">BZ</option>
            <option value="+1">CA(+1)</option>
            <option value="+61">CC(+61)</option>
            <option value="+243">CD(+243)</option>
            <option value="+236">CF(+236)</option>
            <option value="+242">CG(+242)</option>
            <option value="+41">CH(+41)</option>
            <option value="+225">CI(+225)</option>
            <option value="+682">CK(+682)</option>
            <option value="+56">CL(+56)</option>
            <option value="+237">CM(+237)</option>
            <option value="+86">CN(+86)</option>
            <option value="+57">CO(+57)</option>
            <option value="+506">CR(+506)</option>
            <option value="+53">CU(+53)</option>
            <option value="+238">CV(+238)</option>
            <option value="+61">CX(+61)</option>
            <option value="+357">CY(+357)</option>
            <option value="+420">CZ(+420)</option>
            <option value="+49">DE(+49)</option>
            <option value="+253">DJ(+253)</option>
            <option value="+45">DK(+45)</option>
            <option value="+1767">DM(+1767)</option>
            <option value="+1809">DO(+1809)</option>
            <option value="+213">DZ(+213)</option>
            <option value="+593">EC(+593)</option>
            <option value="+372">EE(+372)</option>
            <option value="+20">EG(+20)</option>
            <option value="+291">ER(+291)</option>
            <option value="+34">ES(+34)</option>
            <option value="+251">ET(+251)</option>
            <option value="+358">FI(+358)</option>
            <option value="+679">FJ(+679)</option>
            <option value="+500">FK(+500)</option>
            <option value="+691">FM(+691)</option>
            <option value="+298">FO(+298)</option>
            <option value="+33">FR(+33)</option>
            <option value="+241">GA(+241)</option>
            <option value="+44">GB(+44)</option>
            <option value="+1473">GD(+1473)</option>
            <option value="+995">GE(+995)</option>
            <option value="+233">GH(+233)</option>
            <option value="+350">GI(+350)</option>
            <option value="+299">GL(+299)</option>
            <option value="+220">GM(+220)</option>
            <option value="+224">GN(+224)</option>
            <option value="+240">GQ(+240)</option>
            <option value="+30">GR(+30)</option>
            <option value="+502">GT(+502)</option>
            <option value="+1671">GU(+1671)</option>
            <option value="+245">GW(+245)</option>
            <option value="+592">GY(+592)</option>
            <option value="+852">HK(+852)</option>
            <option value="+504">HN(+504)</option>
            <option value="+385">HR(+385)</option>
            <option value="+509">HT(+509)</option>
            <option value="+36">HU(+36)</option>
            <option value="+62">ID(+62)</option>
            <option value="+353">IE(+353)</option>
            <option value="+972">IL(+972)</option>
            <option value="+91">IND(+91)</option>
            <option value="+964">IQ(+964)</option>
            <option value="+98">IRs(+98)</option>
            <option value="+354">IS(+354)</option>
            <option value="+39">IT(+39)</option>
            <option value="+1876">JM(+1876)</option>
            <option value="+962">JO(+962)</option>
            <option value="+81">JP(+81)</option>
            <option value="+254">KE(+254)</option>
            <option value="+996">KG(+996)</option>
            <option value="+855">KH(+855)</option>
            <option value="+686">KI(+686)</option>
            <option value="+269">KM(+269)</option>
            <option value="+1869">KN(+1869)</option>
            <option value="+850">KP(+850)</option>
            <option value="+82">KR(+82)</option>
            <option value="+965">KW(+965)</option>
            <option value="+1345">KY(+1345)</option>
            <option value="+7">KZ(+7)</option>
            <option value="+856">LA(+856)</option>
            <option value="+961">LB(+961)</option>
            <option value="+1758">LC(+1758)</option>
            <option value="+423">LI(+423)</option>
            <option value="+94">LK(+94)</option>
            <option value="+231">LR(+231)</option>
            <option value="+266">LS(+266)</option>
            <option value="+370">LT(+370)</option>
            <option value="+352">LU(+352)</option>
            <option value="+371">LV(+371)</option>
            <option value="+218">LY(+218)</option>
            <option value="+212">MA(+212)</option>
            <option value="+377">MC(+377)</option>
            <option value="+373">MD(+373)</option>
            <option value="+382">ME(+382)</option>
            <option value="+1599">MF(+1599)</option>
            <option value="+261">MG(+261)</option>
            <option value="+692">MH(+692)</option>
            <option value="+389">MK(+389)</option>
            <option value="+223">ML(+223)</option>
            <option value="+95">MM(+95)</option>
            <option value="+976">MN(+976)</option>
            <option value="+853">MO(+853)</option>
            <option value="+1670">MP(+1670)</option>
            <option value="+222">MR(+222)</option>
            <option value="+1664">MS(+1664)</option>
            <option value="+356">MT(+356)</option>
            <option value="+230">MU(+230)</option>
            <option value="+960">MV(+960)</option>
            <option value="+265">MW(+265)</option>
            <option value="+52">MXMexico (+52)</option>
            <option value="+60">MY(+60)</option>
            <option value="+258">MZ(+258)</option>
            <option value="+264">NA(+264)</option>
            <option value="+687">NC(+687)</option>
            <option value="+227">NE(+227)</option>
            <option value="+234">NG(+234)</option>
            <option value="+505">NI(+505)</option>
            <option value="+31">NL(+31)</option>
            <option value="+47">NO(+47)</option>
            <option value="+977">NP(+977)</option>
            <option value="+674">NR(+674)</option>
            <option value="+683">NU(+683)</option>
            <option value="+64">NZ(+64)</option>
            <option value="+968">OM(+968)</option>
            <option value="+507">PA(+507)</option>
            <option value="+51">PE(+51)</option>
            <option value="+689">PF(+689)</option>
            <option value="+675">PG(+675)</option>
            <option value="+63">PH(+63)</option>
            <option value="+92">PAK(+92)</option>
            <option value="+48">PL(+48)</option>
            <option value="+508">PM(+508)</option>
            <option value="+870">PN(+870)</option>
            <option value="+1">PR(+1)</option>
            <option value="+351">PT(+351)</option>
            <option value="+680">PW(+680)</option>
            <option value="+595">PY(+595)</option>
            <option value="+974">QA(+974)</option>
            <option value="+40">RO(+40)</option>
            <option value="+381">RS(+381)</option>
            <option value="+7">RU(+7)</option>
            <option value="+250">RW(+250)</option>
            <option value="+966">SA(+966)</option>
            <option value="+677">SB(+677)</option>
            <option value="+248">SC(+248)</option>
            <option value="+249">SD(+249)</option>
            <option value="+46">SE(+46)</option>
            <option value="+65">SG(+65)</option>
            <option value="+290">SH(+290)</option>
            <option value="+386">SI(+386)</option>
            <option value="+421">SK(+421)</option>
            <option value="+232">SL(+232)</option>
            <option value="+378">SM(+378)</option>
            <option value="+221">SN(+221)</option>
            <option value="+252">SO(+252)</option>
            <option value="+597">SR(+597)</option>
            <option value="+239">ST(+239)</option>
            <option value="+503">SV(+503)</option>
            <option value="+963">SY(+963)</option>
            <option value="+268">SZ(+268)</option>
            <option value="+1649">TC(+1649)</option>
            <option value="+235">TD(+235)</option>
            <option value="+228">TG(+228)</option>
            <option value="+66">TH(+66)</option>
            <option value="+992">TJ(+992)</option>
            <option value="+690">TK(+690)</option>
            <option value="+670">TL(+670)</option>
            <option value="+993">TM(+993)</option>
            <option value="+216">TN(+216)</option>
            <option value="+676">TO(+676)</option>
            <option value="+90">TR(+90)</option>
            <option value="+1868">TT(+1868)</option>
            <option value="+688">TV(+688)</option>
            <option value="+886">TW(+886)</option>
            <option value="+255">TZ(+255)</option>
            <option value="+380">UA(+380)</option>
            <option value="+256">UG(+256)</option>
            <option value="+1">USA(+1)</option>
            <option value="+44">UK(+44)</option>
            <option value="+598">UY(+598)</option>
            <option value="+998">UZ(+998)</option>
            <option value="+39">VA(+39)</option>
            <option value="+1784">VC(+1784)</option>
            <option value="+58">VE(+58)</option>
            <option value="+1284">VG(+1284)</option>
            <option value="+1340">VI(+1340)</option>
            <option value="+84">VN(+84)</option>
            <option value="+678">VU(+678)</option>
            <option value="+681">WF(+681)</option>
            <option value="+685">WS(+685)</option>
            <option value="+381">XK(+381)</option>
            <option value="+967">YE(+967)</option>
            <option value="+262">YT(+262)</option>
            <option value="+27">ZA(+27)</option>
            <option value="+260">ZM(+260)</option>
            <option value="+263">ZW(+263)</option>
        </select>
        <input
            name="phone_number"
            type="number"
            onkeypress="return (event.charCode !=8 &amp;&amp; event.charCode ==0 || (event.charCode >= 48 &amp;&amp; event.charCode <= 57))"
            id="fma_lwp_phone_number"
            style="width: 60%;"
            placeholder="Enter Mobile Number"
        />
    </div>
    <span id="fma_lwp_show_err_msg_country_code" style="display: none;">Please Select country code</span>
    <span id="fma_lwp_show_err_msg_to_enter_phone_number" style="display: none;"> Please enter your phone number.</span>
</div>

<div class="acc-add" id="add"><a href="#">Add to Order</a></div>
							</div>	
							<div class="col-2">
								<div class="customers-title">How your order will be delivered</div>
								<div class="shipping-aditional-info">
									<div class="items-count"><?php echo $woocommerce->cart->cart_contents_count;?> items</div>
									<div class="pickup-delivery">Pickup  Delivery (Free)</div>
								</div>
								<div class="customers-aditional-info">
									<div class="items-count">Order will be delivered to your location in:</div>
									<div class="checkout-agent-location">Kawangware </div>
								</div>
							</div>								
						<?php } ?><?php */?>							
						</div>

						<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

					<?php endif; ?>


					<div class="order-review-wrapper">
						<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>

						<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

						<div id="order_review" class="woocommerce-checkout-review-order">
							<div class="payment-title">payment method</div>
							<?php do_action( 'woocommerce_checkout_order_review' ); ?>
						</div>

						<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
					</div>

				</div>

			</div>
		</div>
	</div>
</form>
<?php /*?><script>
document.addEventListener("DOMContentLoaded", (event) => {
  const buttonId = 'place_order';
  const elementId = 'check';
  const element = document.getElementById(elementId);
  const button = document.getElementById(buttonId);

  console.log(element);
  console.log(button);

  if (element.classList.contains('acf-hidden')) {
    button.classList.add('active');
  }
});
</script><?php */?>
<script>
(function($) {
  $(document).ready(function() {
    // disable the ACF js navigate away pop up
    acf.unload.active = false;
  });
})(jQuery);
</script>
<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
