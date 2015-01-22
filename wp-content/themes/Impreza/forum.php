<?php
define('THEME_TEMPLATE', TRUE);
global $disable_section_shortcode, $smof_data;
$disable_section_shortcode = TRUE;

if (@$smof_data['forum_sidebar_pos'] == 'No Sidebar')
{
	define('IS_FULLWIDTH', TRUE);
}
elseif (@$smof_data['forum_sidebar_pos'] == 'Left')
{
	define('SIDEBAR_POS', 'left');
}
else
{
	define('SIDEBAR_POS', 'right');
}

get_header(); ?>
<?php if (have_posts()) : while(have_posts()) : the_post(); ?>
	<?php get_template_part( 'templates/pagehead' ); ?>
	<div class="l-submain">
		<div class="l-submain-h g-html i-cf">
			<div class="l-content">
				<?php the_content(); ?>
			</div>
			<div class="l-sidebar at_left">
				<?php if (defined('SIDEBAR_POS') AND SIDEBAR_POS == 'left') dynamic_sidebar('bbpress_sidebar'); ?>
			</div>
			<div class="l-sidebar at_right">
				<?php if (defined('SIDEBAR_POS') AND SIDEBAR_POS == 'right') dynamic_sidebar('bbpress_sidebar'); ?>
			</div>
		</div>
	</div>

<?php endwhile; else : ?>
	<?php _e('No posts were found.', 'us'); ?>
<?php endif; ?>
<?php get_footer(); ?>
