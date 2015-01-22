<?php
$attributes = shortcode_atts(
	array(
		'type' => "",
		'size' => "",
		'icon' => "",
		'text' => "",
	), $atts);

$simple_class = '';
if ($attributes['icon'] == '' AND $attributes['text'] == '') {
	$simple_class = ' no_icon';
}

if ($attributes['text'] != '') {
	$simple_class = ' with_text';
	$content_part = '<h6>'.$attributes['text'].'</h6>';
} else {
	$content_part = '<i class="fa fa-'.$attributes['icon'].'"></i>';
}

$type_class = ($attributes['type'] != '')?' type_'.$attributes['type']:'';
$size_class = ($attributes['size'] != '')?' size_'.$attributes['size']:'';

$output = 	'<div class="g-hr'.$type_class.$size_class.$simple_class.'">
						<span class="g-hr-h">
							'.$content_part.'
						</span>
					</div>';

echo $output;
