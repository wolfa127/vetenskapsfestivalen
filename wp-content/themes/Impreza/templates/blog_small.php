<?php global $smof_data, $us_thumbnail_size; ?><div class="w-blog imgpos_atleft imgtype_circle">
	<div class="w-blog-list">

		<?php
		$temp = $wp_query; $wp_query= null;
		$wp_query = new WP_Query(); $wp_query->query('paged='.$paged.'&post_type=post');
		while ($wp_query->have_posts())
		{
			$wp_query->the_post();
			$us_thumbnail_size = 'blog-small';
			get_template_part('templates/blog_single_post');
		}
		?>


	</div>
</div>
<?php if (function_exists('us_pagination') AND $pagination = us_pagination()) { ?>
	<div class="w-blog-pagination">
		<div class="g-pagination">
			<?php echo $pagination ?>
		</div>
	</div>
<?php } else  { ?>
	<div class="w-blog-pagination">
		<div class="g-pagination">
			<?php posts_nav_link(' ', '<span class="g-pagination-item to_prev">&laquo; Prev</span>',  '<span class="g-pagination-item to_next">Next &raquo;</span>'); ?>
		</div>
	</div>
<?php }
wp_reset_postdata();
$wp_query= $temp;