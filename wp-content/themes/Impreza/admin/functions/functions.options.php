<?php

add_action('init','of_options');

if (!function_exists('of_options'))
{
	function of_options()
	{
		//Access the WordPress Categories via an Array
		$of_categories 		= array();
		$of_categories_obj 	= get_categories('hide_empty=0');
		foreach ($of_categories_obj as $of_cat) {
			$of_categories[$of_cat->cat_ID] = $of_cat->cat_name;}
		$categories_tmp 	= array_unshift($of_categories, "Select a category:");

		//Access the WordPress Pages via an Array
		$of_pages 			= array();
		$of_pages_obj 		= get_pages('sort_column=post_parent,menu_order');
		foreach ($of_pages_obj as $of_page) {
			$of_pages[$of_page->ID] = $of_page->post_name; }
		$of_pages_tmp 		= array_unshift($of_pages, "Select a page:");

		//Testing
		$of_options_select 	= array("one","two","three","four","five");
		$of_options_radio 	= array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five");

		//Sample Homepage blocks for the layout manager (sorter)
		$of_options_homepage_blocks = array
		(
			"disabled" => array (
				"placebo" 		=> "placebo", //REQUIRED!
				"block_one"		=> "Block One",
				"block_two"		=> "Block Two",
				"block_three"	=> "Block Three",
			),
			"enabled" => array (
				"placebo" 		=> "placebo", //REQUIRED!
				"block_four"	=> "Block Four",
			),
		);


		//Stylesheets Reader
		$alt_stylesheet_path = LAYOUT_PATH;
		$alt_stylesheets = array();

		if ( is_dir($alt_stylesheet_path) )
		{
			if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) )
			{
				while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false )
				{
					if(stristr($alt_stylesheet_file, ".css") !== false)
					{
						$alt_stylesheets[] = $alt_stylesheet_file;
					}
				}
			}
		}


		//Background Images Reader
		$bg_images_path = get_stylesheet_directory(). '/images/bg/'; // change this to where you store your bg images
		$bg_images_url = get_template_directory_uri().'/images/bg/'; // change this to where you store your bg images
		$bg_images = array();

		if ( is_dir($bg_images_path) ) {
			if ($bg_images_dir = opendir($bg_images_path) ) {
				while ( ($bg_images_file = readdir($bg_images_dir)) !== false ) {
					if(stristr($bg_images_file, ".png") !== false || stristr($bg_images_file, ".jpg") !== false) {
						$bg_images[] = $bg_images_url . $bg_images_file;
					}
				}
			}
		}


		/*-----------------------------------------------------------------------------------*/
		/* TO DO: Add options/functions that use these */
		/*-----------------------------------------------------------------------------------*/

		//More Options
		$uploads_arr 		= wp_upload_dir();
		$all_uploads_path 	= $uploads_arr['path'];
		$all_uploads 		= get_option('of_uploads');
		$other_entries 		= array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");
		$body_repeat 		= array("no-repeat","repeat-x","repeat-y","repeat");
		$body_pos 			= array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right");

		// Image Alignment radio box
		$of_options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center");

		// Image Links to Options
		$of_options_image_link_to = array("image" => "The Image","post" => "The Post");

		$web_safe_fonts = array(
			'Georgia, serif' => 'Georgia, serif',
			'"Palatino Linotype", "Book Antiqua", Palatino, serif' => 'Palatino Linotype, Book Antiqua, Palatino, serif',
			'"Times New Roman", Times, serif' => 'Times New Roman, Times, serif',
			'Arial, Helvetica, sans-serif' => 'Arial, Helvetica, sans-serif',
			'Impact, Charcoal, sans-serif' => 'Impact, Charcoal, sans-serif',
			'"Lucida Sans Unicode", "Lucida Grande", sans-serif' => 'Lucida Sans Unicode, Lucida Grande, sans-serif',
			'Tahoma, Geneva, sans-serif' => 'Tahoma, Geneva, sans-serif',
			'"Trebuchet MS", Helvetica, sans-serif' => 'Trebuchet MS, Helvetica, sans-serif',
			'Verdana, Geneva, sans-serif' => 'Verdana, Geneva, sans-serif',
			'"Courier New", Courier, monospace' => 'Courier New, Courier, monospace',
			'"Lucida Console", Monaco, monospace' => 'Lucida Console, Monaco, monospace',
		);

		$google_fonts = array(
			'ABeeZee' => 'ABeeZee',
			'Abel' => 'Abel',
			'Abril Fatface' => 'Abril Fatface',
			'Aclonica' => 'Aclonica',
			'Acme' => 'Acme',
			'Actor' => 'Actor',
			'Adamina' => 'Adamina',
			'Advent Pro' => 'Advent Pro',
			'Aguafina Script' => 'Aguafina Script',
			'Akronim' => 'Akronim',
			'Aladin' => 'Aladin',
			'Aldrich' => 'Aldrich',
			'Alef' => 'Alef',
			'Alegreya' => 'Alegreya',
			'Alegreya SC' => 'Alegreya SC',
			'Alegreya Sans' => 'Alegreya Sans',
			'Alegreya Sans SC' => 'Alegreya Sans SC',
			'Alex Brush' => 'Alex Brush',
			'Alfa Slab One' => 'Alfa Slab One',
			'Alice' => 'Alice',
			'Alike' => 'Alike',
			'Alike Angular' => 'Alike Angular',
			'Allan' => 'Allan',
			'Allerta' => 'Allerta',
			'Allerta Stencil' => 'Allerta Stencil',
			'Allura' => 'Allura',
			'Almendra' => 'Almendra',
			'Almendra Display' => 'Almendra Display',
			'Almendra SC' => 'Almendra SC',
			'Amarante' => 'Amarante',
			'Amaranth' => 'Amaranth',
			'Amatic SC' => 'Amatic SC',
			'Amethysta' => 'Amethysta',
			'Anaheim' => 'Anaheim',
			'Andada' => 'Andada',
			'Andika' => 'Andika',
			'Angkor' => 'Angkor',
			'Annie Use Your Telescope' => 'Annie Use Your Telescope',
			'Anonymous Pro' => 'Anonymous Pro',
			'Antic' => 'Antic',
			'Antic Didone' => 'Antic Didone',
			'Antic Slab' => 'Antic Slab',
			'Anton' => 'Anton',
			'Arapey' => 'Arapey',
			'Arbutus' => 'Arbutus',
			'Arbutus Slab' => 'Arbutus Slab',
			'Architects Daughter' => 'Architects Daughter',
			'Archivo Black' => 'Archivo Black',
			'Archivo Narrow' => 'Archivo Narrow',
			'Arimo' => 'Arimo',
			'Arizonia' => 'Arizonia',
			'Armata' => 'Armata',
			'Artifika' => 'Artifika',
			'Arvo' => 'Arvo',
			'Asap' => 'Asap',
			'Asset' => 'Asset',
			'Astloch' => 'Astloch',
			'Asul' => 'Asul',
			'Atomic Age' => 'Atomic Age',
			'Aubrey' => 'Aubrey',
			'Audiowide' => 'Audiowide',
			'Autour One' => 'Autour One',
			'Average' => 'Average',
			'Average Sans' => 'Average Sans',
			'Averia Gruesa Libre' => 'Averia Gruesa Libre',
			'Averia Libre' => 'Averia Libre',
			'Averia Sans Libre' => 'Averia Sans Libre',
			'Averia Serif Libre' => 'Averia Serif Libre',
			'Bad Script' => 'Bad Script',
			'Balthazar' => 'Balthazar',
			'Bangers' => 'Bangers',
			'Basic' => 'Basic',
			'Battambang' => 'Battambang',
			'Baumans' => 'Baumans',
			'Bayon' => 'Bayon',
			'Belgrano' => 'Belgrano',
			'Belleza' => 'Belleza',
			'BenchNine' => 'BenchNine',
			'Bentham' => 'Bentham',
			'Berkshire Swash' => 'Berkshire Swash',
			'Bevan' => 'Bevan',
			'Bigelow Rules' => 'Bigelow Rules',
			'Bigshot One' => 'Bigshot One',
			'Bilbo' => 'Bilbo',
			'Bilbo Swash Caps' => 'Bilbo Swash Caps',
			'Bitter' => 'Bitter',
			'Black Ops One' => 'Black Ops One',
			'Bokor' => 'Bokor',
			'Bonbon' => 'Bonbon',
			'Boogaloo' => 'Boogaloo',
			'Bowlby One' => 'Bowlby One',
			'Bowlby One SC' => 'Bowlby One SC',
			'Brawler' => 'Brawler',
			'Bree Serif' => 'Bree Serif',
			'Bubblegum Sans' => 'Bubblegum Sans',
			'Bubbler One' => 'Bubbler One',
			'Buda' => 'Buda',
			'Buenard' => 'Buenard',
			'Butcherman' => 'Butcherman',
			'Butterfly Kids' => 'Butterfly Kids',
			'Cabin' => 'Cabin',
			'Cabin Condensed' => 'Cabin Condensed',
			'Cabin Sketch' => 'Cabin Sketch',
			'Caesar Dressing' => 'Caesar Dressing',
			'Cagliostro' => 'Cagliostro',
			'Calligraffitti' => 'Calligraffitti',
			'Cambo' => 'Cambo',
			'Candal' => 'Candal',
			'Cantarell' => 'Cantarell',
			'Cantata One' => 'Cantata One',
			'Cantora One' => 'Cantora One',
			'Capriola' => 'Capriola',
			'Cardo' => 'Cardo',
			'Carme' => 'Carme',
			'Carrois Gothic' => 'Carrois Gothic',
			'Carrois Gothic SC' => 'Carrois Gothic SC',
			'Carter One' => 'Carter One',
			'Caudex' => 'Caudex',
			'Cedarville Cursive' => 'Cedarville Cursive',
			'Ceviche One' => 'Ceviche One',
			'Changa One' => 'Changa One',
			'Chango' => 'Chango',
			'Chau Philomene One' => 'Chau Philomene One',
			'Chela One' => 'Chela One',
			'Chelsea Market' => 'Chelsea Market',
			'Chenla' => 'Chenla',
			'Cherry Cream Soda' => 'Cherry Cream Soda',
			'Cherry Swash' => 'Cherry Swash',
			'Chewy' => 'Chewy',
			'Chicle' => 'Chicle',
			'Chivo' => 'Chivo',
			'Cinzel' => 'Cinzel',
			'Cinzel Decorative' => 'Cinzel Decorative',
			'Clicker Script' => 'Clicker Script',
			'Coda' => 'Coda',
			'Coda Caption' => 'Coda Caption',
			'Codystar' => 'Codystar',
			'Combo' => 'Combo',
			'Comfortaa' => 'Comfortaa',
			'Coming Soon' => 'Coming Soon',
			'Concert One' => 'Concert One',
			'Condiment' => 'Condiment',
			'Content' => 'Content',
			'Contrail One' => 'Contrail One',
			'Convergence' => 'Convergence',
			'Cookie' => 'Cookie',
			'Copse' => 'Copse',
			'Corben' => 'Corben',
			'Courgette' => 'Courgette',
			'Cousine' => 'Cousine',
			'Coustard' => 'Coustard',
			'Covered By Your Grace' => 'Covered By Your Grace',
			'Crafty Girls' => 'Crafty Girls',
			'Creepster' => 'Creepster',
			'Crete Round' => 'Crete Round',
			'Crimson Text' => 'Crimson Text',
			'Croissant One' => 'Croissant One',
			'Crushed' => 'Crushed',
			'Cuprum' => 'Cuprum',
			'Cutive' => 'Cutive',
			'Cutive Mono' => 'Cutive Mono',
			'Damion' => 'Damion',
			'Dancing Script' => 'Dancing Script',
			'Dangrek' => 'Dangrek',
			'Dawning of a New Day' => 'Dawning of a New Day',
			'Days One' => 'Days One',
			'Delius' => 'Delius',
			'Delius Swash Caps' => 'Delius Swash Caps',
			'Delius Unicase' => 'Delius Unicase',
			'Della Respira' => 'Della Respira',
			'Denk One' => 'Denk One',
			'Devonshire' => 'Devonshire',
			'Didact Gothic' => 'Didact Gothic',
			'Diplomata' => 'Diplomata',
			'Diplomata SC' => 'Diplomata SC',
			'Domine' => 'Domine',
			'Donegal One' => 'Donegal One',
			'Doppio One' => 'Doppio One',
			'Dorsa' => 'Dorsa',
			'Dosis' => 'Dosis',
			'Dr Sugiyama' => 'Dr Sugiyama',
			'Droid Sans' => 'Droid Sans',
			'Droid Sans Mono' => 'Droid Sans Mono',
			'Droid Serif' => 'Droid Serif',
			'Duru Sans' => 'Duru Sans',
			'Dynalight' => 'Dynalight',
			'EB Garamond' => 'EB Garamond',
			'Eagle Lake' => 'Eagle Lake',
			'Eater' => 'Eater',
			'Economica' => 'Economica',
			'Electrolize' => 'Electrolize',
			'Elsie' => 'Elsie',
			'Elsie Swash Caps' => 'Elsie Swash Caps',
			'Emblema One' => 'Emblema One',
			'Emilys Candy' => 'Emilys Candy',
			'Engagement' => 'Engagement',
			'Englebert' => 'Englebert',
			'Enriqueta' => 'Enriqueta',
			'Erica One' => 'Erica One',
			'Esteban' => 'Esteban',
			'Euphoria Script' => 'Euphoria Script',
			'Ewert' => 'Ewert',
			'Exo' => 'Exo',
			'Exo 2' => 'Exo 2',
			'Expletus Sans' => 'Expletus Sans',
			'Fanwood Text' => 'Fanwood Text',
			'Fascinate' => 'Fascinate',
			'Fascinate Inline' => 'Fascinate Inline',
			'Faster One' => 'Faster One',
			'Fasthand' => 'Fasthand',
			'Fauna One' => 'Fauna One',
			'Federant' => 'Federant',
			'Federo' => 'Federo',
			'Felipa' => 'Felipa',
			'Fenix' => 'Fenix',
			'Finger Paint' => 'Finger Paint',
			'Fjalla One' => 'Fjalla One',
			'Fjord One' => 'Fjord One',
			'Flamenco' => 'Flamenco',
			'Flavors' => 'Flavors',
			'Fondamento' => 'Fondamento',
			'Fontdiner Swanky' => 'Fontdiner Swanky',
			'Forum' => 'Forum',
			'Francois One' => 'Francois One',
			'Freckle Face' => 'Freckle Face',
			'Fredericka the Great' => 'Fredericka the Great',
			'Fredoka One' => 'Fredoka One',
			'Freehand' => 'Freehand',
			'Fresca' => 'Fresca',
			'Frijole' => 'Frijole',
			'Fruktur' => 'Fruktur',
			'Fugaz One' => 'Fugaz One',
			'GFS Didot' => 'GFS Didot',
			'GFS Neohellenic' => 'GFS Neohellenic',
			'Gabriela' => 'Gabriela',
			'Gafata' => 'Gafata',
			'Galdeano' => 'Galdeano',
			'Galindo' => 'Galindo',
			'Gentium Basic' => 'Gentium Basic',
			'Gentium Book Basic' => 'Gentium Book Basic',
			'Geo' => 'Geo',
			'Geostar' => 'Geostar',
			'Geostar Fill' => 'Geostar Fill',
			'Germania One' => 'Germania One',
			'Gilda Display' => 'Gilda Display',
			'Give You Glory' => 'Give You Glory',
			'Glass Antiqua' => 'Glass Antiqua',
			'Glegoo' => 'Glegoo',
			'Gloria Hallelujah' => 'Gloria Hallelujah',
			'Goblin One' => 'Goblin One',
			'Gochi Hand' => 'Gochi Hand',
			'Gorditas' => 'Gorditas',
			'Goudy Bookletter 1911' => 'Goudy Bookletter 1911',
			'Graduate' => 'Graduate',
			'Grand Hotel' => 'Grand Hotel',
			'Gravitas One' => 'Gravitas One',
			'Great Vibes' => 'Great Vibes',
			'Griffy' => 'Griffy',
			'Gruppo' => 'Gruppo',
			'Gudea' => 'Gudea',
			'Habibi' => 'Habibi',
			'Hammersmith One' => 'Hammersmith One',
			'Hanalei' => 'Hanalei',
			'Hanalei Fill' => 'Hanalei Fill',
			'Handlee' => 'Handlee',
			'Hanuman' => 'Hanuman',
			'Happy Monkey' => 'Happy Monkey',
			'Headland One' => 'Headland One',
			'Henny Penny' => 'Henny Penny',
			'Herr Von Muellerhoff' => 'Herr Von Muellerhoff',
			'Holtwood One SC' => 'Holtwood One SC',
			'Homemade Apple' => 'Homemade Apple',
			'Homenaje' => 'Homenaje',
			'IM Fell DW Pica' => 'IM Fell DW Pica',
			'IM Fell DW Pica SC' => 'IM Fell DW Pica SC',
			'IM Fell Double Pica' => 'IM Fell Double Pica',
			'IM Fell Double Pica SC' => 'IM Fell Double Pica SC',
			'IM Fell English' => 'IM Fell English',
			'IM Fell English SC' => 'IM Fell English SC',
			'IM Fell French Canon' => 'IM Fell French Canon',
			'IM Fell French Canon SC' => 'IM Fell French Canon SC',
			'IM Fell Great Primer' => 'IM Fell Great Primer',
			'IM Fell Great Primer SC' => 'IM Fell Great Primer SC',
			'Iceberg' => 'Iceberg',
			'Iceland' => 'Iceland',
			'Imprima' => 'Imprima',
			'Inconsolata' => 'Inconsolata',
			'Inder' => 'Inder',
			'Indie Flower' => 'Indie Flower',
			'Inika' => 'Inika',
			'Irish Grover' => 'Irish Grover',
			'Istok Web' => 'Istok Web',
			'Italiana' => 'Italiana',
			'Italianno' => 'Italianno',
			'Jacques Francois' => 'Jacques Francois',
			'Jacques Francois Shadow' => 'Jacques Francois Shadow',
			'Jim Nightshade' => 'Jim Nightshade',
			'Jockey One' => 'Jockey One',
			'Jolly Lodger' => 'Jolly Lodger',
			'Josefin Sans' => 'Josefin Sans',
			'Josefin Slab' => 'Josefin Slab',
			'Joti One' => 'Joti One',
			'Judson' => 'Judson',
			'Julee' => 'Julee',
			'Julius Sans One' => 'Julius Sans One',
			'Junge' => 'Junge',
			'Jura' => 'Jura',
			'Just Another Hand' => 'Just Another Hand',
			'Just Me Again Down Here' => 'Just Me Again Down Here',
			'Kameron' => 'Kameron',
			'Kantumruy' => 'Kantumruy',
			'Karla' => 'Karla',
			'Kaushan Script' => 'Kaushan Script',
			'Kavoon' => 'Kavoon',
			'Kdam Thmor' => 'Kdam Thmor',
			'Keania One' => 'Keania One',
			'Kelly Slab' => 'Kelly Slab',
			'Kenia' => 'Kenia',
			'Khmer' => 'Khmer',
			'Kite One' => 'Kite One',
			'Knewave' => 'Knewave',
			'Kotta One' => 'Kotta One',
			'Koulen' => 'Koulen',
			'Kranky' => 'Kranky',
			'Kreon' => 'Kreon',
			'Kristi' => 'Kristi',
			'Krona One' => 'Krona One',
			'La Belle Aurore' => 'La Belle Aurore',
			'Lancelot' => 'Lancelot',
			'Lato' => 'Lato',
			'League Script' => 'League Script',
			'Leckerli One' => 'Leckerli One',
			'Ledger' => 'Ledger',
			'Lekton' => 'Lekton',
			'Lemon' => 'Lemon',
			'Libre Baskerville' => 'Libre Baskerville',
			'Life Savers' => 'Life Savers',
			'Lilita One' => 'Lilita One',
			'Lily Script One' => 'Lily Script One',
			'Limelight' => 'Limelight',
			'Linden Hill' => 'Linden Hill',
			'Lobster' => 'Lobster',
			'Lobster Two' => 'Lobster Two',
			'Londrina Outline' => 'Londrina Outline',
			'Londrina Shadow' => 'Londrina Shadow',
			'Londrina Sketch' => 'Londrina Sketch',
			'Londrina Solid' => 'Londrina Solid',
			'Lora' => 'Lora',
			'Love Ya Like A Sister' => 'Love Ya Like A Sister',
			'Loved by the King' => 'Loved by the King',
			'Lovers Quarrel' => 'Lovers Quarrel',
			'Luckiest Guy' => 'Luckiest Guy',
			'Lusitana' => 'Lusitana',
			'Lustria' => 'Lustria',
			'Macondo' => 'Macondo',
			'Macondo Swash Caps' => 'Macondo Swash Caps',
			'Magra' => 'Magra',
			'Maiden Orange' => 'Maiden Orange',
			'Mako' => 'Mako',
			'Marcellus' => 'Marcellus',
			'Marcellus SC' => 'Marcellus SC',
			'Marck Script' => 'Marck Script',
			'Margarine' => 'Margarine',
			'Marko One' => 'Marko One',
			'Marmelad' => 'Marmelad',
			'Marvel' => 'Marvel',
			'Mate' => 'Mate',
			'Mate SC' => 'Mate SC',
			'Maven Pro' => 'Maven Pro',
			'McLaren' => 'McLaren',
			'Meddon' => 'Meddon',
			'MedievalSharp' => 'MedievalSharp',
			'Medula One' => 'Medula One',
			'Megrim' => 'Megrim',
			'Meie Script' => 'Meie Script',
			'Merienda' => 'Merienda',
			'Merienda One' => 'Merienda One',
			'Merriweather' => 'Merriweather',
			'Merriweather Sans' => 'Merriweather Sans',
			'Metal' => 'Metal',
			'Metal Mania' => 'Metal Mania',
			'Metamorphous' => 'Metamorphous',
			'Metrophobic' => 'Metrophobic',
			'Michroma' => 'Michroma',
			'Milonga' => 'Milonga',
			'Miltonian' => 'Miltonian',
			'Miltonian Tattoo' => 'Miltonian Tattoo',
			'Miniver' => 'Miniver',
			'Miss Fajardose' => 'Miss Fajardose',
			'Modern Antiqua' => 'Modern Antiqua',
			'Molengo' => 'Molengo',
			'Molle' => 'Molle',
			'Monda' => 'Monda',
			'Monofett' => 'Monofett',
			'Monoton' => 'Monoton',
			'Monsieur La Doulaise' => 'Monsieur La Doulaise',
			'Montaga' => 'Montaga',
			'Montez' => 'Montez',
			'Montserrat' => 'Montserrat',
			'Montserrat Alternates' => 'Montserrat Alternates',
			'Montserrat Subrayada' => 'Montserrat Subrayada',
			'Moul' => 'Moul',
			'Moulpali' => 'Moulpali',
			'Mountains of Christmas' => 'Mountains of Christmas',
			'Mouse Memoirs' => 'Mouse Memoirs',
			'Mr Bedfort' => 'Mr Bedfort',
			'Mr Dafoe' => 'Mr Dafoe',
			'Mr De Haviland' => 'Mr De Haviland',
			'Mrs Saint Delafield' => 'Mrs Saint Delafield',
			'Mrs Sheppards' => 'Mrs Sheppards',
			'Muli' => 'Muli',
			'Mystery Quest' => 'Mystery Quest',
			'Neucha' => 'Neucha',
			'Neuton' => 'Neuton',
			'New Rocker' => 'New Rocker',
			'News Cycle' => 'News Cycle',
			'Niconne' => 'Niconne',
			'Nixie One' => 'Nixie One',
			'Nobile' => 'Nobile',
			'Nokora' => 'Nokora',
			'Norican' => 'Norican',
			'Nosifer' => 'Nosifer',
			'Nothing You Could Do' => 'Nothing You Could Do',
			'Noticia Text' => 'Noticia Text',
			'Noto Sans' => 'Noto Sans',
			'Noto Serif' => 'Noto Serif',
			'Nova Cut' => 'Nova Cut',
			'Nova Flat' => 'Nova Flat',
			'Nova Mono' => 'Nova Mono',
			'Nova Oval' => 'Nova Oval',
			'Nova Round' => 'Nova Round',
			'Nova Script' => 'Nova Script',
			'Nova Slim' => 'Nova Slim',
			'Nova Square' => 'Nova Square',
			'Numans' => 'Numans',
			'Nunito' => 'Nunito',
			'Odor Mean Chey' => 'Odor Mean Chey',
			'Offside' => 'Offside',
			'Old Standard TT' => 'Old Standard TT',
			'Oldenburg' => 'Oldenburg',
			'Oleo Script' => 'Oleo Script',
			'Oleo Script Swash Caps' => 'Oleo Script Swash Caps',
			'Open Sans' => 'Open Sans',
			'Open Sans Condensed' => 'Open Sans Condensed',
			'Oranienbaum' => 'Oranienbaum',
			'Orbitron' => 'Orbitron',
			'Oregano' => 'Oregano',
			'Orienta' => 'Orienta',
			'Original Surfer' => 'Original Surfer',
			'Oswald' => 'Oswald',
			'Over the Rainbow' => 'Over the Rainbow',
			'Overlock' => 'Overlock',
			'Overlock SC' => 'Overlock SC',
			'Ovo' => 'Ovo',
			'Oxygen' => 'Oxygen',
			'Oxygen Mono' => 'Oxygen Mono',
			'PT Mono' => 'PT Mono',
			'PT Sans' => 'PT Sans',
			'PT Sans Caption' => 'PT Sans Caption',
			'PT Sans Narrow' => 'PT Sans Narrow',
			'PT Serif' => 'PT Serif',
			'PT Serif Caption' => 'PT Serif Caption',
			'Pacifico' => 'Pacifico',
			'Paprika' => 'Paprika',
			'Parisienne' => 'Parisienne',
			'Passero One' => 'Passero One',
			'Passion One' => 'Passion One',
			'Pathway Gothic One' => 'Pathway Gothic One',
			'Patrick Hand' => 'Patrick Hand',
			'Patrick Hand SC' => 'Patrick Hand SC',
			'Patua One' => 'Patua One',
			'Paytone One' => 'Paytone One',
			'Peralta' => 'Peralta',
			'Permanent Marker' => 'Permanent Marker',
			'Petit Formal Script' => 'Petit Formal Script',
			'Petrona' => 'Petrona',
			'Philosopher' => 'Philosopher',
			'Piedra' => 'Piedra',
			'Pinyon Script' => 'Pinyon Script',
			'Pirata One' => 'Pirata One',
			'Plaster' => 'Plaster',
			'Play' => 'Play',
			'Playball' => 'Playball',
			'Playfair Display' => 'Playfair Display',
			'Playfair Display SC' => 'Playfair Display SC',
			'Podkova' => 'Podkova',
			'Poiret One' => 'Poiret One',
			'Poller One' => 'Poller One',
			'Poly' => 'Poly',
			'Pompiere' => 'Pompiere',
			'Pontano Sans' => 'Pontano Sans',
			'Port Lligat Sans' => 'Port Lligat Sans',
			'Port Lligat Slab' => 'Port Lligat Slab',
			'Prata' => 'Prata',
			'Preahvihear' => 'Preahvihear',
			'Press Start 2P' => 'Press Start 2P',
			'Princess Sofia' => 'Princess Sofia',
			'Prociono' => 'Prociono',
			'Prosto One' => 'Prosto One',
			'Puritan' => 'Puritan',
			'Purple Purse' => 'Purple Purse',
			'Quando' => 'Quando',
			'Quantico' => 'Quantico',
			'Quattrocento' => 'Quattrocento',
			'Quattrocento Sans' => 'Quattrocento Sans',
			'Questrial' => 'Questrial',
			'Quicksand' => 'Quicksand',
			'Quintessential' => 'Quintessential',
			'Qwigley' => 'Qwigley',
			'Racing Sans One' => 'Racing Sans One',
			'Radley' => 'Radley',
			'Raleway' => 'Raleway',
			'Raleway Dots' => 'Raleway Dots',
			'Rambla' => 'Rambla',
			'Rammetto One' => 'Rammetto One',
			'Ranchers' => 'Ranchers',
			'Rancho' => 'Rancho',
			'Rationale' => 'Rationale',
			'Redressed' => 'Redressed',
			'Reenie Beanie' => 'Reenie Beanie',
			'Revalia' => 'Revalia',
			'Ribeye' => 'Ribeye',
			'Ribeye Marrow' => 'Ribeye Marrow',
			'Righteous' => 'Righteous',
			'Risque' => 'Risque',
			'Roboto' => 'Roboto',
			'Roboto Condensed' => 'Roboto Condensed',
			'Roboto Slab' => 'Roboto Slab',
			'Rochester' => 'Rochester',
			'Rock Salt' => 'Rock Salt',
			'Rokkitt' => 'Rokkitt',
			'Romanesco' => 'Romanesco',
			'Ropa Sans' => 'Ropa Sans',
			'Rosario' => 'Rosario',
			'Rosarivo' => 'Rosarivo',
			'Rouge Script' => 'Rouge Script',
			'Ruda' => 'Ruda',
			'Rufina' => 'Rufina',
			'Ruge Boogie' => 'Ruge Boogie',
			'Ruluko' => 'Ruluko',
			'Rum Raisin' => 'Rum Raisin',
			'Ruslan Display' => 'Ruslan Display',
			'Russo One' => 'Russo One',
			'Ruthie' => 'Ruthie',
			'Rye' => 'Rye',
			'Sacramento' => 'Sacramento',
			'Sail' => 'Sail',
			'Salsa' => 'Salsa',
			'Sanchez' => 'Sanchez',
			'Sancreek' => 'Sancreek',
			'Sansita One' => 'Sansita One',
			'Sarina' => 'Sarina',
			'Satisfy' => 'Satisfy',
			'Scada' => 'Scada',
			'Schoolbell' => 'Schoolbell',
			'Seaweed Script' => 'Seaweed Script',
			'Sevillana' => 'Sevillana',
			'Seymour One' => 'Seymour One',
			'Shadows Into Light' => 'Shadows Into Light',
			'Shadows Into Light Two' => 'Shadows Into Light Two',
			'Shanti' => 'Shanti',
			'Share' => 'Share',
			'Share Tech' => 'Share Tech',
			'Share Tech Mono' => 'Share Tech Mono',
			'Shojumaru' => 'Shojumaru',
			'Short Stack' => 'Short Stack',
			'Siemreap' => 'Siemreap',
			'Sigmar One' => 'Sigmar One',
			'Signika' => 'Signika',
			'Signika Negative' => 'Signika Negative',
			'Simonetta' => 'Simonetta',
			'Sintony' => 'Sintony',
			'Sirin Stencil' => 'Sirin Stencil',
			'Six Caps' => 'Six Caps',
			'Skranji' => 'Skranji',
			'Slackey' => 'Slackey',
			'Smokum' => 'Smokum',
			'Smythe' => 'Smythe',
			'Sniglet' => 'Sniglet',
			'Snippet' => 'Snippet',
			'Snowburst One' => 'Snowburst One',
			'Sofadi One' => 'Sofadi One',
			'Sofia' => 'Sofia',
			'Sonsie One' => 'Sonsie One',
			'Sorts Mill Goudy' => 'Sorts Mill Goudy',
			'Source Code Pro' => 'Source Code Pro',
			'Source Sans Pro' => 'Source Sans Pro',
			'Special Elite' => 'Special Elite',
			'Spicy Rice' => 'Spicy Rice',
			'Spinnaker' => 'Spinnaker',
			'Spirax' => 'Spirax',
			'Squada One' => 'Squada One',
			'Stalemate' => 'Stalemate',
			'Stalinist One' => 'Stalinist One',
			'Stardos Stencil' => 'Stardos Stencil',
			'Stint Ultra Condensed' => 'Stint Ultra Condensed',
			'Stint Ultra Expanded' => 'Stint Ultra Expanded',
			'Stoke' => 'Stoke',
			'Strait' => 'Strait',
			'Sue Ellen Francisco' => 'Sue Ellen Francisco',
			'Sunshiney' => 'Sunshiney',
			'Supermercado One' => 'Supermercado One',
			'Suwannaphum' => 'Suwannaphum',
			'Swanky and Moo Moo' => 'Swanky and Moo Moo',
			'Syncopate' => 'Syncopate',
			'Tangerine' => 'Tangerine',
			'Taprom' => 'Taprom',
			'Tauri' => 'Tauri',
			'Telex' => 'Telex',
			'Tenor Sans' => 'Tenor Sans',
			'Text Me One' => 'Text Me One',
			'The Girl Next Door' => 'The Girl Next Door',
			'Tienne' => 'Tienne',
			'Tinos' => 'Tinos',
			'Titan One' => 'Titan One',
			'Titillium Web' => 'Titillium Web',
			'Trade Winds' => 'Trade Winds',
			'Trocchi' => 'Trocchi',
			'Trochut' => 'Trochut',
			'Trykker' => 'Trykker',
			'Tulpen One' => 'Tulpen One',
			'Ubuntu' => 'Ubuntu',
			'Ubuntu Condensed' => 'Ubuntu Condensed',
			'Ubuntu Mono' => 'Ubuntu Mono',
			'Ultra' => 'Ultra',
			'Uncial Antiqua' => 'Uncial Antiqua',
			'Underdog' => 'Underdog',
			'Unica One' => 'Unica One',
			'UnifrakturCook' => 'UnifrakturCook',
			'UnifrakturMaguntia' => 'UnifrakturMaguntia',
			'Unkempt' => 'Unkempt',
			'Unlock' => 'Unlock',
			'Unna' => 'Unna',
			'VT323' => 'VT323',
			'Vampiro One' => 'Vampiro One',
			'Varela' => 'Varela',
			'Varela Round' => 'Varela Round',
			'Vast Shadow' => 'Vast Shadow',
			'Vibur' => 'Vibur',
			'Vidaloka' => 'Vidaloka',
			'Viga' => 'Viga',
			'Voces' => 'Voces',
			'Volkhov' => 'Volkhov',
			'Vollkorn' => 'Vollkorn',
			'Voltaire' => 'Voltaire',
			'Waiting for the Sunrise' => 'Waiting for the Sunrise',
			'Wallpoet' => 'Wallpoet',
			'Walter Turncoat' => 'Walter Turncoat',
			'Warnes' => 'Warnes',
			'Wellfleet' => 'Wellfleet',
			'Wendy One' => 'Wendy One',
			'Wire One' => 'Wire One',
			'Yanone Kaffeesatz' => 'Yanone Kaffeesatz',
			'Yellowtail' => 'Yellowtail',
			'Yeseva One' => 'Yeseva One',
			'Yesteryear' => 'Yesteryear',
			'Zeyada' => 'Zeyada',
		);

		$google_fonts_subsets = array(
			'latin' => 'latin',
			'latin-ext' => 'latin-ext',
			'cyrillic' => 'cyrillic',
			'cyrillic-ext' => 'cyrillic-ext',
			'greek' => 'greek',
			'greek-ext' => 'greek-ext',
			'vietnamese' => 'vietnamese',
			'khmer' => 'khmer',
		);
