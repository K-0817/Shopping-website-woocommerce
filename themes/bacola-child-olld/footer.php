<?php
/**
 * footer.php
 * @package WordPress
 * @subpackage Bacola
 * @since Bacola 1.0
 * 
 */
 ?>
			</div><!-- homepage-content -->
		</div><!-- site-content -->
	</main><!-- site-primary -->


	<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) { ?>
		<footer class="site-footer">
			<?php $subscribe = get_theme_mod('bacola_footer_subscribe_area',0); ?>
			<?php if($subscribe == 1){ ?>
				<div class="footer-subscribe">
					<div class="container">
						<div class="row">
							<div class="col-12 col-lg-5">
								<div class="subscribe-content">
									<h6 class="entry-subtitle"><?php echo bacola_sanitize_data(get_theme_mod('bacola_footer_subscribe_title')); ?></h6>
									<h3 class="entry-title"><?php echo bacola_sanitize_data(get_theme_mod('bacola_footer_subscribe_subtitle')); ?></h3>
									<div class="entry-teaser">
										<p><?php echo bacola_sanitize_data(get_theme_mod('bacola_footer_subscribe_desc')); ?></p>
									</div>
									<div class="form-wrapper">
										<?php echo do_shortcode('[mc4wp_form id="'.get_theme_mod('bacola_footer_subscribe_formid').'"]'); ?>
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-7">
								<?php if(get_theme_mod( 'bacola_footer_subscribe_image' )){ ?>
									<div class="subscribe-image"><img src="<?php echo esc_url( wp_get_attachment_url(get_theme_mod( 'bacola_footer_subscribe_image' )) ); ?>" alt="<?php esc_attr_e('subscribe','bacola'); ?>"></div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
	
			<?php $featured_box = get_theme_mod('bacola_footer_featured_box'); ?>
			<?php if($featured_box){ ?>
				<div class="footer-iconboxes">
					<div class="container">
						<div class="row">
							<?php foreach($featured_box as $featured){ ?>
								<div class="col col-12 col-md-6 col-lg-3">
									<div class="iconbox">
										<div class="iconbox-icon"><i class="<?php echo esc_attr($featured['featured_icon']); ?>"></i></div>
										<div class="iconbox-detail">
											<span><?php echo esc_html($featured['featured_text']); ?></span>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			<?php } ?>
	
			<?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) || is_active_sidebar( 'footer-4' )) { ?>
				<div class="footer-widgets border-enable">
					<div class="container">
						<div class="row">
							<?php if(get_theme_mod('bacola_footer_column') == '3columns'){ ?>
								<div class="col col-12 col-lg-4">
									<?php dynamic_sidebar( 'footer-1' ); ?>
								</div>
								<div class="col col-12 col-lg-4">
									<?php dynamic_sidebar( 'footer-2' ); ?>
								</div>
								<div class="col col-12 col-lg-4">
									<?php dynamic_sidebar( 'footer-3' ); ?>
								</div>
							<?php } elseif(get_theme_mod('bacola_footer_column') == '4columns'){ ?>
								<div class="col col-12 col-lg-3">
									<?php dynamic_sidebar( 'footer-1' ); ?>
								</div>
								<div class="col col-12 col-lg-3">
									<?php dynamic_sidebar( 'footer-2' ); ?>
								</div>
								<div class="col col-12 col-lg-3">
									<?php dynamic_sidebar( 'footer-3' ); ?>
								</div>
								<div class="col col-12 col-lg-3">
									<?php dynamic_sidebar( 'footer-4' ); ?>
								</div>
							<?php } else { ?>
								<div class="col col-12 col-lg-3 col-five">
									<?php dynamic_sidebar( 'footer-1' ); ?>
								</div>
								<div class="col col-12 col-lg-3 col-five">
									<?php dynamic_sidebar( 'footer-2' ); ?>
								</div>
								<div class="col col-12 col-lg-3 col-five">
									<?php dynamic_sidebar( 'footer-3' ); ?>
								</div>
								<div class="col col-12 col-lg-3 col-five">
									<?php dynamic_sidebar( 'footer-4' ); ?>
								</div>
								<div class="col col-12 col-lg-3 col-five">
									<?php dynamic_sidebar( 'footer-5' ); ?>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			<?php } ?>
	
			<?php if(get_theme_mod('bacola_footer_contact_area',0) == 1){ ?>
				<div class="footer-contacts">
					<div class="container">
					
						<div class="column column-left">
							<div class="site-phone">
								<div class="phone-icon"><i class="<?php echo esc_html(get_theme_mod('bacola_footer_phone_icon')); ?>"></i></div>
								<div class="phone-detail">
									<h4 class="entry-title"><?php echo esc_html(get_theme_mod('bacola_footer_phone_title')); ?></h4>
									<span><?php echo esc_html(get_theme_mod('bacola_footer_phone_subtitle')); ?></span>
								</div>
							</div>
						</div>
						
						<div class="column column-right">
							<div class="site-mobile-app">
								<div class="app-content">
									<h6 class="entry-title"><?php echo esc_html(get_theme_mod('bacola_footer_app_title')); ?></h6>
									<span><?php echo esc_html(get_theme_mod('bacola_footer_app_subtitle')); ?></span>
								</div>
								<?php $appimage = get_theme_mod('bacola_footer_app_image'); ?>
								<?php if($appimage){ ?>
								<div class="app-buttons">
									<?php foreach($appimage as $app){ ?>
										<a href="<?php echo esc_url($app['app_url']); ?>" class="google-play">
											<img src="<?php echo esc_url( wp_get_attachment_url($app['app_image'])); ?>" alt="<?php esc_attr_e('app','bacola'); ?>">
										</a>
									<?php } ?>
								</div>
								<?php } ?>
							</div>
	
							<?php $footersocial = get_theme_mod('bacola_footer_social_list'); ?>
							<?php if(!empty($footersocial)){ ?>
								<div class="site-social">
									<ul>
										<?php foreach($footersocial as $f){ ?>
											<li><a href="<?php echo esc_url($f['social_url']); ?>" target="_blank"><i class="klbth-icon-<?php echo esc_attr($f['social_icon']); ?>"></i></a></li>
										<?php } ?>
									</ul>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			<?php } ?>
		
			<div class="footer-bottom border-enable">
				<div class="container">
					<div class="site-copyright">
						<?php if(get_theme_mod( 'bacola_copyright' )){ ?>
							<p><?php echo bacola_sanitize_data(get_theme_mod( 'bacola_copyright' )); ?></p>
						<?php } else { ?>
							<p><?php esc_html_e('Copyright 2021.KlbTheme . All rights reserved','bacola'); ?></p>
						<?php } ?>
					</div>
					
					<?php if(get_theme_mod('bacola_footer_menu',0) == '1'){ ?>
						<nav class="site-menu footer-menu">
							<?php 
							wp_nav_menu(array(
							'theme_location' => 'footer-menu',
							'container' => '',
							'fallback_cb' => 'show_top_menu',
							'menu_id' => '',
							'menu_class' => 'menu',
							'echo' => true,
							"walker" => '',
							'depth' => 0 
							));
							?>
						</nav>
					<?php } ?>

				</div>
			</div>
			
		</footer>
	<?php } ?>
	<div class="site-overlay"></div>

	<?php wp_footer(); ?>
<script>
	/*document.addEventListener('DOMContentLoaded', function(){
		jQuery('.swal-button--confirm').click(function(){
			
		});
	});*/
	jQuery( 'document' ).ready( function( $ ) {

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
} );
</script>
<?php if( is_front_page() ) { ?>
<script> 
 if (!sessionStorage.alreadyClicked) {
window.onload=function(){
  document.getElementById("locid").click();
  sessionStorage.alreadyClicked = 1;
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
	</body>
</html>