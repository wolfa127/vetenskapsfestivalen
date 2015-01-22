<?php

if ( ! in_array( 'bbpress/bbpress.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	return false;
}

// Include theme styles for forums
function us_bbpress_styles()
{
	wp_dequeue_style( 'bbp-default' );
	wp_register_style( 'us_bbpress', get_template_directory_uri() . '/css/us.bbpress.css', array(), '1', 'all' );
	wp_enqueue_style( 'us_bbpress' );
}
add_action('bbp_enqueue_scripts', 'us_bbpress_styles', 15);

// Add sidebar to forum pages
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'BBPress Sidebar',
		'id' => 'bbpress_sidebar',
		'description' => 'This is the BBPress sidebar. It is used for forum pages.',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>'
	));
}

// Remove Forum summaries
add_filter('bbp_get_single_forum_description', 'us_remove_forum_summary',10,2 );
add_filter('bbp_get_single_topic_description', 'us_remove_forum_summary',10,2 );

function us_remove_forum_summary() {
	return FALSE;
}
