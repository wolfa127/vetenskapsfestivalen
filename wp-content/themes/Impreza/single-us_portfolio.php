<?php
define('THEME_TEMPLATE', TRUE);
global $smof_data, $us_shortcodes;

$sidebar_position = 'none';
if (@$smof_data['portfolio_sidebar_pos'] == 'Right') {
	$sidebar_position = 'right';
}
if (@$smof_data['portfolio_sidebar_pos'] == 'Left') {
	$sidebar_position = 'left';
}

if (rwmb_meta('us_sidebar') == 'no_sidebar') {
	$sidebar_position = 'none';
}
if (rwmb_meta('us_sidebar') == 'right') {
	$sidebar_position = 'right';
}
if (rwmb_meta('us_sidebar') == 'left') {
	$sidebar_position = 'left';
}

if ($sidebar_position == 'right') {
	define('SIDEBAR_POS', 'right');
} elseif ($sidebar_position == 'left') {
	define('SIDEBAR_POS', 'left');
} else {
	define('IS_FULLWIDTH', TRUE);
}

get_header(); ?>
<?php if (have_posts()) : while(have_posts()) : the_post(); ?>
<?php
	get_template_part( 'templates/pagehead_portfolio' );

	if ($sidebar_position != 'none') {
		// Disabling Section shortcode
		global $disable_section_shortcode;
		$disable_section_shortcode = TRUE;
		?>
		<div class="l-submain">
		<div class="l-submain-h g-html i-cf">
		<div class="l-content">
<?php
		the_content();
		if (@$smof_data['portfolio_comments'] == 1 AND (comments_open() || get_comments_number() != '0')) {
			comments_template();
		}
?>
		</div>
		<div class="l-sidebar at_<?php echo $sidebar_position; ?>">
			<?php generated_dynamic_sidebar(); ?>
		</div>
		</div>
		</div><?php
	} else {
		the_content();
		if (@$smof_data['portfolio_comments'] == 1 AND (comments_open() || get_comments_number() != '0')) { ?>
			<div class="l-submain">
				<div class="l-submain-h g-html i-cf">
					<?php comments_template();?>
				</div>
			</div>
		<?php }
	}
	?>
	<?php  ?>
<?php endwhile; else : ?>
	<?php _e('No posts were found.', 'us'); ?>
<?php endif; ?>
<?php get_footer(); ?>
