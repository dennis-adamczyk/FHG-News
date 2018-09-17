<?php get_header(); ?>
<div class="wrapper">

  <div class="main">
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

			<?php $count ++; endwhile;
		else:?>
    <div class="error">
      <i class="material-icons">search</i>
      <h3>Keine Ergebnisse gefunden</h3>
      <p>Probiere andere Keywords und überprüfe deine Suche</p>
    </div>
		<?php endif; ?>

    </div>
  </div>
	<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
