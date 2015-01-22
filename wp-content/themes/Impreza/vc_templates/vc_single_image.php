<?php

$output = $el_class = $image = $img_size = $img_link = $img_link_target = $img_link_large = $title = $css_animation = '';

extract(shortcode_atts(array(
	'title' => '',
	'image' => $image,
	'img_size'  => 'full',
	'img_link_large' => false,
	'img_link' => '',
	'img_link_target' => '_self',
	'img_link_new_tab' => false,
	'el_class' => '',
	'animate' => '',
	'animate_delay' => '',
	'align' => '',
	'target' => '',
), $atts));

$img_id = preg_replace('/[^\d]/', '', $image);
//$img = wpb_getImageBySize(array( 'attach_id' => $img_id, 'thumb_size' => $img_size ));
$img = wp_get_attachment_image($img_id, $img_size, 0);
if ( $img == NULL ) $img = '<img src="http://placekitten.com/g/400/300" /> <small>'.__('This is image placeholder, edit your page to replace it.', 'js_composer').'</small>';


$a_class = '';
if ( $el_class != '' ) {
	$tmp_class = explode(" ", strtolower($el_class));
	$tmp_class = str_replace(".", "", $tmp_class);
	if ( in_array("prettyphoto", $tmp_class) ) {
		wp_enqueue_script( 'prettyphoto' );
		wp_enqueue_style( 'prettyphoto' );
		$a_class = ' class="prettyphoto"';
		$el_class = str_ireplace(" prettyphoto", "", $el_class);
	}
}

$link_to = '';
$ref = '';
if ($img_link_large==true) {
	$link_to = wp_get_attachment_image_src( $img_id, 'large');
	$link_to = $link_to[0];
	$ref = ' ref="magnificPopup"';
}
else if (!empty($img_link)) {
	$link_to = $img_link;
}
$target_arg = '';
if ($img_link_target != '_self' OR $img_link_new_tab != false) {
	$target_arg = ' target="_blank"';
}
$image_string = !empty($link_to) ? '<a'.$a_class.' href="'.$link_to.'"'.$target_arg.$ref.'>'.$img.'</a>' : $img;

$align_class = ($align != '')?' align_'.$align:'';
$animate_class = ($animate != '')?' animate_'.$animate:'';

$animate_delay_classes = array(
	'0.2' => 'd1',
	'0.4' => 'd2',
	'0.6' => 'd3',
	'0.8' => 'd4',
	'1' => 'd5',
);

$animate_class .= (isset($animate_delay_classes[$animate_delay]))?' '.$animate_delay_classes[$animate_delay]:'';

$css_class =  'wpb_single_image wpb_content_element'.$el_class;

$output .= "\n\t".'<div class="'.$css_class.$animate_class.$align_class.'">';
$output .= "\n\t\t".'<div class="wpb_wrapper">';
$output .= "\n\t\t\t".$image_string;
$output .= "\n\t\t".'</div> ';
$output .= "\n\t".'</div> ';

echo $output;
