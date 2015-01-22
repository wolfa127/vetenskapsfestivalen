<?php
/**
 * WPBakery Visual Composer Shortcodes settings
 *
 * @package VPBakeryVisualComposer
 *
 */

$vc_is_wp_version_3_6_more = version_compare( preg_replace( '/^([\d\.]+)(\-.*$)/', '$1', get_bloginfo( 'version' ) ), '3.6' ) >= 0;

// Used in "Button", "Call __( 'Blue', 'js_composer' )to Action", "Pie chart" blocks
$colors_arr = array(
	__( 'Grey', 'js_composer' ) => 'wpb_button',
	__( 'Blue', 'js_composer' ) => 'btn-primary',
	__( 'Turquoise', 'js_composer' ) => 'btn-info',
	__( 'Green', 'js_composer' ) => 'btn-success',
	__( 'Orange', 'js_composer' ) => 'btn-warning',
	__( 'Red', 'js_composer' ) => 'btn-danger',
	__( 'Black', 'js_composer' ) => "btn-inverse"
);

// Used in "Button" and "Call to Action" blocks
$size_arr = array(
	__( 'Regular size', 'js_composer' ) => 'wpb_regularsize',
	__( 'Large', 'js_composer' ) => 'btn-large',
	__( 'Small', 'js_composer' ) => 'btn-small',
	__( 'Mini', 'js_composer' ) => "btn-mini"
);

$target_arr = array(
	__( 'Same window', 'js_composer' ) => '_self',
	__( 'New window', 'js_composer' ) => "_blank"
);

$add_css_animation = array(
	"type" => "dropdown",
	"heading" => __("Animation", "js_composer"),
	"param_name" => "animate",
	"admin_label" => true,
	"value" => array(
		__("No Animation", "js_composer") => '',
		__("Fade", "js_composer") => "fade",
		__("Appear From Center", "js_composer") => "afc",
		__("Appear From Left", "js_composer") => "afl",
		__("Appear From Right", "js_composer") => "afr",
		__("Appear From Bottom", "js_composer") => "afb",
		__("Appear From Top", "js_composer") => "aft",
		__("Height From Center", "js_composer") => "hfc",
		__("Width From Center", "js_composer") => "wfc",
		__("Rotate From Center", "js_composer") => "rfc",
		__("Rotate From Left", "js_composer") => "rfl",
		__("Rotate From Right", "js_composer") => "rfr",
	),
	"description" => __("Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "js_composer")
);

$add_css_animation_delay = array(
	"type" => "dropdown",
	"heading" => __("Animation Delay", "js_composer"),
	"param_name" => "animate_delay",
	"admin_label" => true,
	"value" => array(
		__("None", "js_composer") => '',
		__("0.2 second", "js_composer") => "0.2",
		__("0.4 second", "js_composer") => "0.4",
		__("0.6 second", "js_composer") => "0.6",
		__("0.8 second", "js_composer") => "0.8",
		__("1 second", "js_composer") => "1",
	),
	"description" => ''
);

$post_categories = array('All' => '');
$post_categories_raw = get_categories("hierarchical=0");
foreach ($post_categories_raw as $post_category_raw)
{
	$post_categories[$post_category_raw->name] = $post_category_raw->slug;
}
$portfolio_categories = array('All' => '');
$portfolio_categories_raw = get_categories("taxonomy=us_portfolio_category&hierarchical=0");//print_r($portfolio_categories_raw);
foreach ($portfolio_categories_raw as $portfolio_category_raw)
{
	$portfolio_categories[$portfolio_category_raw->name] = $portfolio_category_raw->slug;
}

function get_current_post_type() {
	global $post, $typenow, $current_screen;
//we have a post so we can just get the post type from that
	if ( $post && $post->post_type )
		return $post->post_type;
//check the global $typenow - set in admin.php
	elseif( $typenow )
		return $typenow;
//check the global $current_screen object - set in sceen.php
	elseif( $current_screen && $current_screen->post_type )
		return $current_screen->post_type;
//lastly check the post_type querystring
	elseif( isset( $_REQUEST['post_type'] ) )
		return sanitize_key( $_REQUEST['post_type'] );
//we do not know the post type!
	return null;
}
if (isset($_POST['post_id'])) {
	$post_type = get_post_type( $_POST['post_id'] );
} else {
	$post_type = get_current_post_type();
}

if (TRUE OR $post_type != '' AND $post_type != 'post') {
	$section_params = array(
		array(
			"type" => "checkbox",
			"heading" => __("Separate Section", "js_composer"),
			"param_name" => "section",
			"value" => array(__("Place row in separate section", "js_composer") => "yes")
		),
		array(
			"type" => "dropdown",
			"heading" => __("Section Color Style", "js_composer"),
			"param_name" => "background",
			"value" => array(__('Main Content (default)', "js_composer") => "", __('Alternate Content', "js_composer") => "alternate", __('Primary background color & White text color', "js_composer") => "primary", __('Secondary background color & White text color', "js_composer") => "secondary",),
			"description" => __("The section will use the color scheme you select. Color schemes are defined at Styling tab of the Theme Options", "js_composer"),
			"dependency" => Array('element' => "section", 'not_empty' => true)
		),
		array(
			"type" => "checkbox",
			"heading" => __("Full Width Content", "js_composer"),
			"param_name" => "full_width",
			"value" => array(__("Stretch section content to screen width", "js_composer") => "yes"),
			"dependency" => Array('element' => "section", 'not_empty' => true)
		),
		array(
			"type" => "checkbox",
			"heading" => __("Full Height Content", "js_composer"),
			"param_name" => "full_height",
			"value" => array(__("Remove vertical indents", "js_composer") => "yes"),
			"dependency" => Array('element' => "section", 'not_empty' => true)
		),
		array(
			"type" => "attach_image",
			"heading" => __("Section Background Image", "js_composer"),
			"param_name" => "img",
			"value" => "",
			"description" => __("Leave empty if you don't want to use the background image", "js_composer"),
			"dependency" => Array('element' => "section", 'not_empty' => true)
		),
		array(
			"type" => "dropdown",
			"heading" => __("Parallax Effect", "js_composer"),
			"param_name" => "parallax",
			"value" => array(__("None", "js_composer") => "", __("Vertical Parallax", "js_composer") => "vertical", __("Horizontal Parallax", "js_composer") => "horizontal",  __('Still (Image not moves)', "js_composer") => "still",),
			"dependency" => Array('element' => "section", 'not_empty' => true)

		),
		array(
			"type" => "dropdown",
			"heading" => __("Parallax Background Width", "js_composer"),
			"param_name" => "parallax_bg_width",
			"value" => array("110%" => "110", "120%" => "120", "130%" => "130", "140%" => "140", "150%" => "150", ),
			"description" => '',
			"dependency" => Array('element' => "parallax", 'value' => array('horizontal'))
		),
		array(
			"type" => "checkbox",
			"heading" => __("Reverse Parallax", "js_composer"),
			"param_name" => "parallax_reverse",
			"value" => array(__("Reverse Parallax Effect", "js_composer") => "yes"),
			"dependency" => Array('element' => "parallax", 'value' => array('vertical'))

		),
		array(
			"type" => "checkbox",
			"heading" => __("Background Video", "js_composer"),
			"param_name" => "video",
			"value" => array(__("Apply Background Video to this section", "js_composer") => "yes"),
			"dependency" => Array('element' => "section", 'not_empty' => true)
		),
		array(
			"type" => "textfield",
			"heading" => __("MP4 video file", "js_composer"),
			"param_name" => "video_mp4",
			"description" => __("Add link to MP4 video file", "js_composer"),
			"dependency" => Array('element' => "video", 'not_empty' => true)
		),
		array(
			"type" => "textfield",
			"heading" => __("OGV video file", "js_composer"),
			"param_name" => "video_ogg",
			"description" => __("Add link to OGV video file", "js_composer"),
			"dependency" => Array('element' => "video", 'not_empty' => true)
		),
		array(
			"type" => "textfield",
			"heading" => __("WebM video file", "js_composer"),
			"param_name" => "video_webm",
			"description" => __("Add link to WebM video file", "js_composer"),
			"dependency" => Array('element' => "video", 'not_empty' => true)
		),
		array(
			"type" => "dropdown",
			"heading" => __("Overlay", "js_composer"),
			"param_name" => "overlay",
			"value" => array(__('None', "js_composer") => "",__('10% White', "js_composer") => "white_10", __('20% White', "js_composer") => "white_20", __('30% White', "js_composer") => "white_30", __('40% White', "js_composer") => "white_40", __('50% White', "js_composer") => "white_50", __('60% White', "js_composer") => "white_60", __('70% White', "js_composer") => "white_70", __('80% White', "js_composer") => "white_80", __('90% White', "js_composer") => "white_90", __('10% Black', "js_composer") => "black_10", __('20% Black', "js_composer") => "black_20", __('30% Black', "js_composer") => "black_30", __('40% Black', "js_composer") => "black_40", __('50% Black', "js_composer") => "black_50", __('60% Black', "js_composer") => "black_60", __('70% Black', "js_composer") => "black_70", __('80% Black', "js_composer") => "black_80", __('90% Black', "js_composer") => "black_90", ),
			"description" => '',
			"dependency" => Array('element' => "section", 'not_empty' => true)
		),
		array(
			"type" => "textfield",
			"heading" => __("Section ID (optional)", "js_composer"),
			"param_name" => "section_id",
			"description" => '',
			"dependency" => Array('element' => "section", 'not_empty' => true),
		),
		array(
			"type" => "textfield",
			"heading" => __("Extra class name", "js_composer"),
			"param_name" => "class",
			"description" => '',
		),
	);
} else {
	$section_params = array(
		array(
			"type" => "textfield",
			"heading" => __("Extra class name", "js_composer"),
			"param_name" => "class",
			"description" => '',
		),
	);
}

vc_map( array(
	'name' => __( 'Row', 'js_composer' ),
	'base' => 'vc_row',
	'is_container' => true,
	'icon' => 'icon-wpb-row',
	'show_settings_on_create' => false,
	'category' => __( 'Content', 'js_composer' ),
	'description' => __( 'Place content elements inside the row', 'js_composer' ),
	'params' => $section_params,
	'js_view' => 'VcRowView'
) );
vc_map( array(
	'name' => __( 'Row', 'js_composer' ), //Inner Row
	'base' => 'vc_row_inner',
	'content_element' => false,
	'is_container' => true,
	'icon' => 'icon-wpb-row',
	'weight' => 1000,
	'show_settings_on_create' => false,
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'js_composer' ),
			'param_name' => 'class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
		),
//        array(
//            'type' => 'css_editor',
//            'heading' => __( 'Css', 'js_composer' ),
//            'param_name' => 'css',
//            // 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
//            'group' => __( 'Design options', 'js_composer' )
//        )
	),
	'js_view' => 'VcRowView'
) );
vc_map( array(
	'name' => __( 'Column', 'js_composer' ),
	'base' => 'vc_column',
	'is_container' => true,
	'content_element' => false,
	"params" => array(

		$add_css_animation,
		$add_css_animation_delay
	),
	'js_view' => 'VcColumnView'
) );

vc_map( array(
	"name" => __( "Column", "js_composer" ),
	"base" => "vc_column_inner",
	"class" => "",
	"icon" => "",
	"wrapper_class" => "",
	"controls" => "full",
	"allowed_container_element" => false,
	"content_element" => false,
	"is_container" => true,
	"params" => array(
		$add_css_animation,
		$add_css_animation_delay
	),
	"js_view" => 'VcColumnView'
) );
/* Text Block
---------------------------------------------------------- */
vc_map( array(
	'name' => __( 'Text Block', 'js_composer' ),
	'base' => 'vc_column_text',
	'icon' => 'icon-wpb-layer-shape-text',
	'wrapper_class' => 'clearfix',
	'category' => __( 'Content', 'js_composer' ),
	'description' => __( 'A block of text with WYSIWYG editor', 'js_composer' ),
	'params' => array(
		array(
			'type' => 'textarea_html',
			'holder' => 'div',
			'heading' => __( 'Text', 'js_composer' ),
			'param_name' => 'content',
			'value' => __( '<p>I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>', 'js_composer' )
		),
//		$add_css_animation,
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'Extra class name', 'js_composer' ),
//			'param_name' => 'el_class',
//			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
//		),
//		array(
//			'type' => 'css_editor',
//			'heading' => __( 'Css', 'js_composer' ),
//			'param_name' => 'css',
//			// 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
//			'group' => __( 'Design options', 'js_composer' )
//		)
	)
) );

/* Latest tweets
---------------------------------------------------------- */
/*vc_map( array(
	'name' => __( 'Twitter Widget', 'js_composer' ),
	'base' => 'vc_twitter',
	'icon' => 'icon-wpb-balloon-twitter-left',
	'category' => __( 'Social', 'js_composer' ),
	'params' => array(
  array(
		'type' => 'textfield',
		'heading' => __( 'Widget title', 'js_composer' ),
		'param_name' => 'title',
		'description' => __( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'js_composer' )
  ),
  array(
		'type' => 'textfield',
		'heading' => __( 'Twitter username', 'js_composer' ),
		'param_name' => 'twitter_name',
		'admin_label' => true,
		'description' => __( 'Type in twitter profile name from which load tweets.', 'js_composer' )
  ),
  array(
		'type' => 'dropdown',
		'heading' => __( 'Tweets count', 'js_composer' ),
		'param_name' => 'tweets_count',
		'admin_label' => true,
		'value' => array( 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15),
		'description' => __( 'How many recent tweets to load.', 'js_composer' )
  ),
  array(
		'type' => 'textfield',
		'heading' => __( 'Extra class name', 'js_composer' ),
		'param_name' => 'el_class',
		'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
  )
)
) );*/



/* Textual block
---------------------------------------------------------- */
//vc_map( array(
//	'name' => __( 'Separator with Text', 'js_composer' ),
//	'base' => 'vc_text_separator',
//	'icon' => 'icon-wpb-ui-separator-label',
//	'category' => __( 'Content', 'js_composer' ),
//	'description' => __( 'Horizontal separator line with heading', 'js_composer' ),
//	'params' => array(
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'Title', 'js_composer' ),
//			'param_name' => 'title',
//			'holder' => 'div',
//			'value' => __( 'Title', 'js_composer' ),
//			'description' => __( 'Separator title.', 'js_composer' )
//		),
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Title position', 'js_composer' ),
//			'param_name' => 'title_align',
//			'value' => array(
//				__( 'Align center', 'js_composer' ) => 'separator_align_center',
//				__( 'Align left', 'js_composer' ) => 'separator_align_left',
//				__( 'Align right', 'js_composer' ) => "separator_align_right"
//			),
//			'description' => __( 'Select title location.', 'js_composer' )
//		),
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Color', 'js_composer' ),
//			'param_name' => 'color',
//			'value' => getVcShared( 'colors' ),
//			'std' => 'grey',
//			'description' => __( 'Separator color.', 'js_composer' ),
//			'param_holder_class' => 'vc-colored-dropdown'
//		),
//		array(
//			'type' => 'colorpicker',
//			'heading' => __( 'Custom Border Color', 'wpb' ),
//			'param_name' => 'accent_color',
//			'description' => __( 'Select border color for your element.', 'wpb' )
//		),
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Style', 'js_composer' ),
//			'param_name' => 'style',
//			'value' => getVcShared( 'separator styles' ),
//			'description' => __( 'Separator style.', 'js_composer' )
//		),
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Element width', 'js_composer' ),
//			'param_name' => 'el_width',
//			'value' => getVcShared( 'separator widths' ),
//			'description' => __( 'Separator element width in percents.', 'js_composer' )
//		),
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'Extra class name', 'js_composer' ),
//			'param_name' => 'el_class',
//			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
//		)
//	),
//	'js_view' => 'VcTextSeparatorView'
//) );

/* Single image */
vc_map( array(
	'name' => __( 'Single Image', 'js_composer' ),
	'base' => 'vc_single_image',
	'icon' => 'icon-wpb-single-image',
	'category' => __( 'Content', 'js_composer' ),
	'description' => __( 'Single image with CSS animation', 'js_composer' ),
	'params' => array(
		array(
			"type" => "attach_image",
			"heading" => __("Image", "js_composer"),
			"param_name" => "image",
			"value" => "",
			"description" => __("Select image from media library.", "js_composer")
		),
		array(
			"type" => "dropdown",
			"heading" => __("Alignment", "js_composer"),
			"param_name" => "align",
			"value" => array(__('Default', "js_composer") => "", __('Align left', "js_composer") => "left", __('Align center', "js_composer") => "center", __('Align right', "js_composer") => "right"),
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"heading" => __("Image size", "js_composer"),
			"param_name" => "img_size",
			"value" => array(__("Full Size", "js_composer") => "full", __("Thumbnail", "js_composer") => "thumbnail", __("Medium", "js_composer") => "medium", ),
			"description" => ''
		),
		array(
			"type" => 'checkbox',
			"heading" => '',
			"param_name" => "img_link_large",
			"description" => "",
			"value" => Array(__("Open original image in a lightbox on click", "js_composer") => 'yes')
		),
		array(
			"type" => "textfield",
			"heading" => __("Image link", "js_composer"),
			"param_name" => "img_link",
			"description" => __("Enter url if you want this image to have link.", "js_composer"),
			"dependency" => Array('element' => "img_link_large", 'is_empty' => true,)
		),
		array(
			'type' => 'checkbox',
			'heading' => '',
			'param_name' => 'img_link_new_tab',
			'value' => array( __( 'Open this link in a new tab', 'js_composer' ) => true ),
			"dependency" => Array('element' => "img_link", 'not_empty' => true),
		),
		$add_css_animation,
		$add_css_animation_delay,
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'Extra class name', 'js_composer' ),
//			'param_name' => 'el_class',
//			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
//		),
//		array(
//			'type' => 'css_editor',
//			'heading' => __( 'Css', 'js_composer' ),
//			'param_name' => 'css',
//			// 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
//			'group' => __( 'Design options', 'js_composer' )
//		)
	)
) );

