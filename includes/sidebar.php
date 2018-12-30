<?php
/**
 * @package fhgnewsonline
 * -- Register Sidebar
 */

/**
 * Register sidebar
 */
function fhgnewsonline_sidebar_setup() {
	register_sidebar( array(
		'name'          => 'Sidebar',
		'id'            => 'sidebar',
		'class'         => '',
		'description'   => 'Wird auf Tablets & Desktops rechts neben den Posts angezeigt',
		'before_widget' => '<div id="%1$s" class="sidebar__widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="sidebar__widget__title">',
		'after_title'   => '<h2>'
	) );
}

add_action( 'widgets_init', 'fhgnewsonline_sidebar_setup' );