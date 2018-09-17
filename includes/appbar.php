<?php

function get_appbar( $title, $navigation = 'menu', $search = true, $profile = true ) {
	?>

  <header class="header header--top">
    <div class="header__menu <?php echo( 'header__menu--' . $navigation ); ?> ripple--icon">
      <i class="material-icons"><?php echo $navigation; ?></i>
    </div>
    <h1 class="header__title"><?php echo $title ?></h1>
	  <?php if ( $search && $profile && current_user_can( 'publish_posts' ) ): ?>
        <div class="header__add ripple--icon">
          <i class="material-icons">add</i>
        </div>
	  <?php endif; ?>
	  <?php if ( $search ): ?>
        <div class="header__search ripple--icon">
          <i class="material-icons">search</i>
        </div>
	  <?php endif; ?>
	  <?php if ( $profile ): ?>
        <div class="header__profile ripple--icon">
			<?php echo get_avatar( get_current_user_id(), 32 ); ?>
        </div>
	  <?php endif; ?>
  </header>

	<?php
}