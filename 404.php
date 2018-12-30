<?php get_header(); ?>
<div class="wrapper">

  <div class="main">

    <div class="error">
      <h3>404</h3>
      <p>Seite nicht gefunden</p>
      <div class="button button--flat">
        <span><a href="<?php echo get_home_url(); ?>">Zur Startseite</a></span>
      </div>
    </div>

  </div>
	<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>