/* Gallery
---------------------------------------------------------- */
vc_map( array(
	'name' => __( 'Image Gallery', 'js_composer' ),
	'base' => 'vc_gallery',
	'icon' => 'icon-wpb-images-stack',
	'category' => __( 'Content', 'js_composer' ),
	'description' => __( 'Responsive image gallery', 'js_composer' ),
	'params' => array(
		array(
			"type" => "attach_images",
			"heading" => __("Images", "js_composer"),
			"param_name" => "ids",
			"value" => "",
			"description" => __("Select images from media library.", "js_composer")
		),
		array(
			"type" => "dropdown",
			"heading" => __("Columns", "js_composer"),
			"param_name" => "columns",
			"value" => array('1 column' => '1', '2 columns' => '2', '3 columns' => '3', '4 columns' => '4', '5 columns' => '5', '6 columns' => '6', '7 columns' => '7', '8 columns' => '8', '9 columns' => '9', '10 columns' => '10', ),
			"description" => ''
		),
		array(
			"type" => 'checkbox',
			"heading" => __("Masonry Grid", "js_composer"),
			"param_name" => "masonry",
			"description" => "",
			"value" => Array(__("Display thumbs with the initial proportions", "js_composer") => 'yes')
		),
		array(
			"type" => 'checkbox',
			"heading" => __("Indents", "js_composer"),
			"param_name" => "indents",
			"description" => "",
			"value" => Array(__("Add indents between thumbnails", "js_composer") => 'yes')
		),
//        array(
//            "type" => "dropdown",
//            "heading" => __("Gallery Type", "js_composer"),
//            "param_name" => "type",
//            "value" => array(__("Small thumbs (190x190)", "js_composer") => "s", __("Tiny thumbs (114x114)", "js_composer") => "xs", __("Medium thumbs (228x228)", "js_composer") => "m", __("Large thumbs (285x285)", "js_composer") => "l", __("Masonry grid", "js_composer") => "masonry"),
//            "description" => '',
//        ),
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'Extra class name', 'js_composer' ),
//			'param_name' => 'el_class',
//			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
//		)
	)
) );

/* Image Slider
---------------------------------------------------------- */
vc_map( array(
	"name" => __("Image Slider", "js_composer"),
	"base" => "vc_simple_slider",
	"icon" => "icon-wpb-images-stack",
	"category" => __('Content', 'js_composer'),
	"params" => array(

		array(
			"type" => "attach_images",
			"heading" => __("Images", "js_composer"),
			"param_name" => "ids",
			"value" => "",
			"description" => __("Select images from media library.", "js_composer")
		),
		array(
			"type" => 'checkbox',
			"heading" => __("Auto Rotation", "js_composer"),
			"param_name" => "auto_rotation",
			"value" => Array(__("Enable Auto Rotation", "js_composer") => 'yes')
		),
		array(
			"type" => "dropdown",
			"heading" => __("Navigation Arrows", "js_composer"),
			"param_name" => "arrows",
			"value" => array(__("Show always", "js_composer") => "always", __("Show on hover", "js_composer") => "hover", __("Hide", "js_composer") => "hide", ),
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"heading" => __("Additional Navigation", "js_composer"),
			"param_name" => "nav",
			"value" => array(__("None", "js_composer") => "none", __("Dots", "js_composer") => "dots", __("Thumbs", "js_composer") => "thumbs", ),
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"heading" => __("Transition Effect", "js_composer"),
			"param_name" => "transition",
			"value" => array(__("Slide", "js_composer") => "slide", __("Fade", "js_composer") => "fade", __("Dissolve", "js_composer") => "dissolve", ),
			"description" => ''
		),
		array(
			"type" => 'checkbox',
			"heading" => __("Full Screen", "js_composer"),
			"param_name" => "fullscreen",
			"value" => Array(__("Allow Full Screen view", "js_composer") => 'yes')
		),
		array(
			"type" => 'checkbox',
			"heading" => __("Stretch Images", "js_composer"),
			"param_name" => "stretch",
			"value" => Array(__("Stretch all images to full size of this slider", "js_composer") => 'yes')
		),

	)
) );

/* Separator (Divider)
---------------------------------------------------------- */
vc_map( array(
	'name' => __( 'Separator', 'js_composer' ),
	'base' => 'vc_separator',
	'icon' => 'icon-wpb-ui-separator',
//	'show_settings_on_create' => false,
	'category' => __( 'Content', 'js_composer' ),
//"controls"	=> 'popup_delete',
	'description' => __( 'Horizontal separator line', 'js_composer' ),
	'params' => array(
		array(
			"type" => "dropdown",
			"heading" => __("Separator Type", "js_composer"),
			"param_name" => "type",
			"value" => array(__('Default', "js_composer") => "", __('Full Width', "js_composer") => "fullwidth", __('Short', "js_composer") => "short", __('Invisible', "js_composer") => "invisible"),
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"heading" => __("Separator Size", "js_composer"),
			"param_name" => "size",
			"value" => array(__('Medium', "js_composer") => "", __('Small', "js_composer") => "small", __('Big', "js_composer") => "big", __('Huge', "js_composer") => "huge"),
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Icon (optional)", "js_composer"),
			"param_name" => "icon",
			"value" => "",
			"description" => sprintf(__('FontAwesome Icon name. %s', "js_composer"), '<a href="http://fontawesome.io/icons/" target="_blank">Full list of icons</a>')
		),
		array(
			"type" => "textfield",
			"heading" => __("Text (optional)", "js_composer"),
			"param_name" => "text",
			"value" => "",
			"description" => 'Displays text in the middle of this separator'
		),
//
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Color', 'js_composer' ),
//			'param_name' => 'color',
//			'value' => getVcShared( 'colors' ),
//			'std' => 'grey',
//			'description' => __( 'Separator color.', 'js_composer' ),
//			'param_holder_class' => 'vc-colored-dropdown'
//		),
//		array(
//			'type' => 'colorpicker',
//			'heading' => __( 'Custom Border Color', 'wpb' ),
//			'param_name' => 'accent_color',
//			'description' => __( 'Select border color for your element.', 'wpb' )
//		),
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Style', 'js_composer' ),
//			'param_name' => 'style',
//			'value' => getVcShared( 'separator styles' ),
//			'description' => __( 'Separator style.', 'js_composer' )
//		),
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Element width', 'js_composer' ),
//			'param_name' => 'el_width',
//			'value' => getVcShared( 'separator widths' ),
//			'description' => __( 'Separator element width in percents.', 'js_composer' )
//		),
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'Extra class name', 'js_composer' ),
//			'param_name' => 'el_class',
//			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
//		)
	)
) );

/* Button
---------------------------------------------------------- */
vc_map( array(
	"name" => __("Button", "js_composer"),
	"base" => "vc_button",
	"icon" => "icon-wpb-ui-button",
	"category" => __('Content', 'js_composer'),
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("Button Label", "js_composer"),
			"holder" => "button",
			"class" => "wpb_button",
			"param_name" => "text",
			"value" => __("Click me", "js_composer"),
			"description" => __("This is the text that appears on the button", "js_composer")
		),
		array(
			"type" => "textfield",
			"heading" => __("Button Link", "js_composer"),
			"param_name" => "url",
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"heading" => __("Button Color", "js_composer"),
			"param_name" => "type",
			"value" => array(__("Primary (theme color)", "js_composer") => "primary", __("Secondary (theme color)", "js_composer") => "secondary", __("Contrast (theme color)", "js_composer") => "contrast", __("Faded (theme color)", "js_composer") => "default", __("White", "js_composer") => "white", __("Pink", "js_composer") => "pink", __("Blue", "js_composer") => "blue", __("Green", "js_composer") => "green", __("Yellow", "js_composer") => "yellow", __("Purple", "js_composer") => "purple", __("Red", "js_composer") => "red", __("Lime", "js_composer") => "lime", __("Navy", "js_composer") => "navy", __("Cream", "js_composer") => "cream", __("Brown", "js_composer") => "brown", __("Midnight", "js_composer") => "midnight", __("Teal", "js_composer") => "teal", __("Transparent", "js_composer") => "transparent"),
			"description" => ''
		),
		array(
			"type" => 'checkbox',
			"heading" => __("Outlined", "js_composer"),
			"param_name" => "outlined",
			"value" => Array(__("Apply Outlined Style to the Button", "js_composer") => 'yes'),
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Button Icon (optional)", "js_composer"),
			"param_name" => "icon",
			"description" => sprintf(__('FontAwesome Icon name. %s', "js_composer"), '<a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">Full list of icons</a>')
		),
		array(
			"type" => "dropdown",
			"heading" => __("Button Size", "js_composer"),
			"param_name" => "size",
			"value" => array(__("Normal", "js_composer") => "", __("Small", "js_composer") => "small", __("Big", "js_composer") => "big"),
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"heading" => __("Button Position", "js_composer"),
			"param_name" => "align",
			"value" => array(__('Align left', "js_composer") => "left", __('Align center', "js_composer") => "center", __('Align right', "js_composer") => "right"),
			"description" => ''
		),
		array(
			"type" => "checkbox",
			"heading" => '',
			"param_name" => "target",
			"value" => array(__( 'Open button link in a new tab', 'js_composer' ) => 1 ),
			"dependency" => Array('element' => "href", 'not_empty' => true)
		),
	),
	"js_view" => 'VcButtonView'
) );

/* Tabs
---------------------------------------------------------- */
$tab_id_1 = time().'-1-'.rand(0, 100);
$tab_id_2 = time().'-2-'.rand(0, 100);
vc_map( array(
	"name"  => __("Tabs", "js_composer"),
	"base" => "vc_tabs",
	"show_settings_on_create" => false,
	"is_container" => true,
	"icon" => "icon-wpb-ui-tab-content",
	"category" => __('Content', 'js_composer'),
	"params" => array(

		array(
			"type" => 'checkbox',
			"heading" => __("Act as Timeline", "js_composer"),
			"param_name" => "timeline",
			"description" => '',
			"value" => Array(__("Change look and feel into Timeline", "js_composer") => 'yes')
		),

	),
	"custom_markup" => '
  <div class="wpb_tabs_holder wpb_holder vc_container_for_children">
  <ul class="tabs_controls">
  </ul>
  %content%
  </div>'
,
	'default_content' => '
  [vc_tab title="'.__('Tab 1','js_composer').'" tab_id="'.$tab_id_1.'"][/vc_tab]
  [vc_tab title="'.__('Tab 2','js_composer').'" tab_id="'.$tab_id_2.'"][/vc_tab]
  ',
	"js_view" => ($vc_is_wp_version_3_6_more ? 'VcTabsView' : 'VcTabsView35')
) );

vc_map( array(
	"name" => __("Tab", "js_composer"),
	"base" => "vc_tab",
	"allowed_container_element" => 'vc_row',
	"is_container" => true,
	"content_element" => false,
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("Tab Title", "js_composer"),
			"param_name" => "title",
			"description" => __("Enter the tab title here (better keep it short)", "js_composer")
		),
		array(
			"type" => "textfield",
			"heading" => __("Tab Icon (optional)", "js_composer"),
			"param_name" => "icon",
			"description" => sprintf(__('FontAwesome Icon name. %s', "js_composer"), '<a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">Full list of icons</a>'),


		),
		array(
			"type" => 'checkbox',
			"heading" => __("Active", "js_composer"),
			"param_name" => "active",
			"value" => Array(__("Tab is opened when page load", "js_composer") => 'yes')
		)
	),
	'js_view' => ($vc_is_wp_version_3_6_more ? 'VcTabView' : 'VcTabView35')
) );

/* Accordion block
---------------------------------------------------------- */
vc_map( array(
	"name" => __("Accordion", "js_composer"),
	"base" => "vc_accordion",
	"show_settings_on_create" => false,
	"is_container" => true,
	"icon" => "icon-wpb-ui-accordion",
	"category" => __('Content', 'js_composer'),
	"params" => array(

		array(
			"type" => 'checkbox',
			"heading" => __("Act as Toggles", "js_composer"),
			"param_name" => "toggle",
			"value" => Array(__("Allow several sections be open at the same time", "js_composer") => 'yes')
		),

	),
	"custom_markup" => '
  <div class="wpb_accordion_holder wpb_holder clearfix vc_container_for_children">
  %content%
  </div>
  <div class="tab_controls">
  <button class="add_tab" title="'.__("Add accordion section", "js_composer").'">'.__("Add accordion section", "js_composer").'</button>
  </div>
  ',
	'default_content' => '
  [vc_accordion_tab title="'.__('Section 1', "js_composer").'"][/vc_accordion_tab]
  [vc_accordion_tab title="'.__('Section 2', "js_composer").'"][/vc_accordion_tab]
  ',
	'js_view' => 'VcAccordionView'
) );

vc_map( array(
	"name" => __("Accordion Section", "js_composer"),
	"base" => "vc_accordion_tab",
	"allowed_container_element" => 'vc_row',
	"is_container" => true,
	"content_element" => false,
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("Tab Title", "js_composer"),
			"param_name" => "title",
			"description" => __("Enter the tab title here (better keep it short)", "js_composer")
		),
		array(
			"type" => "textfield",
			"heading" => __("Tab Icon (optional)", "js_composer"),
			"param_name" => "icon",
			"description" => sprintf(__('FontAwesome Icon name. %s', "js_composer"), '<a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">Full list of icons</a>')

		),
		array(
			"type" => 'checkbox',
			"heading" => __("Active", "js_composer"),
			"param_name" => "active",
			"value" => Array(__("Tab is opened when page load", "js_composer") => 'yes')
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Background Color"),
			"param_name" => "bg_color",
			"value" => '', //Default Red Background
			"description" => ''
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Text Color"),
			"param_name" => "text_color",
			"value" => '', //Default Red color
			"description" => ''
		),
	),
	'js_view' => 'VcAccordionTabView'
) );

/* Iconbox
---------------------------------------------------------- */
vc_map( array(
	"name" => __("IconBox", "js_composer"),
	"base" => "vc_iconbox",
	"icon" => "icon-wpb-ui-separator-label",
	"category" => __('Content', 'js_composer'),
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("Icon", "js_composer"),
			"param_name" => "icon",
			"value" => 'star',
			"description" => sprintf(__('FontAwesome Icon name. %s', "js_composer"), '<a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">Full list of icons</a>')
		),
		array(
			"type" => "dropdown",
			"heading" => __("Icon Position", "js_composer"),
			"param_name" => "iconpos",
			"value" => array(__('Top', "js_composer") => "top", __('Left', "js_composer") => "left",),
			"description" => ''
		),
		array(
			"type" => "checkbox",
			"heading" => __("With Circle", "js_composer"),
			"param_name" => "with_circle",
			"value" => array(__("Place Icon into Circle") => 'yes' ),
		),
		array(
			"type" => "textfield",
			"heading" => __("Title", "js_composer"),
			"param_name" => "title",
			"holder" => "div",
			"value" => __("Iconbox Title", "js_composer"),
			"description" => ''
		),
		array(
			"type" => "textarea",
			"heading" => __("Iconbox Content", "js_composer"),
			"param_name" => "content",
			"value" => __("Click here to add your own text", "js_composer"),
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Link (optional)", "js_composer"),
			"param_name" => "link",
			"value" => "",
			"description" => ""
		),
		array(
			"type" => "checkbox",
			"heading" => '',
			"param_name" => "external",
			"value" => array(__( 'Open this link in a new tab', 'js_composer' ) => true ),
			"dependency" => Array('element' => "link", 'not_empty' => true)
		),
		array(
			"type" => "attach_image",
			"heading" => __("Image (optional)", "js_composer"),
			"param_name" => "img",
			"value" => "",
			"description" => __("Path to image, which overrides the icon)", "js_composer")
		),
	),
) );

/* Testimonial
---------------------------------------------------------- */
vc_map( array(
	"name" => __("Testimonial", "js_composer"),
	"base" => "vc_testimonial",
	"icon" => "icon-wpb-ui-separator-label",
	"category" => __('Content', 'js_composer'),
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("Name", "js_composer"),
			"param_name" => "author",
			"value" => __("Name", "js_composer"),
			"description" => __("Enter the Name of the Person to quote", "js_composer")
		),
		array(
			"type" => "textfield",
			"heading" => __("Subtitle", "js_composer"),
			"param_name" => "company",
			"value" => '',
			"description" => __("Can be used for a job description", "js_composer")
		),
		array(
			"type" => "textarea",
			'admin_label' => true,
			"heading" => __("Quote", "js_composer"),
			"param_name" => "content",
			"value" => __("Text goes here", "js_composer"),
			"description" => ''
		),
	),
) );

