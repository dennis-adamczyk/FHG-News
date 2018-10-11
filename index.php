<?php get_header(); ?>
<div class="wrapper">

	<div class="main">
		<h2 class="main__title">Aktuelle Neuigkeiten</h2>
		<div class="posts">

			<?php $count = 0; if ( have_posts() ) : while ( have_posts() ): the_post(); ?>

				<?php get_template_part( 'formats/post/content', get_post_format() ); ?>

				<?php if($count % 5  == 0): ?>

					<!--TODO Werbung-->

				<?php endif; ?>

				<?php $count++; endwhile; endif; ?>

		</div>
    <div class="material-loader material-loader--small infiniteScroller">
      <svg class="material-loader__circular" viewBox="25 25 50 50">
        <circle class="material-loader__circular__path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>
      </svg>
    </div>
	</div>
	<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
