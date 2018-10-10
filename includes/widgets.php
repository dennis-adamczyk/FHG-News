<?php
/**
 * @package fhgnewsonline
 * -- Register theme widgets
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