/* Team Member
---------------------------------------------------------- */
vc_map( array(
	"name" => __("Team Member", "js_composer"),
	"base" => "vc_member",
	"icon" => "icon-wpb-ui-separator-label",
	"category" => __('Content', 'js_composer'),
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("Team Member Name", "js_composer"),
			"param_name" => "name",
			"holder" => "div",
			"value" => __("John Doe", "js_composer"),
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Team Member Role", "js_composer"),
			"param_name" => "role",
			"value" => '',
			"description" => ''
		),
		array(
			"type" => "attach_image",
			"heading" => __("Team Member Photo", "js_composer"),
			"param_name" => "img",
			"value" => "",
			"description" => __("Either upload a new, or choose an existing image from your media library", "js_composer")
		),
		array(
			"type" => "textarea",
			"heading" => __("Team Member Description (optional)", "js_composer"),
			"param_name" => "content",
			"value" => '',
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Link (optional)", "js_composer"),
			"param_name" => "link",
			"value" => "",
			"description" => '',
		),
		array(
			'type' => 'checkbox',
			'heading' => '',
			'param_name' => 'external',
			'value' => array( __( 'Open this link in a new tab', 'js_composer' ) => true ),
			"dependency" => Array('element' => "link", 'not_empty' => true),
		),
		array(
			"type" => "textfield",
			"heading" => __("Email (optional)", "js_composer"),
			"param_name" => "email",
			"value" => "",
			"description" => '',
		),
		array(
			"type" => "textfield",
			"heading" => __("Facebook profile (optional)", "js_composer"),
			"param_name" => "facebook",
			"value" => "",
			"description" => '',
		),
		array(
			"type" => "textfield",
			"heading" => __("Twitter profile (optional)", "js_composer"),
			"param_name" => "twitter",
			"value" => "",
			"description" => '',
		),
		array(
			"type" => "textfield",
			"heading" => __("Google+ profile (optional)", "js_composer"),
			"param_name" => "google_plus",
			"value" => "",
			"description" => '',
		),
		array(
			"type" => "textfield",
			"heading" => __("LinkedIn profile (optional)", "js_composer"),
			"param_name" => "linkedin",
			"value" => "",
			"description" => '',
		),
	),
) );

/* Portfolio
---------------------------------------------------------- */
vc_map( array(
	"name" => __("Portfolio", "js_composer"),
	"base" => "vc_portfolio",
	"icon" => "icon-wpb-ui-separator-label",
	"category" => __('Content', 'js_composer'),
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => __("Columns", "js_composer"),
			"param_name" => "columns",
			"value" => array('5 columns' => '5', '4 columns' => '4', '3 columns' => '3', '2 columns' => '2',),
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Items Quantity", "js_composer"),
			"param_name" => "items",
			"value" => '',
			"description" => __("If left blank, equals amount of Columns", "js_composer"),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Pagination', 'js_composer' ),
			'param_name' => 'pagination',
			'value' => array(
				__( 'No pagination', 'js_composer' ) => '',
				__( 'Regular pagination', 'js_composer' ) => 'regular',
				__( 'Ajax pagination (Load More button)', 'js_composer' ) => 'ajax',
			),
			'description' => ''
		),
		array(
			"type" => "dropdown",
			"heading" => __("Items Style", "js_composer"),
			"param_name" => "style",
			"value" => array(
				'Type 1' => 'type_1',
				'Type 2' => 'type_2',
				'Type 3' => 'type_3',
				'Type 4' => 'type_4',
				'Type 5' => 'type_5',
				'Type 6' => 'type_6',
				'Type 7' => 'type_7',
				'Type 8' => 'type_8',
				'Type 9' => 'type_9',
				'Type 10' => 'type_10',
				'Type 11' => 'type_11',
				'Type 12' => 'type_12',
				'Type 13' => 'type_13',
				'Type 14' => 'type_14',
				'Type 15' => 'type_15',
			),
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"heading" => __("Items Text Alignment", "js_composer"),
			"param_name" => "align",
			"value" => array(__('Align left', "js_composer") => "left", __('Align center', "js_composer") => "center", __('Align right', "js_composer") => "right"),
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"heading" => __("Items Ratio", "js_composer"),
			"param_name" => "ratio",
			"value" => array('3:2 (landscape)' => '3:2', '4:3 (landscape)' => '4:3', '1:1 (square)' => '1:1', '2:3 (portrait)' => '2:3', '3:4 (portrait)' => '3:4',),
			"description" => ''
		),
		array(
			"type" => 'checkbox',
			"heading" => __("Items Indents", "js_composer"),
			"param_name" => "with_indents",
			"description" => "",
			"value" => Array(__("Add indents between Items", "js_composer") => 'yes')
		),
		array(
			"type" => "dropdown",
			"heading" => __("Items Meta", "js_composer"),
			"param_name" => "meta",
			"value" => array(__('Do not show', "js_composer") => "", __('Show Item date', "js_composer") => "date", __('Show Item category', "js_composer") => "category"),
			"description" => ''
		),
		array(
			"type" => 'checkbox',
			"heading" => __("Filtering", "js_composer"),
			"param_name" => "filters",
			"description" => "",
			"value" => Array(__("Display bar with filtering by category", "js_composer") => 'yes')
		),
		array(
			"type" => "checkbox",
			"heading" => __("Display Items of selected categories", "js_composer"),
			"param_name" => "category",
			"value" => $portfolio_categories,
			"description" => ''
		),
	),

) );/* Blog
---------------------------------------------------------- */
vc_map( array(
	"name" => __("Blog", "js_composer"),
	"base" => "vc_blog",
	"icon" => "icon-wpb-ui-separator-label",
	"category" => __('Content', 'js_composer'),
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => __("Layout Type", "js_composer"),
			"param_name" => "type",
			"value" => array('Large Image' => 'large_image', 'Small Square Image' => 'small_square_image', 'Small Rounded Image' => 'small_circle_image', 'Masonry Grid' => 'masonry_paginated',),
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Posts Quantity", "js_composer"),
			"param_name" => "items",
			"value" => '',
			"description" => ''
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Pagination', 'js_composer' ),
			'param_name' => 'pagination',
			'value' => array(
				__( 'No pagination', 'js_composer' ) => '',
				__( 'Regular pagination', 'js_composer' ) => 'regular',
				__( 'Ajax pagination (Load More button)', 'js_composer' ) => 'ajax',
			),
			'description' => ''
		),
		array(
			"type" => 'checkbox',
			"heading" => __("Date", "js_composer"),
			"param_name" => "show_date",
			"description" => "",
			"value" => Array(__("Show Post Date", "js_composer") => 'yes')
		),
		array(
			"type" => 'checkbox',
			"heading" => __("Author", "js_composer"),
			"param_name" => "show_author",
			"description" => "",
			"value" => Array(__("Show Post Author", "js_composer") => 'yes')
		),
		array(
			"type" => 'checkbox',
			"heading" => __("Categories", "js_composer"),
			"param_name" => "show_categories",
			"description" => "",
			"value" => Array(__("Show Post Categories", "js_composer") => 'yes')
		),
		array(
			"type" => 'checkbox',
			"heading" => __("Tags", "js_composer"),
			"param_name" => "show_tags",
			"description" => "",
			"value" => Array(__("Show Post Tags", "js_composer") => 'yes')
		),
		array(
			"type" => 'checkbox',
			"heading" => __("Comments", "js_composer"),
			"param_name" => "show_comments",
			"description" => "",
			"value" => Array(__("Show Post Comments", "js_composer") => 'yes')
		),
		array(
			"type" => 'checkbox',
			"heading" => __("Read More", "js_composer"),
			"param_name" => "show_read_more",
			"description" => "",
			"value" => Array(__("Show Read More Buttons", "js_composer") => 'yes')
		),
		array(
			"type" => "dropdown",
			"heading" => __("Posts Content", "js_composer"),
			"param_name" => "post_content",
			"value" => array('Excerpt' => 'excerpt', 'Full Content of Post' => 'full', 'No Content' => 'none',),
			"description" => ''
		),
		array(
			"type" => "checkbox",
			"heading" => __("Display Posts of selected categories", "js_composer"),
			"param_name" => "category",
			"value" => $post_categories,
			"description" => ''
		),
	),

) );

/* Clients
---------------------------------------------------------- */
vc_map( array(
	"name" => __("Client Logos", "js_composer"),
	"base" => "vc_clients",
	"icon" => "icon-wpb-ui-separator-label",
	"category" => __('Content', 'js_composer'),
	"params" => array(
		array(
			"type" => 'checkbox',
			"heading" => __("Auto Rotation", "js_composer"),
			"param_name" => "auto_scroll",
			"value" => Array(__("Enable Auto Rotation", "js_composer") => 'yes')
		),
		array(
			"type" => "textfield",
			"heading" => __("Auto Rotation Interval", "js_composer"),
			"param_name" => "interval",
			"value" => 1,
			"description" => 'Interval in seconds for Auto Rotation',
			"dependency" => Array('element' => "auto_scroll", 'not_empty' => true),
		),
		array(
			"type" => 'checkbox',
			"heading" => __("Arrows", "js_composer"),
			"param_name" => "arrows",
			"value" => Array(__("Show Navigation Arrows", "js_composer") => 'yes')
		),
		array(
			"type" => "dropdown",
			"heading" => __("Quantity of displayed logos", "js_composer"),
			"param_name" => "columns",
			"value" => array('5 items' => '5', '4 items' => '4', '3 items' => '3', '2 items' => '2', '1 item' => '1',),
			"description" => ''
		),
		array(
			"type" => 'checkbox',
			"heading" => __("Indents", "js_composer"),
			"param_name" => "indents",
			"value" => Array(__(" Add indents around logo images", "js_composer") => 'yes')
		),
	),

) );

/* ActionBox
---------------------------------------------------------- */
vc_map( array(
	"name" => __("ActionBox", "js_composer"),
	"base" => "vc_actionbox",
	"icon" => "icon-wpb-ui-separator-label",
	"category" => __('Content', 'js_composer'),
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => __("ActionBox Color", "js_composer"),
			"param_name" => "type",
			"value" => array(__('Primary Color', "js_composer") => "primary", __('Secondary Color', "js_composer") => "secondary", __('Alternate Color', "js_composer") => "alternate",),
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("ActionBox Title", "js_composer"),
			"param_name" => "title",
			"holder" => "div",
			"value" => __("This is ActionBox", "js_composer"),
			"description" => ''
		),
		array(
			"type" => "textarea",
//			'admin_label' => true,
			"heading" => __("ActionBox Text", "js_composer"),
			"param_name" => "message",
			"value" => '',
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Button 1 Label", "js_composer"),
			"param_name" => "button1",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Button 1 Link", "js_composer"),
			"param_name" => "link1",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"heading" => __("Button 1 Color", "js_composer"),
			"param_name" => "style1",
			"value" => array(__("Primary (theme color)", "js_composer") => "primary", __("Secondary (theme color)", "js_composer") => "secondary", __("Contrast (theme color)", "js_composer") => "contrast", __("Faded (theme color)", "js_composer") => "default", __("White", "js_composer") => "white", __("Pink", "js_composer") => "pink", __("Blue", "js_composer") => "blue", __("Green", "js_composer") => "green", __("Yellow", "js_composer") => "yellow", __("Purple", "js_composer") => "purple", __("Red", "js_composer") => "red", __("Lime", "js_composer") => "lime", __("Navy", "js_composer") => "navy", __("Cream", "js_composer") => "cream", __("Brown", "js_composer") => "brown", __("Midnight", "js_composer") => "midnight", __("Teal", "js_composer") => "teal", __("Transparent", "js_composer") => "transparent"),
			"description" => '',
		),
		array(
			"type" => 'checkbox',
			"heading" => __("Button 1 Outlined", "js_composer"),
			"param_name" => "outlined1",
//      "description" => __("Select checkbox to allow for all sections to be be collapsible.", "js_composer"),
			"value" => Array(__("Apply Outlined Style to the Button", "js_composer") => 'yes')
		),
		array(
			"type" => "dropdown",
			"heading" => __("Button 1 Size", "js_composer"),
			"param_name" => "size1",
			"value" => array(__("Normal", "js_composer") => "", __("Small", "js_composer") => "small", __("Big", "js_composer") => "big"),

		),
		array(
			"type" => "textfield",
			"heading" => __("Button 1 Icon (optional)", "js_composer"),
			"param_name" => "icon1",
			"description" => sprintf(__('FontAwesome Icon name. %s', "js_composer"), '<a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">Full list of icons</a>')
		),
		array(
			"type" => "dropdown",
			"heading" => __("Button 1 Target", "js_composer"),
			"param_name" => "target1",
			"value" => $target_arr,
		),
		array(
			"type" => "textfield",
			"heading" => __("Button 2 Label", "js_composer"),
			"param_name" => "button2",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Button 2 Link", "js_composer"),
			"param_name" => "link2",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"heading" => __("Button 2 Color", "js_composer"),
			"param_name" => "style2",
			"value" => array(__("Primary (theme color)", "js_composer") => "primary", __("Secondary (theme color)", "js_composer") => "secondary", __("Contrast (theme color)", "js_composer") => "contrast", __("Faded (theme color)", "js_composer") => "default", __("White", "js_composer") => "white", __("Pink", "js_composer") => "pink", __("Blue", "js_composer") => "blue", __("Green", "js_composer") => "green", __("Yellow", "js_composer") => "yellow", __("Purple", "js_composer") => "purple", __("Red", "js_composer") => "red", __("Lime", "js_composer") => "lime", __("Navy", "js_composer") => "navy", __("Cream", "js_composer") => "cream", __("Brown", "js_composer") => "brown", __("Midnight", "js_composer") => "midnight", __("Teal", "js_composer") => "teal", __("Transparent", "js_composer") => "transparent"),
			"description" => '',
		),
		array(
			"type" => 'checkbox',
			"heading" => __("Button 2 Outlined", "js_composer"),
			"param_name" => "outlined2",
//      "description" => __("Select checkbox to allow for all sections to be be collapsible.", "js_composer"),
			"value" => Array(__("Apply Outlined Style to the Button", "js_composer") => 'yes')
		),
		array(
			"type" => "dropdown",
			"heading" => __("Button 2 Size", "js_composer"),
			"param_name" => "size2",
			"value" => array(__("Normal", "js_composer") => "", __("Small", "js_composer") => "small", __("Big", "js_composer") => "big"),

		),
		array(
			"type" => "textfield",
			"heading" => __("Button 2 Icon (optional)", "js_composer"),
			"param_name" => "icon2",
			"description" => sprintf(__('FontAwesome Icon name. %s', "js_composer"), '<a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">Full list of icons</a>')
		),
		array(
			"type" => "dropdown",
			"heading" => __("Button 2 Target", "js_composer"),
			"param_name" => "target2",
			"value" => $target_arr,
		),
	),
) );

/* Video element
---------------------------------------------------------- */
vc_map( array(
	"name" => __("Video Player", "js_composer"),
	"base" => "vc_video",
	"icon" => "icon-wpb-film-youtube",
	"category" => __('Content', 'js_composer'),
	"params" => array(

		array(
			"type" => "textfield",
			"heading" => __("Video link", "js_composer"),
			"param_name" => "link",
			"admin_label" => true,
			"description" => sprintf(__('Link to the video. More about supported formats at %s.', "js_composer"), '<a href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank">WordPress codex page</a>')
		),
		array(
			"type" => "dropdown",
			"heading" => __("Ratio", "js_composer"),
			"param_name" => "ratio",
			"value" => array('16x9' => "16-9", '4x3' => "4-3", '3x2' => "3-2", '1x1' => "1-1", ),
			"description" => ''
		),

	)
) );

/* Message box
---------------------------------------------------------- */
vc_map( array(
	"name" => __("Message Box", "js_composer"),
	"base" => "vc_message",
	"icon" => "icon-wpb-information-white",
	"wrapper_class" => "alert",
	"category" => __('Content', 'js_composer'),
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => __("Message Box Color", "js_composer"),
			"param_name" => "color",
			"value" => array(__('Notification (blue)', "js_composer") => "info", __('Attention (yellow)', "js_composer") => "attention", __('Success (green)', "js_composer") => "success", __('Error (red)', "js_composer") => "error"),
			"description" => ''
		),
		array(
			"type" => "textarea",
			"holder" => "div",
			"class" => "content",
			"heading" => __("Message Text", "js_composer"),
			"param_name" => "content",
			"value" => __("I am message box. Click edit button to change this text.", "js_composer")
		),
	),
	"js_view" => 'VcMessageView'
) );



/* Button
---------------------------------------------------------- */
$icons_arr = array(
	__("None", "js_composer") => "none",
	__("Address book icon", "js_composer") => "wpb_address_book",
	__("Alarm clock icon", "js_composer") => "wpb_alarm_clock",
	__("Anchor icon", "js_composer") => "wpb_anchor",
	__("Application Image icon", "js_composer") => "wpb_application_image",
	__("Arrow icon", "js_composer") => "wpb_arrow",
	__("Asterisk icon", "js_composer") => "wpb_asterisk",
	__("Hammer icon", "js_composer") => "wpb_hammer",
	__("Balloon icon", "js_composer") => "wpb_balloon",
	__("Balloon Buzz icon", "js_composer") => "wpb_balloon_buzz",
	__("Balloon Facebook icon", "js_composer") => "wpb_balloon_facebook",
	__("Balloon Twitter icon", "js_composer") => "wpb_balloon_twitter",
	__("Battery icon", "js_composer") => "wpb_battery",
	__("Binocular icon", "js_composer") => "wpb_binocular",
	__("Document Excel icon", "js_composer") => "wpb_document_excel",
	__("Document Image icon", "js_composer") => "wpb_document_image",
	__("Document Music icon", "js_composer") => "wpb_document_music",
	__("Document Office icon", "js_composer") => "wpb_document_office",
	__("Document PDF icon", "js_composer") => "wpb_document_pdf",
	__("Document Powerpoint icon", "js_composer") => "wpb_document_powerpoint",
	__("Document Word icon", "js_composer") => "wpb_document_word",
	__("Bookmark icon", "js_composer") => "wpb_bookmark",
	__("Camcorder icon", "js_composer") => "wpb_camcorder",
	__("Camera icon", "js_composer") => "wpb_camera",
	__("Chart icon", "js_composer") => "wpb_chart",
	__("Chart pie icon", "js_composer") => "wpb_chart_pie",
	__("Clock icon", "js_composer") => "wpb_clock",
	__("Fire icon", "js_composer") => "wpb_fire",
	__("Heart icon", "js_composer") => "wpb_heart",
	__("Mail icon", "js_composer") => "wpb_mail",
	__("Play icon", "js_composer") => "wpb_play",
	__("Shield icon", "js_composer") => "wpb_shield",
	__("Video icon", "js_composer") => "wpb_video"
);



