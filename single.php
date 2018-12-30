<?php
add_post_view( get_the_ID() );
get_header();
?>
  <div class="wrapper">

    <div class="main">

		<?php if ( have_posts() ) : while ( have_posts() ): the_post();
			get_template_part( 'formats/single/content', get_post_format() );
		endwhile; endif; ?>

    </div>
	  <?php get_sidebar(); ?>
  </div>

<?php get_footer(); ?>