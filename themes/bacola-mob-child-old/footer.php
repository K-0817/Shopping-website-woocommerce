<?php
/**
 * footer.php
 * @package WordPress
 * @subpackage Bacola
 * @since Bacola 1.0
 * 
 */

$is_basket = is_cart();
$is_account_page = is_account_page() || tl_is_need_login_template();
$is_front_page = is_front_page();

$orders_link = "";
if(is_user_logged_in()){
	$orders_link = get_permalink( get_option('woocommerce_myaccount_page_id') );
} else{
	$orders_link = home_url( '/need-login/' );
}

?>
			</div><!-- homepage-content -->
		</div><!-- site-content -->
	</main><!-- site-primary -->
	<footer class="footer">
    <div class="center-wrap">
      <div class="footer__list">
		<a class="footer__list-item <?php echo $is_front_page ? 'footer__list-item--active' : '';?>" href="<?php echo get_home_url(); ?>">
          <div class="footer__list-icon"><svg viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path
                d="M9.20001 20.2V21C9.20001 21.2208 9.37922 21.4 9.6 21.4C9.82078 21.4 9.99998 21.2208 9.99998 21V20.2C9.99998 19.9793 9.82078 19.8 9.6 19.8C9.37922 19.8 9.20001 19.9793 9.20001 20.2Z" />
              <path
                d="M25.6 26.1999H25.2V13.5999C25.2 13.3792 25.0208 13.2 24.8 13.2C24.5793 13.2 24.4001 13.3792 24.4001 13.5999V26.1999H3.59998V13.5999C3.59998 13.3792 3.42078 13.2 3.2 13.2C2.97922 13.2 2.80002 13.3792 2.80002 13.5999V26.1999H2.39998C2.1792 26.1999 2 26.3791 2 26.5999C2 26.8207 2.1792 27 2.39998 27H25.6C25.8207 27 26 26.8207 26 26.6C26 26.3792 25.8208 26.1999 25.6 26.1999Z" />
              <path
                d="M11.2 25.4C11.4208 25.4 11.6 25.2208 11.6 25V15.4C11.6 15.1792 11.4208 15 11.2 15H5.6C5.37922 15 5.20001 15.1792 5.20001 15.4V25C5.20001 25.2208 5.37922 25.4 5.6 25.4C5.82078 25.4 5.99998 25.2208 5.99998 25V15.8H10.8V25C10.8 25.2208 10.9792 25.4 11.2 25.4Z" />
              <path
                d="M18.6828 17.5172C18.5264 17.3608 18.2736 17.3608 18.1172 17.5172C17.9608 17.6736 17.9608 17.9264 18.1172 18.0828L19.7172 19.6828C19.7952 19.7608 19.8976 19.7999 20 19.7999C20.1024 19.7999 20.2048 19.7608 20.2828 19.6828C20.4392 19.5263 20.4392 19.2735 20.2828 19.1172L18.6828 17.5172Z" />
              <path fill-rule="evenodd" clip-rule="evenodd"
                d="M4.00002 3H24C25.1028 3 26 3.89719 26.0001 5.00002V12.1597C26.0001 12.28 25.9461 12.3937 25.8533 12.4696C25.7601 12.5456 25.6385 12.576 25.5205 12.5516C24.8817 12.422 24.3433 12.0408 24.0005 11.5244C23.5705 12.1724 22.8341 12.6 22.0001 12.6C21.1664 12.6 20.4305 12.1728 20 11.5252C19.5696 12.1728 18.8336 12.6 18 12.6C17.1664 12.6 16.4304 12.1728 16 11.5252C15.5696 12.1728 14.8336 12.6 14 12.6C13.1664 12.6 12.4304 12.1728 12.0001 11.5252C11.5697 12.1727 10.8337 12.6 10.0001 12.6C9.16644 12.6 8.43045 12.1727 8.00005 11.5252C7.56964 12.1727 6.83366 12.6 6.00003 12.6C5.16603 12.6 4.42963 12.1724 3.99964 11.5244C3.65684 12.0408 3.11844 12.422 2.47962 12.5516C2.36239 12.5756 2.23963 12.5452 2.14681 12.4696C2.054 12.3936 2 12.28 2 12.1596V5.00002C2 3.89719 2.89719 3 4.00002 3ZM24.4 10.2C24.4 10.782 24.7172 11.3056 25.2 11.5856H25.2003V5.00002C25.2003 4.33842 24.6619 3.80002 24.0003 3.80002H4.0003C3.3387 3.80002 2.8003 4.33842 2.8003 5.00002V11.5856C3.28311 11.3056 3.60031 10.782 3.60031 10.2V5.00002C3.60031 4.77923 3.77952 4.60003 4.0003 4.60003C4.22108 4.60003 4.40028 4.77923 4.40028 5.00002V10.2C4.40028 11.0824 5.11784 11.8 6.00027 11.8C6.88264 11.8 7.60025 11.0824 7.60025 10.2V5.00002C7.60025 4.77923 7.77945 4.60003 8.00023 4.60003C8.22102 4.60003 8.40022 4.77923 8.40022 5.00002V10.2C8.40022 11.0824 9.11783 11.8 10.0002 11.8C10.8826 11.8 11.6002 11.0824 11.6002 10.2V5.00002C11.6002 4.77923 11.7794 4.60003 12.0002 4.60003C12.221 4.60003 12.4002 4.77923 12.4002 5.00002V10.2C12.4002 11.0824 13.1177 11.8 14.0001 11.8C14.8825 11.8 15.6001 11.0824 15.6001 10.2V5.00002C15.6001 4.77923 15.7793 4.60003 16.0001 4.60003C16.2209 4.60003 16.4001 4.77923 16.4001 5.00002V10.2C16.4001 11.0824 17.1177 11.8 18.0001 11.8C18.8825 11.8 19.6001 11.0824 19.6001 10.2V5.00002C19.6001 4.77923 19.7793 4.60003 20 4.60003C20.2208 4.60003 20.4 4.77923 20.4 5.00002V10.2C20.4 11.0824 21.1176 11.8 22 11.8C22.8824 11.8 23.6 11.0824 23.6 10.2V5.00002C23.6 4.77923 23.7792 4.60003 24 4.60003C24.2208 4.60003 24.4 4.77923 24.4 5.00002V10.2Z" />
              <path fill-rule="evenodd" clip-rule="evenodd"
                d="M22.8 23.4C22.8 23.6208 22.6208 23.8 22.4 23.8H12.8C12.5792 23.8 12.4 23.6208 12.4 23.4V15.4C12.4 15.1792 12.5792 15 12.8 15H22.4C22.6208 15 22.8 15.1792 22.8 15.4V23.4ZM22 15.8H13.2V23H22V15.8Z" />
              <path
                d="M20.2828 16.7172C20.1264 16.5607 19.8736 16.5607 19.7172 16.7172C19.5608 16.8736 19.5608 17.1264 19.7172 17.2828L20.5172 18.0828C20.5952 18.1608 20.6976 18.2 20.8 18.2C20.9024 18.2 21.0048 18.1608 21.0828 18.0828C21.2392 17.9264 21.2392 17.6736 21.0828 17.5172L20.2828 16.7172Z" />
            </svg>
          </div>
          <div class="footer__list-title">shop</div>
        </a>
		<a class="footer__list-item  <?php echo $is_basket ? 'footer__list-item--active' : '';?>" href="<?php echo wc_get_cart_url(); ?>">
			<div class="tl-cart-goods-amoun" attr-js-selector="footer-cart-amount">
				<?php echo  WC()->cart->get_cart_contents_count(); ?>
			</div>	
			<div class="footer__list-icon"><svg viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd"
                d="M26.2494 12.1837C25.7253 11.5273 25.0102 11.1649 24.2363 11.1649H22.4681C22.3016 6.62939 19.0151 3 14.9988 3C10.9824 3 7.6959 6.62939 7.52937 11.1649H5.76121C4.98733 11.1649 4.27223 11.5273 3.74814 12.1837C3.08692 13.0065 2.84692 14.1527 3.09672 15.2547L5.21753 24.6C5.5359 26.0106 6.63304 27 7.88202 27H22.1106C23.3596 27 24.4567 26.0155 24.7751 24.6L26.9008 15.2547C27.1506 14.1527 26.9106 13.0065 26.2494 12.1837ZM14.9988 4.99837C17.9179 4.99837 20.3081 7.73143 20.4649 11.1649H9.53263C9.68937 7.73633 12.0796 4.99837 14.9988 4.99837ZM22.8306 24.1592L24.9514 14.809C25.0641 14.3143 25.2012 13.1633 24.2363 13.1633H5.76121C4.86488 13.1633 4.93345 14.3143 5.0461 14.809L7.16692 24.1592C7.27467 24.6392 7.58325 25.0016 7.88202 25.0016H22.1155C22.4143 25.0016 22.7228 24.6392 22.8306 24.1592Z" />
              <path
                d="M10.0371 15.1519C9.48368 15.1519 9.03796 15.5976 9.03796 16.151V22.3959C9.03796 22.9494 9.48368 23.3951 10.0371 23.3951C10.5906 23.3951 11.0363 22.9494 11.0363 22.3959V16.151C11.0412 15.6025 10.5906 15.1519 10.0371 15.1519Z" />
              <path
                d="M14.8812 15.1519C14.3277 15.1519 13.882 15.5976 13.882 16.151V22.3959C13.882 22.9494 14.3277 23.3951 14.8812 23.3951C15.4347 23.3951 15.8804 22.9494 15.8804 22.3959V16.151C15.8804 15.6025 15.4298 15.1519 14.8812 15.1519Z" />
              <path
                d="M19.7204 15.1519C19.1669 15.1519 18.7212 15.5976 18.7212 16.151V22.3959C18.7212 22.9494 19.1669 23.3951 19.7204 23.3951C20.2738 23.3951 20.7196 22.9494 20.7196 22.3959V16.151C20.7196 15.6025 20.2738 15.1519 19.7204 15.1519Z" />
            </svg>
          </div>
          <div class="footer__list-title">basket</div>
        </a>
		<a class="footer__list-item  
			<?php echo $is_account_page ? 'footer__list-item--active' : '';?>" 
			href="<?php echo $orders_link; ?>"
		>
          <div class="footer__list-icon footer__list-icon--orders"><svg viewBox="0 0 22 24" fill="none"
              xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd"
                d="M15.881 1.92565C14.6607 0.684404 12.9385 0 10.929 0C8.9194 0 7.19725 0.684404 5.97696 1.92565C4.75762 3.16593 4.08825 4.91231 4.08825 6.94737C4.08825 9.68716 5.28114 11.4531 6.7575 12.5131C7.04443 12.719 7.34096 12.8977 7.6401 13.0518C5.9902 13.5052 4.65053 14.2955 3.55981 15.2759C1.83513 16.8259 0.766182 18.8202 0.0460054 20.6059C-0.0844535 20.9294 0.0720265 21.2973 0.395534 21.4278C0.719029 21.5583 1.08702 21.4018 1.21748 21.0783C1.90296 19.3786 2.88196 17.5834 4.40415 16.2153C5.91106 14.8611 7.98339 13.8947 10.929 13.8947C13.6826 13.8947 15.6706 14.7392 17.1462 15.951C18.6342 17.173 19.6363 18.7978 20.3543 20.404C20.8333 21.4757 19.9926 22.7368 18.673 22.7368H4.09891C3.7501 22.7368 3.46733 23.0197 3.46733 23.3684C3.46733 23.7172 3.7501 24 4.09891 24H18.673C20.7599 24 22.4185 21.9269 21.5075 19.8887C20.7452 18.1834 19.6427 16.3666 17.9479 14.9749C16.942 14.1488 15.7394 13.4826 14.2994 13.0746C15.0696 12.6488 15.7027 12.0836 16.2064 11.4431C17.2964 10.0573 17.7697 8.33704 17.7697 6.94737C17.7697 4.91231 17.1004 3.16593 15.881 1.92565ZM14.9803 2.8112C15.9341 3.78144 16.5066 5.19296 16.5066 6.94737C16.5066 8.08401 16.1106 9.52168 15.2136 10.6622C14.3338 11.7808 12.961 12.6316 10.929 12.6316C10.1071 12.6316 8.68925 12.345 7.49423 11.4869C6.33171 10.6522 5.35141 9.26024 5.35141 6.94737C5.35141 5.19296 5.92386 3.78144 6.87772 2.8112C7.83063 1.84191 9.21296 1.26316 10.929 1.26316C12.645 1.26316 14.0274 1.84191 14.9803 2.8112Z" />
            </svg>
          </div>
          <div class="footer__list-title">orders</div>
        </a></div>
    </div>
  </footer>
	<div class="site-overlay"></div>

	<?php wp_footer(); ?>
