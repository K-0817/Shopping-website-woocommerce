<?php
/**
 * header.php
 * @package WordPress
 * @subpackage Bacola
 * @since Bacola 1.0
 * 
 */
 ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( "charset" ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1">
    <link rel='stylesheet' id='bacola-child-css'  href='/wp-content/themes/bacola-child/style.css' type='text/css' media='all' />
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-FEY3WV0SBE"></script>
	<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-FEY3WV0SBE');
	</script>
 	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-KJB3JGT');</script>
	<!-- End Google Tag Manager -->
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KJB3JGT"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

	<?php if (get_theme_mod( 'bacola_preloader' )) { ?>
		<div class="site-loading">
			<div class="preloading">
				<svg class="circular" viewBox="25 25 50 50">
					<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
				</svg>
			</div>
		</div>
	<?php } ?>

	<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) { ?>
		<?php get_template_part( 'includes/header/models/canvas-menu' ); ?>
	
		<?php get_template_part( 'includes/header/models/top-notification' ); ?>
	
		<?php
		if(get_theme_mod('bacola_header_type') == 'type1'){
			get_template_part( 'includes/header/header-type1' );
		} else {
			get_template_part( 'includes/header/header-type2' );
		}
		?>
	<?php } ?>

	<main id="main" class="site-primary">
		<div class="site-content">
			<div class="homepage-content">