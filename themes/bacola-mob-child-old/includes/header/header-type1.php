<header id="masthead" class="site-header desktop-shadow-disable mobile-shadow-enable mobile-nav-enable" itemscope="itemscope" itemtype="http://schema.org/WPHeader">
	<?php if(get_theme_mod('bacola_top_header',0) == 1){ ?>
		<div class="header-top header-wrapper hide-mobile">
			<div class="container">
				<div class="column column-left">
					<nav class="site-menu horizontal">
						<?php 
							wp_nav_menu(array(
							'theme_location' => 'top-left-menu',
							'container' => '',
							'fallback_cb' => 'show_top_menu',
							'menu_id' => '',
							'menu_class' => 'menu',
							'echo' => true,
							"walker" => '',
							'depth' => 0 
							));
						?>
					</nav><!-- site-menu -->
				</div><!-- column-left -->
				
				<div class="column column-right">

					<div class="topbar-notice">
						<i class="klbth-icon-<?php echo esc_attr(get_theme_mod('bacola_top_header_text_icon')); ?>"></i>
						<span><?php echo bacola_sanitize_data(get_theme_mod('bacola_top_header_text')); ?></span>
					</div>

					<div class="text-content">
						<?php echo bacola_sanitize_data(get_theme_mod('bacola_top_header_content_text')); ?>
					</div>

					<div class="header-switchers">
						<nav class="store-language site-menu horizontal">
							<?php 
								wp_nav_menu(array(
								'theme_location' => 'top-right-menu',
								'container' => '',
								'fallback_cb' => 'show_top_menu',
								'menu_id' => '',
								'menu_class' => 'menu',
								'echo' => true,
								"walker" => '',
								'depth' => 0 
								));
							?>
						</nav><!-- site-menu -->
					</div><!-- header-switchers -->

				</div><!-- column-right -->
			</div><!-- container -->
		</div><!-- header-top -->
	<?php } ?>
	<!-- new header 09.02.22 -->
	<?php 
	// need hide on empty cart page && need log in template
	$need_show_header = false;
	if(is_cart()){
		global $woocommerce;
		$need_show_header = $woocommerce->cart->cart_contents_count != 0;
		// dd($woocommerce->cart->get_cart_total());
	} else if(is_front_page()){
		$need_show_header = true;
	}
	if($need_show_header):
	?>
	<header id="js-tl-header" class="header">
		<?php if(is_cart()) : ?>
			<div class="basket__top">
				<div class="basket__simple-title simple-title">BASKET</div>
			</div>
		<?php else: ?>
			<div class="header__inner">
				<div class="center-wrap">
					<div class="header__wrap">
						<div class="header__burger" onclick="tl_shopFiltersControll.openFilters()">
						<div></div>
						<div></div>
						<div></div>
						</div>
						<div class="header__categories simple-title" onclick="tl_shopFiltersControll.openFilters()">
							categories
						</div>
						<a class="header__logo single-anchors img-wrap" 
							href="<?php echo esc_url( home_url( "/" ) ); ?>" 
							title="<?php bloginfo("name"); ?>"
						>
							<div>
								<img src="<?php echo get_template_directory_uri(); ?>/TimLis/NewCatalogPage/assets/images/png/logo.png" alt="">
							</div>
						</a>
					</div>
				</div>
			</div>
		<?php endif; ?>

	</header>
	<!-- end new header -->
	<?php endif; ?>

	<div class="header-nav header-wrapper hide-mobile">
		<div class="container">
		
			<?php get_template_part( 'includes/header/models/sidebar-menu' ); ?>

			<nav class="site-menu primary-menu horizontal">
				<?php
					wp_nav_menu(array(
					'theme_location' => 'main-menu',
					'container' => '',
					'fallback_cb' => 'show_top_menu',
					'menu_id' => '',
					'menu_class' => 'menu',
					'echo' => true,
					"walker" => new bacola_main_walker(),
					'depth' => 0 
					));
				?>
			</nav><!-- site-menu -->
		</div><!-- container -->
	</div><!-- header-nav -->

	<?php do_action('bacola_mobile_bottom_menu'); ?>
</header><!-- site-header -->