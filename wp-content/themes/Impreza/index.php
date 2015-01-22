<?php
define('THEME_TEMPLATE', TRUE);
global $smof_data, $us_shortcodes;
if ($smof_data['blog_layout'] == 'Masonry Grid with pagination' OR $smof_data['blog_layout'] == 'Masonry Grid with ajax load' OR $smof_data['blog_sidebar_pos'] == 'No Sidebar')
{
	define('IS_FULLWIDTH', TRUE);
}
else
{
	// Disabling Section shortcode
	global $disable_section_shortcode;
	$disable_section_shortcode = TRUE;
}
define('IS_BLOG', TRUE);
get_header();
?>
<?php
if ($smof_data['blog_layout'] == 'Masonry Grid with ajax load')
{
	?>
	<div class="l-submain">
		<div class="l-submain-h g-html i-cf">
			<div class="l-content">
				<?php get_template_part( 'templates/blog_grid' ); ?>
			</div>
		</div>
	</div>
	<?php
}
elseif ($smof_data['blog_layout'] == 'Masonry Grid with pagination')
{
	?>
	<div class="l-submain">
		<div class="l-submain-h g-html i-cf">
			<div class="l-content">
				<?php get_template_part( 'templates/blog_grid_paginated' ); ?>
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
				switch ($smof_data['blog_layout'])
				{
					case 'Small Image' :
						get_template_part( 'templates/blog_small' );
						break;
//					case 'Simple' :
//						get_template_part( 'templates/blog_simple' );
//						break;
					default : get_template_part( 'templates/blog_big' );
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