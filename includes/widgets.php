<?php
/**
 * @package fhgnewsonline
 * -- Register theme widgets
 */

/**
 * Class Fhgnewsonline_Social_Media_Widget
 * Social Media Widget
 */
class Fhgnewsonline_Social_Media_Widget extends WP_Widget {

	/**
	 * Fhgnewsonline_Social_Media_Widget constructor
	 */
	public function __construct() {
		$widget_opts = array(
			'classname'   => 'widget_social_media',
			'description' => 'Verlinkung zu unseren Social Media Konten',
		);

		parent::__construct( 'fhgnewsonline_social_media', 'Social Media', $widget_opts );
	}

	/**
	 * Echos inputs for widget settings in backend
	 *
	 * @param array $instance
	 *
	 * @return string|void
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( '', 'text_domain' );

		$facebook  = ! empty( $instance['facebook'] ) ? $instance['facebook'] : esc_html__( '', 'text_domain' );
		$twitter   = ! empty( $instance['twitter'] ) ? $instance['twitter'] : esc_html__( '', 'text_domain' );
		$instagram = ! empty( $instance['instagram'] ) ? $instance['instagram'] : esc_html__( '', 'text_domain' );
		$snapchat  = ! empty( $instance['snapchat'] ) ? $instance['snapchat'] : esc_html__( '', 'text_domain' );
		$youtube   = ! empty( $instance['youtube'] ) ? $instance['youtube'] : esc_html__( '', 'text_domain' );
		?>
      <p>
        <label
            for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Titel:', 'text_domain' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
               name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
               value="<?php echo esc_attr( $title ); ?>">
      </p>
      <br>
      <p>
        <label
            for="<?php echo esc_attr( $this->get_field_id( 'facebook' ) ); ?>"><?php esc_attr_e( 'Facebook:', 'text_domain' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'facebook' ) ); ?>"
               name="<?php echo esc_attr( $this->get_field_name( 'facebook' ) ); ?>" type="url"
               value="<?php echo esc_attr( $facebook ); ?>">
      </p>
      <p>
        <label
            for="<?php echo esc_attr( $this->get_field_id( 'twitter' ) ); ?>"><?php esc_attr_e( 'Twitter:', 'text_domain' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'twitter' ) ); ?>"
               name="<?php echo esc_attr( $this->get_field_name( 'twitter' ) ); ?>" type="url"
               value="<?php echo esc_attr( $twitter ); ?>">
      </p>
      <p>
        <label
            for="<?php echo esc_attr( $this->get_field_id( 'instagram' ) ); ?>"><?php esc_attr_e( 'Instagram:', 'text_domain' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'instagram' ) ); ?>"
               name="<?php echo esc_attr( $this->get_field_name( 'instagram' ) ); ?>" type="url"
               value="<?php echo esc_attr( $instagram ); ?>">
      </p>
      <p>
        <label
            for="<?php echo esc_attr( $this->get_field_id( 'snapchat' ) ); ?>"><?php esc_attr_e( 'Snapchat:', 'text_domain' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'snapchat' ) ); ?>"
               name="<?php echo esc_attr( $this->get_field_name( 'snapchat' ) ); ?>" type="url"
               value="<?php echo esc_attr( $snapchat ); ?>">
      </p>
      <p>
        <label
            for="<?php echo esc_attr( $this->get_field_id( 'youtube' ) ); ?>"><?php esc_attr_e( 'YouTube:', 'text_domain' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'youtube' ) ); ?>"
               name="<?php echo esc_attr( $this->get_field_name( 'youtube' ) ); ?>" type="url"
               value="<?php echo esc_attr( $youtube ); ?>">
      </p>
		<?php
	}

	/**
	 * Saves the widget settings on update
	 *
	 * @param array $new_instance
	 * @param array $old_instance
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';

		$instance['facebook']  = ( ! empty( $new_instance['facebook'] ) ) ? sanitize_text_field( $new_instance['facebook'] ) : '';
		$instance['twitter']   = ( ! empty( $new_instance['twitter'] ) ) ? sanitize_text_field( $new_instance['twitter'] ) : '';
		$instance['instagram'] = ( ! empty( $new_instance['instagram'] ) ) ? sanitize_text_field( $new_instance['instagram'] ) : '';
		$instance['snapchat']  = ( ! empty( $new_instance['snapchat'] ) ) ? sanitize_text_field( $new_instance['snapchat'] ) : '';
		$instance['youtube']   = ( ! empty( $new_instance['youtube'] ) ) ? sanitize_text_field( $new_instance['youtube'] ) : '';

		return $instance;
	}

	/**
	 * Echos widget in sidebar on frontend
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		echo $args['before_title'] . apply_filters( 'widget_title', ( ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Social Media', 'text_domain' ) ) ) . $args['after_title'];

		echo '<ul>';

		if ( ! empty( $instance['facebook'] ) ) {
			echo '<li><a href="' . $instance['facebook'] . '" target="_blank"><img src="' . get_template_directory_uri() . '/img/icons/facebook.svg' . '" width="32px" alt="Facebook"></a></li>';
		}
		if ( ! empty( $instance['twitter'] ) ) {
			echo '<li><a href="' . $instance['twitter'] . '" target="_blank"><img src="' . get_template_directory_uri() . '/img/icons/twitter.svg' . '" width="32px" alt="Twitter"></a></li>';
		}
		if ( ! empty( $instance['instagram'] ) ) {
			echo '<li><a href="' . $instance['instagram'] . '" target="_blank"><img src="' . get_template_directory_uri() . '/img/icons/instagram.svg' . '" width="32px" alt="Instagram"></a></li>';
		}
		if ( ! empty( $instance['snapchat'] ) ) {
			echo '<li><a href="' . $instance['snapchat'] . '" target="_blank"><img src="' . get_template_directory_uri() . '/img/icons/snapchat.svg' . '" width="32px" alt="Snapchat"></a></li>';
		}
		if ( ! empty( $instance['youtube'] ) ) {
			echo '<li><a href="' . $instance['youtube'] . '" target="_blank"><img src="' . get_template_directory_uri() . '/img/icons/youtube.svg' . '" width="32px" alt="YouTube"></a></li>';
		}

		echo '</ul>';

		echo $args['after_widget'];
	}
}

add_action( 'widgets_init', function () {
	register_widget( 'Fhgnewsonline_Social_Media_Widget' );
} );


/**
 * Class Fhgnewsonline_Sponsor_Widget
 * Sponsor Widget
 */
class Fhgnewsonline_Sponsor_Widget extends WP_Widget {