/*-----------------------------------------------------------------------------------*/
/* The Options Array */
/*-----------------------------------------------------------------------------------*/

// Set the Options Array
global $of_options;
$of_options = array();
//$prefix = 'us_'


$of_options[] = array( 	"name" 		=> "General Settings",
						"type" 		=> "heading"
				);

$of_options[] = array( "name" => "Responsive Layout",
	"desc" => "Enable responsive layout",
	"id" => "responsive_layout",
	"std" => 1,
	"type" => "switch");

$of_options[] = array( "name" => "Logo Image",
	"desc" => "Maximum recommended size is 300px of height (also for retina displays)",
	"id" => "custom_logo",
	"std" => "",
	"type" => "upload"
);

$of_options[] = array( "name" => "Logo Image for the Transparent Header <span class='w-info'>(optional)</span>",
	"desc" => "Maximum recommended size is 300px of height (also for retina displays)",
	"id" => "custom_logo_transparent",
	"std" => "",
	"type" => "upload"
);

$of_options[] = array( "name" => "Logo height",
	"desc" => "Set value from 20 to 150 (px)",
	"id" => "logo_height",
	"type" => "sliderui",
	"std" => "30",
	"min" => "20",
	"step"	=> "1",
	"max" => "150",
);

$of_options[] = array( "name" => "Logo height in the shrinked header",
	"desc" => "Set value from 20 to 150 (px)",
	"id" => "logo_height_sticky",
	"type" => "sliderui",
	"std" => "30",
	"min" => "20",
	"step"	=> "1",
	"max" => "150",
);