<div class="hidden" style="display: none;">
<?php if(false && get_theme_mod('bacola_location_filter',0) == 1){ ?>
    <div class="site-location beardcrumbs-location">
        <a href="#">
            <?php if(bacola_location() == 'all'){ ?>
                <div class="current-location"><?php esc_html_e('Select a Location','bacola'); ?></div>
            <?php } else { ?>
                <div class="current-location activated"><?php echo esc_html(bacola_location()); ?></div>
            <?php } ?>
        </a>
    </div>
<?php } ?>
</div>
<div class="promoja-popup hidden">
	<div class="promoja-popup-block">
		<div class="top-block">
			<div class="promoja-title">How Pamoja works</div>
			<div class="close-block"><span class="close-promoja-popup"><i class="klbth-icon-cancel"></i></span></div>
		</div>
		<div class="bottom-block">
			<ul>
				<li class="promoja-popup-item">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam molestie lacus et leo condimentum tempus. Maecenas condimentum sapien augue, eu vestibulum nisl porttitor sed.</li>
				<li class="promoja-popup-item">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam molestie lacus et leo condimentum tempus. Maecenas condimentum sapien augue, eu vestibulum nisl porttitor sed.</li>
				<li class="promoja-popup-item">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam molestie lacus et leo condimentum tempus. Maecenas condimentum sapien augue, eu vestibulum nisl porttitor sed.</li>
			</ul>
		</div>
	</div>
