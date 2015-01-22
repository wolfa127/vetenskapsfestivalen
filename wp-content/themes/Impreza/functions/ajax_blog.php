<?php

if ( ! function_exists('blogAjaxPagination'))
{
	function blogAjaxPagination() {
		global $smof_data, $us_thumbnail_size;

		$thumbnail_sizes = array (
			'blog-big',
			'blog-grid',
			'blog-small',
		);

		if (isset($_POST['type']) AND in_array($_POST['type'], $thumbnail_sizes)) {
			$us_thumbnail_size = $_POST['type'];
		} else {
			$us_thumbnail_size = 'blog-grid';
		}

		if (isset($_POST['page']) AND $_POST['page'] > 1)
		{
			$page = $_POST['page'];
		}
		else
		{
			return;
		}

		$args = array(
			'post_type' 		=> 'post',
			'post_status' 		=> 'publish',
			'orderby' 			=> 'date',
			'order' 			=> 'DESC',
			'paged' 			=> $page
		);

		$_items = intval($_POST['items']);
		if (is_integer($_items) AND $_items > 0) {
			$args['posts_per_page'] = $_items;
		}

		$categories_slugs = null;

		if ( ! empty($_POST['category']))
		{
			$categories_slugs = explode(',', $_POST['category']);
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'category',
					'field' => 'slug',
					'terms' => $categories_slugs
				)
			);
		}

		$wp_query = new WP_Query();

		$lang_param = '';

		if (defined('ICL_LANGUAGE_CODE'))
		{
			$args['lang'] = ICL_LANGUAGE_CODE;
		}

		$wp_query->query($args);

		while ($wp_query->have_posts())
		{
			$wp_query->the_post();
			get_template_part('templates/blog_single_post_ajax');
		}

		die();

	}

	add_action( 'wp_ajax_nopriv_blogAjaxPagination', 'blogAjaxPagination' );
	add_action( 'wp_ajax_blogAjaxPagination', 'blogAjaxPagination' );
}