/* Counter
---------------------------------------------------------- */
vc_map( array(
	"name"		=> __("Counter", "js_composer"),
	"base"		=> "vc_counter",
	'icon'		=> 'icon-wpb-ui-separator',
	"category"  => __('Content', 'js_composer'),
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("The initial number value", "js_composer"),
			"param_name" => "number",
			"value" => "0",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("The final number value", "js_composer"),
			"param_name" => "count",
			"value" => "99",
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"heading" => __("Number Color", "js_composer"),
			"param_name" => "color",
			"value" => array(__("Default (theme color)", "js_composer") => "", __("Primary (theme color)", "js_composer") => "primary", __("Secondary (theme color)", "js_composer") => "secondary",),
			"description" => '',
		),
		array(
			"type" => "textfield",
			"heading" => __("Title for Counter", "js_composer"),
			"param_name" => "title",
			"value" => "Projects completed",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Prefix (optional)", "js_composer"),
			"param_name" => "prefix",
			"value" => "",
			"description" => 'Text before number'
		),
		array(
			"type" => "textfield",
			"heading" => __("Suffix (optional)", "js_composer"),
			"param_name" => "suffix",
			"value" => "",
			"description" => 'Text after number'
		),
	),
) );


/* Contact form
---------------------------------------------------------- */
vc_map( array(
	"name"		=> __("Contact Form", "js_composer"),
	"base"		=> "vc_contact_form",
	'icon'		=> 'icon-wpb-ui-separator',
	"category"  => __('Content', 'js_composer'),
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("Reciever Email", "js_composer"),
			"param_name" => "form_email",
			"value" => "",
			"description" => sprintf(__('Contact requests will be sent to this Email.', "js_composer"))
		),
		array(
			"type" => "dropdown",
			"heading" => __("Name Field State", "js_composer"),
			"param_name" => "form_name_field",
			"value" => array(__('Shown, required', "js_composer") => "required", __('Shown, not required', "js_composer") => "show", __('Hidden', "js_composer") => "not_show"),
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"heading" => __("Email Field State", "js_composer"),
			"param_name" => "form_email_field",
			"value" => array(__('Shown, required', "js_composer") => "required", __('Shown, not required', "js_composer") => "show", __('Hidden', "js_composer") => "not_show"),
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"heading" => __("Phone Field State", "js_composer"),
			"param_name" => "form_phone_field",
			"value" => array(__('Shown, required', "js_composer") => "required", __('Shown, not required', "js_composer") => "show", __('Hidden', "js_composer") => "not_show"),
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"heading" => __("Message Field State", "js_composer"),
			"param_name" => "form_message_field",
			"value" => array(__('Shown, required', "js_composer") => "required", __('Shown, not required', "js_composer") => "show", __('Hidden', "js_composer") => "not_show"),
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"heading" => __("Captcha", "js_composer"),
			"param_name" => "form_captcha",
			"value" => array(__('Don\'t Display Captcha', "js_composer") => "", __('Display Captcha', "js_composer") => "show"),
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"heading" => __("Button Color", "js_composer"),
			"param_name" => "button_color",
			"value" => array(__("Primary (theme color)", "js_composer") => "primary", __("Secondary (theme color)", "js_composer") => "secondary", __("Contrast (theme color)", "js_composer") => "contrast", __("Faded (theme color)", "js_composer") => "default", __("White", "js_composer") => "white", __("Pink", "js_composer") => "pink", __("Blue", "js_composer") => "blue", __("Green", "js_composer") => "green", __("Yellow", "js_composer") => "yellow", __("Purple", "js_composer") => "purple", __("Red", "js_composer") => "red", __("Lime", "js_composer") => "lime", __("Navy", "js_composer") => "navy", __("Cream", "js_composer") => "cream", __("Brown", "js_composer") => "brown", __("Midnight", "js_composer") => "midnight", __("Teal", "js_composer") => "teal", __("Transparent", "js_composer") => "transparent"),
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"heading" => __("Button Alignment", "js_composer"),
			"param_name" => "button_align",
			"value" => array(__('Align left', "js_composer") => "left", __('Align center', "js_composer") => "center", __('Align right', "js_composer") => "right"),
			"description" => ''
		),
		array(
			"type" => 'checkbox',
			"heading" => __("Outlined Button", "js_composer"),
			"param_name" => "button_outlined",
			"value" => Array(__("Apply Outlined Style to the Button", "js_composer") => 'yes'),
			"description" => ''
		),
	),
) );



/* Contacts
---------------------------------------------------------- */
vc_map( array(
	"name"		=> __("Contacts", "js_composer"),
	"base"		=> "vc_contacts",
	'icon'		=> 'icon-wpb-ui-separator',
	"category"  => __('Content', 'js_composer'),
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("Address", "js_composer"),
			"param_name" => "address",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Phone", "js_composer"),
			"param_name" => "phone",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Fax", "js_composer"),
			"param_name" => "fax",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Email", "js_composer"),
			"param_name" => "email",
			"value" => "",
			"description" => ''
		),
	),
) );

/* Social Links
---------------------------------------------------------- */
vc_map( array(
	"name"		=> __("Social Links", "js_composer"),
	"base"		=> "vc_social_links",
	'icon'		=> 'icon-wpb-ui-separator',
	"category"  => __('Content', 'js_composer'),
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => __("Icons Size", "js_composer"),
			"param_name" => "size",
			"value" => array(__('Small', "js_composer") => "", __('Normal', "js_composer") => "normal", __('Big', "js_composer") => "big"),
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"heading" => __("Alignment", "js_composer"),
			"param_name" => "align",
			"value" => array(__('Align left', "js_composer") => "left", __('Align center', "js_composer") => "center", __('Align right', "js_composer") => "right"),
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Email", "js_composer"),
			"param_name" => "email",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Facebook", "js_composer"),
			"param_name" => "facebook",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Twitter", "js_composer"),
			"param_name" => "twitter",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Google+", "js_composer"),
			"param_name" => "google",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("LinkedIn", "js_composer"),
			"param_name" => "linkedin",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("YouTube", "js_composer"),
			"param_name" => "youtube",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Vimeo", "js_composer"),
			"param_name" => "vimeo",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Flickr", "js_composer"),
			"param_name" => "flickr",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Instagram", "js_composer"),
			"param_name" => "instagram",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Behance", "js_composer"),
			"param_name" => "behance",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Xing", "js_composer"),
			"param_name" => "xing",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Pinterest", "js_composer"),
			"param_name" => "pinterest",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Skype", "js_composer"),
			"param_name" => "skype",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Tumblr", "js_composer"),
			"param_name" => "tumblr",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Dribbble", "js_composer"),
			"param_name" => "dribbble",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Vkontakte", "js_composer"),
			"param_name" => "vk",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("SoundCloud", "js_composer"),
			"param_name" => "soundcloud",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Yelp", "js_composer"),
			"param_name" => "yelp",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Twitch", "js_composer"),
			"param_name" => "twitch",
			"value" => "",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("RSS", "js_composer"),
			"param_name" => "rss",
			"value" => "",
			"description" => ''
		),
	),
) );

/* Google maps element
---------------------------------------------------------- */
vc_map( array(
	"name" => __("Google Maps", "js_composer"),
	"base" => "vc_gmaps",
	"icon" => "icon-wpb-map-pin",
	"category" => __('Content', 'js_composer'),
	"params" => array(
		array(
			"type" => "textfield",
			"heading" => __("Address", "js_composer"),
			"holder" => "div",
			"param_name" => "address",
			"value" => "1600 Amphitheatre Parkway, Mountain View, CA 94043, United States",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Marker text", "js_composer"),
			"param_name" => "marker",
			"edit_field_class" => "vc_col-sm-6 vc_column",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Map height", "js_composer"),
			"param_name" => "height",
			"value" => "400",
			"edit_field_class" => "vc_col-sm-6 vc_column",
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"heading" => __("Map type", "js_composer"),
			"param_name" => "type",
			"value" => array(__("Roadmap", "js_composer") => "ROADMAP", __("Satellite", "js_composer") => "SATELLITE", __("Map + Terrain", "js_composer") => "HYBRID", __("Terrain", "js_composer") => "TERRAIN"),
			"edit_field_class" => "vc_col-sm-6 vc_column",
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"heading" => __("Map zoom", "js_composer"),
			"param_name" => "zoom",
			"value" => array(
				__("14 (default)", "js_composer") => '',
				' 1' => '1',
				' 2' => '2',
				' 3' => '3',
				' 4' => '4',
				' 5' => '5',
				' 6' => '6',
				' 7' => '7',
				' 8' => '8',
				' 9' => '9',
				' 10' => '10',
				' 11' => '11',
				' 12' => '12',
				' 13' => '13',
				' 15' => '15',
				' 16' => '16',
				' 17' => '17',
				' 18' => '18',
				' 19' => '19',
				' 20' => '20'),
			"edit_field_class" => "vc_col-sm-6 vc_column",
			"description" => ''
		),
		array(
			"type" => "textfield",
			"heading" => __("Map Latitude (optional)", "js_composer"),
			"param_name" => "latitude",
			"edit_field_class" => "vc_col-sm-6 vc_column",
			"description" => __("If Longitude and Latitude are set, they override the Address for Google Map.", "js_composer"),
		),
		array(
			"type" => "textfield",
			"heading" => __("Map Longitude (optional)", "js_composer"),
			"param_name" => "longitude",
			"edit_field_class" => "vc_col-sm-6 vc_column",
			"description" => __("If Longitude and Latitude are set, they override the Address for Google Map.", "js_composer"),
		),
		array(
			"type" => "attach_image",
			"heading" => __("Custom Marker Image", "js_composer"),
			"param_name" => "custom_marker_img",
			"description" => 'Image should NOT be bigger then 80x80 px'
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Custom Marker Size', 'js_composer' ),
			'param_name' => 'custom_marker_size',
			'value' => array(
				__( '20x20', 'js_composer' ) => '20',
				__( '30x30', 'js_composer' ) => '30',
				__( '40x40', 'js_composer' ) => '40',
				__( '50x50', 'js_composer' ) => '50',
				__( '60x60', 'js_composer' ) => '60',
				__( '70x70', 'js_composer' ) => '70',
				__( '80x80', 'js_composer' ) => '80',
			),
			"dependency" => Array('element' => "custom_marker_img", 'not_empty' => true),
			'description' => ''
		),
		array(
			"type" => "checkbox",
			"heading" => __("Additional Markers", "js_composer"),
			"param_name" => "add_markers",
			"value" => array(__("Add more Markers to the map", "js_composer") => "yes"),
			"description" => ''
		),

		array(
			"type" => "textfield",
			"heading" => __("Marker 2 address", "js_composer"),
			"param_name" => "marker_2_address",
			"edit_field_class" => "vc_col-sm-6 vc_column",
			"description" => '',
			"dependency" => Array('element' => "add_markers", 'not_empty' => true),
		),
		array(
			"type" => "textfield",
			"heading" => __("Marker 2 text", "js_composer"),
			"param_name" => "marker_2",
			"edit_field_class" => "vc_col-sm-6 vc_column",
			"description" => '',
			"dependency" => Array('element' => "add_markers", 'not_empty' => true),
		),

		array(
			"type" => "textfield",
			"heading" => __("Marker 3 address", "js_composer"),
			"param_name" => "marker_3_address",
			"edit_field_class" => "vc_col-sm-6 vc_column",
			"description" => '',
			"dependency" => Array('element' => "add_markers", 'not_empty' => true),
		),
		array(
			"type" => "textfield",
			"heading" => __("Marker 3 text", "js_composer"),
			"param_name" => "marker_3",
			"edit_field_class" => "vc_col-sm-6 vc_column",
			"description" => '',
			"dependency" => Array('element' => "add_markers", 'not_empty' => true),
		),

		array(
			"type" => "textfield",
			"heading" => __("Marker 4 address", "js_composer"),
			"param_name" => "marker_4_address",
			"edit_field_class" => "vc_col-sm-6 vc_column",
			"description" => '',
			"dependency" => Array('element' => "add_markers", 'not_empty' => true),
		),
		array(
			"type" => "textfield",
			"heading" => __("Marker 4 text", "js_composer"),
			"param_name" => "marker_4",
			"edit_field_class" => "vc_col-sm-6 vc_column",
			"description" => '',
			"dependency" => Array('element' => "add_markers", 'not_empty' => true),
		),

		array(
			"type" => "textfield",
			"heading" => __("Marker 5 address", "js_composer"),
			"param_name" => "marker_5_address",
			"edit_field_class" => "vc_col-sm-6 vc_column",
			"description" => '',
			"dependency" => Array('element' => "add_markers", 'not_empty' => true),
		),
		array(
			"type" => "textfield",
			"heading" => __("Marker 5 text", "js_composer"),
			"param_name" => "marker_5",
			"edit_field_class" => "vc_col-sm-6 vc_column",
			"description" => '',
			"dependency" => Array('element' => "add_markers", 'not_empty' => true),
		),
	)
) );

/* Latest posts
---------------------------------------------------------- */
vc_map( array(
	"name" => __("Latest Posts", "js_composer"),
	"base" => "vc_latest_posts",
	"icon" => "icon-wpb-ui-separator-label",
	"category" => __('Content', 'js_composer'),
	"params" => array(
		array(
			"type" => "dropdown",
			"heading" => __("Posts Number", "js_composer"),
			"param_name" => "posts",
			"value" => array(2 => 2, 1 =>1, 3 =>3,),
			"description" => ''
		),
		array(
			"type" => "dropdown",
			"heading" => __("Caregory", "js_composer"),
			"param_name" => "category",
			"value" => $post_categories,
			"description" => ''
		),
	),

) );

/* Raw HTML
---------------------------------------------------------- */
vc_map( array(
	'name' => __( 'Raw HTML', 'js_composer' ),
	'base' => 'vc_raw_html',
	'icon' => 'icon-wpb-raw-html',
	'category' => __( 'Structure', 'js_composer' ),
	'wrapper_class' => 'clearfix',
	'description' => __( 'Output raw html code on your page', 'js_composer' ),
	'params' => array(
		array(
			'type' => 'textarea_raw_html',
			'holder' => 'div',
			'heading' => __( 'Raw HTML', 'js_composer' ),
			'param_name' => 'content',
			'value' => base64_encode( '<p>I am raw html block.<br/>Click edit button to change this html</p>' ),
			'description' => __( 'Enter your HTML content.', 'js_composer' )
		),
	)
) );

/* Raw JS
---------------------------------------------------------- */
vc_map( array(
	'name' => __( 'Raw JS', 'js_composer' ),
	'base' => 'vc_raw_js',
	'icon' => 'icon-wpb-raw-javascript',
	'category' => __( 'Structure', 'js_composer' ),
	'wrapper_class' => 'clearfix',
	'description' => __( 'Output raw javascript code on your page', 'js_composer' ),
	'params' => array(
		array(
			'type' => 'textarea_raw_html',
			'holder' => 'div',
			'heading' => __( 'Raw js', 'js_composer' ),
			'param_name' => 'content',
			'value' => __( base64_encode( '<script type="text/javascript"> alert("Enter your js here!" ); </script>' ), 'js_composer' ),
			'description' => __( 'Enter your JS code.', 'js_composer' )
		),
	)
) );

/* Message box
---------------------------------------------------------- */
//vc_map( array(
//	'name' => __( 'Message Box', 'js_composer' ),
//	'base' => 'vc_message',
//	'icon' => 'icon-wpb-information-white',
//	'wrapper_class' => 'alert',
//	'category' => __( 'Content', 'js_composer' ),
//	'description' => __( 'Notification box', 'js_composer' ),
//	'params' => array(
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Message box type', 'js_composer' ),
//			'param_name' => 'color',
//			'value' => array(
//				__( 'Informational', 'js_composer' ) => 'alert-info',
//				__( 'Warning', 'js_composer' ) => 'alert-warning',
//				__( 'Success', 'js_composer' ) => 'alert-success',
//				__( 'Error', 'js_composer' ) => "alert-danger"
//			),
//			'description' => __( 'Select message type.', 'js_composer' )
//		),
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Style', 'js_composer' ),
//			'param_name' => 'style',
//			'value' => getVcShared( 'alert styles' ),
//			'description' => __( 'Alert style.', 'js_composer' )
//		),
//		array(
//			'type' => 'textarea_html',
//			'holder' => 'div',
//			'class' => 'messagebox_text',
//			'heading' => __( 'Message text', 'js_composer' ),
//			'param_name' => 'content',
//			'value' => __( '<p>I am message box. Click edit button to change this text.</p>', 'js_composer' )
//		),
//		$add_css_animation,
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'Extra class name', 'js_composer' ),
//			'param_name' => 'el_class',
//			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
//		)
//	),
//	'js_view' => 'VcMessageView'
//) );

