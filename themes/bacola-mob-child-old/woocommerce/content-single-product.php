<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>

	

	<div class="product-content">
		<div class="row">
			<div class="col col-5 col-lg-5 product-images">
				<?php
				/**
				 * Hook: woocommerce_before_single_product_summary.
				 *
				 * @hooked woocommerce_show_product_sale_flash - 10
				 * @hooked woocommerce_show_product_images - 20
				 */
				do_action( 'woocommerce_before_single_product_summary' );
				?>
			</div>
			
			<div class="col col-7 col-lg-7 product-detail">

				<?php do_action('bacola_single_header_side'); ?>

				<div class="column">
					<?php do_action('bacola_single_header_top'); 
					$stock_text = $product->get_availability();
					?>
					<div class="product-meta">
						<?php 
						if($stock_status == 'instock'){
						echo '<div class="product-available in-stock">'.$stock_text['availability'].'</div>';
						} else {
						echo '<div class="product-available outof-stock">'.$stock_text['availability'].'</div>';
						}?>
						<?php echo $product->get_categories( ', ', '<span class="posted_in">' . _n( '', 'Categories:', sizeof( get_the_terms( $post->ID, 'product_cat' ) ), 'woocommerce' ) . ' ', '.</span>' ); ?>
					</div>
					<?php /*?><?php wc_get_template_part( 'single-product', 'meta' ); ?><?php */?>
					<?php
					/**
					 * Hook: woocommerce_single_product_summary.
					 *
					 * @hooked woocommerce_template_single_title - 5
					 * @hooked woocommerce_template_single_rating - 10
					 * @hooked woocommerce_template_single_price - 10
					 * @hooked woocommerce_template_single_excerpt - 20
					 * @hooked woocommerce_template_single_add_to_cart - 30
					 * @hooked woocommerce_template_single_meta - 40
					 * @hooked woocommerce_template_single_sharing - 50
					 * @hooked WC_Structured_Data::generate_product_data() - 60
					 */
					//do_action( 'woocommerce_single_product_summary' );
					?>
				</div>
				
				
				
			</div>
			<div class="col-12">
				<div class="single-product-buttons">
					<?php
//					echo bacola_add_to_cart_button();
					echo '<div class="product-info-block">';
					echo '<span class="product-info-link"><img src="/wp-content/themes/bacola-mob-child/assets/img/info.png" alt="">How Pamoja works</span>';
					echo '</div>';
					echo '<div class="product-share-block">';
					echo '<div class="product-share-title">Share & help others save!</div>';
					echo '<div class="product-share-items-block">';
					echo '<a href="whatsapp://send?text='.get_permalink().'" data-action="share/whatsapp/share" target="_blank"><img src="/wp-content/themes/bacola-mob-child/assets/img/watsapp.png" width="20" alt=""></a>';
					echo '<div class="fb-share-button" data-href="'.get_permalink().'" data-layout="button"></div>';
					echo '</div>';
					echo '</div>'; 
					echo '</div>';
					?>
				</div>
			</div>
			<div class="col-12 single-product-features">
				
				<style>
				.vardiv .quantity{
					display: none;
				}
				.single-product-buttons .variations{
					display: flex;
					flex-direction: row;
					flex-wrap: wrap;
				}
                .single-product-buttons .variations .main_qty{
					width: 100%;
                }
                .single-content .product form.cart{
					width: 50%;
                }
			</style>
			<?php if(get_theme_mod('bacola_shop_single_featured_toggle',0) == 1 ){ ?>
					<?php $featured_title = get_theme_mod('bacola_shop_single_featured_title'); ?>
					<div class="column product-icons">
						<?php if($featured_title){ ?>
							<div class="alert-message"><?php echo esc_html($featured_title); ?></div>
						<?php } ?>
						<div class="icon-messages">
							<ul>
								<?php $featured = get_theme_mod('bacola_single_featured_list'); ?>
								<?php foreach($featured as $f){ ?>
								<li>
									<div class="icon"><i class="<?php echo esc_attr($f['featured_icon']); ?>"></i></div>
									<div class="message"><?php echo esc_html($f['featured_text']); ?></div>
								</li>
								<?php } ?>

							</ul>
						</div>
					</div>
				<?php } ?>
			</div>
			
		</div>
	</div>
</div>

	<?php
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	do_action( 'woocommerce_after_single_product_summary' );
	?>


<?php do_action( 'woocommerce_after_single_product' ); ?>
