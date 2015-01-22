<?php
$attributes = shortcode_atts(
	array(
		'type' => null,
		'color' => null,
	), $atts);

if (empty($attributes['color']) AND ( ! empty($attributes['type']))) {
	$attributes['color'] = $attributes['type'];
}

if ( ! in_array($attributes['color'], array('info', 'attention', 'success', 'error', ))) {
	$attributes['color'] = 'info';
}


$output = '<div class="g-alert with_close type_'.$attributes['color'].'"><div class="g-alert-close"> &#10005 </div><div class="g-alert-body"><p>'.do_shortcode($content).'</p></div></div>';

echo $output;