	/**
	 * Fhgnewsonline_Sponsor_Widget constructor
	 */
	public function __construct() {
		$widget_opts = array(
			'classname'   => 'widget_sponsor',
			'description' => 'Nennung unseres Sponsors',
		);

		parent::__construct( 'fhgnewsonline_sponsor', 'Unser Sponsor', $widget_opts );
	}

	/**
	 * Echos inputs for widget settings in backend
	 *
	 * @param array $instance
	 *
	 * @return string|void
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( '', 'text_domain' );

		$name = ! empty( $instance['name'] ) ? $instance['name'] : esc_html__( '', 'text_domain' );
		$url  = ! empty( $instance['url'] ) ? $instance['url'] : esc_html__( '', 'text_domain' );
		$img  = ! empty( $instance['img'] ) ? $instance['img'] : esc_html__( '', 'text_domain' );
		$hint = ! empty( $instance['hint'] ) ? $instance['hint'] : esc_html__( '', 'text_domain' );
		?>
      <p>
        <label
            for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Titel:', 'text_domain' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
               name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
               value="<?php echo esc_attr( $title ); ?>">
      </p>
      <br>
      <p>
        <label
            for="<?php echo esc_attr( $this->get_field_id( 'name' ) ); ?>"><?php esc_attr_e( 'Sponsoren Name:', 'text_domain' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'name' ) ); ?>"
               name="<?php echo esc_attr( $this->get_field_name( 'name' ) ); ?>" type="text"
               value="<?php echo esc_attr( $name ); ?>">
      </p>
      <p>
        <label
            for="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>"><?php esc_attr_e( 'URL Link:', 'text_domain' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>"
               name="<?php echo esc_attr( $this->get_field_name( 'url' ) ); ?>" type="url"
               value="<?php echo esc_attr( $url ); ?>">
      </p>
      <p>
        <label
            for="<?php echo esc_attr( $this->get_field_id( 'img' ) ); ?>"><?php esc_attr_e( 'Logo URL:', 'text_domain' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'img' ) ); ?>"
               name="<?php echo esc_attr( $this->get_field_name( 'img' ) ); ?>" type="url"
               value="<?php echo esc_attr( $img ); ?>">
      </p>
      <p>
        <label
            for="<?php echo esc_attr( $this->get_field_id( 'hint' ) ); ?>"><?php esc_attr_e( 'Hinweis:', 'text_domain' ); ?></label>
        <textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'hint' ) ); ?>"
                  name="<?php echo esc_attr( $this->get_field_name( 'hint' ) ); ?>"
                  type="url"><?php echo esc_attr( $hint ); ?></textarea>
      </p>
		<?php
	}

	/**
	 * Saves the widget settings on update
	 *
	 * @param array $new_instance
	 * @param array $old_instance
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';

		$instance['name'] = ( ! empty( $new_instance['name'] ) ) ? sanitize_text_field( $new_instance['name'] ) : '';
		$instance['url']  = ( ! empty( $new_instance['url'] ) ) ? sanitize_text_field( $new_instance['url'] ) : '';
		$instance['img']  = ( ! empty( $new_instance['img'] ) ) ? sanitize_text_field( $new_instance['img'] ) : '';
		$instance['hint'] = ( ! empty( $new_instance['hint'] ) ) ? $new_instance['hint'] : '';

		return $instance;
	}

	/**
	 * Echos widget in sidebar on frontend
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		echo $args['before_title'] . apply_filters( 'widget_title', ( ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Unser Sponsor', 'text_domain' ) ) ) . $args['after_title'];


		if ( ! empty( $instance['url'] ) || ! empty( $instance['name'] ) || ! empty( $instance['img'] ) ) {
			echo '<a href="' . $instance['url'] . '" target="_blank" class="sponsor_logo_img" title="' . $instance['name'] . '"><img src="' . $instance['img'] . '" alt="' . $instance['name'] . '"></a>';
		}

	  if ( ! empty( $instance['hint'] ) ) {
		  echo '</h2><h2 class="hint_icon waves-effect" data-hint="' . nl2br(htmlentities($instance['hint'])) . '"><i class="material-icons">info</i>';
	  }

		echo $args['after_widget'];
	}
}

add_action( 'widgets_init', function () {
	register_widget( 'Fhgnewsonline_Sponsor_Widget' );
} );