<?php
$category_color = function_exists( 'rl_color' ) ? rl_color( get_the_category()[0]->cat_ID ) : '';
$featured_image = false;

if ( has_post_thumbnail() ) {
	$featured_image = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
} else if ( $img = preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', get_the_content(), $matches ) ) {
	$featured_image = $matches[1][0];
}
?>
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
  <h1 class="post__title">
	  <?php the_title(); ?>
  </h1>
  <p class="post__subtitle">
    <span class="post__subtitle__category">
      <?php if ( empty( get_the_category() ) ): echo "Unkategorisiert";
      else:
	      if ( get_the_category()[0]->parent !== 0 ):
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
	      endif; endif; ?>
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
	  <?php fhgnewsonline_printRecommendedPosts( $post ); ?>
  </div>
  <div class="material-loader material-loader--small infiniteScroller">
    <svg class="material-loader__circular" viewBox="25 25 50 50">
      <circle class="material-loader__circular__path" cx="50" cy="50" r="20" fill="none" stroke-width="2"
              stroke-miterlimit="10"></circle>
    </svg>
  </div>
</div>