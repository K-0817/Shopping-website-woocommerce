<?php
/**
 * Product Loop End
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-end.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- </div> -->
<div class="hover_bkgr_fricc">
    <span class="helper"></span>
    <div>
        <div class="popupCloseButton">&times;</div>
        <p>Add any HTML content<br />inside the popup box!</p>
    </div>
</div> 

</div>
			</div>
		</div>
		<a id="move-top" class="catalog__top tl-btn btn--move-top single-anchors">
      <svg viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M11.2508 8.26239L6.62542 3.63696L2 8.25892" stroke-linecap="round" stroke-linejoin="round" />
			<path d="M6.62543 3.63696V13.5132" stroke-linecap="round" stroke-linejoin="round" />
			<path d="M1 0.5H13" stroke-linecap="round" stroke-linejoin="round" />
			</svg>
			<div class="btn__title">Back to top</div>
		</a>
	</section>
</main>

<div id="js-tl-categories-wrpa" class="categories">
    <div class="categories__wrap">
        <?php if ( is_active_sidebar( 'shop-sidebar' ) ): ?>
          <?php dynamic_sidebar( 'shop-sidebar' ); ?>
        <?php endif; ?>

      <div class="categories__top">
        <div class="categories__title simple-title">browse categories</div>
        <div class="categories__act categories__act--close" onclick="tl_closeShopFilter()">close</div>
      </div>
      <div class="categories__body">
        <div class="categories__checkbox checkbox">
          <!-- <label class="checkbox__label" for="checkbox1">
            <input class="checkbox__input" type="checkbox" id="" name="checkbox-categories"><span
              class="checkbox__content"></span>example Beauty
          </label> -->
        </div>
        <div class="categories__btns">
          <div 
            class="categories__btn tl-btn btn--empty categories__btn--opacity"
            attr-js-filter-shop-clear
            onclick="tl_shopFiltersControll.handlerClearFilter()"
          >clear</div>
          <div 
            class="categories__btn tl-btn btn--orange categories__btn--opacity"
            attr-js-filter-shop-aplly
            onclick="tl_shopFiltersControll.handlerApplyFilter()"
          >
            apply
          </div>
        </div>
        <div class="categories__phone">
          <div class="categories__phone-left">
            <div class="categories__phone-title">need help?</div>
            <div class="categories__phone-tel" id="destenation-1-tl-js-get-phone-number-for-origin">Call Us on </div>
            <div class="categories__phone-info">We’re available from<br>8:00AM - 7:00PM</div>
          </div>
          <div class="categories__phone-right">
            <a class="categories__phone-btn tl-btn" id="destenation-2-tl-js-get-phone-number-for-origin" href="">call</a>
          </div>
        </div>
        <div class="dn" id="tl-js-get-phone-number-for-origin">
          <?php echo get_theme_mod('bacola_top_header_content_text'); ?>  
        </div>
      </div>
    </div>
  </div>




<script>
jQuery(function($) {
$(window).load(function () {
    $("single_add_to_cart_button").click(function(){
       $('.hover_bkgr_fricc').show();
    });
    $('.hover_bkgr_fricc').click(function(){
        $('.hover_bkgr_fricc').hide();
    });
    $('.popupCloseButton').click(function(){
        $('.hover_bkgr_fricc').hide();
    });
});
});
</script>
<script>
  try{
  let tl_linkWithPhone = document.querySelector('#tl-js-get-phone-number-for-origin a');
  document.querySelector('#destenation-1-tl-js-get-phone-number-for-origin')
    .innerHTML += " " + tl_linkWithPhone.innerText.trim();
  document.querySelector('#destenation-2-tl-js-get-phone-number-for-origin')
    .setAttribute("href", tl_linkWithPhone.getAttribute('href'));
  } catch (e){
    console.log('call number errors');
  }
</script>