<div class="site-canvas">
	<div class="site-scroll">
		<div class="canvas-header">
			<div class="site-brand">
				<?php if (get_theme_mod( 'bacola_logo' )) { ?>
					<?php $size = get_theme_mod( 'bacola_logo_size', array( 'width' => '127', 'height' => '34') ); ?>
					<a href="<?php echo esc_url( home_url( "/" ) ); ?>" title="<?php bloginfo("name"); ?>">
						<img src="<?php echo esc_url( wp_get_attachment_url(get_theme_mod( 'bacola_logo' )) ); ?>" width="<?php echo esc_attr( $size["width"] ); ?>" height="<?php echo esc_attr( $size["height"] ); ?>" alt="<?php bloginfo("name"); ?>">
					</a>
				<?php } elseif (get_theme_mod( 'bacola_logo_text' )) { ?>
					<a class="navbar-brand text" href="<?php echo esc_url( home_url( "/" ) ); ?>" title="<?php bloginfo("name"); ?>">
						<span class="brand-text"><?php echo esc_html(get_theme_mod( 'bacola_logo_text' )); ?></span>
					</a>
				<?php } else { ?>
					<a href="<?php echo esc_url( home_url( "/" ) ); ?>" title="<?php bloginfo("name"); ?>">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/images/bacola-logo.png" width="127" height="34" alt="<?php bloginfo("name"); ?>">
					</a>
				<?php } ?>
			</div><!-- site-brand -->
			<div class="close-canvas">
				<i class="klbth-icon-x"></i>
			</div><!-- close-canvas -->
		</div><!-- canvas-header -->
		
		<div class="canvas-main">

			<?php if(get_theme_mod('bacola_location_filter',0) == 1){ ?>
				<div class="site-location">
					<a href="#">
						<span class="location-description"><?php esc_html_e('Your Location','bacola'); ?></span>
						<?php if(bacola_location() == 'all'){ ?>
							<div class="current-location"><?php esc_html_e('Select a Location','bacola'); ?></div>
						<?php } else { ?>
							<div class="current-location activated"><?php echo esc_html(bacola_location()); ?></div>
						<?php } ?>
					</a>
				</div>
			<?php } ?>
			<?php if(get_theme_mod('bacola_footer_contact_area',0) == 1){ ?>
			<div class="bacola-mob-child-contact-area">
				<div class="footer-contacts">
					<div class="site-phone">
                        <div class="phone-icon"><img src="/wp-content/themes/bacola-mob-child/assets/img/call-center-icon.png" alt=""></div>
                        <div class="phone-detail">
                            <h4 class="entry-title"><?php echo esc_html(get_theme_mod('bacola_footer_phone_title')); ?></h4>
                            <span><?php echo esc_html(get_theme_mod('bacola_footer_phone_subtitle')); ?></span>
                        </div>
                    </div>
				</div>
			</div>
			<?php } ?>
			<?php /*?><div class="canvas-title">
				<h6 class="entry-title"><?php esc_html_e('Site Navigation','bacola'); ?></h6>
			</div><!-- canvas-title -->
			<nav class="canvas-menu canvas-primary vertical">
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
			</nav><!-- site-menu --><?php */?>
		</div><!-- canvas-main -->
		
		<div class="canvas-footer">
			<?php /*?><div class="site-copyright">
				<?php if(get_theme_mod( 'bacola_copyright' )){ ?>
					<?php echo bacola_sanitize_data(get_theme_mod( 'bacola_copyright' )); ?>
				<?php } else { ?>
					<?php esc_html_e('Copyright 2021.KlbTheme . All rights reserved','bacola'); ?>
				<?php } ?>
			</div><!-- site-copyright --><?php */?>
			<nav class="canvas-menu canvas-secondary select-language vertical">
				<?php 
					 wp_nav_menu(array(
					 'theme_location' => 'canvas-bottom',
					 'container' => '',
					 'fallback_cb' => 'show_top_menu',
					 'menu_id' => '',
					 'menu_class' => 'menu',
					 'echo' => true,
					 'depth' => 0 
					)); 
				?>
			</nav><!-- site-menu -->
		</div><!-- canvas-footer -->
		
	</div><!-- site-scroll -->
</div><!-- site-canvas -->