/* Facebook like button
---------------------------------------------------------- */
//vc_map( array(
//	'name' => __( 'Facebook Like', 'js_composer' ),
//	'base' => 'vc_facebook',
//	'icon' => 'icon-wpb-balloon-facebook-left',
//	'category' => __( 'Social', 'js_composer' ),
//	'description' => __( 'Facebook like button', 'js_composer' ),
//	'params' => array(
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Button type', 'js_composer' ),
//			'param_name' => 'type',
//			'admin_label' => true,
//			'value' => array(
//				__( 'Standard', 'js_composer' ) => 'standard',
//				__( 'Button count', 'js_composer' ) => 'button_count',
//				__( 'Box count', 'js_composer' ) => 'box_count'
//			),
//			'description' => __( 'Select button type.', 'js_composer' )
//		)
//	)
//) );

/* Tweetmeme button
---------------------------------------------------------- */
//vc_map( array(
//	'name' => __( 'Tweetmeme Button', 'js_composer' ),
//	'base' => 'vc_tweetmeme',
//	'icon' => 'icon-wpb-tweetme',
//	'category' => __( 'Social', 'js_composer' ),
//	'description' => __( 'Share on twitter button', 'js_composer' ),
//	'params' => array(
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Button type', 'js_composer' ),
//			'param_name' => 'type',
//			'admin_label' => true,
//			'value' => array(
//				__( 'Horizontal', 'js_composer' ) => 'horizontal',
//				__( 'Vertical', 'js_composer' ) => 'vertical',
//				__( 'None', 'js_composer' ) => 'none'
//			),
//			'description' => __( 'Select button type.', 'js_composer' )
//		)
//	)
//) );

/* Google+ button
---------------------------------------------------------- */
//vc_map( array(
//	'name' => __( 'Google+ Button', 'js_composer' ),
//	'base' => 'vc_googleplus',
//	'icon' => 'icon-wpb-application-plus',
//	'category' => __( 'Social', 'js_composer' ),
//	'description' => __( 'Recommend on Google', 'js_composer' ),
//	'params' => array(
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Button size', 'js_composer' ),
//			'param_name' => 'type',
//			'admin_label' => true,
//			'value' => array(
//				__( 'Standard', 'js_composer' ) => '',
//				__( 'Small', 'js_composer' ) => 'small',
//				__( 'Medium', 'js_composer' ) => 'medium',
//				__( 'Tall', 'js_composer' ) => 'tall'
//			),
//			'description' => __( 'Select button size.', 'js_composer' )
//		),
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Annotation', 'js_composer' ),
//			'param_name' => 'annotation',
//			'admin_label' => true,
//			'value' => array(
//				__( 'Inline', 'js_composer' ) => 'inline',
//				__( 'Bubble', 'js_composer' ) => '',
//				__( 'None', 'js_composer' ) => 'none'
//			),
//			'description' => __( 'Select type of annotation', 'js_composer' )
//		)
//	)
//) );

/* Pinterest button
---------------------------------------------------------- */
//vc_map( array(
//	'name' => __( 'Pinterest', 'js_composer' ),
//	'base' => 'vc_pinterest',
//	'icon' => 'icon-wpb-pinterest',
//	'category' => __( 'Social', 'js_composer' ),
//	'description' => __( 'Pinterest button', 'js_composer' ),
//	"params" => array(
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Button layout', 'js_composer' ),
//			'param_name' => 'type',
//			'admin_label' => true,
//			'value' => array(
//				__( 'Horizontal', 'js_composer' ) => '',
//				__( 'Vertical', 'js_composer' ) => 'vertical',
//				__( 'No count', 'js_composer' ) => 'none' ),
//			'description' => __( 'Select button layout.', 'js_composer' )
//		)
//	)
//) );

/* Toggle (FAQ)
---------------------------------------------------------- */
//vc_map( array(
//	'name' => __( 'FAQ', 'js_composer' ),
//	'base' => 'vc_toggle',
//	'icon' => 'icon-wpb-toggle-small-expand',
//	'category' => __( 'Content', 'js_composer' ),
//	'description' => __( 'Toggle element for Q&A block', 'js_composer' ),
//	'params' => array(
//		array(
//			'type' => 'textfield',
//			'holder' => 'h4',
//			'class' => 'toggle_title',
//			'heading' => __( 'Toggle title', 'js_composer' ),
//			'param_name' => 'title',
//			'value' => __( 'Toggle title', 'js_composer' ),
//			'description' => __( 'Toggle block title.', 'js_composer' )
//		),
//		array(
//			'type' => 'textarea_html',
//			'holder' => 'div',
//			'class' => 'toggle_content',
//			'heading' => __( 'Toggle content', 'js_composer' ),
//			'param_name' => 'content',
//			'value' => __( '<p>Toggle content goes here, click edit button to change this text.</p>', 'js_composer' ),
//			'description' => __( 'Toggle block content.', 'js_composer' )
//		),
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Default state', 'js_composer' ),
//			'param_name' => 'open',
//			'value' => array(
//				__( 'Closed', 'js_composer' ) => 'false',
//				__( 'Open', 'js_composer' ) => 'true'
//			),
//			'description' => __( 'Select "Open" if you want toggle to be open by default.', 'js_composer' )
//		),
//		$add_css_animation,
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'Extra class name', 'js_composer' ),
//			'param_name' => 'el_class',
//			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
//		)
//	),
//	'js_view' => 'VcToggleView'
//) );




/* Image Carousel
---------------------------------------------------------- */
//vc_map( array(
//	'name' => __( 'Image Carousel', 'js_composer' ),
//	'base' => 'vc_images_carousel',
//	'icon' => 'icon-wpb-images-carousel',
//	'category' => __( 'Content', 'js_composer' ),
//	'description' => __( 'Animated carousel with images', 'js_composer' ),
//	'params' => array(
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'Widget title', 'js_composer' ),
//			'param_name' => 'title',
//			'description' => __( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'js_composer' )
//		),
//		array(
//			'type' => 'attach_images',
//			'heading' => __( 'Images', 'js_composer' ),
//			'param_name' => 'images',
//			'value' => '',
//			'description' => __( 'Select images from media library.', 'js_composer' )
//		),
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'Image size', 'js_composer' ),
//			'param_name' => 'img_size',
//			'description' => __( 'Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'js_composer' )
//		),
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'On click', 'js_composer' ),
//			'param_name' => 'onclick',
//			'value' => array(
//				__( 'Open prettyPhoto', 'js_composer' ) => 'link_image',
//				__( 'Do nothing', 'js_composer' ) => 'link_no',
//				__( 'Open custom link', 'js_composer' ) => 'custom_link'
//			),
//			'description' => __( 'What to do when slide is clicked?', 'js_composer' )
//		),
//		array(
//			'type' => 'exploded_textarea',
//			'heading' => __( 'Custom links', 'js_composer' ),
//			'param_name' => 'custom_links',
//			'description' => __( 'Enter links for each slide here. Divide links with linebreaks (Enter) . ', 'js_composer' ),
//			'dependency' => array(
//				'element' => 'onclick',
//				'value' => array( 'custom_link' )
//			)
//		),
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Custom link target', 'js_composer' ),
//			'param_name' => 'custom_links_target',
//			'description' => __( 'Select where to open  custom links.', 'js_composer' ),
//			'dependency' => array(
//				'element' => 'onclick',
//				'value' => array( 'custom_link' )
//			),
//			'value' => $target_arr
//		),
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Slider mode', 'js_composer' ),
//			'param_name' => 'mode',
//			'value' => array(
//				__( 'Horizontal', 'js_composer' ) => 'horizontal',
//				__( 'Vertical', 'js_composer' ) => 'vertical'
//			),
//			'description' => __( 'Slides will be positioned horizontally (for horizontal swipes) or vertically (for vertical swipes)', 'js_composer' )
//		),
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'Slider speed', 'js_composer' ),
//			'param_name' => 'speed',
//			'value' => '5000',
//			'description' => __( 'Duration of animation between slides (in ms)', 'js_composer' )
//		),
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'Slides per view', 'js_composer' ),
//			'param_name' => 'slides_per_view',
//			'value' => '1',
//			'description' => __( 'Set numbers of slides you want to display at the same time on slider\'s container for carousel mode. Supports also "auto" value, in this case it will fit slides depending on container\'s width. "auto" mode isn\'t compatible with loop mode.', 'js_composer' )
//		),
//		array(
//			'type' => 'checkbox',
//			'heading' => __( 'Slider autoplay', 'js_composer' ),
//			'param_name' => 'autoplay',
//			'description' => __( 'Enables autoplay mode.', 'js_composer' ),
//			'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes' )
//		),
//		array(
//			'type' => 'checkbox',
//			'heading' => __( 'Hide pagination control', 'js_composer' ),
//			'param_name' => 'hide_pagination_control',
//			'description' => __( 'If YES pagination control will be removed.', 'js_composer' ),
//			'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes' )
//		),
//		array(
//			'type' => 'checkbox',
//			'heading' => __( 'Hide prev/next buttons', 'js_composer' ),
//			'param_name' => 'hide_prev_next_buttons',
//			'description' => __( 'If "YES" prev/next control will be removed.', 'js_composer' ),
//			'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes' )
//		),
//		array(
//			'type' => 'checkbox',
//			'heading' => __( 'Partial view', 'js_composer' ),
//			'param_name' => 'partial_view',
//			'description' => __( 'If "YES" part of the next slide will be visible on the right side.', 'js_composer' ),
//			'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes' )
//		),
//		array(
//			'type' => 'checkbox',
//			'heading' => __( 'Slider loop', 'js_composer' ),
//			'param_name' => 'wrap',
//			'description' => __( 'Enables loop mode.', 'js_composer' ),
//			'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes' )
//		),
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'Extra class name', 'js_composer' ),
//			'param_name' => 'el_class',
//			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
//		)
//	)
//) );



