<?php get_header(); ?>
  <div class="wrapper">

    <div class="main">

		<?php if ( have_posts() ) : while ( have_posts() ): the_post(); ?>



			  <?php if ( function_exists( 'rl_color' ) ) {
				  $category_color = rl_color( get_the_category()[0]->cat_ID );
			  } ?>
			  <?php get_template_part( 'formats/single/content', get_post_format() ); ?>

		<?php endwhile; endif; ?>

    </div>
	  <?php get_sidebar(); ?>
  </div>

<?php get_footer(); ?>