</div>

<?php get_template_part( 'templates/partial/add-to-cart-popup' ); ?>

<script>
jQuery( 'document' ).ready( function( $ ) {
	$('#fma_lwp_phone_number').click(function(){
		if(jQuery('#country_code').val() === '+254' && $(this).val().length === 0){
			$(this).val(0);
		}
	});
    // Form submission listener
    jQuery('.swal-button--confirm').click(function(){
		 var first_name = $('#fma_lwp_firstname').val();
		 var last_name = $('#fma_lwp_lastname').val();
		console.log( first_name );
		console.log( last_name );
            $.ajax( {
                url : '<?php echo admin_url( 'admin-ajax.php' ) ?>',                 // Use our localized variable that holds the AJAX URL
                type: 'POST',                   // Declare our ajax submission method ( GET or POST )
                data: {                         // This is our data object
                    action  : 'um_cb',          // AJAX POST Action
                    'first_name': first_name,
                    'last_name': last_name,
                }
            } )
            .success( function( results ) {
                console.log( 'User Meta Updated!' );
            } )
            .fail( function( data ) {
                console.log( data.responseText );
                console.log( 'Request failed: ' + data.statusText );
            } );
    } );
	if(jQuery('.woocommerce-breadcrumb').length != 0){
		jQuery('.woocommerce-breadcrumb').append(jQuery('.beardcrumbs-location'));
	}else{
		jQuery('.homepage-content').children('.container').prepend(jQuery('.beardcrumbs-location'));
		jQuery('.homepage-content').children('.container').addClass('without-beardcrumbs');
	}
	jQuery('.product').hover(function(){
		var input_qty_arr = [];
		jQuery(this).find('input.qty').each(function() {
			input_qty_arr.push(this);
		});
		jQuery.each(input_qty_arr, function (index, value) {
            jQuery(value).change(function(){
				var qty = jQuery(this).val();
				console.log(qty);
				jQuery.each(input_qty_arr, function (index, value) {
					jQuery(value).val(qty);
				});
			});
        });
	});
	jQuery('.product-info-link').click(function(){
		jQuery('.promoja-popup').removeClass('hidden');
		jQuery('.close-promoja-popup').click(function(){
			jQuery('.promoja-popup').addClass('hidden');
		});
	});
	if(jQuery('body').hasClass('woocommerce-checkout')){
		jQuery('#fma_lwp_send_code_btn').click(function(){
			var response = grecaptcha.getResponse();
			if (response.length == 0) {
              	jQuery('#recaptcha_err_msg').show();
            }
            else {
              	jQuery('#recaptcha_err_msg').hide();
				if($(this).hasClass('disabled')){}else{
					$('#recaptcha-container').css('display', 'none');
					$(this).css('display', 'none');
				}
				
            }
		});
		jQuery('.add-user-agent-checkout').click(function(){
			var user_login = jQuery('#customer_phone').val();
			var user_name = jQuery('#customer_name').val();
			if(user_name.length > 0 && user_login.length > 0){
				$.ajax( {
					url : '<?php echo admin_url( 'admin-ajax.php' ) ?>',   // Use our localized variable that holds the AJAX URL
					type: 'POST',                   // Declare our ajax submission method ( GET or POST )
					data: {                         // This is our data object
						action  : 'agent_create_customer',          // AJAX POST Action
						'user_name': user_name,
						'user_login': user_login,
					}
				} )
				.success( function( response ) {
					//console.log( 'User Created!' );
					if(response.length > 0 ){
						jQuery('.msg-user-added').html(response);
						jQuery('.msg-user-added').show();
						setTimeout(function(){
							jQuery('.msg-user-added').fadeOut();

						},3000);
					}else{
						jQuery('.msg-user-added').show();
						setTimeout(function(){
							jQuery('.msg-user-added').fadeOut();

						},3000);
					}
				} )
				.fail( function( data ) {
					console.log( data.responseText );
					console.log( 'Request failed: ' + data.statusText );
				} );
			}else{
				jQuery('.user-error-msg').show();
				setTimeout(function(){
					jQuery('.user-error-msg').fadeOut();

				},3000);
			}
		});
		var select_user = jQuery('#acf-field_61e9cf9f44b38-field_61e9cfcc44b39').val();
		jQuery('.order-review-wrapper').addClass('disabled');
		jQuery('#acf-field_61e9cf9f44b38-field_61e9cfcc44b39').change(function(){
			if(jQuery(this).val().length > 0){
				jQuery('.order-review-wrapper').removeClass('disabled')
			}else{
				jQuery('.order-review-wrapper').addClass('disabled');
			}
		})
		var count_input = 0;
		var inputs_id = '';
		jQuery('.acf-button').click(function(){
			setTimeout(function(){
			
				jQuery('.acf-table').find('input').each(function(){
					count_input++;
					console.log(jQuery(this));

					if(count_input === 2){
						inputs_id = '#' + jQuery(this).attr('id');
					}
					console.log(inputs_id);
					jQuery(inputs_id).keyup(function(){
						if(jQuery(this).val().length > 0){
							jQuery('.order-review-wrapper').removeClass('disabled')
						}else{
							jQuery('.order-review-wrapper').addClass('disabled');
						}
						console.log(jQuery(this).val());
					});
				});
			},1000);
		});
		
	}
	jQuery('.-minus').click(function(){
		jQuery('.acf-table').find('input').each(function(){
            count_input++;
			
            /*console.log(jQuery(this));

            if(count_input === 4){
                inputs_id = '#' + jQuery(this).attr('id');
            }
            console.log(inputs_id);
            jQuery(inputs_id).change(function(){
                if(jQuery(this).val().length > 0){
                    jQuery('.order-review-wrapper').removeClass('disabled')
                }else{
                    jQuery('.order-review-wrapper').addClass('disabled');
                }
                console.log(jQuery(this).val());
            });*/
        });
		console.log(count_input);
	});
	if(jQuery('body').hasClass('woocommerce-account')){
		jQuery('#pills-editacc-tab').click(function(){
			jQuery('.groupWrapper').removeClass('active');
			jQuery('.editacc-tab').addClass('active');
		});
		jQuery('#pills-customers-tab').click(function(){
			jQuery('.groupWrapper').removeClass('active');
			jQuery('.customers-tab').addClass('active');
		});
		jQuery('#pills-orders-tab').click(function(){
			jQuery('.groupWrapper').removeClass('active');
			jQuery('.orders-tab').addClass('active');
		});
		jQuery('.statsWrapper').removeClass('show');
		jQuery('.statsWrapper').removeClass('active');
		jQuery('#nav-week').addClass('show');
		jQuery('#nav-week').addClass('active');
		jQuery('.dropdown-menu-item').click(function(){
			var tabid = jQuery(this).data('tabid');
			var tabname = jQuery(this).html();
			jQuery('.statsWrapper').removeClass('show');
			jQuery('.statsWrapper').removeClass('active');
			jQuery('#' + tabid).addClass('show');
			jQuery('#' + tabid).addClass('active');
			jQuery('.period-dropdown-btn').html(tabname);
		});
	}
	<?php if(is_checkout()){ ?>
	jQuery('option').click(function(){
		jQuery('option').removeAttr('selected');
		jQuery(this).attr('selected', 'selected');
	});
	jQuery('#sales_agent').change(function(){
		if(jQuery(this).val().length > 0){
            jQuery('.order-review-wrapper').removeClass('disabled')
        }else{
            jQuery('.order-review-wrapper').addClass('disabled');
        }
	});
	var fake_email = '<?php echo wp_create_nonce(); ?>' + '@kapu.com';
	jQuery('#billing_email').val(fake_email);
    jQuery('.swal-button--confirm').on('click',function(){
        var temp = jQuery("<input>");
        jQuery("body").append(temp);
        temp.val(new_password).select();
        document.execCommand("copy");
        temp.remove();
        location.reload();
    });
	setTimeout(function(){
		jQuery('.select2-search__field').attr('placeholder', 'Search customer by mobile #');
	},500);
    <?php } ?>
	jQuery('input[name="xoo-ml-reg-phone"]').keyup(function(){
		var ccode = $('select.xoo-ml-phone-cc').val();
		if(ccode == '+254'){
			if($(this).val().length == 9){
				$('.xoo-ml-login-otp-btn').addClass('active');
			}else{
				$('.xoo-ml-login-otp-btn').removeClass('active');
			}
		}
		if(ccode == '+380'){
			if($(this).val().length == 9){
				$('.xoo-ml-login-otp-btn').addClass('active');
			}else{
				$('.xoo-ml-login-otp-btn').removeClass('active');
			}
		}
		if(ccode !== '+254' && ccode !== '+380'){
			if($(this).val().length == 9){
				$('.xoo-ml-login-otp-btn').addClass('active');
			}else{
				$('.xoo-ml-login-otp-btn').removeClass('active');
			}
		}
	});
} );
function isEven(value) {
	if (value%2 == 0)
		return true;
	else
		return false;
}
</script>
<?php if( is_front_page() ) { ?>
<script> 
 if (!sessionStorage.alreadyClicked) {
window.onload=function(){
	try{

  document.getElementById("locid").click();
  sessionStorage.alreadyClicked = 1;
} catch(e){
	console.log("err");
}
  }
}
</script>
<?php } ?>
<script>
function alertFunction() {
   var element = document.getElementById("hidelc");
   element.classList.add("showalert");
}
</script>
<script>
(function ($) {
  "use strict";
$('.product').click(function(){
  $('.product').removeClass('active');
  $(this).addClass('active');
});
})(jQuery);
</script>
<style>
	.woocommerce-billing-fields{
		display: none;
	}
	#registrationSwitch{
		display: none;
	}
	.cuss-title-pomoja-padding{
		height: 10px;
		width: 100%;
	}
	.cuss_item{
		margin-bottom: 5px;
	}
	.my-account-wrapper{
		padding: 0 20px;
	}
	.orders-tab .myAccount.ordersWrapper .order .order-status.Cancelled{
		border-color: red;
		color: red;
	}
	.orders-tab .myAccount.ordersWrapper .order .order-status.Delivered{
		border-color: rgba(33, 37, 41, 0.5);
		color: rgba(33, 37, 41, 0.5);
	}
	.title{
		font-size: 14px;
    	font-weight: 600;
		color: #68A315;
		text-transform: uppercase;
	}
	.agent-customer-details{
		display: none;
	}
	.agent-customer-details.main{
		display: block;
	}
	.woocommerce{
		margin-bottom: 100px;
	}
	.chapter{
		font-size: 14px;
    	font-weight: 800;
		color: #212529;
	}
	.period-dropdown-btn{
		background: none;
		color: #FF7700;
		font-size: 12px;
    	font-weight: 600;
	}
	.editacc-tab .dropdown-btn-wrap .dropdown-menu{
		text-align: center;
		border-color: #FF7700;
	}
	.editacc-tab .dropdown-btn-wrap .dropdown-menu .dropdown-menu-item{
		padding: 3px 0;
	}
	.editacc-tab .dropdown-btn-wrap .dropdown-menu .dropdown-menu-item:hover{
		cursor: pointer;
	}
	.my-account-page .groupWrapper.customers-tab{
		border:none;
		padding: 0;
	}
	.my-account-page .groupWrapper.customers-tab .cuss_item{
		padding: 20px;
    	border: 1px var(--wrapperBorder) solid;
    	border-radius: 2px;
		margin-bottom: 10px;
	}