$of_options[] = array( "name" => "Logo height at tablets <span class='w-info'>(screen width < 900px)</span>",
	"desc" => "Set value from 20 to 80 (px)",
	"id" => "logo_height_tablets",
	"type" => "sliderui",
	"std" => "30",
	"min" => "20",
	"step"	=> "1",
	"max" => "80",
);

$of_options[] = array( "name" => "Logo height at mobiles <span class='w-info'>(screen width < 600px)</span>",
	"desc" => "Set value from 20 to 50 (px)",
	"id" => "logo_height_mobiles",
	"type" => "sliderui",
	"std" => "30",
	"min" => "20",
	"step"	=> "1",
	"max" => "50",
);

$of_options[] = array( "name" => "Logo as text",
	"desc" => "Show text instead of image as Logo",
	"id" => "logo_as_text",
	"std" => 0,
	"folds" => 1,
	"type" => "switch");

$of_options[] = array( "name" => "",
	"desc" => "",
	"id" => "logo_text",
	"std" => "IMPREZA",
	"fold" => "logo_as_text",
	"type" => "text");

$of_options[] = array( "name" => "Page Comments",
	"desc" => "Enable comments at regular pages",
	"id" => "page_comments",
	"std" => 0,
	"type" => "switch");

$of_options[] = array( "name" => "Title Bar size",
	"desc" => "Set default size of Title Bar on all pages",
	"id" => "header_layout_type",
	"std" => "Large",
	"type" => "select",
	"options" => array(
		'Ultra Compact' => 'Ultra Compact',
		'Compact' => 'Compact',
		'Large' => 'Large',
		'Huge' => 'Huge',
	));

