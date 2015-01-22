<?php global $smof_data; ?><!DOCTYPE HTML>
<?php
$no_responsive_class = ( ! isset($smof_data['responsive_layout']) OR $smof_data['responsive_layout'] == 1) ? '':'no-responsive';
?>
<html class="<?php echo $no_responsive_class;?>" <?php language_attributes('html')?>>
<head>
	<meta charset="UTF-8">
	<title><?php bloginfo('name'); ?><?php wp_title(' - ', true, 'left'); ?></title>

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />

	<?php if(@$smof_data['custom_favicon'] != "") { ?><link rel="shortcut icon" href="<?php echo @$smof_data['custom_favicon']; ?>"><?php } ?>

	<?php wp_head(); ?>
	<?php
	global $load_styles_directly;
	if (isset($load_styles_directly) AND $load_styles_directly)
	{
		get_template_part('templates/custom_css');
	}
	?>

</head><?php
$body_background_styles_text = '';

$body_background_image = (@$smof_data['body_background_image'] != '')?@$smof_data['body_background_image']:'';

if ($body_background_image != '')
{
	$body_background_styles = array( 'background-image' => 'url('.$body_background_image.')');

	$body_background_image_stretch = (@$smof_data['body_background_image_stretch'] == 1)?TRUE:FALSE;
	if ($body_background_image_stretch) {
		$body_background_styles['background-size'] = 'cover';
	}

	if (@$smof_data['body_background_image_repeat'] != '') {
		$baclgroundRepeatCss = array(
			'Repeat' => 'repeat',
			'Repeat Horizontally' => 'repeat-x',
			'Repeat Vertically' => 'repeat-y',
			'Do Not Repeat' => 'no-repeat',
		);
		$body_background_styles['background-repeat'] = $baclgroundRepeatCss[@$smof_data['body_background_image_repeat']];
	}

	if (@$smof_data['body_background_image_position'] != '') {
		$body_background_styles['background-position'] = @$smof_data['body_background_image_position'];
	}

	if (@$smof_data['body_background_image_attachment'] == 'Background is fixed with regard to the viewport') {

		$body_background_styles['background-attachment'] = 'fixed';
	}

	foreach ($body_background_styles as $body_background_style => $body_background_style_val)
	{
		$body_background_styles_text .= $body_background_style.': '.$body_background_style_val.';';
	}
}
?>
<body <?php body_class('l-body'); ?><?php echo  ($body_background_styles_text != '')?' style="'.$body_background_styles_text.'"':''; ?>>
<!-- CANVAS -->
<div class="l-canvas">


	<!-- MAIN -->
	<div class="l-main">
<?php
if ( ! defined('THEME_TEMPLATE') AND FALSE) {
	// Disabling Section shortcode
	global $disable_section_shortcode;
	$disable_section_shortcode = TRUE;
?>
		<div class="l-submain">
			<div class="l-submain-h g-html i-cf">
<?php } ?>
