<?php
/**
 * @package fhgnewsonline
 * -- Admin Menu
 */

function fhgnewsonline_add_admin_page() {
  if (current_user_can('edit_others_posts')) {
	  add_menu_page( 'FHG News OrgaPlan', 'FHG News', 'edit_posts', 'fhgnewsonline_orgaplan', 'fhgnewsonline_orgaplan_page', get_theme_file_uri( '/img/icons/fhgnews_white_icon.svg' ), 110 );
	  add_submenu_page( 'fhgnewsonline_orgaplan', 'OrgaPlan', 'OrgaPlan', 'edit_others_posts', 'fhgnewsonline_orgaplan', 'fhgnewsonline_orgaplan_page' );
	  add_submenu_page( 'fhgnewsonline_orgaplan', 'Handbuch', 'Handbuch', 'edit_posts', 'fhgnewsonline_handbook', 'fhgnewsonline_handbook_page' );
  } else {
	  add_menu_page( 'FHG News Handbuch', 'FHG News', 'edit_posts', 'fhgnewsonline_handbook', 'fhgnewsonline_handbook_page', get_theme_file_uri( '/img/icons/fhgnews_white_icon.svg' ), 110 );
  }
}

add_action( 'admin_menu', 'fhgnewsonline_add_admin_page' );


function fhgnewsonline_admin_style() {
	if ( $_GET['page'] == 'fhgnewsonline_orgaplan' || $_GET['page'] == 'fhgnewsonline_handbook' ) {
		wp_enqueue_style( 'admin-style', get_theme_file_uri( '/css/admin-style.css' ) );
		wp_enqueue_style( 'material-icons', 'https://fonts.googleapis.com/icon?family=Material+Icons' );
		wp_enqueue_style( 'roboto', 'https://fonts.googleapis.com/css?family=Roboto:300,400,500,600' );
		wp_enqueue_script( 'admin-script', get_theme_file_uri( '/js/admin-script.js' ) );
		wp_localize_script( 'admin-script', 'admin_info', array(
			'style_url' => get_theme_file_uri( '/css/admin-style.css' ),
		) );
	}
}

add_action( 'admin_enqueue_scripts', 'fhgnewsonline_admin_style' );

function fhgnewsonline_orgaplan_page() {
	?>
  <iframe id="iframe_fhgnewsonline"
          src="https://docs.google.com/document/d/e/2PACX-1vTfFnnV5_gxthwfS3nYhSh51I9Mp6z5_PI_-s19Lsmy1vzTmvmFtN-55Iv6JF-MJ3wnNrpV803MknZ8/pub?embedded=true">
  </iframe>
  <div class="button--blue">
    <span>Bearbeiten</span>
  </div>
	<?php
}

function fhgnewsonline_handbook_page() {
	?>
  <iframe id="iframe_fhgnewsonline"
          src="https://docs.google.com/document/d/e/2PACX-1vTnKZQqswvZx24J_CVc9ktyl5CP6DIRsOFqPkd0bicEnOyXUe4euVuWgy5kRu6x42ROKg2bz_GsB3hQ/pub?embedded=true">
  </iframe>
  <div class="button--blue button--flat">
    <span>Öffnen</span>
  </div>
	<?php
}