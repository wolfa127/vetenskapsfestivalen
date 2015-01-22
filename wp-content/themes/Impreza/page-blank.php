<?php
/*
Template Name: Blank Page
*/
define('THEME_TEMPLATE', TRUE);
define('IS_FULLWIDTH', TRUE);
get_header('blank'); ?>
<?php if (have_posts()) : while(have_posts()) : the_post(); ?>
	<?php the_content(); ?>
<?php endwhile; else : ?>
	<?php _e('No posts were found.', 'us'); ?>
<?php endif; ?>
<?php get_footer('blank'); ?>
