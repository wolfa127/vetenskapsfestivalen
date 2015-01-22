<?php

/**
 * Embed custom fonts
 */
function us_enqueue_fonts() {
	global $smof_data;

	$font_weights = array('200', '300', '400', '600', '700');
	$prefixes = array('heading', 'body', 'nav');

	// Compatibility with the previous version
	if ( ! isset($smof_data['heading_font_family']) AND isset($smof_data['heading_font'])){
		$smof_data['heading_font_family'] = $smof_data['heading_font'];
	}
	if ( ! isset($smof_data['body_font_family']) AND isset($smof_data['body_text_font'])){
		$smof_data['body_font_family'] = $smof_data['body_text_font'];
	}
	if ( ! isset($smof_data['nav_font_family']) AND isset($smof_data['navigation_font'])){
		$smof_data['nav_font_family'] = $smof_data['navigation_font'];
	}

	$fonts = array();

	foreach ( $prefixes as $prefix ){
		// Some error in options
		if ( ! isset($smof_data[$prefix.'_font_family']) OR empty($smof_data[$prefix.'_font_family']))
			continue;

		// Web safe combination or empty font selected
		if ($smof_data[$prefix.'_font_family'] == 'none' OR strpos(',', $smof_data[$prefix.'_font_family'] !== FALSE))
			continue;

		$font_family = str_replace(' ', '+', $smof_data[$prefix.'_font_family']);
		if ( ! isset($fonts[$font_family])){
			$fonts[$font_family] = array();
		}

		// Do we need to load italic font styles as well?
		$has_italic = (isset($smof_data[$prefix.'_font_style_italic']) AND ($smof_data[$prefix.'_font_style_italic'] == 1));

		$selected_font_weights = array();

		foreach ( $font_weights as $font_weight ) {
			if (isset($smof_data[$prefix.'_font_weight_'.$font_weight]) AND $smof_data[$prefix.'_font_weight_'.$font_weight] == 1){
				$selected_font_weights[] = $font_weight;
			}
		}

		// Fault tolerance for missing font-heights
		if (count($selected_font_weights) == 0) {
			$selected_font_weights = array('400', '700');
		}

		foreach ( $selected_font_weights as $font_weight ) {
			$fonts[$font_family][] = $font_weight;
			if ($has_italic){
				$fonts[$font_family][] = $font_weight.'italic';
			}
		}
	}

	$protocol = is_ssl() ? 'https' : 'http';
	$subset = (isset($smof_data['font_subset']) AND ! empty($smof_data['font_subset'])) ? ('&subset='.$smof_data['font_subset']) : '';

	$font_index = 1;
	foreach ( $fonts as $font_name => $font_weights ){
		if (count($font_weights) == 0)
			continue;
		$font_weights = array_unique($font_weights);

		// Google font url
		$font_url = $protocol.'://fonts.googleapis.com/css?family='.$font_name.':'.implode(',', $font_weights).$subset;

		wp_enqueue_style( 'us-font-'.$font_index, $font_url );

		$font_index++;
	}

}
add_action( 'wp_enqueue_scripts', 'us_enqueue_fonts' );

function us_styles()
{
	global $smof_data;

	$template_directory_uri = get_template_directory_uri();

	// Retrieving theme version
	$theme = wp_get_theme();
	$theme_version = $theme->get('Version');

	wp_register_style('us-motioncss', $template_directory_uri.'/css/motioncss.css', array(), $theme_version, 'all');
	wp_enqueue_style('us-motioncss');

	if ( ! isset($smof_data['responsive_layout']) OR $smof_data['responsive_layout'] == 1){
		wp_register_style('us-motioncss-responsive', $template_directory_uri.'/css/motioncss-responsive.css', array(), $theme_version, 'all');
		wp_enqueue_style('us-motioncss-responsive');
	}

	wp_register_style('us-font-awesome', $template_directory_uri.'/css/font-awesome.css', array(), '4.2.0', 'all');
	wp_enqueue_style('us-font-awesome');

	wp_register_style('us-magnific-popup', $template_directory_uri.'/css/magnific-popup.css', array(), '1', 'all');
	wp_enqueue_style('us-magnific-popup');

	wp_register_style('us-fotorama', $template_directory_uri.'/css/fotorama.css', array(), '1', 'all');
	wp_enqueue_style('us-fotorama');

	wp_register_style('us-style', $template_directory_uri.'/css/style.css', array(), $theme_version, 'all');
	wp_enqueue_style('us-style');

	if ( ! isset($smof_data['responsive_layout']) OR $smof_data['responsive_layout'] == 1){
		wp_register_style('us-responsive', $template_directory_uri.'/css/responsive.css', array(), $theme_version, 'all');
		wp_enqueue_style('us-responsive');
	}
	if (us_is_vc_fe()){
		wp_register_style('us-js-composer-fe', $template_directory_uri.'/vc_templates/css/us.js_composer_fe.css', array(), '1', 'all');
		wp_enqueue_style('us-js-composer-fe');
	}else{
		wp_dequeue_style('js_composer_front');
	}
}
add_action('wp_enqueue_scripts', 'us_styles', 12);

