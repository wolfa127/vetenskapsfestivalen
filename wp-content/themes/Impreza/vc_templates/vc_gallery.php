<?php
$post = get_post();

static $instance = 0;
$instance++;

if ( ! empty($atts['ids']))
{
	// 'ids' is explicitly ordered, unless you specify otherwise.
	if (empty($atts['orderby']))
	{
		$atts['orderby'] = 'post__in';
	}
	$atts['include'] = $atts['ids'];
}

// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
if (isset($atts['orderby']))
{
	$atts['orderby'] = sanitize_sql_orderby($atts['orderby']);
	if ( !$atts['orderby'])
	{
		unset($atts['orderby']);
	}
}

extract(shortcode_atts(array(
	'order'      => 'ASC',
	'orderby'    => 'menu_order ID',
	'id'         => $post->ID,
	'itemtag'    => 'dl',
	'icontag'    => 'dt',
	'captiontag' => 'dd',
	'columns'    => 6,
	'include'    => '',
	'exclude'    => '',
	'indents'    => '',
	'masonry'    => '',
), $atts));

$columns_to_size = array(
	1 => 'l',
	2 => 'l',
	3 => 'l',
	4 => 'm',
	5 => 'm',
	6 => 'm',
	7 => 'm',
	8 => 's',
	9 => 's',
	10 => 's',
);


$type_classes = ' columns_'.$columns;
$indents_class = ($indents == 1 OR $indents == 'yes')?' with_indents':'';
$masonry_class = ($masonry == 1 OR $masonry == 'yes')?' type_masonry':'';
if ($masonry_class != '') {
	$size = 'gallery-masonry-'.$columns_to_size[$columns];
	// We'll need the isotope script for this, but only once
	if ( ! wp_script_is('us-isotope', 'enqueued')){
		wp_enqueue_script('us-isotope');
	}
} else {
	$size = 'gallery-'.$columns_to_size[$columns];
}

$id = intval($id);
if ('RAND' == $order)
{
	$orderby = 'none';
}

if ( !empty($include))
{
	$_attachments = get_posts(array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));

	$attachments = array();
	if (is_array($_attachments))
	{
		foreach ($_attachments as $key => $val) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	}
}
elseif ( !empty($exclude))
{
	$attachments = get_children(array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
}
else
{
	$attachments = get_children(array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
}

if (empty($attachments))
{
	return '';
}

if (is_feed())
{
	$output = "\n";
	if (is_array($attachments))
	{
		foreach ($attachments as $att_id => $attachment)
			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
	}
	return $output;
}

$rand_id = rand(99999, 999999);

$output = '<div id="gallery_'.$rand_id.'" class="w-gallery'.$type_classes.$masonry_class.$indents_class.'"> <div class="w-gallery-tnails">';

$i = 1;
if (is_array($attachments))
{
	foreach ($attachments as $id => $attachment) {

		$title = trim(strip_tags(get_post_meta($id, '_wp_attachment_image_alt', true)));
		if (empty($title))
		{
			$title = trim(strip_tags($attachment->post_excerpt)); // If not, Use the Caption
		}
		if (empty($title))
		{
			$title = trim(strip_tags($attachment->post_title)); // Finally, use the title
		}

		$output .= '<a class="w-gallery-tnail order_'.$i.'" href="'.wp_get_attachment_url($id).'" title="'.$title.'">';
		$output .= wp_get_attachment_image($id, $size, 0, array('class' => 'w-gallery-tnail-img'));
		$output .= '<span class="w-gallery-tnail-title"></span>';
		$output .= '</a>';

		$i++;

	}
}

$output .= "</div> </div>\n";

echo $output;