/* Teaser grid
* @deprecated please use vc_posts_grid
---------------------------------------------------------- */
vc_map( array(
	'name' => __( 'Teaser (posts) Grid', 'js_composer' ),
	'base' => 'vc_teaser_grid',
	'content_element' => false,
	'icon' => 'icon-wpb-application-icon-large',
	'category' => __( 'Content', 'js_composer' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Widget title', 'js_composer' ),
			'param_name' => 'title',
			'description' => __( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'js_composer' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Columns count', 'js_composer' ),
			'param_name' => 'grid_columns_count',
			'value' => array( 4, 3, 2, 1 ),
			'admin_label' => true,
			'description' => __( 'Select columns count.', 'js_composer' )
		),
		array(
			'type' => 'posttypes',
			'heading' => __( 'Post types', 'js_composer' ),
			'param_name' => 'grid_posttypes',
			'description' => __( 'Select post types to populate posts from.', 'js_composer' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Teasers count', 'js_composer' ),
			'param_name' => 'grid_teasers_count',
			'description' => __( 'How many teasers to show? Enter number or word "All".', 'js_composer' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Content', 'js_composer' ),
			'param_name' => 'grid_content',
			'value' => array(
				__( 'Teaser (Excerpt)', 'js_composer' ) => 'teaser',
				__( 'Full Content', 'js_composer' ) => 'content'
			),
			'description' => __( 'Teaser layout template.', 'js_composer' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Layout', 'js_composer' ),
			'param_name' => 'grid_layout',
			'value' => array(
				__( 'Title + Thumbnail + Text', 'js_composer' ) => 'title_thumbnail_text',
				__( 'Thumbnail + Title + Text', 'js_composer' ) => 'thumbnail_title_text',
				__( 'Thumbnail + Text', 'js_composer' ) => 'thumbnail_text',
				__( 'Thumbnail + Title', 'js_composer' ) => 'thumbnail_title',
				__( 'Thumbnail only', 'js_composer' ) => 'thumbnail',
				__( 'Title + Text', 'js_composer' ) => 'title_text' ),
			'description' => __( 'Teaser layout.', 'js_composer' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Link', 'js_composer' ),
			'param_name' => 'grid_link',
			'value' => array(
				__( 'Link to post', 'js_composer' ) => 'link_post',
				__( 'Link to bigger image', 'js_composer' ) => 'link_image',
				__( 'Thumbnail to bigger image, title to post', 'js_composer' ) => 'link_image_post',
				__( 'No link', 'js_composer' ) => 'link_no'
			),
			'description' => __( 'Link type.', 'js_composer' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Link target', 'js_composer' ),
			'param_name' => 'grid_link_target',
			'value' => $target_arr,
			'dependency' => array(
				'element' => 'grid_link',
				'value' => array( 'link_post', 'link_image_post' )
			)
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Teaser grid layout', 'js_composer' ),
			'param_name' => 'grid_template',
			'value' => array(
				__( 'Grid', 'js_composer' ) => 'grid',
				__( 'Grid with filter', 'js_composer' ) => 'filtered_grid',
				__( 'Carousel', 'js_composer' ) => 'carousel'
			),
			'description' => __( 'Teaser layout template.', 'js_composer' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Layout mode', 'js_composer' ),
			'param_name' => 'grid_layout_mode',
			'value' => array(
				__( 'Fit rows', 'js_composer' ) => 'fitRows',
				__( 'Masonry', 'js_composer' ) => 'masonry'
			),
			'dependency' => array(
				'element' => 'grid_template',
				'value' => array( 'filtered_grid', 'grid' )
			),
			'description' => __( 'Teaser layout template.', 'js_composer' )
		),
		array(
			'type' => 'taxonomies',
			'heading' => __( 'Taxonomies', 'js_composer' ),
			'param_name' => 'grid_taxomonies',
			'dependency' => array(
				'element' => 'grid_template',
				// 'not_empty' => true,
				'value' => array( 'filtered_grid' ),
				'callback' => 'wpb_grid_post_types_for_taxonomies_handler'
			),
			'description' => __( 'Select taxonomies from.', 'js_composer' ) //TODO: Change description
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Thumbnail size', 'js_composer' ),
			'param_name' => 'grid_thumb_size',
			'description' => __( 'Enter thumbnail size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height) . ', 'js_composer' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Post/Page IDs', 'js_composer' ),
			'param_name' => 'posts_in',
			'description' => __( 'Fill this field with page/posts IDs separated by commas (,) to retrieve only them. Use this in conjunction with "Post types" field.', 'js_composer' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Exclude Post/Page IDs', 'js_composer' ),
			'param_name' => 'posts_not_in',
			'description' => __( 'Fill this field with page/posts IDs separated by commas (,) to exclude them from query.', 'js_composer' )
		),
		array(
			'type' => 'exploded_textarea',
			'heading' => __( 'Categories', 'js_composer' ),
			'param_name' => 'grid_categories',
			'description' => __( 'If you want to narrow output, enter category names here. Note: Only listed categories will be included. Divide categories with linebreaks (Enter) . ', 'js_composer' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Order by', 'js_composer' ),
			'param_name' => 'orderby',
			'value' => array(
				'',
				__( 'Date', 'js_composer' ) => 'date',
				__( 'ID', 'js_composer' ) => 'ID',
				__( 'Author', 'js_composer' ) => 'author',
				__( 'Title', 'js_composer' ) => 'title',
				__( 'Modified', 'js_composer' ) => 'modified',
				__( 'Random', 'js_composer' ) => 'rand',
				__( 'Comment count', 'js_composer' ) => 'comment_count',
				__( 'Menu order', 'js_composer' ) => 'menu_order'
			),
			'description' => sprintf( __( 'Select how to sort retrieved posts. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Order way', 'js_composer' ),
			'param_name' => 'order',
			'value' => array(
				__( 'Descending', 'js_composer' ) => 'DESC',
				__( 'Ascending', 'js_composer' ) => 'ASC'
			),
			'description' => sprintf( __( 'Designates the ascending or descending order. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'js_composer' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
		)
	)
) );

/* Posts Grid
---------------------------------------------------------- */
$vc_layout_sub_controls = array(
	array( 'link_post', __( 'Link to post', 'js_composer' ) ),
	array( 'no_link', __( 'No link', 'js_composer' ) ),
	array( 'link_image', __( 'Link to bigger image', 'js_composer' ) )
);
//vc_map( array(
//	'name' => __( 'Posts Grid', 'js_composer' ),
//	'base' => 'vc_posts_grid',
//	'icon' => 'icon-wpb-application-icon-large',
//	'description' => __( 'Posts in grid view', 'js_composer' ),
//	'params' => array(
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'Widget title', 'js_composer' ),
//			'param_name' => 'title',
//			'description' => __( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'js_composer' )
//		),
//		array(
//			'type' => 'loop',
//			'heading' => __( 'Grids content', 'js_composer' ),
//			'param_name' => 'loop',
//			'settings' => array(
//				'size' => array( 'hidden' => false, 'value' => 10 ),
//				'order_by' => array( 'value' => 'date' ),
//			),
//			'description' => __( 'Create WordPress loop, to populate content from your site.', 'js_composer' )
//		),
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Columns count', 'js_composer' ),
//			'param_name' => 'grid_columns_count',
//			'value' => array( 6, 4, 3, 2, 1 ),
//			'std' => 3,
//			'admin_label' => true,
//			'description' => __( 'Select columns count.', 'js_composer' )
//		),
//		array(
//			'type' => 'sorted_list',
//			'heading' => __( 'Teaser layout', 'js_composer' ),
//			'param_name' => 'grid_layout',
//			'description' => __( 'Control teasers look. Enable blocks and place them in desired order. Note: This setting can be overrriden on post to post basis.', 'js_composer' ),
//			'value' => 'title,image,text',
//			'options' => array(
//				array( 'image', __( 'Thumbnail', 'js_composer' ), $vc_layout_sub_controls ),
//				array( 'title', __( 'Title', 'js_composer' ), $vc_layout_sub_controls ),
//				array( 'text', __( 'Text', 'js_composer' ), array(
//					array( 'excerpt', __( 'Teaser/Excerpt', 'js_composer' ) ),
//					array( 'text', __( 'Full content', 'js_composer' ) )
//				) ),
//				array( 'link', __( 'Read more link', 'js_composer' ) )
//			)
//		),
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Link target', 'js_composer' ),
//			'param_name' => 'grid_link_target',
//			'value' => $target_arr,
//			// 'dependency' => array(
//			//     'element' => 'grid_link',
//			//     'value' => array( 'link_post', 'link_image_post' )
//			// )
//		),
//		array(
//			'type' => 'checkbox',
//			'heading' => __( 'Show filter', 'js_composer' ),
//			'param_name' => 'filter',
//			'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
//			'description' => __( 'Select to add animated category filter to your posts grid.', 'js_composer' )
//		),
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Layout mode', 'js_composer' ),
//			'param_name' => 'grid_layout_mode',
//			'value' => array(
//				__( 'Fit rows', 'js_composer' ) => 'fitRows',
//				__( 'Masonry', 'js_composer' ) => 'masonry'
//			),
//			'description' => __( 'Teaser layout template.', 'js_composer' )
//		),
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'Thumbnail size', 'js_composer' ),
//			'param_name' => 'grid_thumb_size',
//			'description' => __( 'Enter thumbnail size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height) . ', 'js_composer' )
//		),
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'Extra class name', 'js_composer' ),
//			'param_name' => 'el_class',
//			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
//		)
//	)
//// 'html_template' => dirname(__DIR__).'/composer/shortcodes_templates/vc_posts_grid.php'
//) );

/* Carousel
---------------------------------------------------------- */
//vc_map( array(
//	'name' => __( 'Carousel', 'vc_extend' ),
//	'base' => 'vc_carousel',
//	'class' => '',
//	'icon' => 'icon-wpb-vc_carousel',
//	'category' => __( 'Content', 'js_composer' ),
//	'description' => __( 'Animated carousel with posts', 'js_composer' ),
//	'params' => array(
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'Widget title', 'js_composer' ),
//			'param_name' => 'title',
//			'description' => __( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'js_composer' )
//		),
//		array(
//			'type' => 'loop',
//			'heading' => __( 'Carousel content', 'js_composer' ),
//			'param_name' => 'posts_query',
//			'settings' => array(
//				'size' => array( 'hidden' => false, 'value' => 10 ),
//				'order_by' => array( 'value' => 'date' )
//			),
//			'description' => __( 'Create WordPress loop, to populate content from your site.', 'js_composer' )
//		),
//		array(
//			'type' => 'sorted_list',
//			'heading' => __( 'Teaser layout', 'js_composer' ),
//			'param_name' => 'layout',
//			'description' => __( 'Control teasers look. Enable blocks and place them in desired order. Note: This setting can be overrriden on post to post basis.', 'js_composer' ),
//			'value' => 'title,image,text',
//			'options' => array(
//				array( 'image', __( 'Thumbnail', 'js_composer' ), $vc_layout_sub_controls ),
//				array( 'title', __( 'Title', 'js_composer' ), $vc_layout_sub_controls ),
//				array( 'text', __( 'Text', 'js_composer' ), array(
//					array( 'excerpt', __( 'Teaser/Excerpt', 'js_composer' ) ),
//					array( 'text', __( 'Full content', 'js_composer' ) )
//				) ),
//				array( 'link', __( 'Read more link', 'js_composer' ) )
//			)
//		),
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Link target', 'js_composer' ),
//			'param_name' => 'link_target',
//			'value' => $target_arr,
//			// 'dependency' => array( 'element' => 'link', 'value' => array( 'link_post', 'link_image_post', 'link_image' ) )
//		),
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'Thumbnail size', 'js_composer' ),
//			'param_name' => 'thumb_size',
//			'description' => __( 'Enter thumbnail size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height) . ', 'js_composer' )
//		),
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'Slider speed', 'js_composer' ),
//			'param_name' => 'speed',
//			'value' => '5000',
//			'description' => __( 'Duration of animation between slides (in ms)', 'js_composer' )
//		),
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Slider mode', 'js_composer' ),
//			'param_name' => 'mode',
//			'value' => array( __( 'Horizontal', 'js_composer' ) => 'horizontal', __( 'Vertical', 'js_composer' ) => 'vertical' ),
//			'description' => __( 'Slides will be positioned horizontally (for horizontal swipes) or vertically (for vertical swipes)', 'js_composer' )
//		),
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'Slides per view', 'js_composer' ),
//			'param_name' => 'slides_per_view',
//			'value' => '4',
//			'description' => __( 'Set numbers of slides you want to display at the same time on slider\'s container for carousel mode. Also supports for "auto" value, in this case it will fit slides depending on container\'s width. "auto" mode doesn\'t compatible with loop mode.', 'js_composer' )
//		),
//		array(
//			'type' => 'checkbox',
//			'heading' => __( 'Slider autoplay', 'js_composer' ),
//			'param_name' => 'autoplay',
//			'description' => __( 'Enables autoplay mode.', 'js_composer' ),
//			'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes' )
//		),
//		array(
//			'type' => 'checkbox',
//			'heading' => __( 'Hide pagination control', 'js_composer' ),
//			'param_name' => 'hide_pagination_control',
//			'description' => __( 'If "YES" pagination control will be removed', 'js_composer' ),
//			'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes' )
//		),
//		array(
//			'type' => 'checkbox',
//			'heading' => __( 'Hide prev/next buttons', 'js_composer' ),
//			'param_name' => 'hide_prev_next_buttons',
//			'description' => __( 'If "YES" prev/next control will be removed', 'js_composer' ),
//			'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes' )
//		),
//		array(
//			'type' => 'checkbox',
//			'heading' => __( 'Partial view', 'js_composer' ),
//			'param_name' => 'partial_view',
//			'description' => __( 'If "YES" part of the next slide will be visible on the right side', 'js_composer' ),
//			'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes' )
//		),
//		array(
//			'type' => 'checkbox',
//			'heading' => __( 'Slider loop', 'js_composer' ),
//			'param_name' => 'wrap',
//			'description' => __( 'Enables loop mode.', 'js_composer' ),
//			'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes' )
//		),
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'Extra class name', 'js_composer' ),
//			'param_name' => 'el_class',
//			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
//		)
//	)
//) );


/* Posts slider
---------------------------------------------------------- */
//vc_map( array(
//	'name' => __( 'Posts Slider', 'js_composer' ),
//	'base' => 'vc_posts_slider',
//	'icon' => 'icon-wpb-slideshow',
//	'category' => __( 'Content', 'js_composer' ),
//	'description' => __( 'Slider with WP Posts', 'js_composer' ),
//	'params' => array(
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'Widget title', 'js_composer' ),
//			'param_name' => 'title',
//			'description' => __( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'js_composer' )
//		),
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Slider type', 'js_composer' ),
//			'param_name' => 'type',
//			'admin_label' => true,
//			'value' => array(
//				__( 'Flex slider fade', 'js_composer' ) => 'flexslider_fade',
//				__( 'Flex slider slide', 'js_composer' ) => 'flexslider_slide',
//				__( 'Nivo slider', 'js_composer' ) => 'nivo'
//			),
//			'description' => __( 'Select slider type.', 'js_composer' )
//		),
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'Slides count', 'js_composer' ),
//			'param_name' => 'count',
//			'description' => __( 'How many slides to show? Enter number or word "All".', 'js_composer' )
//		),
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Auto rotate slides', 'js_composer' ),
//			'param_name' => 'interval',
//			'value' => array( 3, 5, 10, 15, __( 'Disable', 'js_composer' ) => 0 ),
//			'description' => __( 'Auto rotate slides each X seconds.', 'js_composer' )
//		),
//		array(
//			'type' => 'posttypes',
//			'heading' => __( 'Post types', 'js_composer' ),
//			'param_name' => 'posttypes',
//			'description' => __( 'Select post types to populate posts from.', 'js_composer' )
//		),
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Description', 'js_composer' ),
//			'param_name' => 'slides_content',
//			'value' => array(
//				__( 'No description', 'js_composer' ) => '',
//				__( 'Teaser (Excerpt)', 'js_composer' ) => 'teaser'
//			),
//			'description' => __( 'Some sliders support description text, what content use for it?', 'js_composer' ),
//			'dependency' => array(
//				'element' => 'type',
//				'value' => array( 'flexslider_fade', 'flexslider_slide' )
//			),
//		),
//		array(
//			'type' => 'checkbox',
//			'heading' => __( 'Output post title?', 'js_composer' ),
//			'param_name' => 'slides_title',
//			'description' => __( 'If selected, title will be printed before the teaser text.', 'js_composer' ),
//			'value' => array( __( 'Yes, please', 'js_composer' ) => true ),
//			'dependency' => array(
//				'element' => 'slides_content',
//				'value' => array( 'teaser' )
//			),
//		),
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Link', 'js_composer' ),
//			'param_name' => 'link',
//			'value' => array(
//				__( 'Link to post', 'js_composer' ) => 'link_post',
//				__( 'Link to bigger image', 'js_composer' ) => 'link_image',
//				__( 'Open custom link', 'js_composer' ) => 'custom_link',
//				__( 'No link', 'js_composer' ) => 'link_no'
//			),
//			'description' => __( 'Link type.', 'js_composer' )
//		),
//		array(
//			'type' => 'exploded_textarea',
//			'heading' => __( 'Custom links', 'js_composer' ),
//			'param_name' => 'custom_links',
//			'dependency' => array( 'element' => 'link', 'value' => 'custom_link' ),
//			'description' => __( 'Enter links for each slide here. Divide links with linebreaks (Enter).', 'js_composer' )
//		),
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'Thumbnail size', 'js_composer' ),
//			'param_name' => 'thumb_size',
//			'description' => __( 'Enter thumbnail size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height) . ', 'js_composer' )
//		),
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'Post/Page IDs', 'js_composer' ),
//			'param_name' => 'posts_in',
//			'description' => __( 'Fill this field with page/posts IDs separated by commas (,), to retrieve only them. Use this in conjunction with "Post types" field.', 'js_composer' )
//		),
//		array(
//			'type' => 'exploded_textarea',
//			'heading' => __( 'Categories', 'js_composer' ),
//			'param_name' => 'categories',
//			'description' => __( 'If you want to narrow output, enter category names here. Note: Only listed categories will be included. Divide categories with linebreaks (Enter) . ', 'js_composer' )
//		),
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Order by', 'js_composer' ),
//			'param_name' => 'orderby',
//			'value' => array(
//				'',
//				__( 'Date', 'js_composer' ) => 'date',
//				__( 'ID', 'js_composer' ) => 'ID',
//				__( 'Author', 'js_composer' ) => 'author',
//				__( 'Title', 'js_composer' ) => 'title',
//				__( 'Modified', 'js_composer' ) => 'modified',
//				__( 'Random', 'js_composer' ) => 'rand',
//				__( 'Comment count', 'js_composer' ) => 'comment_count',
//				__( 'Menu order', 'js_composer' ) => 'menu_order'
//			),
//			'description' => sprintf( __( 'Select how to sort retrieved posts. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
//		),
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Order by', 'js_composer' ),
//			'param_name' => 'order',
//			'value' => array(
//				__( 'Descending', 'js_composer' ) => 'DESC',
//				__( 'Ascending', 'js_composer' ) => 'ASC'
//			),
//			'description' => sprintf( __( 'Designates the ascending or descending order. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
//		),
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'Extra class name', 'js_composer' ),
//			'param_name' => 'el_class',
//			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
//		)
//	)
//) );

/* Widgetised sidebar
---------------------------------------------------------- */
vc_map( array(
	'name' => __( 'Widgetised Sidebar', 'js_composer' ),
	'base' => 'vc_widget_sidebar',
	'class' => 'wpb_widget_sidebar_widget',
	'icon' => 'icon-wpb-layout_sidebar',
	'category' => __( 'Structure', 'js_composer' ),
	'description' => __( 'Place widgetised sidebar', 'js_composer' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Widget title', 'js_composer' ),
			'param_name' => 'title',
			'description' => __( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'js_composer' )
		),
		array(
			'type' => 'widgetised_sidebars',
			'heading' => __( 'Sidebar', 'js_composer' ),
			'param_name' => 'sidebar_id',
			'description' => __( 'Select which widget area output.', 'js_composer' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'js_composer' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
		)
	)
) );

