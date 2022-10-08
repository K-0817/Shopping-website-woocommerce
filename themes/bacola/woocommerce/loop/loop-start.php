<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$term = get_term_by('slug', bacola_location(), 'location');
if($term === false){
  $term = "All";
  ?>
  <script>
    window.needSelectLocation = true;
  </script>
  <?php
} else {
  $term = $term->name;
}
?>
  <main>
    <section class="catalog" id="home">
      <div class="catalog__location">
        <div class="center-wrap">
          <div class="location" onclick="tl_showSelectLocationPopup()">
            <div class="location__title">LOCATION - 
              <span class='location__title-value'><?php echo $term;?></span>
            </div>
            <div class="location__btn tl-btn">Change</div>
          </div>
        </div>
      </div>
<?php if(bacola_shop_view() == 'list_view') { ?>
	<div class="products column-1 mobile-column-1 align-inherit">
<?php } else{ ?>
	<div class="catalog__body">
		<div class="center-wrap">
			<div class="catalog__list products" id="capu-product-list">
	<!-- <div class="asdasdasda products column-<?php echo esc_attr( wc_get_loop_prop( 'columns' ) ); ?> mobile-column-2 align-inherit"> -->
<?php } ?>
