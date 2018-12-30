<?php
/**
 * Comments Section
 * @package fhgnewsonline
 */

if ( post_password_required() ) {
	return;
}
?>

<?php fhgnewsonline_comment_form('global'); ?>

<div id="comments" class="comments">

  <h3 class="comments__title">
    Kommentare <span><?php echo get_comments_number( $post_id ); ?></span>
  </h3>

	<?php if ( comments_open() ) {
		fhgnewsonline_comment_form();
	} ?>

  <ul class="comments__list">
	  <?php wp_list_comments( array(
		  'callback'     => 'fhgnewsonline_comment_callback',
		  'end-callback' => 'fhgnewsonline_comment_end_callback'
	  ) ); ?>
  </ul>

	<?php if ( have_comments() ): ?>

	<?php endif; ?>

</div>
