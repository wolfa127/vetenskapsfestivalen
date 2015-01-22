<?php

if(!function_exists('us_dataImport'))
{
	function us_dataImport()
	{
		if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);

		require_once(get_template_directory().'/vendor/wordpress-importer/wordpress-importer.php');

		if(!is_file(get_template_directory().'/xml/demo_data.xml'))
		{
			echo "Automatic import failed. Please use the wordpress importer and import the XML file (Impeza/xml/demo_data.xml) manually.";
		}
		else
		{
			$wp_import = new WP_Import();
			$wp_import->fetch_attachments = true;
			$wp_import->import(get_template_directory().'/xml/demo_data.xml');

			// Set menu
			$locations = get_theme_mod('nav_menu_locations');
			$menus  = wp_get_nav_menus();

			if(!empty($menus))
			{
				foreach($menus as $menu)
				{
					if(is_object($menu) && $menu->name == 'Impeza Header Menu')
					{
						$locations['impeza_main_menu'] = $menu->term_id;
					}
					if(is_object($menu) && $menu->name == 'Impeza Footer Menu')
					{
						$locations['impeza_footer_menu'] = $menu->term_id;
					}
				}
			}

			set_theme_mod('nav_menu_locations', $locations);
		}


		die();
	}

	add_action('wp_ajax_us_dataImport', 'us_dataImport');
}