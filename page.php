<?php get_header(); ?>
  <div class="wrapper">

    <div class="main">

		<?php if ( have_posts() ) : while ( have_posts() ): the_post(); ?>


			<?php if ( function_exists( 'rl_color' ) ) {
				$category_color = rl_color( get_the_category()[0]->cat_ID );
			} ?>

          <div <?php post_class( 'page' ); ?>>
            <div class="page__content">
				      <?php the_content(); ?>
            </div>
          </div>

		<?php endwhile; endif; ?>

    </div>
	  <?php get_sidebar(); ?>
  </div>

<?php get_footer(); ?>