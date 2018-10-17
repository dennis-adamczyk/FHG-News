<?php
$body_class = '';
switch ( get_query_var( 'fhgnewsonline_page_id' ) ) {
	case 1:
		$body_class = 'edit_profile';
		break;
	case 3:
		$body_class = 'login_page';
		break;
	case 4:
		$body_class = 'register';
		break;
	case 5:
		$body_class = 'reset_password';
		break;
}
?>
<!DOCTYPE HTML>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php bloginfo( 'name' ); ?></title>
	<?php wp_head(); ?>
</head>
<body <?php body_class( $body_class ); ?>>
<overlay></overlay>
<dialogBox></dialogBox>
<div class="snackBox"></div>
<div class="lightBox">
  <div class="lightBox__header">
    <p class="lightBox__header__page">
      <span class="lightBox__header__page__index"></span> / <span class="lightBox__header__page__total"></span>
    </p>
    <div class="lightBox__header__close ripple--icon--light" onclick="hideLightBox()">
      <i class="material-icons">close</i>
    </div>
  </div>

  <div class="lightBox__left ripple--icon--light"><i class="material-icons">navigate_before</i></div>
  <div class="lightBox__right ripple--icon--light"><i class="material-icons">navigate_next</i></div>
  <img src="" class="lightBox__image">
  <div class="lightBox__captionBox">
    <p class="lightBox__captionBox__caption"></p>
  </div>
</div>
<div class="userOptions">
  <div class="userOptions__current ripple--box" onclick="window.location = '<?php echo get_home_url(); ?>/user/'">
	  <?php echo get_avatar( get_current_user_id(), 32 ); ?>
    <p class="userOptions__current__name"><?php echo wp_get_current_user()->user_login; ?></p>
    <p class="userOptions__current__mail"><?php echo wp_get_current_user()->user_email; ?></p>
  </div>
  <div class="userOptions__actions">
    <div class="userOptions__actions__action ripple--box"
         onmouseup="openURL('<?php echo get_home_url() . '/user/edit'; ?>', event)">
      <i class="material-icons">edit</i>
      <p class="userOptions__actions__action__name">Profil bearbeiten</p>
    </div>
    <div class="userOptions__actions__action ripple--box">
      <i class="material-icons">settings</i>
      <p class="userOptions__actions__action__name">Einstellungen</p>
    </div>
    <div class="userOptions__actions__action ripple--box"
         onclick="window.location = '<?php echo wp_logout_url( $_SERVER['REQUEST_URI'] ); ?>'">
      <i class="material-icons">exit_to_app</i>
      <p class="userOptions__actions__action__name">Abmelden</p>
    </div>
  </div>
</div>

<?php get_appbar( fhgnewsonline_get_page_title(), ( is_single() || is_category() ? 'arrow_back' : 'menu' ), ( is_single() ? false : true ) ); ?>

<nav class="nav">
  <img src="<?php echo get_template_directory_uri() . '/img/fhgnews.svg'; ?>" class="nav__logo"
       onclick="window.location = '<?php echo get_home_url(); ?>'">
	<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
</nav>

<content>