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
} else if ( strpos( get_the_content(), 'http://' ) !== false || strpos( get_the_content(), 'https://' ) !== false ) {
	$content = get_the_content();
	preg_match_all( '#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $content, $match );
	$url = $match[0][1];
	if ( strpos( $url, 'open.spotify.com' ) !== false || strpos( $url, 'open.spotify.de' ) !== false ) {
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_URL, 'https://embed.spotify.com/oembed?url=' . $url );
		$result = curl_exec( $ch );
		curl_close( $ch );

		$obj            = json_decode( $result );
		$featured_image = $obj->thumbnail_url;
	}
}
?>
<article <?php post_class( 'post' ); ?> id="<?php echo $count; ?>"
                                        onclick="window.location = '<?php echo get_the_permalink(); ?>'">
  <div class="post__image ripple--mobile" style="background-image: url('<?php echo $featured_image; ?>')">
	  <?php if ( ! $featured_image ) { ?>
        <div class="post__image__error">
          <i class="material-icons">error</i>
          <p>Kein Bild gefunden!</p>
        </div>
		  <?php
	  } else {
		  ?>
        <i class="material-icons post__image__hint">play_arrow</i>
		  <?php
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