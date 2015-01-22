<?php
$output = $el_class = $width = '';
extract(shortcode_atts(array(
	'el_class' => '',
	'width' => '1/1',
	'animate' => '',
	'animate_delay' => '',
), $atts));


switch ($width) {
	case '1/2': $width_class = 'one-half';
		break;
	case '1/3': $width_class = 'one-third';
		break;
	case '2/3': $width_class = 'two-thirds';
		break;
	case '1/4': $width_class = 'one-quarter';
		break;
	case '3/4': $width_class = 'three-quarters';
		break;
	case '1/6': $width_class = 'one-sixth';
		break;
	case '5/6': $width_class = 'five-sixths';
		break;
	default: $width_class = 'full-width';
}

$animate_class = ($animate != '')?' animate_'.$animate:'';

$animate_delay_classes = array(
	'0.2' => 'd1',
	'0.4' => 'd2',
	'0.6' => 'd3',
	'0.8' => 'd4',
	'1' => 'd5',
);

$animate_class .= (isset($animate_delay_classes[$animate_delay]))?' '.$animate_delay_classes[$animate_delay]:'';

$css_class = $width_class.$el_class.$animate_class;
//$output .= "\n\t".'<div class="'.$css_class.'">';
//$output .= "\n\t\t".'<div class="wpb_wrapper">';
//$output .= "\n\t\t\t".wpb_js_remove_wpautop($content);
//$output .= "\n\t\t".'</div> '.$this->endBlockComment('.wpb_wrapper');
//$output .= "\n\t".'</div> '.$this->endBlockComment($el_class) . "\n";

$output = '<div class="'.$css_class.'">'.do_shortcode($content).'</div>';

echo $output;