function us_custom_styles()
{
	$wp_upload_dir  = wp_upload_dir();
	$styles_dir = $wp_upload_dir['basedir'].'/us_custom_css';
	$styles_dir = str_replace('\\', '/', $styles_dir);
	$styles_file = $styles_dir.'/us_impreza_custom_styles.css';

	// Retrieving theme version
	$theme = wp_get_theme();
	$theme_version = $theme->get('Version');

	if (get_template_directory_uri() !=  get_stylesheet_directory_uri()){
		wp_register_style('impeza-style' ,  get_stylesheet_directory_uri() . '/style.css', array(), $theme_version, 'all');
		wp_enqueue_style('impeza-style');
	}

	if (file_exists($styles_file)){
		wp_register_style('us_custom_css', $wp_upload_dir['baseurl'] . '/us_custom_css/us_impreza_custom_styles.css', array(), $theme_version, 'all');
		wp_enqueue_style('us_custom_css');
	}
	else {
		global $load_styles_directly;
		$load_styles_directly = true;
	}
}
add_action('wp_enqueue_scripts', 'us_custom_styles', 17);

function us_jscripts()
{
	$template_directory_url = get_template_directory_uri();

	// Retrieving theme version
	$theme = wp_get_theme();
	$theme_version = $theme->get('Version');

	wp_register_script('us-modernizr', $template_directory_url.'/js/modernizr.js', array('jquery'));
	wp_enqueue_script('us-modernizr');

	wp_register_script('us-jquery-easing', $template_directory_url.'/js/jquery.easing.min.js', array('jquery'), '', TRUE);
	wp_enqueue_script('us-jquery-easing');

	wp_register_script('us-isotope', $template_directory_url.'/js/jquery.isotope.js', array('jquery'), '', TRUE);

	wp_register_script('us-fotorama', $template_directory_url.'/js/fotorama.js', array('jquery'));

	wp_register_script('us-slick', $template_directory_url.'/js/slick.min.js', array('jquery'), '', TRUE);

	wp_register_script('us-magnific-popup', $template_directory_url.'/js/jquery.magnific-popup.js', array('jquery'), '', TRUE);
	wp_enqueue_script('us-magnific-popup');

	// Google Maps are enqueued in the first map shortcode
	wp_register_script('us-google-maps', 'http://maps.google.com/maps/api/js?sensor=false', array(), '', FALSE);
	wp_register_script('us-gmap', $template_directory_url.'/js/jquery.gmap.min.js', array('jquery'), '', TRUE);

	wp_register_script('us-parallax', $template_directory_url.'/js/jquery.parallax.js', array('jquery'), $theme_version, TRUE);
	wp_register_script('us-hor-parallax', $template_directory_url.'/js/jquery.horparallax.js', array('jquery'), $theme_version, TRUE);

	wp_register_script('us-simpleplaceholder', $template_directory_url.'/js/jquery.simpleplaceholder.js', array('jquery'), '', TRUE);
	wp_enqueue_script('us-simpleplaceholder');

	wp_register_script('us-waypoints', $template_directory_url.'/js/waypoints.min.js', array('jquery'), '', TRUE);
	wp_enqueue_script('us-waypoints');

	wp_register_script('us-imagesloaded', $template_directory_url.'/js/imagesloaded.js', array('jquery'), '', TRUE);
	wp_enqueue_script('us-imagesloaded');

	wp_register_script('us-mediaelement', $template_directory_url.'/js/mediaelement-and-player.js', array('jquery'), '', TRUE);

	wp_register_script('us-plugins', $template_directory_url.'/js/plugins.js', array('jquery'), $theme_version, TRUE);
	wp_register_script('us-widgets', $template_directory_url.'/js/us.widgets.js', array('jquery'), $theme_version, TRUE);
	wp_enqueue_script('us-plugins');
	wp_enqueue_script('us-widgets');

	wp_enqueue_script('comment-reply');
}


add_action('wp_enqueue_scripts', 'us_jscripts');