/*.agent .disabled{
    opacity: 0.5;
    pointer-events: none;
}*/
.confirmation_pop-up_wrapper{
    z-index: 999;
}
/*.woocommerce-checkout .acf-fields .acf-field-61e9cfcc44b39:after{
    top: 9px;
}*/
.orders-tab .myAccount.ordersWrapper .order{
    display: block;
}
.orders-tab .myAccount.ordersWrapper .order .info a{
    font-size: 12px;
    font-weight: 700;
    color: #9B9BB4;
    line-height: 20px;
}
.orders-tab .myAccount.ordersWrapper .order .info .order-info{
    font-size: 11px;
    font-weight: 200;
    color: rgba(33, 37, 41, 0.5);
    line-height: 20px;
}
.orders-tab .myAccount.ordersWrapper .order .info .order-info-total{
    font-size: 11px;
    font-weight: 600;
    color: #212529;
    line-height: 18px;
}
.orders-tab .myAccount.ordersWrapper .order .order-status{
    margin-top: 10px;
    font-size: 12px;
    font-weight: 200;
    color: #FF7700;
    border: 1px solid #FF7700;
    border-radius: 4px;
    padding: 10px 9px;
    width: fit-content;
    text-transform: uppercase;
}
.editacc-tab h3{
    font-size: 12px;
    font-weight: 700;
    color:#212529;
    line-height: 20px;
    margin-bottom: 0;
}
.editacc-tab .title{
    font-size: 12px;
    font-weight: 700;
    color:#212529;
    line-height: 20px;
    margin-bottom: 0;
	text-transform: uppercase;
}
.editacc-tab .name{
    font-size: 12px;
    font-weight: 200;
    color: rgba(33, 37, 41, 0.5);
    line-height: 20px;
}
.editacc-tab .phone{
    font-size: 11px;
    font-weight: 700;
    color: rgba(33, 37, 41, 0.5);
    line-height: 18px;
}
.editacc-tab .location{
    font-size: 11px;
    font-weight: 600;
    color: rgba(33, 37, 41, 0.5);
    line-height: 18px;
}
.editacc-tab .signOutBtn{
    margin-top: 20px;
    font-size: 12px;
    font-weight: 200;
    color:#fff;
    padding: 10px 18px;
    background: #E84A5F;
    border-color: #E84A5F;
    border-radius: 4px;
    text-transform: uppercase;
    display: block;
    width: fit-content;
}
.my-account-page .statsWrapper .stat .stat__heading{
    text-transform: uppercase;
    font-size: 10px;
    font-weight: 500;
    color: #71778E;
}
td.product-subtitle{
    text-align: left;
    padding-left: 0;
}
td.product-img{
    padding: 0;
    text-align: center;
    width: 54px;
}
td.product-img img{
    width: auto;
    max-width: 40px;
}
td.product-subtitle{
    font-size: 11px;
    font-weight: 600;
    color: rgba(33, 37, 41, 0.5);

}
.product-price, .product-qty{
    padding-right: 0;
}
td.product-subtitle, td.product-price, td.product-qty, td.product-total{
    border: none;
    padding: 0;
}
td.product-price, td.product-qty, td.product-total{
    font-size: 11px;
    font-weight: 200;
    color: rgba(33, 37, 41, 0.5);
}
td.product-total{
    color: rgba(33, 37, 41, 0.7);
}
td.product-subtotal{
    color: rgba(33, 37, 41, 0.7);
    text-transform: uppercase;
    height: 40px;
    padding-bottom: 20px;
}
td.product-total{
    padding-bottom: 20px;
}
.order_details tfoot{
    border-top: 1px solid #F7F8FD;
}
.order_details tfoot td.order-total-title{
    text-align: left;
    font-size: 12px;
    font-weight: 600;
    color: rgba(33, 37, 41, 0.6);
    text-transform: uppercase;
    padding: 0;
    width: 57px;
    height: 30px;
    position: relative;
}
.order_details tfoot td.order-total-title span{
    position: absolute;
    top: 10px;
    left: 0;
    width: 132px;
}
.my-account-navigation{
    display: none;
}
.order-details-block span{
    display: block;
    line-height: 20px;
}
h2.woocommerce-customer-details__title{
    display: none;
}
table.customer_details{
    display: none;
}
section.woocommerce-order-details{
    margin-top: 10px;
    margin-bottom: 20px;
}
p.order-again{
    display: none;
}
.woocommerce-customer-details{
    display: none;
}
.woocommerce-customer-details.woocommerce-view-order-sec{
    display: block;
}
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
.woocommerce-order-details{
    border:1px solid #F7F8FD;
    border-radius: 2px;
    padding: 20px;
}
.items-title{
    margin-bottom: 20px;
}
h2.pickup_details{
    border:none;
    font-weight: 700;
    padding-bottom: 0;
    margin-bottom: 0;
}
.pickup_details_wrap{
    padding: 20px;
    border: 1px solid #F7F8FD;
    margin-bottom: 20px;
}
.agent-customer-details, .order-details-block_wrap{
    padding: 20px;
    border: 1px solid #F7F8FD;
    margin-bottom: 20px;
}
.agent-customer-details .cuss-title{
    margin-top: 0;
}
.woocommerce-customer-details.woocommerce-view-order-sec{
    margin-top: 20px;
}
.order-num p{
    text-transform: uppercase;
    font-size: 12px;
    font-weight: 700;
    color: #71778E;
    margin-bottom: 0;
    line-height: 20px;
}
.order-details-block .left-block span{
    font-size: 11px;
    font-weight: 600;
    color: rgba(33, 37, 41, 0.5);
}
.order-status{
    text-transform: capitalize;
}
.order-details-block .right-block span{
    font-size: 12px;
    font-weight: 500;
    color: rgba(33, 37, 41, 0.5);
}
.order-details-block .right-block span.payment_method{
    font-size: 12px;
    font-weight: 700;
    color: rgba(33, 37, 41);
}
.cuss-title{
    font-family: var(--font-secondary);
}
.woocommerce-MyAccount-content h3 a{
    text-align: right;
    float: right;
    width: 65%;
    display: inline-block;
    font-size: 10px;
    font-weight: 500;
    color: #68A315;
    text-decoration: underline;
}
.back-btn-wrap{
    background: #fff;
    padding-bottom: 20px;
}
.back-btn-wrap a{
    font-size: 14px;
    font-weight: 600;
    color: #212529;
    padding-left: 20px;
    text-transform: uppercase;
    position: relative;
}
.back-btn-wrap a:before{
    font-family: "klbtheme";
    font-size: 180%;
    content: '\e8d3';
    transform: rotate(0.5turn);
    display: block;
    position: absolute;
    top: -11px;
}
.back-btn-wrap a:hover{
    text-decoration: none;
}
</style>
	</body>
</html>