$of_options[] = array( "name" => "Disable animation at width:",
	"desc" => "If screen width is less than this value, animation in all elements will be disabled",
	"id" => "disable_animation_width",
	"std" => "1023",
	"type" => "text");

$of_options[] = array( 	"name" 		=> "Favicon",
	"desc" => "Upload an ICO/PNG/GIF image that will represent your website's favicon",
	"id" => "custom_favicon",
	"std" => "",
	"type" => "upload");

$of_options[] = array( "name" => "Custom HTML code",
	"desc" => "Paste your custom code here, it will be added into the footer section of your site. You can use JS code with &lt;script&gt;&lt;/script&gt; tags. Also you can add Google Analytics or other tracking code into this field.",
	"id" => "tracking_code",
	"std" => "",
	"type" => "textarea");

/*--------------------------------------------------------------------------*/

$of_options[] = array( "name" => "Styling",
	"type" => "heading");

$of_options[] = array( "name" => "Predefined color style",
	"desc" => "",
	"id" => "color_scheme",
	"std" => "Midnight Turquoise",
	"type" => "select",
	"options" => array(
		'White Pink' => 'White Pink',
		'White Blue' => 'White Blue',
		'Ectoplasm' => 'Ectoplasm',
		'Midnight Red' => 'Midnight Red',
		'Stylish Cyan' => 'Stylish Cyan',
		'Light Ocean' => 'Light Ocean',
		'Coffee Shop' => 'Coffee Shop',
		'Bright Sunrise' => 'Bright Sunrise',
		'Grey Turquoise' => 'Grey Turquoise',
		'Twilight' => 'Twilight',
		'White Alizarin' => 'White Alizarin',
		'White Royal' => 'White Royal',
		'White Green' => 'White Green',
		'White Yellow' => 'White Yellow',
		'Black & White' => 'Black & White',
		'Retro Package' => 'Retro Package',
		'Nautical Knot' => 'Nautical Knot',
		'Mild Ocean' => 'Mild Ocean',
		'City Hunter' => 'City Hunter',
		'Dark Cyan' => 'Dark Cyan',
	));

/*--------------------------------------*/
$of_options[] = array( "name" => "Custom color style",
	"desc" => "Change <strong>Header</strong> colors",
	"id" => "change_header_colors",
	"std" => 0,
	"folds" => 1,
	"type" => "switch");

$of_options[] = array( "name" =>  "",
	"desc" => "Header Background Color",
	"id" => "header_bg",
	"std" => "#fff",
	"fold" => "change_header_colors",
	"type" => "color");

$of_options[] = array( "name" =>  "",
	"desc" => "Header Text Color",
	"id" => "header_text",
	"std" => "#666",
	"fold" => "change_header_colors",
	"type" => "color");

$of_options[] = array( "name" =>  "",
	"desc" => "Header Text Hover Color",
	"id" => "header_text_hover",
	"std" => "#d13a7a",
	"fold" => "change_header_colors",
	"type" => "color");

$of_options[] = array( "name" =>  "",
	"desc" => "Extended Header Background Color",
	"id" => "header_ext_bg",
	"std" => "#f5f5f5",
	"fold" => "change_header_colors",
	"type" => "color");

$of_options[] = array( "name" =>  "",
	"desc" => "Extended Header Text Color",
	"id" => "header_ext_text",
	"std" => "#999",
	"fold" => "change_header_colors",
	"type" => "color");

$of_options[] = array( "name" =>  "",
	"desc" => "Extended Header Text Hover Color",
	"id" => "header_ext_text_hover",
	"std" => "#d13a7a",
	"fold" => "change_header_colors",
	"type" => "color");

$of_options[] = array( "name" =>  "",
	"desc" => "Search Screen Background Color",
	"id" => "search_bg",
	"std" => "#d13a7a",
	"fold" => "change_header_colors",
	"type" => "color");

$of_options[] = array( "name" =>  "",
	"desc" => "Search Screen Text Color",
	"id" => "search_text",
	"std" => "#fff",
	"fold" => "change_header_colors",
	"type" => "color");

/*--------------------------------------*/
$of_options[] = array( "name" =>  "",
	"desc" => "Change <strong>Main Menu</strong> colors",
	"id" => "change_main_menu_colors",
	"std" => 0,
	"folds" => 1,
	"type" => "switch");

$of_options[] = array( "name" =>  "",
	"desc" => "Menu Hover Background Color",
	"id" => "menu_hover_bg",
	"std" => "#fff",
	"fold" => "change_main_menu_colors",
	"type" => "color");

$of_options[] = array( "name" =>  "",
	"desc" => "Menu Hover Text Color",
	"id" => "menu_hover_text",
	"std" => "#d13a7a",
	"fold" => "change_main_menu_colors",
	"type" => "color");

$of_options[] = array( "name" =>  "",
	"desc" => "Menu Active Background Color",
	"id" => "menu_active_bg",
	"std" => "#fff",
	"fold" => "change_main_menu_colors",
	"type" => "color");

