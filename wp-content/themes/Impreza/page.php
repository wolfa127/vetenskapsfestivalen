<?php
define('THEME_TEMPLATE', TRUE);
define('IS_FULLWIDTH', TRUE);
global $smof_data;
get_header(); ?>
<?php if (have_posts()) { while(have_posts()) { the_post(); ?>
	<?php get_template_part( 'templates/pagehead' ); ?>
	<?php if (us_is_vc_fe()) { ?>
		<div class="l-submain">
			<div class="l-submain-h g-html i-cf">
				<?php the_content(); ?>
			</div>
		</div>
	<?php } else { ?>
		<?php the_content(); ?>
	<?php } ?>
	<?php if (@$smof_data['page_comments'] == 1 AND (comments_open() || get_comments_number() != '0')) { ?>
	<div class="l-submain">
		<div class="l-submain-h g-html i-cf">
		<?php comments_template();?>
		</div>
	</div>
	<?php } ?>
<?php }  } else { ?>
	<?php _e('No posts were found.', 'us'); ?>
<?php } ?>
<?php get_footer(); ?>
