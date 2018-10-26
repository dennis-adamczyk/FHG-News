<?php
global $count;
$category = array();
foreach ( get_the_category() as $cat ) {
	if ( $cat->parent !== 0 ) {
		$category = $cat;
	}
}
if ( $category === array() ) {
	$category = get_the_category()[0];
}
$category_color = function_exists( 'rl_color' ) ? rl_color( $category->cat_ID ) : '';
?>
<article <?php post_class( 'post' ); ?> id="<?php echo $count; ?>"
                                        onclick="window.location = '<?php echo get_the_permalink(); ?>'">
  <div class="post__author">
    <div class="post__author__profilePicture">
		<?php echo get_avatar( get_the_author_meta( 'ID' ), 32 ); ?>
    </div>
    <div class="post__author__info">
      <p class="post__author__info__name">
		  <?php the_author(); ?>
      </p>
      <p class="post__author__info__subtitle">
    <span class="post__author__info__subtitle__category">
      <?php if ( empty( get_the_category() ) ): echo "Unkategorisiert";
      else:
	      if ( $category->parent !== 0 ):
		      echo '<span class="post__author__info__subtitle__category__parent" style="color: ' . rl_color( get_category( $category->parent )->cat_ID ) . ';" onclick="window.location = \'' . get_category_link( get_category( $category->parent )->cat_ID ) . '\'">' .
		           get_category( $category->parent )->name .
		           '</span>' .
		           '<i class="material-icons">chevron_right</i>' .
		           '<span class="post__author__info__subtitle__category__sub" style="color: ' . $category_color . ';" onclick="window.location = \'' . get_category_link( $category->cat_ID ) . '\'">' .
		           $category->name .
		           '</span>';
	      else:
		      echo '<span class="post__author__info__subtitle__category__sub" style="color: ' . $category_color . ';" onclick="window.location = \'' . get_category_link( $category->cat_ID ) . '\'">' .
		           $category->name .
		           '</span>';
	      endif; endif; ?>
    </span> &bull; vor <?php echo human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ); ?>
      </p>
    </div>
  </div>
  <p class="post__preview">
	  <?php echo trim_words( strip_tags( get_the_content(), '<br><a><strong><em><i><b><u><span>' ), 30, '... <span class="post__preview__more">Mehr anzeigen</span>', 4); ?>
  </p>
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