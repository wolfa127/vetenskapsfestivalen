<?php
$output = $title = $alias = $el_class = '';
extract( shortcode_atts( array(
	'title' => '',
	'alias' => '',
	'el_class' => ''
), $atts ) );

$css_class = 'wpb_revslider_element wpb_content_element' . $el_class;

$output .= '<div class="'.$css_class.'">';
$output .= do_shortcode('[rev_slider '.$alias.']');
$output .= '</div>'."\n";

echo $output;
