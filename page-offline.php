<?php get_header(); ?>
	<div class="wrapper">

		<div class="main">

			<?php if ( have_posts() ) : while ( have_posts() ):
				the_post(); ?>

				<div <?php post_class( 'page' ); ?>>
					<div class="page__content">
						<img src="<?php echo get_theme_file_uri('/img/undraw/before_dawn.svg'); ?>" alt="Offline">
						<h3>Du bist offline</h3>
						<p>Du hast versucht eine Seite aufzurufen, die bisher noch nicht für die Offline-Nutzung verfügbar ist. Verbinde dich mit dem Internet um die Seite zu laden.</p>
						<a href="." class="button">
							<span>Erneut versuchen</span>
						</a>
					</div>
				</div>

			<?php endwhile; endif; ?>

		</div>
		<?php get_sidebar(); ?>
	</div>

<?php get_footer(); ?>