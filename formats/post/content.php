<?php
global $category_color;

$featured_image = false;

if ( has_post_thumbnail() ) {
	$featured_image = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
} else if ( $img = preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/im', get_the_content(), $matches ) ) {
	$featured_image = $matches[1][0];
}
?>
<article <?php post_class( 'post' ); ?> onclick="window.location = '<?php echo get_the_permalink(); ?>'">
  <div class="post__image ripple--mobile" style="background-image: url('<?php echo $featured_image; ?>')">
	  <?php if ( ! $featured_image ) { ?>
        <div class="post__image__error">
          <i class="material-icons">error</i>
          <p>Kein Bild gefunden!</p>
        </div>
		  <?php
	  } ?>
  </div>
  <h3 class="post__title"><?php the_title(); ?></h3>
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
  <p class="post__preview"><?php echo wp_trim_words( get_the_content( '...' ), 30, '...' ) ?></p>
  <div class="post__foot">
    <div class="post__foot__like<?php if ( is_user_logged_in() ) {
		if ( has_liked( get_the_ID(), get_current_user_id() ) ) {
			echo " active";
		}
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