$of_options[] = array( "name" =>  "",
	"desc" => "Menu Active Text Color",
	"id" => "menu_active_text",
	"std" => "#d13a7a",
	"fold" => "change_main_menu_colors",
	"type" => "color");

$of_options[] = array( "name" =>  "",
	"desc" => "Dropdown Background Color",
	"id" => "drop_bg",
	"std" => "#fff",
	"fold" => "change_main_menu_colors",
	"type" => "color");

$of_options[] = array( "name" =>  "",
	"desc" => "Dropdown Text Color",
	"id" => "drop_text",
	"std" => "#666",
	"fold" => "change_main_menu_colors",
	"type" => "color");

$of_options[] = array( "name" =>  "",
	"desc" => "Dropdown Hover Background Color",
	"id" => "drop_hover_bg",
	"std" => "#d13a7a",
	"fold" => "change_main_menu_colors",
	"type" => "color");

$of_options[] = array( "name" =>  "",
	"desc" => "Dropdown Hover Text Color",
	"id" => "drop_hover_text",
	"std" => "#fff",
	"fold" => "change_main_menu_colors",
	"type" => "color");

$of_options[] = array( "name" =>  "",
	"desc" => "Dropdown Active Background Color",
	"id" => "drop_active_bg",
	"std" => "#fff",
	"fold" => "change_main_menu_colors",
	"type" => "color");

$of_options[] = array( "name" =>  "",
	"desc" => "Dropdown Active Text Color",
	"id" => "drop_active_text",
	"std" => "#d13a7a",
	"fold" => "change_main_menu_colors",
	"type" => "color");

$of_options[] = array( "name" =>  "",
	"desc" => "Menu Button Background Color",
	"id" => "menu_button_bg",
	"std" => "#d13a7a",
	"fold" => "change_main_menu_colors",
	"type" => "color");

$of_options[] = array( "name" =>  "",
	"desc" => "Menu Button Text Color",
	"id" => "menu_button_text",
	"std" => "#fff",
	"fold" => "change_main_menu_colors",
	"type" => "color");

$of_options[] = array( "name" =>  "",
	"desc" => "Menu Button Hover Background Color",
	"id" => "menu_button_hover_bg",
	"std" => "#6254a8",
	"fold" => "change_main_menu_colors",
	"type" => "color");

$of_options[] = array( "name" =>  "",
	"desc" => "Menu Button Hover Text Color",
	"id" => "menu_button_hover_text",
	"std" => "#fff",
	"fold" => "change_main_menu_colors",
	"type" => "color");

/*--------------------------------------*/
$of_options[] = array( "name" =>  "",
	"desc" => "Change <strong>Main Content</strong> colors",
	"id" => "change_main_content_colors",
	"std" => 0,
	"folds" => 1,
	"type" => "switch");

$of_options[] = array( "name" =>  "",
	"desc" => "Background Color",
	"id" => "main_bg",
	"std" => "#fff",
	"fold" => "change_main_content_colors",
	"type" => "color");

$of_options[] = array( "name" =>  "",
	"desc" => "Alternate Background Color",
	"id" => "main_bg_alternative",
	"std" => "#f2f2f2",
	"fold" => "change_main_content_colors",
	"type" => "color");

$of_options[] = array( "name" =>  "",
	"desc" => "Border Color",
	"id" => "main_border",
	"std" => "#e8e8e8",
	"fold" => "change_main_content_colors",
	"type" => "color");

$of_options[] = array( "name" =>  "",
	"desc" => "Heading Color",
	"id" => "main_heading",
	"std" => "#444",
	"fold" => "change_main_content_colors",
	"type" => "color");

$of_options[] = array( "name" =>  "",
	"desc" => "Text Color",
	"id" => "main_text",
	"std" => "#666",
	"fold" => "change_main_content_colors",
	"type" => "color");

$of_options[] = array( "name" =>  "",
	"desc" => "Primary Color",
	"id" => "main_primary",
	"std" => "#d13a7a",
	"fold" => "change_main_content_colors",
	"type" => "color");

$of_options[] = array( "name" =>  "",
	"desc" => "Secondary Color",
	"id" => "main_secondary",
	"std" => "#6254a8",
	"fold" => "change_main_content_colors",
	"type" => "color");

$of_options[] = array( "name" =>  "",
	"desc" => "Faded Elements Color",
	"id" => "main_fade",
	"std" => "#999",
	"fold" => "change_main_content_colors",
	"type" => "color");

/*--------------------------------------*/
$of_options[] = array( "name" =>  "",
	"desc" => "Change <strong>Alternate Content</strong> colors",
	"id" => "change_alternate_content_colors",
	"std" => 0,
	"folds" => 1,
	"type" => "switch");

$of_options[] = array( "name" =>  "",
	"desc" => "Background Color",
	"id" => "alt_bg",
	"std" => "#f2f2f2",
	"fold" => "change_alternate_content_colors",
	"type" => "color");

$of_options[] = array( "name" =>  "",
	"desc" => "Alternate Background Color",
	"id" => "alt_bg_alternative",
	"std" => "#fff",
	"fold" => "change_alternate_content_colors",
	"type" => "color");

$of_options[] = array( "name" =>  "",
	"desc" => "Border Color",
	"id" => "alt_border",
	"std" => "#ddd",
	"fold" => "change_alternate_content_colors",
	"type" => "color");

$of_options[] = array( "name" =>  "",
	"desc" => "Heading Color",
	"id" => "alt_heading",
	"std" => "#333",
	"fold" => "change_alternate_content_colors",
	"type" => "color");

$of_options[] = array( "name" =>  "",
	"desc" => "Text Color",
	"id" => "alt_text",
	"std" => "#555",
	"fold" => "change_alternate_content_colors",
	"type" => "color");

$of_options[] = array( "name" =>  "",
	"desc" => "Primary Color",
	"id" => "alt_primary",
	"std" => "#d13a7a",
	"fold" => "change_alternate_content_colors",
	"type" => "color");

$of_options[] = array( "name" =>  "",
	"desc" => "Secondary Color",
	"id" => "alt_secondary",
	"std" => "#6254a8",
	"fold" => "change_alternate_content_colors",
	"type" => "color");

$of_options[] = array( "name" =>  "",
	"desc" => "Faded Elements Color",
	"id" => "alt_fade",
	"std" => "#999",
	"fold" => "change_alternate_content_colors",
	"type" => "color");

/*--------------------------------------*/
$of_options[] = array( "name" =>  "",
	"desc" => "Change <strong>SubFooter</strong> colors",
	"id" => "change_subfooter_colors",
	"std" => 0,
	"folds" => 1,
	"type" => "switch");

$of_options[] = array( "name" =>  "",
	"desc" => "Background Color",
	"id" => "subfooter_bg",
	"std" => "#1a1a1a",
	"fold" => "change_subfooter_colors",
	"type" => "color");

$of_options[] = array( "name" =>  "",
	"desc" => "Border Color",
	"id" => "subfooter_border",
	"std" => "#222",
	"fold" => "change_subfooter_colors",
	"type" => "color");

$of_options[] = array( "name" =>  "",
	"desc" => "Text Color",
	"id" => "subfooter_text",
	"std" => "#808080",
	"fold" => "change_subfooter_colors",
	"type" => "color");

$of_options[] = array( "name" =>  "",
	"desc" => "Heading Color",
	"id" => "subfooter_heading",
	"std" => "#ccc",
	"fold" => "change_subfooter_colors",
	"type" => "color");

$of_options[] = array( "name" =>  "",
	"desc" => "Link Color",
	"id" => "subfooter_link",
	"std" => "#ccc",
	"fold" => "change_subfooter_colors",
	"type" => "color");

$of_options[] = array( "name" =>  "",
	"desc" => "Link Hover Color",
	"id" => "subfooter_link_hover",
	"std" => "#fff",
	"fold" => "change_subfooter_colors",
	"type" => "color");

/*--------------------------------------*/
$of_options[] = array( "name" =>  "",
	"desc" => "Change <strong>Footer</strong> colors",
	"id" => "change_footer_colors",
	"std" => 0,
	"folds" => 1,
	"type" => "switch");

$of_options[] = array( "name" =>  "",
	"desc" => "Background Color",
	"id" => "footer_bg",
	"std" => "#222",
	"fold" => "change_footer_colors",
	"type" => "color");

$of_options[] = array( "name" =>  "",
	"desc" => "Text Color",
	"id" => "footer_text",
	"std" => "#666",
	"fold" => "change_footer_colors",
	"type" => "color");

$of_options[] = array( "name" =>  "",
	"desc" => "Link Color",
	"id" => "footer_link",
	"std" => "#999",
	"fold" => "change_footer_colors",
	"type" => "color");

$of_options[] = array( "name" =>  "",
	"desc" => "Link Hover Color",
	"id" => "footer_link_hover",
	"std" => "#fff",
	"fold" => "change_footer_colors",
	"type" => "color");

/*--------------------------------------*/

$of_options[] = array(
	"name" =>  "Boxed layout",
	"desc" => "Activate Boxed layout of the theme",
	"id" => "boxed_layout",
	"std" => 0,
	"folds" => 1,
	"type" => "switch"
);

$of_options[] = array(
	"name" =>  "",
	"desc" => "Body Background Color",
	"id" => "body_bg",
	"std" => "#eee",
	"fold" => "boxed_layout",
	"type" => "color"
);

$of_options[] = array(
	"name" => "",
	"desc" => "Set Body Background Image",
	"id" => "body_background_image",
	"std" => "",
	"fold" => "boxed_layout",
	"type" => "upload");

$of_options[] = array( "name" => "",
	"desc" => "Background Image repeat",
	"id" => "body_background_image_repeat",
	"type" => "select",
	"std" => 'Repeat',
	"fold" => "boxed_layout",
	"options" => array(
		'repeat' => 'Repeat',
		'repeat-x' => 'Repeat Horizontally',
		'repeat-y' => 'Repeat Vertically',
		'no-repeat' => 'Do Not Repeat',
	));

$of_options[] = array( "name" => "",
	"desc" => "Background Image position",
	"id" => "body_background_image_position",
	"type" => "select",
	"std" => 'top center',
	"fold" => "boxed_layout",
	"options" => array(
		'top center' => 'Top Center',
		'top left' => 'Top Left',
		'top right' => 'Top Right',
		'bottom center' => 'Bottom Center',
		'bottom left' => 'Bottom Left',
		'bottom right' => 'Bottom Right',
		'center center' => 'Center Center',
		'center left' => 'Center Left',
		'center right' => 'Center Right',
	));

$of_options[] = array( "name" => "",
	"desc" => "Fix Background Image with regard to the screen",
	"id" => "body_background_image_attachment_fixed",
	"type" => "switch",
	"std" => 0,
	"fold" => "boxed_layout",
);

