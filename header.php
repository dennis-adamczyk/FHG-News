<!DOCTYPE HTML>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php bloginfo( 'name' ); ?></title>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<overlay></overlay>
<dialogBox></dialogBox>
<div class="snackBox"></div>
<div class="lightBox">
  <div class="lightBox__header">
    <p class="lightBox__header__page">
      <span class="lightBox__header__page__index"></span> / <span class="lightBox__header__page__total"></span>
    </p>
    <div class="lightBox__header__close ripple--icon--light" onclick="hideLightBox()"><i class="material-icons">close</i></div>
  </div>

  <div class="lightBox__left ripple--icon--light"><i class="material-icons">chevron_left</i></div>
  <div class="lightBox__right ripple--icon--light"><i class="material-icons">chevron_right</i></div>
  <img class="lightBox__image">
  <div class="lightBox__captionBox">
    <p class="lightBox__captionBox__caption"></p>
  </div>
</div>

<?php get_appbar( fhgnewsonline_get_page_title(), ( is_single() ? 'arrow_back' : 'menu' ), ( is_single() ? false : true ) ); ?>

<nav class="nav">
  <img src="<?php echo get_template_directory_uri() ?>/img/fhgnews.svg" class="nav__logo"
       onclick="window.location = '<?php echo get_home_url(); ?>'">
	<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
</nav>

<content>