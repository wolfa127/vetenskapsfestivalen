<?php

function us_enqueue_editor_style() {
	add_editor_style( 'functions/tinymce/mce_styles.css' );
}

add_action('init', 'us_enqueue_editor_style');

// Redirect to Demo Import page after Theme activation
function us_theme_activation()
{
	global $pagenow;
	if (is_admin() && $pagenow == 'themes.php' && isset($_GET['activated'])) {
		//Set menu
		$user = wp_get_current_user();
		update_user_option( $user->ID, 'impreza_cpt_in_menu_set', false, true );

		//Redirect to demo import
		header( 'Location: '.admin_url().'themes.php?page=us_demo_import' ) ;
	}
}

add_action('admin_init','us_theme_activation');

function us_include_cpt_to_menu() {
	global $pagenow;
	if ( is_admin() AND $pagenow == 'nav-menus.php' ) {
		$already_set = get_user_option( 'impreza_cpt_in_menu_set' );

		if ( ! $already_set ) {
			$hidden_meta_boxes = get_user_option( 'metaboxhidden_nav-menus' );

			if ($hidden_meta_boxes !== false) {
				if (($key = array_search('add-us_portfolio', $hidden_meta_boxes)) !== false) {
					unset($hidden_meta_boxes[$key]);
				}
				if (($key = array_search('add-us_portfolio_category', $hidden_meta_boxes)) === false) {
					$hidden_meta_boxes[] = 'add-us_portfolio_category';
				}
				if (($key = array_search('add-us_client', $hidden_meta_boxes)) === false) {
					$hidden_meta_boxes[] = 'add-us_client';
				}

				$user = wp_get_current_user();
				update_user_option( $user->ID, 'metaboxhidden_nav-menus', $hidden_meta_boxes, true );
				update_user_option( $user->ID, 'impreza_cpt_in_menu_set', true, true );
			}
		}
	}
}

add_action('admin_head','us_include_cpt_to_menu', 99);

// TinyMCE buttons
function us_enqueue_admin_css() {
	wp_enqueue_style( 'us-admin-styles', get_template_directory_uri() . '/functions/assets/css/us.admin.css' );
	wp_enqueue_style( 'us-composer', get_template_directory_uri() . '/vc_templates/css/us.js_composer.css' );
	wp_enqueue_style( 'us-metabox', get_template_directory_uri() . '/vendor/meta-box/css/us_meta_box_style.css ' );
}

add_action( 'admin_print_scripts', 'us_enqueue_admin_css', 12);

if ( ! function_exists('us_is_vc_fe')) {
	function us_is_vc_fe() {
		if (function_exists('vc_mode') AND in_array(vc_mode(), array('page_editable', 'admin_frontend_editor', 'admin_page'))) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
