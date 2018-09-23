<?php get_header(); ?>
  <div class="wrapper">

    <div class="main">
      <h2 class="main__title">Kategorie: <span
            style="<?php echo( function_exists( 'rl_color' ) ? 'color: ' . rl_color( get_category( get_query_var( 'cat' ) )->cat_ID ) : '' ) ?>"><?php single_cat_title(); ?></span>
      </h2>
      <div class="posts">

		  <?php $count = 0;
		  if ( have_posts() ) : while ( have_posts() ): the_post(); ?>

			  <?php if ( function_exists( 'rl_color' ) ) {
				  $category_color = rl_color( get_the_category()[0]->cat_ID );
			  } ?>
			  <?php get_template_part( 'formats/post/content', get_post_format() ); ?>

			  <?php if ( $count % 5 == 0 ): ?>

              <!--TODO Werbung-->

			  <?php endif; ?>

			  <?php $count ++; endwhile; endif; ?>

      </div>
    </div>
	  <?php get_sidebar(); ?>
  </div>

<?php get_footer(); ?>