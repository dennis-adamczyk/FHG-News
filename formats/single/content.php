<?php global $category_color; ?>
<div <?php post_class( 'post' ); ?>>
  <div class="post__author"
       onclick="window.location = '<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>'">
    <div class="post__author__profilePicture">
		<?php echo get_avatar( get_the_author_meta( 'ID' ), 32 ); ?>
    </div>
    <p class="post__author__name">
		<?php the_author(); ?>
    </p>
  </div>
  <div class="post__thumbnail" style="background-image: url('<?php the_post_thumbnail_url(); ?>')">
	  <?php if ( ! has_post_thumbnail() ) { ?>
        <div class="post__image__error">
          <i class="material-icons">error</i>
          <p>Kein Bild gefunden!</p>
        </div>
		  <?php
	  } ?>
  </div>
  <h3 class="post__title">
	  <?php the_title(); ?>
  </h3>
  <p class="post__subtitle">
    <span class="post__subtitle__category">
      <?php if ( get_the_category()[0]->parent !== 0 ):
	      echo '<span class="post__subtitle__category__parent" style="color: ' . rl_color( get_category( get_the_category()[0]->parent )->cat_ID ) . ';" onclick="window.location = \'' . get_category_link( get_category( get_the_category()[0]->parent )->cat_ID ) . '\'">' .
	           get_category( get_the_category()[0]->parent )->name .
	           '</span>' .
	           '<i class="material-icons">chevron_right</i>' .
	           '<span class="post__subtitle__category__sub" style="color: ' . $category_color . ';" onclick="window.location = \'' . get_category_link( get_the_category()[0]->cat_ID ) . '\'">' .
	           get_the_category()[0]->name .
	           '</span>';
      else:
	      echo '<span class="post__subtitle__category__sub" style="color: ' . $category_color . ';" onclick="window.location = \'' . get_category_link( get_the_category()[0]->cat_ID ) . '\'">' .
	           get_the_category()[0]->name .
	           '</span>';
      endif; ?>
    </span> &bull; vor <?php echo human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ); ?>
  </p>
  <div class="post__content">
	  <?php the_content(); ?>
  </div>
  <div class="post__foot">
    <div class="post__foot__like<?php if ( is_user_logged_in() ) {
		if ( has_liked( get_the_ID(), get_current_user_id() ) ) {
			echo " active";
		}
	} ?>">
      <i class="material-icons">favorite</i>
      <p class="post__foot__like__count"><?php echo get_like_amount( get_the_ID() ); ?></p>
    </div>
    <div class="post__foot__share"
         onclick="event.stopPropagation(); showShareDialog('<?php echo get_permalink(); ?>', '<?php echo get_the_title(); ?>');">
      <i class="material-icons">share</i>
    </div>
	  <?php if ( ( current_user_can( 'edit_posts' ) && get_the_author_meta( 'ID' ) === get_current_user_id() ) || current_user_can( 'edit_others_posts' ) ): ?>
        <div class="post__foot__edit" onclick="window.location = '<?php echo get_edit_post_link(); ?>'">
          <i class="material-icons">edit</i>
        </div>
	  <?php endif; ?>
  </div>
</div>
<?php if ( comments_open() || get_comments_number() ) {
	comments_template();
} ?>
<div class="recommended">
  <h3 class="recommended__title">
    Ähnliche Artikel
  </h3>
  <div class="recommended__posts">
	  <?php
	  $orig_post = $post;
	  global $post;
	  $tags = wp_get_post_tags( $post->ID );

	  if ( $tags ) {
		  $tag_ids = array();
		  foreach ( $tags as $individual_tag ) {
			  $tag_ids[] = $individual_tag->term_id;
		  }
		  $related_query = new WP_Query( array(
			  'tag__in'          => $tag_ids,
			  'post__not_in'     => array( $post->ID ),
			  'posts_per_page'   => 3,
			  'caller_get_posts' => 1
		  ) );

	  } else {
		  $categories = wp_get_post_categories( $post->ID );

		  if ( $categories ) {
			  $cat_ids       = $categories;
			  $related_query = new WP_Query( array(
				  'category__in'     => $cat_ids,
				  'post__not_in'     => array( $post->ID ),
				  'posts_per_page'   => 3,
				  'caller_get_posts' => 1
			  ) );
		  }
	  }
	  if ( isset( $related_query ) ) {
		  if ( $related_query->have_posts() ) {
			  while ( $related_query->have_posts() ) {
				  $related_query->the_post();
				  if ( function_exists( 'rl_color' ) ) {
					  $category_color = rl_color( get_the_category()[0]->cat_ID );
				  } ?>
                <article <?php post_class( 'recommended__post' ); ?>
                    onclick="window.location = '<?php echo get_the_permalink(); ?>'">
                  <div class="post__image" style="background-image: url('<?php the_post_thumbnail_url(); ?>')">
					  <?php if ( ! has_post_thumbnail() ): ?>
                        <div class="post__image__error">
                          <i class="material-icons">error</i>
                          <p>Kein Bild gefunden!</p>
                        </div>
					  <?php endif; ?>
                  </div>
                  <h4 class="post__title"><?php the_title(); ?></h4>
                  <p class="post__subtitle">
                    <span class="post__subtitle__category">
                    <?php if ( get_the_category()[0]->parent !== 0 ):
	                    echo '<span class="post__subtitle__category__parent" style="color: ' . rl_color( get_category( get_the_category()[0]->parent )->cat_ID ) . ';" onclick="window.location = \'' . get_category_link( get_category( get_the_category()[0]->parent )->cat_ID ) . '\'">' .
	                         get_category( get_the_category()[0]->parent )->name .
	                         '</span>' .
	                         '<i class="material-icons">chevron_right</i>' .
	                         '<span class="post__subtitle__category__sub" style="color: ' . $category_color . ';" onclick="window.location = \'' . get_category_link( get_the_category()[0]->cat_ID ) . '\'">' .
	                         get_the_category()[0]->name .
	                         '</span>';
                    else:
	                    echo '<span class="post__subtitle__category__sub" style="color: ' . $category_color . ';" onclick="window.location = \'' . get_category_link( get_the_category()[0]->cat_ID ) . '\'">' .
	                         get_the_category()[0]->name .
	                         '</span>';
                    endif; ?>
                  </span> &bull; vor <?php echo human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ); ?>
                  </p>
                  <div class="post__foot">
                    <div
                        class="post__foot__like<?php if ( is_user_logged_in() && has_liked( get_the_ID(), get_current_user_id() ) ) {
							echo " active";
						} ?>">
                      <i class="material-icons">favorite</i>
                      <p class="post__foot__like__count"><?php echo get_like_amount( get_the_ID() ); ?></p>
                    </div>
                    <div class="post__foot__comments">
                      <i class="material-icons">insert_comment</i>
                      <p class="post__foot__comments__count"><?php echo get_comments_number() ?: ''; ?></p>
                    </div>
                    <div class="post__foot__share"
                         onclick="event.stopPropagation(); showShareDialog('<?php echo get_permalink(); ?>', '<?php echo get_the_title(); ?>');">
                      <i class="material-icons">share</i>
                    </div>
                  </div>
                </article>

				  <?php
			  }
		  } else {
			  ?>
            <div class="recommended__error">
              <p>Keine Artikel vorhanden.</p>
            </div>
			  <?php
		  }
	  } else {
		  ?>
        <div class="recommended__error">
          <p>Keine Artikel vorhanden.</p>
        </div>
		  <?php
	  }


	  $post = $orig_post;
	  wp_reset_query();
	  ?>
  </div>

</div>