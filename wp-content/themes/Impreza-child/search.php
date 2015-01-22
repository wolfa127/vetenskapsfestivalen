<?php
define('THEME_TEMPLATE', TRUE);
global $smof_data, $us_shortcodes;
define('IS_BLOG', TRUE);
if ($smof_data['search_layout'] == 'Masonry Grid' OR $smof_data['blog_sidebar_pos'] == 'No Sidebar')
{
	define('IS_FULLWIDTH', TRUE);
}
else
{
	// Disabling Section shortcode
	global $disable_section_shortcode;
	$disable_section_shortcode = TRUE;
}
get_header();

// Disabling Section shortcode
global $disable_section_shortcode;
$disable_section_shortcode = TRUE;
?>

	<div class="l-main">
		<div class="l-submain  _pagehead size_large">
		<div class="l-submain-img" style="background-image: url(http://vetenskapsfestivalen.stendahls.se/wp-content/uploads/2014/12/head_finger1.gif);"></div>        <div class="l-submain-h g-html i-cf">
			<div class="w-pagehead">
									<h1></h1>
					<h1>VETENSKAPSFESTIVALEN</h1><h2>13-24 APRIL 2015. ÅRETS TEMA: LIV OCH DÖD</h2>                                            <!-- breadcrums -->

			</div>
		</div>
	</div>

	<div class="l-submain for_pagehead search_results">
		<div class="l-submain-h g-html i-cf">
			<div class="w-pagehead">
				<h1>Sökresultat för <?php echo ' "'.esc_attr($s).'"'; ?></h1>
				<p></p>

			</div>
		</div>
	</div>

<?php
if ($smof_data['search_layout'] == 'Masonry Grid')
{
	?>
	<div class="l-submain">
		<div class="l-submain-h g-html i-cf">
			<div class="l-content">
				<?php get_template_part( 'templates/archive_grid_paginated' ); ?>
			</div>
		</div>
	</div>
<?php
}
else
{
	?>
	<div class="l-submain">
		<div class="l-submain-h g-html i-cf">
			<div class="l-content">
				<?php
				switch ($smof_data['search_layout'])
				{
					case 'Small Image' :
						get_template_part( 'templates/archive_small' );
						break;
					default :
						get_template_part( 'templates/archive_big' );
						break;
				}

				?>
			</div>
			<div class="l-sidebar at_left">
				<?php if ($smof_data['blog_sidebar_pos'] != 'Right') dynamic_sidebar('default_sidebar'); ?>
			</div>

			<div class="l-sidebar at_right">
				<?php if ($smof_data['blog_sidebar_pos'] == 'Right') dynamic_sidebar('default_sidebar'); ?>
			</div>
		</div>
	</div>
<?php
}

get_footer(); ?>
