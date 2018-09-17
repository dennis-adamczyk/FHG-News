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

  <?php get_appbar( fhgnewsonline_get_page_title(), ( is_single() ? 'arrow_back' : 'menu' ), ( is_single() ? false : true ) ); ?>

  <nav class="nav">
    <img src="<?php echo get_template_directory_uri() ?>/img/fhgnews.svg" class="nav__logo"
         onclick="window.location = '<?php echo get_home_url(); ?>'">
    <?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
  </nav>

  <content>