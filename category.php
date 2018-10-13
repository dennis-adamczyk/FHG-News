<?php get_header(); ?>
  <div class="wrapper">

    <div class="main">
      <h2 class="main__title">Kategorie:

		  <?php
		  if ( get_category( get_query_var( 'cat' ) )->parent !== 0 ):
			  echo '<span class="main__title__parent" style="' . ( function_exists( 'rl_color' ) ? 'color: ' . rl_color( get_category( get_query_var( 'cat' ) )->parent ) : '' ) . '" onclick="window.location = \'' . get_category_link(get_category( get_query_var( 'cat' ) )->parent) . '\'">' . get_category(get_category( get_query_var( 'cat' ) )->parent)->name . '</span>' .
			       '<i class="material-icons">chevron_right</i>' .
			       '<span style="' . ( function_exists( 'rl_color' ) ? 'color: ' . rl_color( get_category( get_query_var( 'cat' ) )->cat_ID ) : '' ) . '">' . get_category( get_query_var( 'cat' ) )->name . '</span>';
		  else:
			  echo '<span style="' . ( function_exists( 'rl_color' ) ? 'color: ' . rl_color( get_category( get_query_var( 'cat' ) )->cat_ID ) : '' ) . '">' . get_category( get_query_var( 'cat' ) )->name . '</span>';
		  endif;
		  ?>
      </h2>
      <div class="posts">

		  <?php $count = 0; fhgnewsonline_printPaged();
		  if ( have_posts() ) : while ( have_posts() ): the_post(); ?>

			  <?php get_template_part( 'formats/post/content', get_post_format() ); ?>

			  <?php if ( $count % 4 == 0 && $count !== 0 ): ?>

              <!--TODO Werbung-->

			  <?php endif; ?>

			  <?php $count ++; endwhile; endif; ?>

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