<?php get_header(); ?>
  <div class="wrapper">
	  <?php $curauth = ( get_query_var( 'author_name' ) ) ? get_user_by( 'slug', get_query_var( 'author_name' ) ) : get_userdata( get_query_var( 'author' ) ); ?>
    <div class="info">
      <div class="profile">
        <div class="profile__picture">
			<?php echo get_avatar( $curauth->ID, 128 ); ?>
        </div>
        <p class="profile__name">
			<?php echo $curauth->display_name ?>
        </p>
        <p class="profile__role" style="color: <?php echo get_user_role_color( $curauth ); ?>">
			<?php echo get_user_role_name( $curauth ); ?>
        </p>
      </div>
      <hr class="divider">
		<?php if ( ! empty( $curauth->description ) ): ?>
          <p class="biography">
            <span class="biography__title">Steckbrief</span>
			  <?php echo $curauth->description; ?>
          </p>
		<?php endif; ?>
      <p class="postCount">
        <span class="postCount__title">Beiträge</span>
		  <?php echo count_user_posts( $curauth->ID ); ?>
      </p>
		<?php if ( ! empty( $curauth->user_url ) ): ?>
          <p class="website">
            <span class="website__title">Webseite</span>
            <a target="_blank" href="<?php echo $curauth->user_url; ?>"><?php $url = parse_url( $curauth->user_url );
				echo $url['host'] . rtrim( $url['path'], '/' ); ?></a>
          </p>
		<?php endif; ?>
      <hr class="divider">
      <!-- TODO: Social Media Links-->
      <hr class="divider">
    </div>
    <div class="posts">
      <h2 class="posts__title">Beiträge von <?php echo $curauth->display_name; ?></h2>

		<?php $count = 0;
		if ( have_posts() ) : while ( have_posts() ): the_post(); ?>

			<?php if ( function_exists( 'rl_color' ) ) {
				$category_color = rl_color( get_the_category()[0]->cat_ID );
			} ?>
			<?php get_template_part( 'formats/post/content', get_post_format() ); ?>

			<?php if ( $count % 4 == 0 && $count !== 0 ): ?>

            <!--TODO Werbung-->

			<?php endif; ?>

			<?php $count ++; endwhile; else: ?>
      <div class="error">
        <p><span class="error__name"><?php echo $curauth->display_name; ?></span> hat noch keine Beiträge veröffentlicht</p>
      </div>
		<?php endif; ?>
    </div>
  </div>

<?php get_footer(); ?>