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

$image_urls = array();
$images     = get_children( array(
	'post_parent'    => $post->ID,
	'post_status'    => 'inheret',
	'post_type'      => 'attachment',
	'post_mime_type' => 'image'
) );

if ( isset( $images ) ) {
	foreach ( $images as $image ) {
		$image_urls[] = wp_get_attachment_url( $image->ID );
	}
}
?>
<article <?php post_class( 'post' ); ?> id="<?php echo $count; ?>"
                                        onclick="window.location = '<?php echo get_the_permalink(); ?>'">
  <div class="post__image ripple--mobile">
	  <?php if ( ! $image_urls ) { ?>
        <div class="post__image__error">
          <i class="material-icons">error</i>
          <p>Kein Bild gefunden!</p>
        </div>
		  <?php
	  } else {
		  for ($i = 0; $i < 4; $i ++) {
	      echo "<div class='post__image__img' style='background-image: url({$image_urls[$i]})'></div>";
		  }
    } ?>
  </div>
  <h3 class="post__title"><?php the_title(); ?></h3>
  <p class="post__subtitle">
    <span class="post__subtitle__category">
      <?php if ( empty( get_the_category() ) ): echo "Unkategorisiert";
      else:
	      if ( $category->parent !== 0 ):
		      echo '<span class="post__subtitle__category__parent" style="color: ' . rl_color( get_category( $category->parent )->cat_ID ) . ';" onclick="window.location = \'' . get_category_link( get_category( $category->parent )->cat_ID ) . '\'">' .
		           get_category( $category->parent )->name .
		           '</span>' .
		           '<i class="material-icons">chevron_right</i>' .
		           '<span class="post__subtitle__category__sub" style="color: ' . $category_color . ';" onclick="window.location = \'' . get_category_link( $category->cat_ID ) . '\'">' .
		           $category->name .
		           '</span>';
	      else:
		      echo '<span class="post__subtitle__category__sub" style="color: ' . $category_color . ';" onclick="window.location = \'' . get_category_link( $category->cat_ID ) . '\'">' .
		           $category->name .
		           '</span>';
	      endif; endif; ?>
    </span> &bull; vor <?php echo human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ); ?>
  </p>
  <p class="post__preview"><?php echo wp_trim_words( get_the_excerpt(), 30, '...' ); ?></p>
  <div class="post__foot">
    <div class="post__foot__like<?php echo( has_liked( get_the_ID(), get_current_user_id() ) ? " active" : "" ); ?>">
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