$of_options[] = array( "name" => "",
	"desc" => "Stretch Background Image to actual screen size",
	"id" => "body_background_image_stretch",
	"std" => 0,
	"fold" => "boxed_layout",
	"type" => "switch");

$of_options[] = array( 	"name" 		=> "Quick CSS",
	"desc" 		=> "Paste your CSS code. Do not include <strong>&lt;pre&gt;&lt;/pre&gt;</strong> tags or any html tag in this field.",
	"id" 		=> "custom_css",
	"std" 		=> "",
	"type" 		=> "textarea"
);

/*--------------------------------------------------------------------------*/

$of_options[] = array(	"name" => "Header Options",
	"type"=> "heading");

$of_options[] = array( "name" => "Sticky Header",
	"desc" => "Fix the header on the top of a page during scroll by default",
	"id" => "header_is_sticky",
	"std" => 1,
	"folds" => 1,
	"type" => "switch");

$of_options[] = array( "name" => "Transparent Sticky Header",
	"desc" => "Make the header transparent on its initial position by default",
	"id" => "header_bg_transparent",
	"std" => 0,
	"fold" => "header_is_sticky",
	"type" => "switch");
	
$of_options[] = array( 	"name" => "Header Note",
	"std" 		=> "Sticky and transparent header options can be set for a separate certain page when editing it.
	If the options above has no effect for some page, check its Header Type setting.",
	"id" 		=> "header_info",
	"type" 		=> "info");

$of_options[] = array( "name" => "Disable Sticky Header at width:",
	"desc" => "If screen width is less than this value, sticky header transforms to non-sticky",
	"id" => "disable_sticky_header_width",
	"std" => "1000",
	"fold" => "header_is_sticky",
	"type" => "text");

$url = ADMIN_DIR . 'assets/images/';
$of_options[] = array( "name" => "Header Layout",
	"desc" => "",
	"id" => "main_header_layout",
	"std" => "standard",
	"type" => "images",
	"options" => array(
		'standard' => $url . 'header1.png',
		'extended' => $url . 'header2.png',
		'advanced' => $url . 'header3.png',
		'centered' => $url . 'header4.png'
	)
);

$of_options[] = array( "name" => "Height of the main Header area",
	"desc" => "Set value from 50 to 150 (px)",
	"id" => "header_main_height",
	"std" => "120",
	"min" => "50",
	"step"	=> "1",
	"max" => "150",
	"type" => "sliderui"
);
$of_options[] = array( "name" => "Height of the shrinked main Header area",
	"desc" => "Set value from 50 to 150 (px)",
	"id" => "header_main_shrinked_height",
	"std" => "60",
	"min" => "50",
	"step"	=> "1",
	"max" => "150",
	"type" => "sliderui"
);
$of_options[] = array( "name" => "Height of the extra Header area",
	"desc" => "Set value from 36 to 60 (px)",
	"id" => "header_extra_height",
	"std" => "36",
	"min" => "36",
	"step"	=> "1",
	"max" => "60",
	"type" => "sliderui"
);

$of_options[] = array( "name" => "Inverted Logo Position",
	"desc" => "Place Logo to the right side of the Header",
	"id" => "header_invert_logo_pos",
	"std" => 0,
	"type" => "switch"
);

$of_options[] = array( "name" => "Header Elements",
	"desc" => "Show <strong>Search Widget</strong> in the Header",
	"id" => "header_show_search",
	"std" => 1,
	"type" => "switch"
);

$of_options[] = array( "name" => "",
	"desc" => "Show <strong>Contacts Widget</strong> in the Header",
	"id" => "header_show_contacts",
	"std" => 0,
	"folds" => 1,
	"type" => "switch"
);

$of_options[] = array( "name" => "Contact Phone Number",
	"desc" => "",
	"id" => "header_phone",
	"std" => "",
	"fold" => "header_show_contacts",
	"type" => "text");

$of_options[] = array( "name" => "Contact Email",
	"desc" => "",
	"id" => "header_email",
	"std" => "",
	"fold" => "header_show_contacts",
	"type" => "text");

$of_options[] = array( "name" => "",
	"desc" => "Show <strong>Social Links</strong> in the Header",
	"id" => "header_show_socials",
	"std" => 0,
	"folds" => 1,
	"type" => "switch"
);

$of_options[] = array( "name" => "Facebook",
	"desc" => "",
	"id" => "header_social_facebook",
	"std" => "",
	"fold" => "header_show_socials",
	"type" => "text");

$of_options[] = array( "name" => "Twitter",
	"desc" => "",
	"id" => "header_social_twitter",
	"std" => "",
	"fold" => "header_show_socials",
	"type" => "text");

$of_options[] = array( "name" => "Google+",
	"desc" => "",
	"id" => "header_social_google",
	"std" => "",
	"fold" => "header_show_socials",
	"type" => "text");

$of_options[] = array( "name" => "LinkedIn",
	"desc" => "",
	"id" => "header_social_linkedin",
	"std" => "",
	"fold" => "header_show_socials",
	"type" => "text");

$of_options[] = array( "name" => "YouTube",
	"desc" => "",
	"id" => "header_social_youtube",
	"std" => "",
	"fold" => "header_show_socials",
	"type" => "text");

$of_options[] = array( "name" => "Vimeo",
	"desc" => "",
	"id" => "header_social_vimeo",
	"std" => "",
	"fold" => "header_show_socials",
	"type" => "text");

$of_options[] = array( "name" => "Flickr",
	"desc" => "",
	"id" => "header_social_flickr",
	"std" => "",
	"fold" => "header_show_socials",
	"type" => "text");

$of_options[] = array( "name" => "Instagram",
	"desc" => "",
	"id" => "header_social_instagram",
	"std" => "",
	"fold" => "header_show_socials",
	"type" => "text");

$of_options[] = array( "name" => "Behance",
	"desc" => "",
	"id" => "header_social_behance",
	"std" => "",
	"fold" => "header_show_socials",
	"type" => "text");

$of_options[] = array( "name" => "Xing",
	"desc" => "",
	"id" => "header_social_xing",
	"std" => "",
	"fold" => "header_show_socials",
	"type" => "text");

$of_options[] = array( "name" => "Pinterest",
	"desc" => "",
	"id" => "header_social_pinterest",
	"std" => "",
	"fold" => "header_show_socials",
	"type" => "text");

$of_options[] = array( "name" => "Skype",
	"desc" => "",
	"id" => "header_social_skype",
	"std" => "",
	"fold" => "header_show_socials",
	"type" => "text");

$of_options[] = array( "name" => "Tumblr",
	"desc" => "",
	"id" => "header_social_tumblr",
	"std" => "",
	"fold" => "header_show_socials",
	"type" => "text");

$of_options[] = array( "name" => "Dribbble",
	"desc" => "",
	"id" => "header_social_dribbble",
	"std" => "",
	"fold" => "header_show_socials",
	"type" => "text");

$of_options[] = array( "name" => "Vkontakte",
	"desc" => "",
	"id" => "header_social_vk",
	"std" => "",
	"fold" => "header_show_socials",
	"type" => "text");

$of_options[] = array( "name" => "SoundCloud",
	"desc" => "",
	"id" => "header_social_soundcloud",
	"std" => "",
	"fold" => "header_show_socials",
	"type" => "text");

$of_options[] = array( "name" => "Yelp",
	"desc" => "",
	"id" => "header_social_yelp",
	"std" => "",
	"fold" => "header_show_socials",
	"type" => "text");

$of_options[] = array( "name" => "Twitch",
	"desc" => "",
	"id" => "header_social_twitch",
	"std" => "",
	"fold" => "header_show_socials",
	"type" => "text");

$of_options[] = array( "name" => "RSS",
	"desc" => "",
	"id" => "header_social_rss",
	"std" => "",
	"fold" => "header_show_socials",
	"type" => "text");

/* $of_options[] = array( "name" => "",
	"desc" => "Show <strong>Custom Block</strong> in the Header",
	"id" => "header_show_custom",
	"std" => 1,
	"folds" => 1,
	"type" => "switch"
);
$of_options[] = array( "name" => "Icon of Custom Block",
	"desc" => "Enter FontAwesome icon name.<br>Full list of icons",
	"id" => "header_custom_icon",
	"std" => "user",
	"fold" => "header_show_custom",
	"type" => "text"
);
$of_options[] = array( "name" => "Text of Custom Block",
	"desc" => "Enter any text, you can use html tags",
	"id" => "header_custom_text",
	"std" => "Hello! I am a custom block",
	"fold" => "header_show_custom",
	"type" => "text"
); */

$of_options[] = array( "name" => "",
	"desc" => "Show <strong>Language Widget</strong> in the Header",
	"id" => "header_show_language",
	"std" => 0,
	"type" => "switch");

$of_options[] = array( "name" => "Language Widget type",
	"desc" => "",
	"id" => "header_language_type",
	"std" => "Your own links",
	"type" => "select",
	"options" => array(
		'own' => 'Your own links',
		'wpml' => 'WPML language switcher',
	));

$of_options[] = array( "name" => "Languages amount",
	"desc" => "Only for your own links",
	"id" => "header_language_amount",
	"std" => "2",
	"type" => "select",
	"options" => array(
		'2' => '2',
		'3' => '3',
		'4' => '4',
		'5' => '5',
		'6' => '6',
		'7' => '7',
		'8' => '8',
		'9' => '9',
		'10' => '10',
	));

$of_options[] = array( "name" => "Current Language",
	"desc" => "Current Language code or name",
	"id" => "header_language_1_name",
	"std" => "",
	"type" => "text");

$of_options[] = array( "name" => "Language 2",
	"desc" => "Language 2 code or name",
	"id" => "header_language_2_name",
	"std" => "",
	"type" => "text");

$of_options[] = array( "name" => "",
	"desc" => "Language 2 URL",
	"id" => "header_language_2_url",
	"std" => "",
	"type" => "text");

$of_options[] = array( "name" => "Language 3",
	"desc" => "Language 3 code or name",
	"id" => "header_language_3_name",
	"std" => "",
	"type" => "text");

$of_options[] = array( "name" => "",
	"desc" => "Language 3 URL",
	"id" => "header_language_3_url",
	"std" => "",
	"type" => "text");

$of_options[] = array( "name" => "Language 4",
	"desc" => "Language 4 code or name",
	"id" => "header_language_4_name",
	"std" => "",
	"type" => "text");

$of_options[] = array( "name" => "",
	"desc" => "Language 4 URL",
	"id" => "header_language_4_url",
	"std" => "",
	"type" => "text");

$of_options[] = array( "name" => "Language 5",
	"desc" => "Language 5 code or name",
	"id" => "header_language_5_name",
	"std" => "",
	"type" => "text");

$of_options[] = array( "name" => "",
	"desc" => "Language 5 URL",
	"id" => "header_language_5_url",
	"std" => "",
	"type" => "text");

$of_options[] = array( "name" => "Language 6",
	"desc" => "Language 6 code or name",
	"id" => "header_language_6_name",
	"std" => "",
	"type" => "text");

