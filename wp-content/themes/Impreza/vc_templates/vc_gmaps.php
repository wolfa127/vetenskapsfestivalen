<?php
$output = $title = $link = $size = $zoom = $type = $bubble = $el_class = '';
extract(shortcode_atts(array(
	'address' => '',
	'latitude' => '',
	'longitude' => '',
	'marker' => '',
	'marker_address' => '',
	'marker_2' => '',
	'marker_2_address' => '',
	'marker_3' => '',
	'marker_3_address' => '',
	'marker_4' => '',
	'marker_4_address' => '',
	'marker_5' => '',
	'marker_5_address' => '',
	'custom_marker' => FALSE,
	'custom_marker_img' => FALSE,
	'custom_marker_size' => 20,
	'height' => 400,
	'zoom' => 14,
	'type' => 'ROADMAP',

), $atts));

if ( ! in_array( $custom_marker_size, array(20, 30, 40, 50, 60, 70, 80, ) ) ) {
	$custom_marker_size = 20;
}

if ( ! in_array( $zoom, array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20 ) ) ) {
	$zoom = 14;
}
$map_id = rand(99999, 999999);

if ($latitude != '' AND $longitude != '') {
	$map_location_options = 'latitude: "'.$latitude.'", longitude: "'.$longitude.'", ';
} elseif ($address != '') {
	$map_location_options = 'address: "'.$address.'", ';
} else {
	return null;
}

$markers = array();
$marker_title_options = '';
if ($marker != '') {
	$marker_title_options = 'html: "'.$marker.'"';
}


if ($marker_title_options != '') {
	$markers[] = '{'.$map_location_options.$marker_title_options.'}';
}

$marker_2_title_options = '';
if ($marker_2 != '') {
	$marker_2_title_options = 'html: "'.$marker_2.'"';
}
$marker_2_address_options = '';
if ($marker_2_address != '') {
	$marker_2_address_options = 'address: "'.$marker_2_address.'", ';
}

if ($marker_2_address_options != '' AND $marker_2_title_options != '') {
	$markers[] = '{'.$marker_2_address_options.$marker_2_title_options.'}';
}

$marker_3_title_options = '';
if ($marker_3 != '') {
	$marker_3_title_options = 'html: "'.$marker_3.'"';
}
$marker_3_address_options = '';
if ($marker_3_address != '') {
	$marker_3_address_options = 'address: "'.$marker_3_address.'", ';
}

if ($marker_3_address_options != '' AND $marker_3_title_options != '') {
	$markers[] = '{'.$marker_3_address_options.$marker_3_title_options.'}';
}

$marker_4_title_options = '';
if ($marker_4 != '') {
	$marker_4_title_options = 'html: "'.$marker_4.'"';
}
$marker_4_address_options = '';
if ($marker_4_address != '') {
	$marker_4_address_options = 'address: "'.$marker_4_address.'", ';
}

if ($marker_4_address_options != '' AND $marker_4_title_options != '') {
	$markers[] = '{'.$marker_4_address_options.$marker_4_title_options.'}';
}

$marker_5_title_options = '';
if ($marker_5 != '') {
	$marker_5_title_options = 'html: "'.$marker_5.'"';
}
$marker_5_address_options = '';
if ($marker_5_address != '') {
	$marker_5_address_options = 'address: "'.$marker_5_address.'", ';
}

if ($marker_5_address_options != '' AND $marker_5_title_options != '') {
	$markers[] = '{'.$marker_5_address_options.$marker_5_title_options.'}';
}

$markers = implode(',',$markers);

$custom_marker_options = '';

if ($custom_marker_img != '')
{
	if (is_numeric($custom_marker_img))
	{
		$custom_marker_img_id = preg_replace('/[^\d]/', '', $custom_marker_img);
		$custom_marker_img = wp_get_attachment_image_src($custom_marker_img_id, 'full', 0);

		if ( $custom_marker_img != NULL )
		{
			$custom_marker_img = $custom_marker_img[0];
		}
	}
	$custom_marker_width_half = ceil($custom_marker_size/2);

	$custom_marker_options = 'icon: {
		image: "'.$custom_marker_img.'",
		iconsize: ['.$custom_marker_size.', '.$custom_marker_size.'],
		iconanchor: ['.$custom_marker_width_half.', '.$custom_marker_size.']
	},';
}

if ($height == '') {
	$height = 400;
}

// Enqueued the script only once
if( ! wp_script_is('us-google-maps', 'enqueued')){
	wp_enqueue_script('us-google-maps');
	wp_enqueue_script('us-gmap');
}

$output = '<div class="w-map" id="map_'.$map_id.'" style="height: '.$height.'px">
				<div class="w-map-h">

				</div>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function(){
					jQuery("#map_'.$map_id.'").gMap({
						'.$map_location_options.'
						zoom: '.$zoom.',
						maptype: "'.$type.'",'.$custom_marker_options.'
						markers:['.$markers.']
					});
				});
			</script>';

echo $output;