/* Button
---------------------------------------------------------- */
$icons_arr = array(
	__( 'None', 'js_composer' ) => 'none',
	__( 'Address book icon', 'js_composer' ) => 'wpb_address_book',
	__( 'Alarm clock icon', 'js_composer' ) => 'wpb_alarm_clock',
	__( 'Anchor icon', 'js_composer' ) => 'wpb_anchor',
	__( 'Application Image icon', 'js_composer' ) => 'wpb_application_image',
	__( 'Arrow icon', 'js_composer' ) => 'wpb_arrow',
	__( 'Asterisk icon', 'js_composer' ) => 'wpb_asterisk',
	__( 'Hammer icon', 'js_composer' ) => 'wpb_hammer',
	__( 'Balloon icon', 'js_composer' ) => 'wpb_balloon',
	__( 'Balloon Buzz icon', 'js_composer' ) => 'wpb_balloon_buzz',
	__( 'Balloon Facebook icon', 'js_composer' ) => 'wpb_balloon_facebook',
	__( 'Balloon Twitter icon', 'js_composer' ) => 'wpb_balloon_twitter',
	__( 'Battery icon', 'js_composer' ) => 'wpb_battery',
	__( 'Binocular icon', 'js_composer' ) => 'wpb_binocular',
	__( 'Document Excel icon', 'js_composer' ) => 'wpb_document_excel',
	__( 'Document Image icon', 'js_composer' ) => 'wpb_document_image',
	__( 'Document Music icon', 'js_composer' ) => 'wpb_document_music',
	__( 'Document Office icon', 'js_composer' ) => 'wpb_document_office',
	__( 'Document PDF icon', 'js_composer' ) => 'wpb_document_pdf',
	__( 'Document Powerpoint icon', 'js_composer' ) => 'wpb_document_powerpoint',
	__( 'Document Word icon', 'js_composer' ) => 'wpb_document_word',
	__( 'Bookmark icon', 'js_composer' ) => 'wpb_bookmark',
	__( 'Camcorder icon', 'js_composer' ) => 'wpb_camcorder',
	__( 'Camera icon', 'js_composer' ) => 'wpb_camera',
	__( 'Chart icon', 'js_composer' ) => 'wpb_chart',
	__( 'Chart pie icon', 'js_composer' ) => 'wpb_chart_pie',
	__( 'Clock icon', 'js_composer' ) => 'wpb_clock',
	__( 'Fire icon', 'js_composer' ) => 'wpb_fire',
	__( 'Heart icon', 'js_composer' ) => 'wpb_heart',
	__( 'Mail icon', 'js_composer' ) => 'wpb_mail',
	__( 'Play icon', 'js_composer' ) => 'wpb_play',
	__( 'Shield icon', 'js_composer' ) => 'wpb_shield',
	__( 'Video icon', 'js_composer' ) => "wpb_video"
);
//
//vc_map( array(
//	'name' => __( 'Button', 'js_composer' ),
//	'base' => 'vc_button',
//	'icon' => 'icon-wpb-ui-button',
//	'category' => __( 'Content', 'js_composer' ),
//	'description' => __( 'Eye catching button', 'js_composer' ),
//	'params' => array(
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'Text on the button', 'js_composer' ),
//			'holder' => 'button',
//			'class' => 'wpb_button',
//			'param_name' => 'title',
//			'value' => __( 'Text on the button', 'js_composer' ),
//			'description' => __( 'Text on the button.', 'js_composer' )
//		),
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'URL (Link)', 'js_composer' ),
//			'param_name' => 'href',
//			'description' => __( 'Button link.', 'js_composer' )
//		),
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Target', 'js_composer' ),
//			'param_name' => 'target',
//			'value' => $target_arr,
//			'dependency' => array( 'element' => 'href', 'not_empty' => true )
//		),
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Color', 'js_composer' ),
//			'param_name' => 'color',
//			'value' => $colors_arr,
//			'description' => __( 'Button color.', 'js_composer' ),
//			'param_holder_class' => 'vc-colored-dropdown'
//		),
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Icon', 'js_composer' ),
//			'param_name' => 'icon',
//			'value' => $icons_arr,
//			'description' => __( 'Button icon.', 'js_composer' )
//		),
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Size', 'js_composer' ),
//			'param_name' => 'size',
//			'value' => $size_arr,
//			'description' => __( 'Button size.', 'js_composer' )
//		),
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'Extra class name', 'js_composer' ),
//			'param_name' => 'el_class',
//			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
//		)
//	),
//	'js_view' => 'VcButtonView'
//) );
//
//vc_map( array(
//	'name' => __( 'Button', 'js_composer' ) . " 2",
//	'base' => 'vc_button2',
//	'icon' => 'icon-wpb-ui-button',
//	'category' => array(
//		__( 'Content', 'js_composer' ),
//		__( 'New elements', 'js_composer' ) ),
//	'description' => __( 'Eye catching button', 'js_composer' ),
//	'params' => array(
//		array(
//			'type' => 'vc_link',
//			'heading' => __( 'URL (Link)', 'js_composer' ),
//			'param_name' => 'link',
//			'description' => __( 'Button link.', 'js_composer' )
//		),
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'Text on the button', 'js_composer' ),
//			'holder' => 'button',
//			'class' => 'wpb_button',
//			'param_name' => 'title',
//			'value' => __( 'Text on the button', 'js_composer' ),
//			'description' => __( 'Text on the button.', 'js_composer' )
//		),
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Style', 'js_composer' ),
//			'param_name' => 'style',
//			'value' => getVcShared( 'button styles' ),
//			'description' => __( 'Button style.', 'js_composer' )
//		),
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Color', 'js_composer' ),
//			'param_name' => 'color',
//			'value' => getVcShared( 'colors' ),
//			'description' => __( 'Button color.', 'js_composer' ),
//			'param_holder_class' => 'vc-colored-dropdown'
//		),
//		/*array(
//        'type' => 'dropdown',
//        'heading' => __( 'Icon', 'js_composer' ),
//        'param_name' => 'icon',
//        'value' => getVcShared( 'icons' ),
//        'description' => __( 'Button icon.', 'js_composer' )
//  ),*/
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Size', 'js_composer' ),
//			'param_name' => 'size',
//			'value' => getVcShared( 'sizes' ),
//			'std' => 'md',
//			'description' => __( 'Button size.', 'js_composer' )
//		),
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'Extra class name', 'js_composer' ),
//			'param_name' => 'el_class',
//			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
//		)
//	)
//) );
//
///* Call to Action Button
//---------------------------------------------------------- */
//vc_map( array(
//	'name' => __( 'Call to Action Button', 'js_composer' ),
//	'base' => 'vc_cta_button',
//	'icon' => 'icon-wpb-call-to-action',
//	'category' => __( 'Content', 'js_composer' ),
//	'description' => __( 'Catch visitors attention with CTA block', 'js_composer' ),
//	'params' => array(
//		array(
//			'type' => 'textarea',
//			'admin_label' => true,
//			'heading' => __( 'Text', 'js_composer' ),
//			'param_name' => 'call_text',
//			'value' => __( 'Click edit button to change this text.', 'js_composer' ),
//			'description' => __( 'Enter your content.', 'js_composer' )
//		),
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'Text on the button', 'js_composer' ),
//			'param_name' => 'title',
//			'value' => __( 'Text on the button', 'js_composer' ),
//			'description' => __( 'Text on the button.', 'js_composer' )
//		),
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'URL (Link)', 'js_composer' ),
//			'param_name' => 'href',
//			'description' => __( 'Button link.', 'js_composer' )
//		),
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Target', 'js_composer' ),
//			'param_name' => 'target',
//			'value' => $target_arr,
//			'dependency' => array( 'element' => 'href', 'not_empty' => true )
//		),
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Color', 'js_composer' ),
//			'param_name' => 'color',
//			'value' => $colors_arr,
//			'description' => __( 'Button color.', 'js_composer' ),
//			'param_holder_class' => 'vc-colored-dropdown'
//		),
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Icon', 'js_composer' ),
//			'param_name' => 'icon',
//			'value' => $icons_arr,
//			'description' => __( 'Button icon.', 'js_composer' )
//		),
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Size', 'js_composer' ),
//			'param_name' => 'size',
//			'value' => $size_arr,
//			'description' => __( 'Button size.', 'js_composer' )
//		),
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Button position', 'js_composer' ),
//			'param_name' => 'position',
//			'value' => array(
//				__( 'Align right', 'js_composer' ) => 'cta_align_right',
//				__( 'Align left', 'js_composer' ) => 'cta_align_left',
//				__( 'Align bottom', 'js_composer' ) => 'cta_align_bottom'
//			),
//			'description' => __( 'Select button alignment.', 'js_composer' )
//		),
//		$add_css_animation,
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'Extra class name', 'js_composer' ),
//			'param_name' => 'el_class',
//			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
//		)
//	),
//	'js_view' => 'VcCallToActionView'
//) );
//
//vc_map( array(
//	'name' => __( 'Call to Action Button', 'js_composer' ) . ' 2',
//	'base' => 'vc_cta_button2',
//	'icon' => 'icon-wpb-call-to-action',
//	'category' => array( __( 'Content', 'js_composer' ), __( 'New elements', 'js_composer' ) ),
//	'description' => __( 'Catch visitors attention with CTA block', 'js_composer' ),
//	'params' => array(
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'Heading first line', 'js_composer' ),
//			'holder' => 'h2',
//			'param_name' => 'h2',
//			'value' => __( 'Hey! I am first heading line feel free to change me', 'js_composer' ),
//			'description' => __( 'Text for the first heading line.', 'js_composer' )
//		),
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'Heading second line', 'js_composer' ),
//			'holder' => 'h4',
//			'param_name' => 'h4',
//			'value' => '',
//			'description' => __( 'Optional text for the second heading line.', 'js_composer' )
//		),
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'CTA style', 'js_composer' ),
//			'param_name' => 'style',
//			'value' => getVcShared( 'cta styles' ),
//			'description' => __( 'Call to action style.', 'js_composer' )
//		),
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Element width', 'js_composer' ),
//			'param_name' => 'el_width',
//			'value' => getVcShared( 'cta widths' ),
//			'description' => __( 'Call to action element width in percents.', 'js_composer' )
//		),
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Text align', 'js_composer' ),
//			'param_name' => 'txt_align',
//			'value' => getVcShared( 'text align' ),
//			'description' => __( 'Text align in call to action block.', 'js_composer' )
//		),
//		array(
//			'type' => 'colorpicker',
//			'heading' => __( 'Custom Background Color', 'wpb' ),
//			'param_name' => 'accent_color',
//			'description' => __( 'Select background color for your element.', 'wpb' )
//		),
//		array(
//			'type' => 'textarea_html',
//			'holder' => 'div',
//			'heading' => __( 'Promotional text', 'js_composer' ),
//			'param_name' => 'content',
//			'value' => __( '<p>I am promo text. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>', 'js_composer' )
//		),
//		array(
//			'type' => 'vc_link',
//			'heading' => __( 'URL (Link)', 'js_composer' ),
//			'param_name' => 'link',
//			'description' => __( 'Button link.', 'js_composer' )
//		),
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'Text on the button', 'js_composer' ),
//			//'holder' => 'button',
//			//'class' => 'wpb_button',
//			'param_name' => 'title',
//			'value' => __( 'Text on the button', 'js_composer' ),
//			'description' => __( 'Text on the button.', 'js_composer' )
//		),
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Button style', 'js_composer' ),
//			'param_name' => 'btn_style',
//			'value' => getVcShared( 'button styles' ),
//			'description' => __( 'Button style.', 'js_composer' )
//		),
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Color', 'js_composer' ),
//			'param_name' => 'color',
//			'value' => getVcShared( 'colors' ),
//			'description' => __( 'Button color.', 'js_composer' ),
//			'param_holder_class' => 'vc-colored-dropdown'
//		),
//		/*array(
//        'type' => 'dropdown',
//        'heading' => __( 'Icon', 'js_composer' ),
//        'param_name' => 'icon',
//        'value' => getVcShared( 'icons' ),
//        'description' => __( 'Button icon.', 'js_composer' )
//  ),*/
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Size', 'js_composer' ),
//			'param_name' => 'size',
//			'value' => getVcShared( 'sizes' ),
//			'std' => 'md',
//			'description' => __( 'Button size.', 'js_composer' )
//		),
//		array(
//			'type' => 'dropdown',
//			'heading' => __( 'Button position', 'js_composer' ),
//			'param_name' => 'position',
//			'value' => array(
//				__( 'Align right', 'js_composer' ) => 'right',
//				__( 'Align left', 'js_composer' ) => 'left',
//				__( 'Align bottom', 'js_composer' ) => 'bottom'
//			),
//			'description' => __( 'Select button alignment.', 'js_composer' )
//		),
//		$add_css_animation,
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'Extra class name', 'js_composer' ),
//			'param_name' => 'el_class',
//			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
//		)
//	)
//) );

/* Video element
---------------------------------------------------------- */
//vc_map( array(
//	'name' => __( 'Video Player', 'js_composer' ),
//	'base' => 'vc_video',
//	'icon' => 'icon-wpb-film-youtube',
//	'category' => __( 'Content', 'js_composer' ),
//	'description' => __( 'Embed YouTube/Vimeo player', 'js_composer' ),
//	'params' => array(
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'Widget title', 'js_composer' ),
//			'param_name' => 'title',
//			'description' => __( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'js_composer' )
//		),
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'Video link', 'js_composer' ),
//			'param_name' => 'link',
//			'admin_label' => true,
//			'description' => sprintf( __( 'Link to the video. More about supported formats at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank">WordPress codex page</a>' )
//		),
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'Extra class name', 'js_composer' ),
//			'param_name' => 'el_class',
//			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
//		),
//		array(
//			'type' => 'css_editor',
//			'heading' => __( 'Css', 'js_composer' ),
//			'param_name' => 'css',
//			// 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
//			'group' => __( 'Design options', 'js_composer' )
//		)
//	)
//) );

/* Google maps element
---------------------------------------------------------- */
//vc_map( array(
//	'name' => __( 'Google Maps', 'js_composer' ),
//	'base' => 'vc_gmaps',
//	'icon' => 'icon-wpb-map-pin',
//	'category' => __( 'Content', 'js_composer' ),
//	'description' => __( 'Map block', 'js_composer' ),
//	'params' => array(
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'Widget title', 'js_composer' ),
//			'param_name' => 'title',
//			'description' => __( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'js_composer' )
//		),
//		array(
//			'type' => 'textarea_safe',
//			'heading' => __( 'Map embed iframe', 'js_composer' ),
//			'param_name' => 'link',
//			'description' => sprintf( __( 'Visit %s to create your map. 1) Find location 2) Click "Share" and make sure map is public on the web 3) Click folder icon to reveal "Embed on my site" link 4) Copy iframe code and paste it here.', 'js_composer' ), '<a href="https://mapsengine.google.com/" target="_blank">Google maps</a>' )
//		),
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'Map height', 'js_composer' ),
//			'param_name' => 'size',
//			'description' => __( 'Enter map height in pixels. Example: 200 or leave it empty to make map responsive.', 'js_composer' )
//		),
//		/*array(
//        'type' => 'dropdown',
//        'heading' => __( 'Map type', 'js_composer' ),
//        'param_name' => 'type',
//        'value' => array( __( 'Map', 'js_composer' ) => 'm', __( 'Satellite', 'js_composer' ) => 'k', __( 'Map + Terrain', 'js_composer' ) => "p" ),
//        'description' => __( 'Select map type.', 'js_composer' )
//  ),
//  array(
//        'type' => 'dropdown',
//        'heading' => __( 'Map Zoom', 'js_composer' ),
//        'param_name' => 'zoom',
//        'value' => array( __( '14 - Default', 'js_composer' ) => 14, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 15, 16, 17, 18, 19, 20)
//  ),
//  array(
//        'type' => 'checkbox',
//        'heading' => __( 'Remove info bubble', 'js_composer' ),
//        'param_name' => 'bubble',
//        'description' => __( 'If selected, information bubble will be hidden.', 'js_composer' ),
//        'value' => array( __( 'Yes, please', 'js_composer' ) => true),
//  ),*/
//		array(
//			'type' => 'textfield',
//			'heading' => __( 'Extra class name', 'js_composer' ),
//			'param_name' => 'el_class',
//			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
//		)
//	)
//) );



/* Flickr
---------------------------------------------------------- */
vc_map( array(
	'base' => 'vc_flickr',
	'name' => __( 'Flickr Widget', 'js_composer' ),
	'icon' => 'icon-wpb-flickr',
	'category' => __( 'Content', 'js_composer' ),
	'description' => __( 'Image feed from your flickr account', 'js_composer' ),
	"params" => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Widget title', 'js_composer' ),
			'param_name' => 'title',
			'description' => __( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'js_composer' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Flickr ID', 'js_composer' ),
			'param_name' => 'flickr_id',
			'admin_label' => true,
			'description' => sprintf( __( 'To find your flickID visit %s.', 'js_composer' ), '<a href="http://idgettr.com/" target="_blank">idGettr</a>' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Number of photos', 'js_composer' ),
			'param_name' => 'count',
			'value' => array( 9, 8, 7, 6, 5, 4, 3, 2, 1 ),
			'description' => __( 'Number of photos.', 'js_composer' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Type', 'js_composer' ),
			'param_name' => 'type',
			'value' => array(
				__( 'User', 'js_composer' ) => 'user',
				__( 'Group', 'js_composer' ) => 'group'
			),
			'description' => __( 'Photo stream type.', 'js_composer' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Display', 'js_composer' ),
			'param_name' => 'display',
			'value' => array(
				__( 'Latest', 'js_composer' ) => 'latest',
				__( 'Random', 'js_composer' ) => 'random'
			),
			'description' => __( 'Photo order.', 'js_composer' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'js_composer' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
		)
	)
) );


/* Support for 3rd Party plugins
---------------------------------------------------------- */
// Contact form 7 plugin
include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); // Require plugin.php to use is_plugin_active() below
if ( is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) {
	global $wpdb;
	$cf7 = $wpdb->get_results(
		"
  SELECT ID, post_title
  FROM $wpdb->posts
  WHERE post_type = 'wpcf7_contact_form'
  "
	);
	$contact_forms = array();
	if ( $cf7 ) {
		foreach ( $cf7 as $cform ) {
			$contact_forms[$cform->post_title] = $cform->ID;
		}
	} else {
		$contact_forms[__( 'No contact forms found', 'js_composer' )] = 0;
	}
	vc_map( array(
		'base' => 'contact-form-7',
		'name' => __( 'Contact Form 7', 'js_composer' ),
		'icon' => 'icon-wpb-contactform7',
		'category' => __( 'Content', 'js_composer' ),
		'description' => __( 'Place Contact Form7', 'js_composer' ),
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Form title', 'js_composer' ),
				'param_name' => 'title',
				'admin_label' => true,
				'description' => __( 'What text use as form title. Leave blank if no title is needed.', 'js_composer' )
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Select contact form', 'js_composer' ),
				'param_name' => 'id',
				'value' => $contact_forms,
				'description' => __( 'Choose previously created contact form from the drop down list.', 'js_composer' )
			)
		)
	) );
} // if contact form7 plugin active

if ( is_plugin_active( 'gravityforms/gravityforms.php' ) ) {
	$gravity_forms_array[__( 'No Gravity forms found.', 'js_composer' )] = '';
	if ( class_exists( 'RGFormsModel' ) ) {
		$gravity_forms = RGFormsModel::get_forms( 1, 'title' );
		if ( $gravity_forms ) {
			$gravity_forms_array = array( __( 'Select a form to display.', 'js_composer' ) => '' );
			foreach ( $gravity_forms as $gravity_form ) {
				$gravity_forms_array[$gravity_form->title] = $gravity_form->id;
			}
		}
	}
	vc_map( array(
		'name' => __( 'Gravity Form', 'js_composer' ),
		'base' => 'gravityform',
		'icon' => 'icon-wpb-vc_gravityform',
		'category' => __( 'Content', 'js_composer' ),
		'description' => __( 'Place Gravity form', 'js_composer' ),
		'params' => array(
			array(
				'type' => 'dropdown',
				'heading' => __( 'Form', 'js_composer' ),
				'param_name' => 'id',
				'value' => $gravity_forms_array,
				'description' => __( 'Select a form to add it to your post or page.', 'js_composer' ),
				'admin_label' => true
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Display Form Title', 'js_composer' ),
				'param_name' => 'title',
				'value' => array(
					__( 'No', 'js_composer' ) => 'false',
					__( 'Yes', 'js_composer' ) => 'true'
				),
				'description' => __( 'Would you like to display the forms title?', 'js_composer' ),
				'dependency' => array( 'element' => 'id', 'not_empty' => true )
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Display Form Description', 'js_composer' ),
				'param_name' => 'description',
				'value' => array(
					__( 'No', 'js_composer' ) => 'false',
					__( 'Yes', 'js_composer' ) => 'true'
				),
				'description' => __( 'Would you like to display the forms description?', 'js_composer' ),
				'dependency' => array( 'element' => 'id', 'not_empty' => true )
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Enable AJAX?', 'js_composer' ),
				'param_name' => 'ajax',
				'value' => array(
					__( 'No', 'js_composer' ) => 'false',
					__( 'Yes', 'js_composer' ) => 'true'
				),
				'description' => __( 'Enable AJAX submission?', 'js_composer' ),
				'dependency' => array( 'element' => 'id', 'not_empty' => true )
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Tab Index', 'js_composer' ),
				'param_name' => 'tabindex',
				'description' => __( '(Optional) Specify the starting tab index for the fields of this form. Leave blank if you\'re not sure what this is.', 'js_composer' ),
				'dependency' => array( 'element' => 'id', 'not_empty' => true )
			)
		)
	) );
} // if gravityforms active

/* WordPress default Widgets (Appearance->Widgets)
---------------------------------------------------------- */
vc_map( array(
	'name' => 'WP ' . __( "Search" ),
	'base' => 'vc_wp_search',
	'icon' => 'icon-wpb-wp',
	'category' => __( 'WordPress Widgets', 'js_composer' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'A search form for your site', 'js_composer' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Widget title', 'js_composer' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'js_composer' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'js_composer' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
		)
	)
) );

vc_map( array(
	'name' => 'WP ' . __( 'Meta' ),
	'base' => 'vc_wp_meta',
	'icon' => 'icon-wpb-wp',
	'category' => __( 'WordPress Widgets', 'js_composer' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'Log in/out, admin, feed and WordPress links', 'js_composer' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Widget title', 'js_composer' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'js_composer' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'js_composer' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
		)
	)
) );

