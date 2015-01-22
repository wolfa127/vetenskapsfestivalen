<?php
$output = $el_class = $css_animation = '';

extract(shortcode_atts(array(
	'el_class' => '',
), $atts));

if (mb_substr(trim($content), 0, 1) != '<') {
	$content = '<p>'.$content;
}

$css_class = 'wpb_text_column '.$el_class;
$output .= "\n\t".'<div class="'.$css_class.'">';
$output .= "\n\t\t".'<div class="wpb_wrapper">';
$output .= "\n\t\t\t".do_shortcode($content);
$output .= "\n\t\t".'</div> ';
$output .= "\n\t".'</div> ';

echo $output;
