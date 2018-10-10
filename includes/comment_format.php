<?php
/**
 * @package fhgnewsonline
 * -- Comments Format
 */

/**
 * Echos the comment form
 *
 * @param null $class
 */
function fhgnewsonline_comment_form( $class = null ) {
	global $id;
	$post_id       = $id;
	$commenter     = wp_get_current_commenter();
	$user          = wp_get_current_user();
	$user_identity = $user->exists() ? $user->display_name : '';

	?><?php do_action( 'comment_form_top' ); ?>
	<?php do_action( 'comment_form_logged_in_after', $commenter, $user_identity ); ?>

	<?php if ( comments_open( $post_id ) ) : ?>
		<?php do_action( 'comment_form_before' ); ?>
    <form class="comments__respond <?php echo( $class ?: '' ); ?>"
          action="<?php echo site_url( '/wp-comments-post.php' ); ?>" method="post"
          id="commentform<?php echo( $class ? '-' . $class : '' ); ?>">
		<?php do_action( 'comment_form_top' ); ?>
		<?php do_action( 'comment_form_logged_in_after', $commenter, $user_identity ); ?>
      <div class="comments__respond__avatar">
		  <?php echo get_avatar( get_current_user_id(), 32 ); ?>
      </div>
      <div class="input input--textarea input--line input--placeholderDisappear comments__respond__commentInput">
        <textarea id="comment<?php echo( $class ? '-' . $class : '' ); ?>" name="comment" rows="1" required></textarea>
        <label for="comment<?php echo( $class ? '-' . $class : '' ); ?>" class="input__label">Öffentlich kommentieren...</label>
      </div>
      <div class="comments__respond__submit">
        <div class="button button--flat comments__respond__submit__cancel">
          <span>Abbrechen</span>
        </div>
        <input name="submit" class="btn btn-success <?php echo( $class ? 'material-icons' : '' ); ?>" type="submit" id="submit<?php echo( $class ? '-' . $class : '' ); ?>" value="<?php echo( $class ? 'send' : 'Kommentieren' ); ?>"/>
		  <?php comment_id_fields( $post_id ); ?>
      </div>
    </form>
		<?php do_action( 'comment_form_after' ); ?>
	<?php else : ?>
		<?php do_action( 'comment_form_comments_closed' ); ?>
	<?php endif; ?>
	<?php
}

/**
 * Echos all comments
 */
function fhgnewsonline_comment_callback() {
	if ( $GLOBALS['comment_depth'] == 1 ):
		?>
      <div class="comments__list__commentParent">
	<?php endif; ?>
  <li <?php comment_class( 'comments__list__comment' ); ?> id="comment-<?php comment_ID(); ?>" data-comment-id="<?php echo get_comment_ID(); ?>"
                                                           data-parent-id="<?php echo get_comment()->comment_parent; ?>"
                                                           data-author="<?php echo get_comment_author(); ?>">
    <div class="comments__list__comment__avatar">
		<?php echo get_avatar( get_comment_author_email(), 32 ); ?>
    </div>
    <div class="comments__list__comment__box">
      <p class="comments__list__comment__box__info">
        <a href="<?php if ( get_user_by( 'email', get_comment_author_email() ) != false ): echo get_author_posts_url( get_user_by( 'email', get_comment_author_email() )->ID ); endif; ?>"><?php echo get_comment_author(); ?></a>
        <span>&bull;</span> vor <?php echo human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ); ?>
      </p>
      <p class="comments__list__comment__box__content">
		  <?php echo strip_tags( apply_filters('comment_text', get_comment_text(), get_comment()), '<a><img><span><pre><code><strong>'); ?>
      </p>
      <div class="comments__list__comment__box__foot">
        <div
            class="comments__list__comment__box__foot__like<?php if ( is_user_logged_in() ) if ( has_liked_comment( get_comment_ID(), get_current_user_id() ) ) echo " active"; ?>">
          <i class="material-icons">favorite</i>
          <p class="comments__list__comment__box__foot__like__count"><?php echo get_comment_like_amount( get_comment_ID() ); ?></p>
        </div>
		  <?php if ( $GLOBALS['comment_depth'] == 1 ): ?>
            <div class="comments__list__comment__box__foot__replies" onclick="displayComments($(this))">
              <i class="material-icons">insert_comment</i>
              <p class="comments__list__comment__box__foot__replies__count"><?php echo fhgnewsonline_reply_count( get_the_ID(), get_comment_ID() ) ?: ''; ?></p>
            </div>
		  <?php endif; ?>
		  <?php if ( current_user_can( 'edit_comment' ) ): ?>
            <div class="comments__list__comment__box__foot__edit"
                 onclick="window.location = '<?php echo get_edit_comment_link(); ?>'">
              <i class="material-icons">edit</i>
            </div>
		  <?php endif; ?>
        <div class="button button--flat comments__list__comment__box__foot__reply">
          <span>Antworten</span>
        </div>
      </div>
    </div>
  </li>

	<?php
}

/**
 * End of echoing all comments
 */
function fhgnewsonline_comment_end_callback() {
	if ( $GLOBALS['comment_depth'] == 1 ):
		?>
      </div>
	<?php
	endif;
}

/**
 * Returns the amount of reply comments on the comment with post ID and comment ID
 *
 * @param $post_id
 * @param $comment_id
 *
 * @return int
 */
function fhgnewsonline_reply_count( $post_id, $comment_id ) {
	global $wpdb;
	$query   = "SELECT COUNT(comment_post_ID) AS count FROM $wpdb->comments WHERE `comment_approved` = 1 AND `comment_post_ID` = $post_id AND `comment_parent` = $comment_id";
	$parents = $wpdb->get_row( $query );

	return intval( $parents->count );
}