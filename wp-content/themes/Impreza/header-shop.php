<?php
global $smof_data;
if (is_single()) {
	if (@$smof_data['good_sidebar_pos'] == 'No Sidebar')
	{
		define('IS_FULLWIDTH', TRUE);
	}
	elseif (@$smof_data['good_sidebar_pos'] == 'Left')
	{
		define('SIDEBAR_POS', 'left');
	}
	else
	{
		define('SIDEBAR_POS', 'right');
	}

	$related_products_qty_classes = array(
		'2 items' => 'columns-2',
		'3 items' => 'columns-3',
		'4 items' => 'columns-4',
		'5 items' => 'columns-5',
	);

	if (@$smof_data['related_products_qty'] != '' AND array_key_exists($smof_data['related_products_qty'], $related_products_qty_classes))
	{
		define('COLUMNS_QTY_CLASS', $related_products_qty_classes[$smof_data['related_products_qty']]);
	} else {
		define('COLUMNS_QTY_CLASS', 'columns-4');
	}

} else {
	if (@$smof_data['shop_sidebar_pos'] == 'No Sidebar')
	{
		define('IS_FULLWIDTH', TRUE);
	}
	elseif (@$smof_data['shop_sidebar_pos'] == 'Left')
	{
		define('SIDEBAR_POS', 'left');
	}
	else
	{
		define('SIDEBAR_POS', 'right');
	}

	$shop_columns_qty_classes = array(
		'2 columns' => 'columns-2',
		'3 columns' => 'columns-3',
		'4 columns' => 'columns-4',
		'5 columns' => 'columns-5',
	);

	if (@$smof_data['shop_columns_qty'] != '' AND array_key_exists($smof_data['shop_columns_qty'], $shop_columns_qty_classes))
	{
		define('COLUMNS_QTY_CLASS', $shop_columns_qty_classes[$smof_data['shop_columns_qty']]);
	} else {
		define('COLUMNS_QTY_CLASS', 'columns-4');
	}
}

get_header();