$of_options[] = array( "name" => "",
	"desc" => "Language 6 URL",
	"id" => "header_language_6_url",
	"std" => "",
	"type" => "text");

$of_options[] = array( "name" => "Language 7",
	"desc" => "Language 7 code or name",
	"id" => "header_language_7_name",
	"std" => "",
	"type" => "text");

$of_options[] = array( "name" => "",
	"desc" => "Language 7 URL",
	"id" => "header_language_7_url",
	"std" => "",
	"type" => "text");

$of_options[] = array( "name" => "Language 8",
	"desc" => "Language 8 code or name",
	"id" => "header_language_8_name",
	"std" => "",
	"type" => "text");

$of_options[] = array( "name" => "",
	"desc" => "Language 8 URL",
	"id" => "header_language_8_url",
	"std" => "",
	"type" => "text");

$of_options[] = array( "name" => "Language 9",
	"desc" => "Language 9 code or name",
	"id" => "header_language_9_name",
	"std" => "",
	"type" => "text");

$of_options[] = array( "name" => "",
	"desc" => "Language 9 URL",
	"id" => "header_language_9_url",
	"std" => "",
	"type" => "text");

$of_options[] = array( "name" => "Language 10",
	"desc" => "Language 10 code or name",
	"id" => "header_language_10_name",
	"std" => "",
	"type" => "text");

$of_options[] = array( "name" => "",
	"desc" => "Language 10 URL",
	"id" => "header_language_10_url",
	"std" => "",
	"type" => "text");

/*--------------------------------------------------------------------------*/

$of_options[] = array(	"name" => "Menu Options",
	"type"=> "heading");
	
$of_options[] = array( "name" => "Transform Menu to mobile view at width:",
	"desc" => "If screen width is less than this value, main menu transforms to mobile-friendly layout",
	"id" => "mobile_nav_width",
	"std" => "1000",
	"type" => "text");

$of_options[] = array( "name" => "Menu dropdown appearance effect",
	"desc" => "",
	"id" => "menu_hover_animation",
	"std" => "Opacity fadeIn/fadeOut",
	"type" => "select",
	"options" => array(
		'opacity' => 'FadeIn',
		'height' => 'FadeIn + SlideDown',
//		'mdesign' => 'Material Design Effect',
	));

$of_options[] = array( "name" => "Mobile Menu behaviour",
	"desc" => "Open sub items on click at menu titles (instead of arrows)",
	"id" => "header_menu_togglable",
	"std" => 0,
	"type" => "switch");
	
/*--------------------------------------------------------------------------*/

$of_options[] = array(	"name" => "Footer Options",
	"type"=> "heading");

$of_options[] = array( "name" => "Subfooter",
	"desc" => "Show <strong>Subfooter</strong> (widgets area)",
	"id" => "footer_show_widgets",
	"std" => 1,
	"folds" => 1,
	"type" => "switch");

$of_options[] = array( "name" => "Subfooter columns",
	"desc" => "Set number of columns in Subfooter. You can populate these columns with <a target='_blank' href='".admin_url()."widgets.php'>widgets</a>",
	"id" => "footer_widgets_columns",
	"std" => 3,
	"type" => "select",
	"fold" => "footer_show_widgets",
	"options" => array(
		1, 2, 3, 4
	));

$of_options[] = array( "name" => " Footer",
	"desc" => "Show <strong>Footer</strong> (copyright and menu area)",
	"id" => "footer_show_footer",
	"std" => 1,
	"folds" => 1,
	"type" => "switch");

$of_options[] = array( "name" => "Copyright text",
	"desc" => "",
	"id" => "footer_copyright",
	"std" => "Any text goes here",
	"fold" => "footer_show_footer",
	"type" => "text");

$of_options[] = array( "name" => "Typography",
	"type" => "heading");

$of_options[] = array( 	"name" 		=> "Headings",
	"desc" 		=> "",
	"id" 		=> "heading_font", // TODO: Rename to "heading_font_family"
	"std" 		=> "Noto Sans",
	"type" 		=> "select_google_font",
	"preview" 	=> array(
		"text" => "Heading Font Preview", //this is the text from preview box
		"size" => "30px" //this is the text size from preview box
	),
	"options" 	=> array(
		'web_safe_fonts' => $web_safe_fonts,
		'google_fonts' => $google_fonts,
	),
);

$of_options[] = array( "name" => "",
	"desc" => "Extra-Light (200)",
	"id" => "heading_font_weight_200",
	"std" => 0,
	"type" => "checkbox");

$of_options[] = array( "name" => "",
	"desc" => "Light (300)",
	"id" => "heading_font_weight_300",
	"std" => 1,
	"type" => "checkbox");

$of_options[] = array( "name" => "",
	"desc" => "Normal (400)",
	"id" => "heading_font_weight_400",
	"std" => 1,
	"type" => "checkbox");

$of_options[] = array( "name" => "",
	"desc" => "Semi-bold (600)",
	"id" => "heading_font_weight_600",
	"std" => 0,
	"type" => "checkbox");

$of_options[] = array( "name" => "",
	"desc" => "Bold (700)",
	"id" => "heading_font_weight_700",
	"std" => 1,
	"type" => "checkbox");

$of_options[] = array( "name" => "",
   "desc" => "Enable Italic font style for the chosen font weights",
   "id" => "heading_font_style_italic",
   "std" => 0,
   "type" => "switch");

$of_options[] = array( "name" =>  "Sizes on Desktops",
	"desc" => "<strong>Heading 1</strong> font size",
	"id" => "h1_fontsize",
	"std" => "38",
	"class" => "font",
	"type" => "text");
$of_options[] = array( "name" =>  "Sizes on Mobiles",
	"desc" => "<strong>Heading 1</strong> font size",
	"id" => "h1_fontsize_mobile",
	"std" => "30",
	"class" => "font",
	"type" => "text");

$of_options[] = array( "name" =>  "",
	"desc" => "<strong>Heading 2</strong> font size",
	"id" => "h2_fontsize",
	"std" => "32",
	"class" => "font",
	"type" => "text");
$of_options[] = array( "name" =>  "",
	"desc" => "<strong>Heading 2</strong> font size",
	"id" => "h2_fontsize_mobile",
	"std" => "26",
	"class" => "font",
	"type" => "text");

$of_options[] = array( "name" =>  "",
	"desc" => "<strong>Heading 3</strong> font size",
	"id" => "h3_fontsize",
	"std" => "26",
	"class" => "font",
	"type" => "text");
$of_options[] = array( "name" =>  "",
	"desc" => "<strong>Heading 3</strong> font size",
	"id" => "h3_fontsize_mobile",
	"std" => "22",
	"class" => "font",
	"type" => "text");

$of_options[] = array( "name" =>  "",
	"desc" => "<strong>Heading 4</strong> font size",
	"id" => "h4_fontsize",
	"std" => "22",
	"class" => "font",
	"type" => "text");
$of_options[] = array( "name" =>  "",
	"desc" => "<strong>Heading 4</strong> font size",
	"id" => "h4_fontsize_mobile",
	"std" => "20",
	"class" => "font",
	"type" => "text");

$of_options[] = array( "name" =>  "",
	"desc" => "<strong>Heading 5</strong> font size",
	"id" => "h5_fontsize",
	"std" => "20",
	"class" => "font",
	"type" => "text");
$of_options[] = array( "name" =>  "",
	"desc" => "<strong>Heading 5</strong> font size",
	"id" => "h5_fontsize_mobile",
	"std" => "18",
	"class" => "font",
	"type" => "text");

$of_options[] = array( "name" =>  "",
	"desc" => "<strong>Heading 6</strong> font size",
	"id" => "h6_fontsize",
	"std" => "18",
	"class" => "font",
	"type" => "text");
$of_options[] = array( "name" =>  "",
	"desc" => "<strong>Heading 6</strong> font size",
	"id" => "h6_fontsize_mobile",
	"std" => "16",
	"class" => "font",
	"type" => "text");

$of_options[] = array( 	"name" => "Regular Text",
	"desc" 		=> "",
	"id" 		=> "body_text_font", // TODO: Rename to ""body_font_family"
	"std" 		=> "Open Sans",
	"type" 		=> "select_google_font",
	"preview" 	=> array(
		"text" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec condimentum tellus purus condimentum pulvinar. Duis cursus bibendum dui, eget iaculis urna pharetra. Aenean semper nec ipsum vitae mollis.", //this is the text from preview box
		"size" => "16px" //this is the text size from preview box
	),
	"options" 	=> array(
		'web_safe_fonts' => $web_safe_fonts,
		'google_fonts' => $google_fonts,
	),
);

$of_options[] = array( "name" => "",
	"desc" => "Extra-Light (200)",
	"id" => "body_font_weight_200",
	"std" => 0,
	"type" => "checkbox");

$of_options[] = array( "name" => "",
	"desc" => "Light (300)",
	"id" => "body_font_weight_300",
	"std" => 0,
	"type" => "checkbox");

$of_options[] = array( "name" => "",
	"desc" => "Normal (400)",
	"id" => "body_font_weight_400",
	"std" => 1,
	"type" => "checkbox");

$of_options[] = array( "name" => "",
	"desc" => "Semi-bold (600)",
	"id" => "body_font_weight_600",
	"std" => 0,
	"type" => "checkbox");

$of_options[] = array( "name" => "",
	"desc" => "Bold (700)",
	"id" => "body_font_weight_700",
	"std" => 1,
	"type" => "checkbox");

$of_options[] = array( "name" => "",
   "desc" => "Enable Italic font style for the chosen font weights",
   "id" => "body_font_style_italic",
   "std" => 1,
   "type" => "switch");


$of_options[] = array( "name" =>  "Sizes on Desktops",
	"desc" => "Font size",
	"id" => "regular_fontsize",
	"std" => "14",
	"class" => "font",
	"type" => "text");
$of_options[] = array( "name" =>  "Sizes on Mobiles",
	"desc" => "Font size",
	"id" => "regular_fontsize_mobile",
	"std" => "13",
	"class" => "font",
	"type" => "text");

$of_options[] = array( "name" =>  "",
	"desc" => "Line height",
	"id" => "regular_lineheight",
	"std" => "24",
	"class" => "font",
	"type" => "text");
$of_options[] = array( "name" =>  "",
	"desc" => "Line height",
	"id" => "regular_lineheight_mobile",
	"std" => "21",
	"class" => "font",
	"type" => "text");

$of_options[] = array( 	"name" => "Main Menu Text",
	"desc" 		=> "",
	"id" 		=> "navigation_font", // TODO: Rename to ""nav_font_family"
	"std" 		=> "Open Sans",
	"type" 		=> "select_google_font",
	"preview" 	=> array(
		"text" => "Home&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;About&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Services&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Portfolio", //this is the text from preview box
		"size" => "17px" //this is the text size from preview box
	),
	"options" 	=> array(
		'web_safe_fonts' => $web_safe_fonts,
		'google_fonts' => $google_fonts,
	),
);

