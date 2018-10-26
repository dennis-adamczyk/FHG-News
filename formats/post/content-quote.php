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
$featured_image = false;

if ( has_post_thumbnail() ) {
	$featured_image = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
} else if ( $img = preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', get_the_content(), $matches ) ) {
	$featured_image = $matches[1][0];
}
?>
<article <?php post_class( 'post' ); ?> id="<?php echo $count; ?>"
                                        onclick="window.location = '<?php echo get_the_permalink(); ?>'">
	<?php if ( $featured_image ): ?>
      <div class="post__image ripple--mobile" style="background-image: url('<?php echo $featured_image; ?>')"></div>
	<?php endif; ?>
	<?php if ( ! empty( get_the_title() ) ): ?>
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
	<?php else: ?>
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
	<?php endif; ?>
  <p class="post__preview">
	  <?php
    $content = get_the_content(); //<blockquote><p><cite><br><a><strong><em><i><b><u><span>

	  $dom = new DOMDocument();
    $dom->formatOutput = true;
	  @$dom->loadHtml( '<?xml encoding="UTF-8">' . $content );
	  $result = $dom->getElementsByTagName('blockquote')->item(0)->getElementsByTagName( 'p' );
	  $quote = $result->item( 0 )->nodeValue;

	  $quote = trim_words($quote, 30, '... <span class="post__preview__more">Mehr anzeigen</span>', 4);
	  $result->item(0)->textContent = $quote;

	  echo $quote . '<cite>' . $dom->getElementsByTagName('blockquote')->item(0)->getElementsByTagName( 'cite' )->item(0)->nodeValue . '</cite>'
	  ?>
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