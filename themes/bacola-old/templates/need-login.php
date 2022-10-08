<?php
/*
Template Name: Need login
*/
?>
<?php get_header(); ?>
<main>
      <section class="basket">
        <div class="basket__top"> 
          <div class="basket__simple-title simple-title">orders</div>
        </div>
        <div class="center-wrap"> 
          <div class="basket__body">
            <div class="basket__img-wrap img-wrap">
              <div><img src="<?php echo get_template_directory_uri(); ?>/TimLis/NewCatalogPage/assets/images/svg/basket-icon2.svg" alt=""></div>
            </div>
            <div class="basket__content">
              <p>Sign in to view your orders</p>
            </div>
            <a class="basket__link" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>">sign in</a>
          </div>
        </div>
      </section>
    </main>
<?php get_footer(); ?>