$of_options[] = array( "name" => "",
	"desc" => "Extra-Light (200)",
	"id" => "nav_font_weight_200",
	"std" => 0,
	"type" => "checkbox");

$of_options[] = array( "name" => "",
	"desc" => "Light (300)",
	"id" => "nav_font_weight_300",
	"std" => 1,
	"type" => "checkbox");

$of_options[] = array( "name" => "",
	"desc" => "Normal (400)",
	"id" => "nav_font_weight_400",
	"std" => 0,
	"type" => "checkbox");

$of_options[] = array( "name" => "",
	"desc" => "Semi-bold (600)",
	"id" => "nav_font_weight_600",
	"std" => 0,
	"type" => "checkbox");

$of_options[] = array( "name" => "",
	"desc" => "Bold (700)",
	"id" => "nav_font_weight_700",
	"std" => 0,
	"type" => "checkbox");

$of_options[] = array( "name" => "",
   "desc" => "Enable Italic font style for the chosen font weights",
   "id" => "nav_font_style_italic",
   "std" => 0,
   "type" => "switch");

$of_options[] = array( "name" =>  "Sizes on Default Menu",
	"desc" => "Font size of <strong>main</strong> items",
	"id" => "nav_fontsize",
	"std" => "16",
	"class" => "font",
	"type" => "text");
$of_options[] = array( "name" =>  "Sizes on Mobile Menu",
	"desc" => "Font size of <strong>main</strong> items",
	"id" => "nav_fontsize_mobile",
	"std" => "16",
	"class" => "font",
	"type" => "text");

$of_options[] = array( "name" =>  "",
	"desc" => "Font size of <strong>sub</strong> items",
	"id" => "subnav_fontsize",
	"std" => "15",
	"class" => "font",
	"type" => "text");
$of_options[] = array( "name" =>  "",
	"desc" => "Font size of <strong>sub</strong> items",
	"id" => "subnav_fontsize_mobile",
	"std" => "15",
	"class" => "font",
	"type" => "text");

$of_options[] = array( "name" => "Subset",
	"desc" => "Select characters subset for Google fonts. <strong>Please note: some fonts does not support particular subsets!</strong>",
	"id" => "font_subset",
	"std" => "latin",
	"type" => "select",
	"options" => $google_fonts_subsets,
);

$of_options[] = array( "name" => "Portfolio Options",
	"type" => "heading");

$of_options[] = array( "name" => "Sidebar at Portfolio Items",
	"desc" => "Sidebar position at Portfolio Items",
	"id" => "portfolio_sidebar_pos",
	"std" => "No Sidebar",
	"type" => "select",
	"options" => array(
		'No Sidebar',
		'Right',
		'Left',
	));

$of_options[] = array( "name" => "Portfolio Comments",
	"desc" => "Enable comments at Portfolio Items",
	"id" => "portfolio_comments",
	"std" => 0,
	"type" => "switch");

$of_options[] = array( "name" => "Portfolio Slug",
	"desc" => "",
	"id" => "portfolio_slug",
	"std" => "portfolio",
	"type" => "text");

$of_options[] = array( 	"name" => "Portfolio Slug Note",
	"std" 		=> "Please go to <a href='".admin_url('options-permalink.php')."'>Permalinks Settings</a> and hit <strong>Save Changes</strong> button once after each time you change Portfolio Slug field. This will regenerate permalinks so they will match new Portfolio slug.",
	"id" 		=> "portfolio_slug_info",
	"type" 		=> "info");

$of_options[] = array( "name" => "Blog Options",
	"type" => "heading");

$of_options[] = array( "name" => "Sidebar at Blog page",
	"desc" => "Sidebar position at blog page (Large Image and Small Image templates only)",
	"id" => "blog_sidebar_pos",
	"std" => "Right",
	"type" => "select",
	"options" => array(
		'right' => 'Right',
		'left' => 'Left',
		'none' => 'No Sidebar',
	));

$of_options[] = array( "name" => "Sidebar at Posts",
	"desc" => "Sidebar position at posts",
	"id" => "post_sidebar_pos",
	"std" => "Right",
	"type" => "select",
	"options" => array(
		'right' => 'Right',
		'left' => 'Left',
		'none' => 'No Sidebar',
	));

$of_options[] = array( "name" => "Read More Button",
	"desc" => "Show Read More button",
	"id" => "post_read_more",
	"std" => 1,
	"type" => "switch");

$of_options[] = array( "name" => "Post Meta",
	"desc" => "Show date",
	"id" => "post_meta_date",
	"std" => 1,
	"type" => "switch");

$of_options[] = array( "name" => "",
	"desc" => "Show author",
	"id" => "post_meta_author",
	"std" => 1,
	"type" => "switch");

$of_options[] = array( "name" => "",
	"desc" => "Show categories",
	"id" => "post_meta_categories",
	"std" => 1,
	"type" => "switch");

$of_options[] = array( "name" => "",
	"desc" => "Show comments number",
	"id" => "post_meta_comments",
	"std" => 1,
	"type" => "switch");

$of_options[] = array( "name" => "",
	"desc" => "Show tags",
	"id" => "post_meta_tags",
	"std" => 1,
	"type" => "switch");

//$of_options[] = array( "name" => "Date Format",
//	"desc" => "<a href=\"http://codex.wordpress.org/Formatting_Date_and_Time\" target=\"_blank\">Formatting Date and Time</a>",
//	"id" => "blog_date_format",
//	"std" => "F jS, Y",
//	"type" => "text");

$of_options[] = array( "name" => "Related Posts",
	"desc" => "Show  list of posts with same tags at single post page",
	"id" => "post_related_posts",
	"std" => 1,
	"type" => "switch");

//$of_options[] = array( "name" => "Comments",
//	"desc" => "Show comments.",
//	"id" => "blog_comments",
//	"std" => 1,
//	"type" => "switch");


$of_options[] = array( "name" => "Posts Content at Blog page",
	"desc" => "Select type of posts content which shows at blog page",
	"id" => "use_excerpt",
	"std" => "Excerpt",
	"type" => "select",
	"options" => array('Excerpt' => 'Excerpt', 'Full Content of Post' => 'Full Content of Post', 'No Content' => 'No Content'));

$of_options[] = array( "name" => "Excerpt Length",
	"desc" => "Input the number of words in the Excerpt",
	"id" => "blog_excerpt_length",
	"std" => "40",
	"type" => "text");

$of_options[] = array( "name" => "Default Blog layout",
	"desc" => "Select blog layout for default front page",
	"id" => "blog_layout",
	"std" => "Large Image",
	"type" => "select",
	"options" => array(
		'large_image' => 'Large Image',
		'small_image' => 'Small Image',
		'grid' => 'Masonry Grid with ajax load',
		'grid_paginated' => 'Masonry Grid with pagination',
//		'simple' => 'Simple',
	));

$of_options[] = array( "name" => "Archives layout",
	"desc" => "Select layout for Archives pages (Category Archive, Tagged Posts, Blog Archives)",
	"id" => "archive_layout",
	"std" => "Large Image",
	"type" => "select",
	"options" => array(
		'large_image' => 'Large Image',
		'small_image' => 'Small Image',
		'grid_paginated' => 'Masonry Grid',
	));

$of_options[] = array( "name" => "Search Results layout",
	"desc" => "Select layout for Search Results page",
	"id" => "search_layout",
	"std" => "Large Image",
	"type" => "select",
	"options" => array(
		'large_image' => 'Large Image',
		'small_image' => 'Small Image',
		'grid_paginated' => 'Masonry Grid',
	));

if ( class_exists( 'woocommerce' ) ) {
	// WooCommerce Options
	$of_options[] = array( 	"name" 		=> "WooCommerce",
		"type" 		=> "heading"
	);

	$of_options[] = array( "name" => "Sidebar at Shop pages",
		"desc" => "Sidebar position at shop pages",
		"id" => "shop_sidebar_pos",
		"std" => "Right",
		"type" => "select",
		"options" => array(
			'Right' => 'Right',
			'Left' => 'Left',
			'No Sidebar' => 'No Sidebar',
		));

	$of_options[] = array( "name" => "Sidebar at Product pages",
		"desc" => "Sidebar position at product pages",
		"id" => "good_sidebar_pos",
		"std" => "Right",
		"type" => "select",
		"options" => array(
			'Right' => 'Right',
			'Left' => 'Left',
			'No Sidebar' => 'No Sidebar',
		));

	$of_options[] = array( "name" => "Columns at Shop Pages",
		"desc" => "",
		"id" => "shop_columns_qty",
		"std" => 3,
		"type" => "select",
		"options" => array(
			'2 columns',
			'3 columns',
			'4 columns',
			'5 columns',
		));

	$of_options[] = array( "name" => "Related Products Quantity",
		"desc" => "",
		"id" => "related_products_qty",
		"std" => 3,
		"type" => "select",
		"options" => array(
			'2 items',
			'3 items',
			'4 items',
			'5 items',
		));
}

if (in_array( 'bbpress/bbpress.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	// BBPress Options
	$of_options[] = array( 	"name" 		=> "BBPress",
		"type" 		=> "heading"
	);

	$of_options[] = array( "name" => "Sidebar at Forum pages",
		"desc" => "Sidebar position at forum pages",
		"id" => "forum_sidebar_pos",
		"std" => "Right",
		"type" => "select",
		"options" => array(
			'Right' => 'Right',
			'Left' => 'Left',
			'No Sidebar' => 'No Sidebar',
		));
}

// Theme Update Options
$of_options[] = array( 	"name" 		=> "Theme Update",
	"type" 		=> "heading"
);

$of_options[] = array( 	"name" 		=> "TF_Update",
	"std" 		=> "Please enter your Themeforest username and Secret API Key below if you want to get update notifications for IMPREZA theme.",
	"id" 		=> "themeforest_info",
	"type" 		=> "info"
);

$of_options[] = array( "name" => "ThemeForest User Name",
	"desc" => "",
	"id" => "themeforest_username",
	"std" => "",
	"type" => "text"
);

$of_options[] = array( "name" => "ThemeForest API Key",
	"desc" => "Copy API Key of your ThemeForest account here. Check this <a target='_blank' href='".get_template_directory_uri()."/img/find-api.png'>screenshot</a> for more info",
	"id" => "themeforest_api_key",
	"std" => "",
	"type" => "text"
);


// Manage Options
$of_options[] = array( 	"name" 		=> "Manage Options",
	"type" 		=> "heading"
);

$of_options[] = array( 	"name" 		=> "Backup and restore Theme Options",
	"id" 		=> "of_backup",
	"std" 		=> "",
	"type" 		=> "backup",
	"desc" 		=> 'You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.',
);

$of_options[] = array( "name" => "Transfer Theme Options data",
	"id" => "of_transfer",
	"std" => "",
	"type" => "transfer",
	"desc" => 'You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".',
);

	}//End function: of_options()
}//End chack if function exists: of_options()
?>
