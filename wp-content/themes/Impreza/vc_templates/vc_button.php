<?php
$output = $color = $size = $icon = $target = $href = $el_class = $title = $position = '';
$attributes = shortcode_atts(array(
	'text' => '',
	'url' => '',
	'target' => '',
	'type' => 'default',
	'outlined' => false,
	'size' => '',
	'icon' => '',
	'align' => 'left',
), $atts);


$icon_part = '';
if ($attributes['icon'] != '') {
	$icon_part = '<i class="fa fa-'.$attributes['icon'].'"></i>';
}

$output = '<span class="wpb_button align_'.$attributes['align'].'"><a href="'.$attributes['url'].'"';
$output .= ($attributes['target'] == 1 OR $attributes['target'] == '_blank')?' target="_blank"':'';
$output .= ' class="g-btn';
$output .= ($attributes['type'] != '')?' color_'.$attributes['type']:'';
$output .= ($attributes['size'] != '')?' size_'.$attributes['size']:'';
$output .= ($attributes['outlined'] == 1 OR $attributes['outlined'] == 'yes')?' outlined':'';
$output .= ($el_class != '')?' '.$el_class:'';
$output .= '">'.$icon_part.'<span>'.$attributes['text'].'</span></a></span>';

echo $output . "\n";