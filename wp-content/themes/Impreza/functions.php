<?php
/**
 * Include all needed files
 */
/* Slightly Modified Options Framework */
require_once (get_template_directory() . '/admin/index.php');
/* Admin specific functions */
require_once(get_template_directory() . '/functions/admin.php');
/* Load shortcodes */
require_once(get_template_directory() . '/functions/shortcodes.php');
require_once(get_template_directory() . '/functions/zilla-shortcodes/zilla-shortcodes.php');
/* Breadcrumbs function */
require_once(get_template_directory() . '/functions/breadcrumbs.php');
/* Post formats */
require_once(get_template_directory() . '/functions/post_formats.php');
/* Custom Post types */
require_once(get_template_directory() . '/functions/post_types.php');
/* Meta Box plugin and settings */
define( 'RWMB_URL', trailingslashit( get_template_directory_uri() . '/vendor/meta-box' ) );
define( 'RWMB_DIR', trailingslashit( get_template_directory() . '/vendor/meta-box' ) );
require_once RWMB_DIR . 'meta-box.php';
require_once(get_template_directory() . '/functions/meta-box_settings.php');
/* Menu and it's custom markup */
require_once(get_template_directory() . '/functions/menu.php');
/* Comments custom markup */
require_once(get_template_directory() . '/functions/comments.php');
/* wp_link_pages both next and numbers usage */
require_once(get_template_directory() . '/functions/link_pages.php');
/* Sidebars init */
require_once(get_template_directory() . '/functions/sidebars.php');
/* Sidebar generator */
require_once(get_template_directory() . '/vendor/sidebar_generator.php');
/* Plugins activation */
require_once(get_template_directory() . '/functions/plugin_activation.php');
/* CSS and JS enqueue */
require_once(get_template_directory() . '/functions/enqueue.php');
/* Widgets */
require_once(get_template_directory() . '/functions/widgets/contact.php');
require_once(get_template_directory() . '/functions/widgets/socials.php');
add_filter('widget_text', 'do_shortcode');
/* Demo Import */
require_once(get_template_directory() . '/functions/demo_import.php');
/* Auto Updater */
require_once(get_template_directory() . '/vendor/tf_updater/index.php');

require_once(get_template_directory() . '/functions/ajax_grid_blog.php');
require_once(get_template_directory() . '/functions/ajax_blog.php');
require_once(get_template_directory() . '/functions/ajax_portfolio.php');
require_once(get_template_directory() . '/functions/ajax_import.php');
require_once(get_template_directory() . '/functions/ajax_contact.php');

/* WooCommerce */
require_once(get_template_directory() . '/functions/woocommerce.php');
/* bbPress */
require_once(get_template_directory() . '/functions/bbpress.php');

/**
 * Theme Setup
 */
function us_theme_setup()
{
	global $smof_data, $content_width;

	if ( ! isset( $content_width ) ) $content_width = 1500;
	add_theme_support('automatic-feed-links');

	add_theme_support('post-formats', array('quote', 'image', 'gallery', 'video', ));

	/* Add post thumbnail functionality */
add_theme_support('post-thumbnails');
add_image_size('portfolio-list', 600, 400, true);
add_image_size('portfolio-list-3-2', 600, 400, true);
add_image_size('portfolio-list-4-3', 600, 450, true);
add_image_size('portfolio-list-1-1', 600, 600, true);
add_image_size('portfolio-list-2-3', 400, 600, true);
add_image_size('portfolio-list-3-4', 450, 600, true);
add_image_size('member', 350, 350, true);
add_image_size('blog-small', 350, 350, true);
add_image_size('blog-grid', 600, 0, false);
add_image_size('blog-large', 1140, 600, true);
add_image_size('gallery-s', 150, 150, true);
add_image_size('gallery-m', 300, 300, true);
add_image_size('gallery-l', 600, 600, true);
add_image_size('gallery-masonry-s', 150, 0, false);
add_image_size('gallery-masonry-m', 300, 0, false);
add_image_size('gallery-masonry-l', 600, 0, false);
add_image_size('carousel-thumb', 300, 200, false);


	/* hide admin bar */
//	show_admin_bar( false );

	/* Excerpt length */
	if (isset($smof_data['blog_excerpt_length']) AND $smof_data['blog_excerpt_length'] != 55) {
		add_filter( 'excerpt_length', 'us_excerpt_length', 999 );
	}

	/* Remove [...] from excerpt */
	add_filter('excerpt_more', 'us_excerpt_more');

	/* Theme localization */
	load_theme_textdomain( 'us', get_template_directory() . '/languages' );
}

add_action( 'after_setup_theme', 'us_theme_setup' );

if (function_exists('set_revslider_as_theme')) {
	set_revslider_as_theme();
}

if (function_exists('vc_set_as_theme')) {
	vc_set_as_theme(true);
}

function us_excerpt_length( $length ) {
	global $smof_data;
	return $smof_data['blog_excerpt_length'];
}

function us_excerpt_more( $more ) {
	return '...';
}

/* Custom code goes below this line. */

/* Custom code goes above this line. */
