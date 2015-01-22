<?php

$prefix = 'us_';

$slider_revolution = array(0 => 'No Slider');


$header_titlebar_fields = array (
	array(
		'name'		=> 'Title Bar Content',
		'id'		=> $prefix . "titlebar",
		'type'		=> 'select',
		'options'	=> array(
			'' => 'Captions and Breadcrumbs',
			'caption_only' => 'Captions only',
			'hide' => 'Hide',
		),
	),
	array(
		'name'		=> 'Title Bar Size',
		'id'		=> $prefix . "header_layout_type",
		'type'		=> 'select',
		'options'	=> array(
			'' => 'Default (set at Theme Options)',
			'Ultra Compact' => 'Ultra Compact',
			'Compact' => 'Compact',
			'Large' => 'Large',
			'Huge' => 'Huge',
		),
	),
	array(
		'name'		=> 'Small caption (shown next to Page Title)',
		'id'		=> $prefix . 'subtitle',
		'clone'		=> false,
		'type'		=> 'text',
		'std'		=> '',
	),
	array(
		'name'		=> 'Title Bar Color Style',
		'id'		=> $prefix . "titlebar_color",
		'type'		=> 'select',
		'options'	=> array(
			'' => 'Default bg | Default text',
			'alternate' => 'Alternate bg | Default text',
			'primary' => 'Primary bg | White text',
			'secondary' => 'Secondary bg | White text',
		),
	),
	array(
		'name'		=> 'Title Bar Background Image',
		'id'		=> $prefix . "titlebar_image",
		'type'		=> 'image_advanced',
		'max_file_uploads'	=> 1,

	),
	array(
		'name'		=> 'Parallax Effect',
		'id'		=> $prefix . "titlebar_parallax",
		'type'		=> 'select',
		'options'	=> array(
			'' => 'None',
			'vertical' => 'Vertical Parallax',
			'vertical_reversed' => 'Vertical Reversed Parallax',
			'horizontal' => 'Horizontal Parallax',
			'still' => 'Still (Image not moves)',
		),
	),
	array(
		'name'		=> 'Overlay Color',
		'id'		=> $prefix . "titlebar_overlay_color",
		'type'		=> 'color',
	),
	array(
		'name'		=> 'Overlay Opacity',
		'id'		=> $prefix . "titlebar_overlay_opacity",
		'type'		 => 'slider',
		'js_options' => array(
			'min' => 1,
			'max' => 99,
		)
	),

);

$footer_fields = array(

	array(
		'name'		=> 'Display the Subfooter widgets',
		'id'		=> $prefix . "show_subfooter_widgets",
		'type'		=> 'select',
		'options'	=> array(
			'' => 'Default (set at Theme Options)',
			'yes' => 'Show',
			'no' => 'Hide',
		),
	),
	array(
		'name'		=> 'Display the Footer (copyright and menu)',
		'id'		=> $prefix . "show_footer",
		'type'		=> 'select',
		'options'	=> array(
			'' => 'Default (set at Theme Options)',
			'yes' => 'Show',
			'no' => 'Hide',
		),
	),

);

$meta_boxes[] = array(
	'id' => 'impreza_post_page_portfolio_header_settings',
	'title' => 'Header Settings',
	'pages' => array( 'post', 'page', 'us_portfolio', ),
	'context' => 'side',
	'priority' => 'default',

	// List of meta fields
	'fields' => array (
		array(
			'name'		=> 'Header Type',
			'id'		=> $prefix . "header_type",
			'type'		=> 'select',
			'options'	=> array(
				'' => 'Default (set at Theme Options)',
				'Sticky Transparent' => 'Sticky Transparent',
				'Sticky Solid' => 'Sticky Solid',
				'Non-sticky' => 'Non-sticky',
			),
		),
	),
);

$meta_boxes[] = array(
	'id' => 'impeza_page_portfolio_header_settings',
	'title' => 'Title Bar Settings',
	'pages' => array('page', 'us_portfolio'),
	'context' => 'side',
	'priority' => 'default',

	// List of meta fields
	'fields' => $header_titlebar_fields,
);

if (in_array( 'bbpress/bbpress.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	$meta_boxes[] = array(
		'id' => 'impeza_forum_header_settings',
		'title' => 'Title Bar Settings',
		'pages' => array('forum', 'topic'),
		'context' => 'side',
		'priority' => 'default',

		// List of meta fields
		'fields' => $header_titlebar_fields,
	);
}


$meta_boxes[] = array(
	'id' => 'client_settings',
	'title' => 'Client Settings',
	'pages' => array('us_client'),
	'context' => 'normal',
	'priority' => 'high',

	// List of meta fields
	'fields' => array(
		array(
			'name'		=> 'Client URL',
			'id'		=> $prefix . 'client_url',
			'type'		=> 'text',
			'std'		=> '',
		),
		array(
			'name'		=> 'Open URL in a new Tab (Window)',
			'id'		=> $prefix . "client_new_tab",
			'type'		=> 'checkbox',
			'std'		=> false,
		),
	),
);





$meta_boxes[] = array(
	'id' => 'portfolio_layout_settings',
	'title' => 'Portfolio Item Settings',
	'pages' => array('us_portfolio'),
	'context' => 'normal',
	'priority' => 'high',

	// List of meta fields
	'fields' => array(
		array(
			'name'		=> 'Additional Image on hover (optional)',
			'id'		=> $prefix . "additional_image",
			'type'		=> 'image_advanced',
			'max_file_uploads'	=> 1,

		),
		array(
			'name'		=> 'Open Portfolio Image in Lightbox',
			'id'		=> $prefix . "lightbox",
			'type'		=> 'checkbox',
			'std'		=> false,
		),
		array(
			'name'		=> 'Custom Project Link',
			'id'		=> $prefix . 'custom_link',
			'type'		=> 'text',
			'std'		=> '',
		),
		array(
			'name'		=> 'Custom Project Link Target',
			'id'		=> $prefix . "custom_link_blank",
			'type'		=> 'checkbox',
			'desc'		=> 'Open Custom Project Link in a new Tab (Window)',
		),
		array(
			'name'		=> 'Item Tile Background Color',
			'id'		=> $prefix . "title_bg_color",
			'type'		=> 'color',
		),
		array(
			'name'		=> 'Item Tile Text Color',
			'id'		=> $prefix . "title_text_color",
			'type'		=> 'color',
		),
		array(
			'name'		=> 'Sidebar Position',
			'id'		=> $prefix . "sidebar",
			'type'		=> 'select',
			'options'	=> array(
				'' => 'Default (set at Theme Options)',
				'no_sidebar' => 'No Sidebar',
				'right' => 'Right',
				'left' => 'Left',
			),
		),
	),

);

$meta_boxes[] = array(
	'id' => 'impeza_common_footer_settings',
	'title' => 'Footer Settings',
	'pages' => array( 'post', 'page', 'us_portfolio'),
	'context' => 'side',
	'priority' => 'default',

	// List of meta fields
	'fields' => $footer_fields

);

function us_register_meta_boxes()
{
	global $meta_boxes;

	// Make sure there's no errors when the plugin is deactivated or during upgrade
	if ( class_exists( 'RW_Meta_Box' ) )
	{
		foreach ( $meta_boxes as $meta_box )
		{
			new RW_Meta_Box( $meta_box );
		}
	}
}
// Hook to 'admin_init' to make sure the meta box class is loaded before
// (in case using the meta box class in another plugin)
// This is also helpful for some conditionals like checking page template, categories, etc.
add_action( 'admin_init', 'us_register_meta_boxes' );