vc_map( array(
	'name' => 'WP ' . __( 'Recent Comments' ),
	'base' => 'vc_wp_recentcomments',
	'icon' => 'icon-wpb-wp',
	'category' => __( 'WordPress Widgets', 'js_composer' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'The most recent comments', 'js_composer' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Widget title', 'js_composer' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'js_composer' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of comments to show', 'js_composer' ),
			'param_name' => 'number',
			'admin_label' => true
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'js_composer' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
		)
	)
) );

vc_map( array(
	'name' => 'WP ' . __( 'Calendar' ),
	'base' => 'vc_wp_calendar',
	'icon' => 'icon-wpb-wp',
	'category' => __( 'WordPress Widgets', 'js_composer' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'A calendar of your sites posts', 'js_composer' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Widget title', 'js_composer' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'js_composer' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'js_composer' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
		)
	)
) );

vc_map( array(
	'name' => 'WP ' . __( 'Pages' ),
	'base' => 'vc_wp_pages',
	'icon' => 'icon-wpb-wp',
	'category' => __( 'WordPress Widgets', 'js_composer' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'Your sites WordPress Pages', 'js_composer' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Widget title', 'js_composer' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'js_composer' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Sort by', 'js_composer' ),
			'param_name' => 'sortby',
			'value' => array(
				__( 'Page title', 'js_composer' ) => 'post_title',
				__( 'Page order', 'js_composer' ) => 'menu_order',
				__( 'Page ID', 'js_composer' ) => 'ID'
			),
			'admin_label' => true
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Exclude', 'js_composer' ),
			'param_name' => 'exclude',
			'description' => __( 'Page IDs, separated by commas.', 'js_composer' ),
			'admin_label' => true
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'js_composer' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
		)
	)
) );

$tag_taxonomies = array();
foreach ( get_taxonomies() as $taxonomy ) {
	$tax = get_taxonomy( $taxonomy );
	if ( ! $tax->show_tagcloud || empty( $tax->labels->name ) ) {
		continue;
	}
	$tag_taxonomies[$tax->labels->name] = esc_attr( $taxonomy );
}
vc_map( array(
	'name' => 'WP ' . __( 'Tag Cloud' ),
	'base' => 'vc_wp_tagcloud',
	'icon' => 'icon-wpb-wp',
	'category' => __( 'WordPress Widgets', 'js_composer' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'Your most used tags in cloud format', 'js_composer' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Widget title', 'js_composer' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'js_composer' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Taxonomy', 'js_composer' ),
			'param_name' => 'taxonomy',
			'value' => $tag_taxonomies,
			'admin_label' => true
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'js_composer' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
		)
	)
) );

$custom_menus = array();
$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
if ( is_array( $menus ) ) {
	foreach ( $menus as $single_menu ) {
		$custom_menus[$single_menu->name] = $single_menu->term_id;
	}
}
vc_map( array(
	'name' => 'WP ' . __( "Custom Menu" ),
	'base' => 'vc_wp_custommenu',
	'icon' => 'icon-wpb-wp',
	'category' => __( 'WordPress Widgets', 'js_composer' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'Use this widget to add one of your custom menus as a widget', 'js_composer' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Widget title', 'js_composer' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'js_composer' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Menu', 'js_composer' ),
			'param_name' => 'nav_menu',
			'value' => $custom_menus,
			'description' => empty( $custom_menus ) ? __( 'Custom menus not found. Please visit <b>Appearance > Menus</b> page to create new menu.', 'js_composer' ) : __( 'Select menu', 'js_composer' ),
			'admin_label' => true
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'js_composer' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
		)
	)
) );

vc_map( array(
	'name' => 'WP ' . __( 'Text' ),
	'base' => 'vc_wp_text',
	'icon' => 'icon-wpb-wp',
	'category' => __( 'WordPress Widgets', 'js_composer' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'Arbitrary text or HTML', 'js_composer' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Widget title', 'js_composer' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'js_composer' )
		),
		array(
			'type' => 'textarea',
			'heading' => __( 'Text', 'js_composer' ),
			'param_name' => 'content',
			// 'admin_label' => true
		),
		/*array(
        'type' => 'checkbox',
        'heading' => __( 'Automatically add paragraphs', 'js_composer' ),
        'param_name' => "filter"
  ),*/
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'js_composer' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
		)
	)
) );


vc_map( array(
	'name' => 'WP ' . __( 'Recent Posts' ),
	'base' => 'vc_wp_posts',
	'icon' => 'icon-wpb-wp',
	'category' => __( 'WordPress Widgets', 'js_composer' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'The most recent posts on your site', 'js_composer' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Widget title', 'js_composer' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'js_composer' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of posts to show', 'js_composer' ),
			'param_name' => 'number',
			'admin_label' => true
		),
		array(
			'type' => 'checkbox',
			'heading' => __( 'Display post date?', 'js_composer' ),
			'param_name' => 'show_date',
			'value' => array( __( 'Yes, please', 'js_composerp' ) => true )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'js_composer' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
		)
	)
) );


$link_category = array( __( 'All Links', 'js_composer' ) => '' );
$link_cats     = get_terms( 'link_category' );
if ( is_array( $link_cats ) ) {
	foreach ( $link_cats as $link_cat ) {
		$link_category[ $link_cat->name ] = $link_cat->term_id;
	}
}
vc_map( array(
	'name'        => 'WP ' . __( 'Links' ),
	'base'        => 'vc_wp_links',
	'icon'        => 'icon-wpb-wp',
	'category'    => __( 'WordPress Widgets', 'js_composer' ),
	'class'       => 'wpb_vc_wp_widget',
	'content_element' => (bool) get_option( 'link_manager_enabled' ),
	'weight'      => - 50,
	'description' => __( 'Your blogroll', 'js_composer' ),
	'params'      => array(
		array(
			'type'        => 'dropdown',
			'heading'     => __( 'Link Category', 'js_composer' ),
			'param_name'  => 'category',
			'value'       => $link_category,
			'admin_label' => true
		),
		array(
			'type'       => 'dropdown',
			'heading'    => __( 'Sort by', 'js_composer' ),
			'param_name' => 'orderby',
			'value'      => array(
				__( 'Link title', 'js_composer' )  => 'name',
				__( 'Link rating', 'js_composer' ) => 'rating',
				__( 'Link ID', 'js_composer' )     => 'id',
				__( 'Random', 'js_composer' )      => 'rand'
			)
		),
		array(
			'type'       => 'checkbox',
			'heading'    => __( 'Options', 'js_composer' ),
			'param_name' => 'options',
			'value'      => array(
				__( 'Show Link Image', 'js_composer' )       => 'images',
				__( 'Show Link Name', 'js_composer' )        => 'name',
				__( 'Show Link Description', 'js_composer' ) => 'description',
				__( 'Show Link Rating', 'js_composer' )      => 'rating'
			)
		),
		array(
			'type'       => 'textfield',
			'heading'    => __( 'Number of links to show', 'js_composer' ),
			'param_name' => 'limit'
		),
		array(
			'type'        => 'textfield',
			'heading'     => __( 'Extra class name', 'js_composer' ),
			'param_name'  => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
		)
	)
) );

vc_map( array(
	'name' => 'WP ' . __( 'Categories' ),
	'base' => 'vc_wp_categories',
	'icon' => 'icon-wpb-wp',
	'category' => __( 'WordPress Widgets', 'js_composer' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'A list or dropdown of categories', 'js_composer' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Widget title', 'js_composer' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'js_composer' )
		),
		array(
			'type' => 'checkbox',
			'heading' => __( 'Options', 'js_composer' ),
			'param_name' => 'options',
			'value' => array(
				__( 'Display as dropdown', 'js_composer' ) => 'dropdown',
				__( 'Show post counts', 'js_composer' ) => 'count',
				__( 'Show hierarchy', 'js_composer' ) => 'hierarchical'
			)
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'js_composer' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
		)
	)
) );


vc_map( array(
	'name' => 'WP ' . __( 'Archives' ),
	'base' => 'vc_wp_archives',
	'icon' => 'icon-wpb-wp',
	'category' => __( 'WordPress Widgets', 'js_composer' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'A monthly archive of your sites posts', 'js_composer' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Widget title', 'js_composer' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'js_composer' )
		),
		array(
			'type' => 'checkbox',
			'heading' => __( 'Options', 'js_composer' ),
			'param_name' => 'options',
			'value' => array(
				__( 'Display as dropdown', 'js_composer' ) => 'dropdown',
				__( 'Show post counts', 'js_composer' ) => 'count'
			)
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'js_composer' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
		)
	)
) );

vc_map( array(
	'name' => 'WP ' . __( 'RSS' ),
	'base' => 'vc_wp_rss',
	'icon' => 'icon-wpb-wp',
	'category' => __( 'WordPress Widgets', 'js_composer' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'Entries from any RSS or Atom feed', 'js_composer' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Widget title', 'js_composer' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'js_composer' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'RSS feed URL', 'js_composer' ),
			'param_name' => 'url',
			'description' => __( 'Enter the RSS feed URL.', 'js_composer' ),
			'admin_label' => true
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Items', 'js_composer' ),
			'param_name' => 'items',
			'value' => array( __( '10 - Default', 'js_composer' ) => '', 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20 ),
			'description' => __( 'How many items would you like to display?', 'js_composer' ),
			'admin_label' => true
		),
		array(
			'type' => 'checkbox',
			'heading' => __( 'Options', 'js_composer' ),
			'param_name' => 'options',
			'value' => array(
				__( 'Display item content?', 'js_composer' ) => 'show_summary',
				__( 'Display item author if available?', 'js_composer' ) => 'show_author',
				__( 'Display item date?', 'js_composer' ) => 'show_date'
			)
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'js_composer' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
		)
	)
) );

/* Empty Space Element
---------------------------------------------------------- */
vc_map( array(
	'name' => __( 'Empty Space', 'js_composer' ),
	'base' => 'vc_empty_space',
	'icon' => 'icon-wpb-ui-empty_space',
	'show_settings_on_create' => true,
	'category' => __( 'Content', 'js_composer' ),
	'description' => __( 'Add spacer with custom height', 'js_composer' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Height', 'js_composer' ),
			'param_name' => 'height',
			'value' => '32px',
			'admin_label' => true,
			'description' => __( 'Enter empty space height.', 'js_composer' ),
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'js_composer' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
		),
	),
) );

/* Custom Heading element
----------------------------------------------------------- */
vc_map( array(
    'name' => __( 'Custom Heading', 'js_composer' ),
    'base' => 'vc_custom_heading',
    'icon' => 'icon-wpb-ui-custom_heading',
    'show_settings_on_create' => true,
    'category' => __( 'Content', 'js_composer' ),
    'description' => __( 'Add custom heading text with google fonts', 'js_composer' ),
    'params' => array(
        array(
            'type' => 'textarea',
            'heading' => __( 'Text', 'js_composer' ),
            'param_name' => 'text',
            'admin_label' => true,
            'value'=> __( 'This is custom heading element with Google Fonts', 'js_composer' ),
            'description' => __( 'Enter your content. If you are using non-latin characters be sure to activate them under Settings/Visual Composer/General Settings.', 'js_composer' ),
        ),
        array(
            'type' => 'font_container',
            'param_name' => 'font_container',
            'value'=>'',
            'settings'=>array(
                'fields'=>array(
                    'tag'=>'h2', // default value h2
                    'text_align',
                    'font_size',
                    'line_height',
                    'color',
                    //'font_style_italic'
                    //'font_style_bold'
                    //'font_family'

                    'tag_description' => __('Select element tag.','js_composer'),
                    'text_align_description' => __('Select text alignment.','js_composer'),
                    'font_size_description' => __('Enter font size.','js_composer'),
                    'line_height_description' => __('Enter line height.','js_composer'),
                    'color_description' => __('Select color for your element.','js_composer'),
                    //'font_style_description' => __('Put your description here','js_composer'),
                    //'font_family_description' => __('Put your description here','js_composer'),
                ),
            ),
           // 'description' => __( '', 'js_composer' ),
        ),
        array(
            'type' => 'google_fonts',
            'param_name' => 'google_fonts',
            'value' => '',// Not recommended, this will override 'settings'. 'font_family:'.rawurlencode('Exo:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic').'|font_style:'.rawurlencode('900 bold italic:900:italic'),
            'settings' => array(
                //'no_font_style' // Method 1: To disable font style
                //'no_font_style'=>true // Method 2: To disable font style
                'fields'=>array(
                    'font_family'=>'Abril Fatface:regular', //'Exo:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic',// Default font family and all available styles to fetch
                    'font_style'=>'400 regular:400:normal', // Default font style. Name:weight:style, example: "800 bold regular:800:normal"
                    'font_family_description' => __('Select font family.','js_composer'),
                    'font_style_description' => __('Select font styling.','js_composer')
                )
            ),
           // 'description' => __( '', 'js_composer' ),
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Extra class name', 'js_composer' ),
            'param_name' => 'el_class',
            'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
        ),
        array(
            'type' => 'css_editor',
            'heading' => __( 'Css', 'js_composer' ),
            'param_name' => 'css',
            // 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
            'group' => __( 'Design options', 'js_composer' )
        )
    ),
) );

/*** Visual Composer Content elements refresh ***/
class VcSharedLibrary {
	// Here we will store plugin wise (shared) settings. Colors, Locations, Sizes, etc...
	private static $colors = array(
		'Blue' => 'blue', // Why __( 'Blue', 'js_composer' ) doesn't work?
		'Turquoise' => 'turquoise',
		'Pink' => 'pink',
		'Violet' => 'violet',
		'Peacoc' => 'peacoc',
		'Chino' => 'chino',
		'Mulled Wine' => 'mulled_wine',
		'Vista Blue' => 'vista_blue',
		'Black' => 'black',
		'Grey' => 'grey',
		'Orange' => 'orange',
		'Sky' => 'sky',
		'Green' => 'green',
		'Juicy pink' => 'juicy_pink',
		'Sandy brown' => 'sandy_brown',
		'Purple' => 'purple',
		'White' => 'white'
	);

	public static $icons = array(
		'Glass' => 'glass',
		'Music' => 'music',
		'Search' => 'search'
	);

	public static $sizes = array(
		'Mini' => 'xs',
		'Small' => 'sm',
		'Normal' => 'md',
		'Large' => 'lg'
	);

	public static $button_styles = array(
		'Rounded' => 'rounded',
		'Square' => 'square',
		'Round' => 'round',
		'Outlined' => 'outlined',
		'3D' => '3d',
		'Square Outlined' => 'square_outlined'
	);

	public static $cta_styles = array(
		'Rounded' => 'rounded',
		'Square' => 'square',
		'Round' => 'round',
		'Outlined' => 'outlined',
		'Square Outlined' => 'square_outlined'
	);

	public static $txt_align = array(
		'Left' => 'left',
		'Right' => 'right',
		'Center' => 'center',
		'Justify' => 'justify'
	);

	public static $el_widths = array(
		'100%' => '',
		'90%' => '90',
		'80%' => '80',
		'70%' => '70',
		'60%' => '60',
		'50%' => '50'
	);

	public static $sep_styles = array(
		'Border' => '',
		'Dashed' => 'dashed',
		'Dotted' => 'dotted',
		'Double' => 'double'
	);

	public static $box_styles = array(
		'Default' => '',
		'Rounded' => 'vc_box_rounded',
		'Border' => 'vc_box_border',
		'Outline' => 'vc_box_outline',
		'Shadow' => 'vc_box_shadow',
		'Bordered shadow' => 'vc_box_shadow_border',
		'3D Shadow' => 'vc_box_shadow_3d',
		'Circle' => 'vc_box_circle', //new
		'Circle Border' => 'vc_box_border_circle', //new
		'Circle Outline' => 'vc_box_outline_circle', //new
		'Circle Shadow' => 'vc_box_shadow_circle', //new
		'Circle Border Shadow' => 'vc_box_shadow_border_circle' //new
	);

	public static function getColors() {
		return self::$colors;
	}

	public static function getIcons() {
		return self::$icons;
	}

	public static function getSizes() {
		return self::$sizes;
	}

	public static function getButtonStyles() {
		return self::$button_styles;
	}

	public static function getCtaStyles() {
		return self::$cta_styles;
	}

	public static function getTextAlign() {
		return self::$txt_align;
	}

	public static function getElementWidths() {
		return self::$el_widths;
	}

	public static function getSeparatorStyles() {
		return self::$sep_styles;
	}

	public static function getBoxStyles() {
		return self::$box_styles;
	}
}

//VcSharedLibrary::getColors();
function getVcShared( $asset = '' ) {
	switch ( $asset ) {
		case 'colors':
			return VcSharedLibrary::getColors();
			break;

		case 'icons':
			return VcSharedLibrary::getIcons();
			break;

		case 'sizes':
			return VcSharedLibrary::getSizes();
			break;

		case 'button styles':
		case 'alert styles':
			return VcSharedLibrary::getButtonStyles();
			break;

		case 'cta styles':
			return VcSharedLibrary::getCtaStyles();
			break;

		case 'text align':
			return VcSharedLibrary::getTextAlign();
			break;

		case 'cta widths':
		case 'separator widths':
			return VcSharedLibrary::getElementWidths();
			break;

		case 'separator styles':
			return VcSharedLibrary::getSeparatorStyles();
			break;

		case 'single image styles':
			return VcSharedLibrary::getBoxStyles();
			break;

		default:
			# code...
			break;
	}
}
