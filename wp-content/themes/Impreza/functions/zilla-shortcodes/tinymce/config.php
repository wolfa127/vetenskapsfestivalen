<?php

$post_categories = array('' => 'All');
if (function_exists('get_categories')) {
$post_categories_raw = get_categories("hierarchical=0");
	foreach ($post_categories_raw as $post_category_raw)
	{
		$post_categories[$post_category_raw->slug] = $post_category_raw->name;
	}
}
$portfolio_categories = array('' => 'All');
if (function_exists('get_categories')) {
	$portfolio_categories_raw = get_categories("taxonomy=us_portfolio_category&hierarchical=0");
	foreach ($portfolio_categories_raw as $portfolio_category_raw)
	{
		$portfolio_categories[$portfolio_category_raw->slug] = $portfolio_category_raw->name;
	}
}

/*-----------------------------------------------------------------------------------*/
/*	Button Config
/*-----------------------------------------------------------------------------------*/

$us_zilla_shortcodes['button'] = array(
	'no_preview' => true,
	'params' => array(
		'text' => array(
			'std' => 'Click me',
			'type' => 'text',
			'label' => 'Button Label',
			'desc' => '',
		),
		'url' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Button Link',
			'desc' => '',
		),
		'type' => array(
			'type' => 'select',
			'label' => 'Button Color',
			'desc' => '',
			'options' => array(
				'primary' => 'Primary (theme color)',
				'secondary' => 'Secondary (theme color)',
				'contrast' => 'Contrast (theme color)',
				'default' => 'Faded (theme color)',
				'white' => 'White',
				'pink' => 'Pink',
				'blue' => 'Blue',
				'green' => 'Green',
				'yellow' => 'Yellow',
				'purple' => 'Purple',
				'red' => 'Red',
				'lime' => 'Lime',
				'navy' => 'Navy',
				'cream' => 'Cream',
				'brown' => 'Brown',
				'midnight' => 'Midnight',
				'teal' => 'Teal',
				'transparent' => 'Transparent',
			)
		),
		'outlined' => array(
			'std' => '0',
			'type' => 'checkbox',
			'label' => 'Outlined',
			'checkbox_text' => 'Apply Outlined Style to the Button',
			'desc' => '',
		),
		'icon' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Button Icon (optional)',
			'desc' => 'FontAwesome Icon name. <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">Full list of icons</a>',
		),
		'align' => array(
			'type' => 'select',
			'label' => 'Button Position',
			'desc' => '',
			'options' => array(
				'left' => 'Align left',
				'center' => 'Align center',
				'right' => 'Align right',
			)
		),
		'size' => array(
			'type' => 'select',
			'label' => 'Button Size',
			'desc' => '',
			'options' => array(
				'' => 'Normal',
				'small' => 'Small',
				'big' => 'Big'
			)
		),
		'target' => array(
			'std' => '',
			'type' => 'select',
			'label' => 'Button Link Target',
			'desc' => '',
			'options' => array(
				'_self' => 'Same window',
				'_blank' => 'New window',
			)
		),
	),
	'shortcode' => '[vc_button url="{{url}}" text="{{text}}" size="{{size}}" align="{{align}}" type="{{type}}" outlined="{{outlined}}" icon="{{icon}}" target="{{target}}"]',
	'popup_title' => 'Insert Button shortcode'
);

/*-----------------------------------------------------------------------------------*/
/*	Alert Config
/*-----------------------------------------------------------------------------------*/

$us_zilla_shortcodes['alert'] = array(
	'no_preview' => true,
	'params' => array(
		'type' => array(
			'type' => 'select',
			'label' => 'Alert Color',
			'desc' => '',
			'options' => array(
				'info' => 'Notification (blue)',
				'attention' => 'Attention (yellow)',
				'success' => 'Success (green)',
				'error' => 'Error (red)',
			)
		),
		'content' => array(
			'std' => 'Alert Text',
			'type' => 'textarea',
			'label' => 'Alert Text',
			'desc' => '',
		)

	),
	'shortcode' => '[vc_message type="{{type}}"] {{content}} [/vc_message]',
	'popup_title' => 'Insert Message Box shortcode'
);

/*-----------------------------------------------------------------------------------*/
/*	Tabs Config
/*-----------------------------------------------------------------------------------*/

$us_zilla_shortcodes['tabs'] = array(
	'params' => array(
		'timeline' => array(
			'std' => '0',
			'type' => 'checkbox',
			'label' => 'Act as Timeline',
			'checkbox_text' => 'Change look and feel into Timeline',
			'desc' => '',
		),
	),
	'no_preview' => true,
	'shortcode' => '[vc_tabs timeline="{{timeline}}"] {{child_shortcode}} <br>[/vc_tabs]',
	'popup_title' => 'Insert Tabs shortcode',

	'child_shortcode' => array(
		'params' => array(
			'title' => array(
				'std' => 'Title',
				'type' => 'text',
				'label' => 'Tab Title',
				'desc' => 'Enter the tab title here (better keep it short)',
			),
			'icon' => array(
				'std' => '',
				'type' => 'text',
				'label' => 'Tab Icon (optional)',
				'desc' => 'FontAwesome Icon name. <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">Full list of icons</a>',
			),
			'active' => array(
				'std' => '0',
				'type' => 'checkbox',
				'label' => 'Active Tab',
				'checkbox_text' => 'Tab is opened on page load',
				'desc' => '',
			),
			'content' => array(
				'std' => 'Tab Content. You can use other shortcodes here',
				'type' => 'textarea',
				'label' => 'Tab Content',
				'desc' => ''
			),
		),
		'shortcode' => '<br>[vc_tab title="{{title}}" icon="{{icon}}" active="{{active}}"] {{content}} [/vc_tab]',
		'clone_button' => 'Add Tab'
	)
);


/*-----------------------------------------------------------------------------------*/
/*	Accordion Config
/*-----------------------------------------------------------------------------------*/

$us_zilla_shortcodes['accordion'] = array(
	'params' => array(
		'toggle' => array(
			'std' => '0',
			'type' => 'checkbox',
			'label' => 'Act as Toggles',
			'checkbox_text' => 'Allow several sections be open at the same time',
			'desc' => '',
		),
	),
	'no_preview' => true,
	'shortcode' => '[vc_accordion toggle="{{toggle}}"] {{child_shortcode}} [/vc_accordion]',
	'popup_title' => 'Insert Accordion shortcode',

	'child_shortcode' => array(
		'params' => array(
			'title' => array(
				'std' => 'Title',
				'type' => 'text',
				'label' => 'Tab Title',
				'desc' => 'Enter the tab title here (better keep it short)',
			),
			'icon' => array(
				'std' => '',
				'type' => 'text',
				'label' => 'Tab Icon (optional)',
				'desc' => '',
			),
			'active' => array(
				'std' => '0',
				'type' => 'checkbox',
				'label' => 'Active Tab',
				'checkbox_text' => 'Tab is opened on page load',
				'desc' => '',
			),
			'content' => array(
				'std' => 'Tab Content. You can use other shortcodes here',
				'type' => 'textarea',
				'label' => 'Tab Content',
				'desc' => 'FontAwesome Icon name. <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">Full list of icons</a>'
			),
		),
		'shortcode' => '<br>[vc_accordion_tab title="{{title}}" icon="{{icon}}" active="{{active}}"] {{content}} [/vc_accordion_tab]',
		'clone_button' => 'Add Accordion'
	)
);

/*-----------------------------------------------------------------------------------*/
/*	Video Config
/*-----------------------------------------------------------------------------------*/

$us_zilla_shortcodes['video'] = array(
	'no_preview' => true,
	'params' => array(
		'link' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Video link',
			'desc' => 'Link to the video. More about supported formats at <a href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank">WordPress codex page</a>',
		),
		'ratio' => array(
			'type' => 'select',
			'label' => 'Ratio',
			'desc' => '',
			'options' => array(
				'16-9' => '16x9',
				'4-3' => '4x3',
				'3-2' => '3x2',
				'1-1' => '1x1',
			)
		),

	),
	'shortcode' => '[vc_video link="{{link}}" ratio="{{ratio}}"]',
	'popup_title' => 'Insert Video shortcode'
);


/*-----------------------------------------------------------------------------------*/
/*	Contact Form Config
/*-----------------------------------------------------------------------------------*/

$us_zilla_shortcodes['contact_form'] = array(
	'no_preview' => true,
	'params' => array(
		'form_email' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Reciever Email',
			'desc' => 'Contact requests will be sent to this Email.',
		),
		'form_name_field' => array(
			'type' => 'select',
			'label' => 'Name Field State',
			'desc' => '',
			'options' => array(
				'required' => 'Shown, required',
				'show' => 'Shown, not required',
				'hide' => 'Hidden',
			)
		),
		'form_email_field' => array(
			'type' => 'select',
			'label' => 'Email Field State',
			'desc' => '',
			'options' => array(
				'required' => 'Shown, required',
				'show' => 'Shown, not required',
				'hide' => 'Hidden',
			)
		),
		'form_phone_field' => array(
			'type' => 'select',
			'label' => 'Phone Field State',
			'desc' => '',
			'options' => array(
				'required' => 'Shown, required',
				'show' => 'Shown, not required',
				'hide' => 'Hidden',
			)
		),
		'form_captcha' => array(
			'type' => 'select',
			'label' => 'Captcha',
			'desc' => '',
			'options' => array(
				'' => 'Don\'t Display Captcha',
				'show' => 'Display Captcha',
			)
		),
		'button_type' => array(
			'type' => 'select',
			'label' => 'Button Color',
			'desc' => '',
			'options' => array(
				'primary' => 'Primary (theme color)',
				'secondary' => 'Secondary (theme color)',
				'contrast' => 'Contrast (theme color)',
				'default' => 'Faded (theme color)',
				'white' => 'White',
				'pink' => 'Pink',
				'blue' => 'Blue',
				'green' => 'Green',
				'yellow' => 'Yellow',
				'purple' => 'Purple',
				'red' => 'Red',
				'lime' => 'Lime',
				'navy' => 'Navy',
				'cream' => 'Cream',
				'brown' => 'Brown',
				'midnight' => 'Midnight',
				'teal' => 'Teal',
				'transparent' => 'Transparent',
			)
		),
		'button_outlined' => array(
			'std' => '0',
			'type' => 'checkbox',
			'label' => 'Outlined Button',
			'checkbox_text' => 'Apply Outlined Style to the Button',
			'desc' => '',
		),

	),
	'shortcode' => '[vc_contact_form form_email="{{form_email}}" form_name_field="{{form_name_field}}" form_email_field="{{form_email_field}}" form_phone_field="{{form_phone_field}}" button_type="{{button_type}}" button_outlined="{{button_outlined}}"]',
	'popup_title' => 'Insert Contact Form shortcode'
);


/*-----------------------------------------------------------------------------------*/
/*	Social Links Config
/*-----------------------------------------------------------------------------------*/

$us_zilla_shortcodes['social_links'] = array(
	'no_preview' => true,
	'params' => array(
		'size' => array(
			'type' => 'select',
			'label' => 'Icons Size',
			'desc' => '',
			'options' => array(
				'normal' => 'Normal',
				'' => 'Small',
				'big' => 'Big',
			)
		),
		'email' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Email',
			'desc' => '',
		),
		'facebook' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Facebook',
			'desc' => '',
		),
		'twitter' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Twitter',
			'desc' => '',
		),
		'google' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Google+',
			'desc' => '',
		),
		'linkedin' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'LinkedIn',
			'desc' => '',
		),
		'youtube' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'YouTube',
			'desc' => '',
		),
		'vimeo' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Vimeo',
			'desc' => '',
		),
		'flickr' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Flickr',
			'desc' => '',
		),
		'instagram' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Instagram',
			'desc' => '',
		),
		'behance' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Behance',
			'desc' => '',
		),
		'xing' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Xing',
			'desc' => '',
		),
		'pinterest' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Pinterest',
			'desc' => '',
		),
		'skype' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Skype',
			'desc' => '',
		),
		'tumblr' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Tumblr',
			'desc' => '',
		),
		'dribbble' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Dribbble',
			'desc' => '',
		),
		'vk' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Vkontakte',
			'desc' => '',
		),
		'rss' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'RSS',
			'desc' => '',
		),

	),
	'shortcode' => '[vc_social_links size="{{size}}" email="{{email}}" facebook="{{facebook}}" twitter="{{twitter}}" google="{{google}}" linkedin="{{linkedin}}" youtube="{{youtube}}" flickr="{{flickr}}" instagram="{{instagram}}" behance="{{behance}}" xing="{{xing}}" pinterest="{{pinterest}}" skype="{{skype}}" tumblr="{{tumblr}}" dribbble="{{dribbble}}" vk="{{vk}}" rss="{{rss}}"]',
	'popup_title' => 'Insert Social Links shortcode'
);

/*-----------------------------------------------------------------------------------*/
/*	Contacts Config
/*-----------------------------------------------------------------------------------*/

$us_zilla_shortcodes['contacts'] = array(
	'no_preview' => true,
	'params' => array(
		'address' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Address',
			'desc' => '',
		),
		'phone' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Phone number',
			'desc' => '',
		),
		'email' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Email',
			'desc' => '',
		),
	),
	'shortcode' => '[vc_contacts address="{{address}}" phone="{{phone}}" email="{{email}}"]',
	'popup_title' => 'Insert Contacts shortcode'
);

/*-----------------------------------------------------------------------------------*/
/*	Team Member
/*-----------------------------------------------------------------------------------*/

$us_zilla_shortcodes['member'] = array(
	'params' => array(
		'name' => array(
			'std' => 'John Doe',
			'type' => 'text',
			'label' => 'Team Member Name',
			'desc' => '',
		),
		'role' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Team Member Role',
			'desc' => 'E.g. CEO, Manager, etc',
		),
		'img' => array(
			'std' => '',
			'type' => 'image',
			'label' => 'Photo',
			'desc' => 'Path to member\'s photo',
		),
		'description' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => 'Team Member Description (optional)',
			'desc' => '',
		),
		'link' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Link (optional)',
			'desc' => '',
		),
		'email' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Email (optional)',
			'desc' => '',
		),
		'facebook' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Facebook profile (optional)',
			'desc' => '',
		),
		'twitter' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Twitter profile (optional)',
			'desc' => '',
		),
		'google_plus' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Google+ profile (optional)',
			'desc' => '',
		),
		'linkedin' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'LinkedIn profile (optional)',
			'desc' => '',
		),
	),
	'no_preview' => true,
	'shortcode' => '[vc_member name="{{name}}" role="{{role}}" img="{{img}}" facebook="{{facebook}}" twitter="{{twitter}}" linkedin="{{linkedin}}" email="{{email}}" link="{{link}}"] {{description}} [/vc_member]',
	'popup_title' => 'Insert Team Member shortcode',
);
/*-----------------------------------------------------------------------------------*/
/*	Separator Config
/*-----------------------------------------------------------------------------------*/

$us_zilla_shortcodes['separator'] = array(
	'no_preview' => true,
	'params' => array(
		'type' => array(
			'type' => 'select',
			'label' => 'Separator Type',
			'desc' => '',
			'options' => array(
				'' => 'Full Width',
				'short' => 'Short',
				'invisible' => 'Invisible',
			)
		),
		'size' => array(
			'type' => 'select',
			'label' => 'Separator Size',
			'desc' => '',
			'options' => array(
				'' => 'Medium',
				'small' => 'Small',
				'big' => 'Big',
				'huge' => 'Huge',
			)
		),
		'icon' => array(
			'std' => 'star',
			'type' => 'text',
			'label' => 'Icon',
			'desc' => 'FontAwesome Icon name. <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">Full list of icons</a>',
		),
	),
	'shortcode' => '[vc_separator type="{{type}}" size="{{size}}" icon="{{icon}}"]',
	'popup_title' => 'Insert Separator shortcode'
);
/*-----------------------------------------------------------------------------------*/
/*	Icon Config
/*-----------------------------------------------------------------------------------*/

$us_zilla_shortcodes['icon'] = array(
	'no_preview' => true,
	'params' => array(
		'icon' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Icon',
			'desc' => 'FontAwesome icon name',
		),
	),
	'shortcode' => '[icon icon="{{icon}}"]',
	'popup_title' => 'Insert Icon shortcode'
);
/*-----------------------------------------------------------------------------------*/
/*	IconBox Config
/*-----------------------------------------------------------------------------------*/

$us_zilla_shortcodes['iconbox'] = array(
	'no_preview' => true,
	'params' => array(
		'icon' => array(
			'std' => 'star',
			'type' => 'text',
			'label' => 'Icon',
			'desc' => 'FontAwesome Icon name. <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">Full list of icons</a>',
		),
		'iconpos' => array(
			'type' => 'select',
			'label' => 'Icon Position',
			'desc' => '',
			'options' => array(
				'top' => 'Top',
				'left' => 'Left',
			)
		),
		'with_circle' => array(
			'std' => false,
			'type' => 'checkbox',
			'label' => 'With Circle',
			'checkbox_text' => 'Place Icon into Circle',
			'desc' => '',
		),
		'title' => array(
			'std' => 'Title',
			'type' => 'text',
			'label' => 'Title',
			'desc' => '',
		),
		'content' => array(
			'std' => 'Any text goes here',
			'type' => 'textarea',
			'label' => 'IconBox Text',
			'desc' => '',
		),
		'link' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Link (optional)',
			'desc' => '',
		),
		'external' => array(
			'std' => false,
			'type' => 'checkbox',
			'label' => 'External Link',
			'checkbox_text' => 'Opens in new tab',
			'desc' => '',
		),
		'img' => array(
			'std' => '',
			'type' => 'image',
			'label' => 'Image (optional)',
			'desc' => 'Path to 32x32 px image. Image overrides icon setting.',
		),
	),
	'shortcode' => '[vc_iconbox iconpos="{{iconpos}}" icon="{{icon}}" with_circle="{{with_circle}}" title="{{title}}" link="{{link}}" external="{{external}}" img="{{img}}"] {{content}} [/vc_iconbox]',
	'popup_title' => 'Insert IconBox shortcode'
);
/*-----------------------------------------------------------------------------------*/
/*	Testimonial Config
/*-----------------------------------------------------------------------------------*/

$us_zilla_shortcodes['testimonial'] = array(
	'no_preview' => true,
	'params' => array(
		'author' => array(
			'std' => 'Name',
			'type' => 'text',
			'label' => 'Name',
			'desc' => 'Enter the Name of the Person to quote',
		),
		'company' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Subtitle',
			'desc' => 'Can be used for a job description',
		),
		'content' => array(
			'std' => 'Text goes here',
			'type' => 'textarea',
			'label' => 'Quote',
			'desc' => '',
		),
	),
	'shortcode' => '[vc_testimonial author="{{author}}" company="{{company}}"] {{content}} [/vc_testimonial]',
	'popup_title' => 'Insert Testimonial shortcode'
);

/*-----------------------------------------------------------------------------------*/
/*	Timeline Config
/*-----------------------------------------------------------------------------------*/

$us_zilla_shortcodes['timeline'] = array(
	'params' => array(),
	'no_preview' => true,
	'shortcode' => '[timeline] {{child_shortcode}} [/timeline]',
	'popup_title' => 'Insert Timeline shortcode',

	'child_shortcode' => array(
		'params' => array(
			'title' => array(
				'std' => '',
				'type' => 'text',
				'label' => 'Timepoint Title',
				'desc' => 'Displayed above timeline point',
			),
			'text' => array(
				'std' => '',
				'type' => 'textarea',
				'label' => 'Timepoint text',
				'desc' => '',
			),
		),
		'shortcode' => '<br>[timepoint title="{{title}}"] {{text}} [/timepoint]',
		'clone_button' => 'Add Timepoint'
	)
);
/*-----------------------------------------------------------------------------------*/
/*	Latest Posts Config
/*-----------------------------------------------------------------------------------*/

$us_zilla_shortcodes['latest_posts'] = array(
	'no_preview' => true,
	'params' => array(
		'posts' => array(
			'type' => 'select',
			'label' => 'Posts',
			'desc' => '',
			'options' => array(
				'1' => '1',
				'2' => '2',
				'3' => '3',
			)
		),
		'category' => array(
			'type' => 'select',
			'label' => 'Category',
			'desc' => '',
			'options' => $post_categories,
		),
	),
	'shortcode' => '[vc_latest_posts posts="{{posts}}" category="{{category}}"]',
	'popup_title' => 'Insert Latest Posts shortcode'
);
/*-----------------------------------------------------------------------------------*/
/*	Portfolio Config
/*-----------------------------------------------------------------------------------*/

$us_zilla_shortcodes['portfolio'] = array(
	'no_preview' => true,
	'params' => array(
		'columns' => array(
			'type' => 'select',
			'label' => 'Columns',
			'desc' => '',
			'options' => array(
				'5' => '5',
				'4' => '4',
				'3' => '3',
				'2' => '2',
			)
		),
		'items' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Items Quantity',
			'desc' => 'If left blank, equals amount of Columns',
		),
		'pagination' => array(
			'std' => '0',
			'type' => 'checkbox',
			'label' => 'Pagination',
			'checkbox_text' => 'Turn on pagination',
			'desc' => 'If checked, Items Quantity parameter sets amount of Items per page',
		),
		'ratio' => array(
			'type' => 'select',
			'label' => 'Item Ratio',
			'desc' => '',
			'options' => array(
				'3:2' => '3:2',
				'4:3' => '4:3',
				'1:1' => '1:1 (square)',
				'2:3' => '2:3',
				'3:4' => '3:4',
			)
		),
		'no_indents' => array(
			'std' => '0',
			'type' => 'checkbox',
			'label' => 'Remove indents between Items',
			'checkbox_text' => '',
			'desc' => '',
		),
		'filters' => array(
			'std' => '0',
			'type' => 'checkbox',
			'label' => 'Filtering',
			'checkbox_text' => 'Display bar with filtering by category',
			'desc' => '',
		),
		'category' => array(
			'type' => 'select',
			'label' => 'Category',
			'desc' => 'Displays items of selected category only',
			'options' => $portfolio_categories,
		),
	),
	'shortcode' => '[vc_portfolio columns="{{columns}}" items="{{items}}" pagination="{{pagination}}" ratio="{{ratio}}" no_indents="{{no_indents}}" filters="{{filters}}" category="{{category}}"]',
	'popup_title' => 'Insert Portfolio shortcode'
);
/*-----------------------------------------------------------------------------------*/
/*	Slider Revolution Config
/*-----------------------------------------------------------------------------------*/
$slider_revolution = array();

if(class_exists('RevSlider')){
	$slider = new RevSlider();
	$arrSliders = $slider->getArrSliders();
	foreach($arrSliders as $revSlider) {
		$slider_revolution[$revSlider->getAlias()] = $revSlider->getTitle();
	}
}
if (count ($slider_revolution) > 0) {
	$us_zilla_shortcodes['rev_slider'] = array(
		'no_preview' => true,
		'params' => array(
			'alias' => array(
				'type' => 'select',
				'label' => 'Revolution Slider',
				'desc' => '',
				'options' => $slider_revolution,
			),
		),
		'shortcode' => '[rev_slider_vc alias="{{alias}}"]',
		'popup_title' => 'Insert Revolution Slider shortcode'
	);
}

/*-----------------------------------------------------------------------------------*/
/*	ActionBox Config
/*-----------------------------------------------------------------------------------*/

$us_zilla_shortcodes['actionbox'] = array(
	'no_preview' => true,
	'params' => array(
		'type' => array(
			'type' => 'select',
			'label' => 'ActionBox Color',
			'desc' => '',
			'options' => array(
				'primary' => 'Primary Color',
				'secondary' => 'Secondary Color',
				'alternate' => 'Alternate Color',
			)
		),
		'title' => array(
			'std' => 'This is ActionBox',
			'type' => 'text',
			'label' => 'ActionBox Title',
			'desc' =>  '',
		),
		'message' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => 'ActionBox Text',
			'desc' =>  '',
		),
		'button1' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Button 1 Label',
			'desc' => '',
		),
		'link1' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Button 1 Link',
			'desc' => '',
		),
		'style1' => array(
			'type' => 'select',
			'label' => 'Button 1 Color',
			'desc' => '',
			'options' => array(
				'primary' => 'Primary (theme color)',
				'secondary' => 'Secondary (theme color)',
				'contrast' => 'Contrast (theme color)',
				'default' => 'Faded (theme color)',
				'white' => 'White',
				'pink' => 'Pink',
				'blue' => 'Blue',
				'green' => 'Green',
				'yellow' => 'Yellow',
				'purple' => 'Purple',
				'red' => 'Red',
				'lime' => 'Lime',
				'navy' => 'Navy',
				'cream' => 'Cream',
				'brown' => 'Brown',
				'midnight' => 'Midnight',
				'teal' => 'Teal',
				'transparent' => 'Transparent',
			)
		),
		'outlined1' => array(
			'std' => '0',
			'type' => 'checkbox',
			'label' => 'Outlined',
			'checkbox_text' => 'Apply Outlined Style to the Button',
			'desc' => '',
		),
		'size1' => array(
			'type' => 'select',
			'label' => 'Button 1 Size',
			'desc' => '',
			'options' => array(
				'' => 'Normal',
				'small' => 'Small',
				'big' => 'Big'
			)
		),
		'icon1' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Button 1 Icon (optional)',
			'desc' => 'FontAwesome Icon name. <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">Full list of icons</a>',
		),
		'button2' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Button 2 Label',
			'desc' => '',
		),
		'link2' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Button 2 Link',
			'desc' => '',
		),
		'style2' => array(
			'type' => 'select',
			'label' => 'Button 2 Color',
			'desc' => '',
			'options' => array(
				'primary' => 'Primary (theme color)',
				'secondary' => 'Secondary (theme color)',
				'contrast' => 'Contrast (theme color)',
				'default' => 'Faded (theme color)',
				'white' => 'White',
				'pink' => 'Pink',
				'blue' => 'Blue',
				'green' => 'Green',
				'yellow' => 'Yellow',
				'purple' => 'Purple',
				'red' => 'Red',
				'lime' => 'Lime',
				'navy' => 'Navy',
				'cream' => 'Cream',
				'brown' => 'Brown',
				'midnight' => 'Midnight',
				'teal' => 'Teal',
				'transparent' => 'Transparent',
			)
		),
		'outlined2' => array(
			'std' => '0',
			'type' => 'checkbox',
			'label' => 'Outlined',
			'checkbox_text' => 'Apply Outlined Style to the Button',
			'desc' => '',
		),
		'size2' => array(
			'type' => 'select',
			'label' => 'Button 2 Size',
			'desc' => '',
			'options' => array(
				'' => 'Normal',
				'small' => 'Small',
				'big' => 'Big'
			)
		),
		'icon2' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Button 2 Icon (optional)',
			'desc' => 'FontAwesome Icon name. <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">Full list of icons</a>',
		),
	),
	'shortcode' => '[vc_actionbox type="{{type}}" title="{{title}}" message="{{message}}" button1="{{button1}}" link1="{{link1}}" style1="{{style1}}" size1="{{size1}}" icon1="{{icon1}}" button2="{{button2}}" link2="{{link2}}" style2="{{style2}}" size2="{{size2}}" icon2="{{icon2}}"]',
	'popup_title' => 'Insert ActionBox shortcode'
);

/*-----------------------------------------------------------------------------------*/
/*	Google Maps Config
/*-----------------------------------------------------------------------------------*/

$us_zilla_shortcodes['gmaps'] = array(
	'no_preview' => true,
	'params' => array(
		'address' => array(
			'std' => '1600 Amphitheatre Parkway, Mountain View, CA 94043, United States',
			'type' => 'text',
			'label' => 'Map Address',
			'desc' =>  '',
		),
		'marker' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Map Marker text',
			'desc' =>  'Leave blank to hide the Marker.',
		),
		'height' => array(
			'std' => '400',
			'type' => 'text',
			'label' => 'Map height',
			'desc' =>  'Enter map height in pixels. Default: 400.',
		),
		'type' => array(
			'type' => 'select',
			'label' => 'Map type',
			'desc' => '',
			'options' => array(
				'ROADMAP' => 'Roadmap',
				'SATELLITE' => 'Satellite',
				'HYBRID' => 'Map + Terrain',
				'TERRAIN' => 'Terrain',
			)
		),
		'zoom' => array(
			'type' => 'select',
			'label' => 'Map zoom',
			'desc' => '',
			'options' => array(
				'14' => '14 - Default',
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
				'6' => '6',
				'7' => '7',
				'8' => '8',
				'9' => '9',
				'10' => '10',
				'11' => '11',
				'12' => '12',
				'13' => '13',
				'15' => '15',
				'16' => '16',
				'17' => '17',
				'18' => '18',
				'19' => '19',
				'20' => '20',
			)
		),
		'latitude' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Map Latitude',
			'desc' =>  'If Longitude and Latitude are set, they override the Address for Google Map.',
		),
		'longitude' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Map Longitude',
			'desc' =>  'If Longitude and Latitude are set, they override the Address for Google Map.',
		),
	),
	'shortcode' => '[vc_gmaps address="{{address}}" latitude="{{latitude}}" longitude="{{longitude}}" marker="{{marker}}" height="{{height}}" type="{{type}}" zoom="{{zoom}}"]',
	'popup_title' => 'Insert Google Maps shortcode'
);

/*-----------------------------------------------------------------------------------*/
/*	Icon Config
/*-----------------------------------------------------------------------------------*/

$us_zilla_shortcodes['icon'] = array(
	'no_preview' => true,
	'params' => array(
		'icon' => array(
			'std' => 'star',
			'type' => 'text',
			'label' => 'Icon',
			'desc' => 'FontAwesome Icon name. <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">Full list of icons</a>',
		),
		'color' => array(
			'type' => 'select',
			'label' => 'Color Style',
			'desc' => '',
			'options' => array(
				'text' => 'Text Color',
				'primary' => 'Primary Theme Color',
				'secondary' => 'Secondary Theme Color',
				'fade' => 'Fade Theme Color',
				'border' => 'Border Theme Color',
			)
		),
		'size' => array(
			'type' => 'select',
			'label' => 'Size',
			'desc' => '',
			'options' => array(
				'tiny' => 'Tiny',
				'small' => 'Small',
				'medium' => 'Medium',
				'big' => 'Big',
				'huge' => 'Huge',
			)
		),
		'with_circle' => array(
			'std' => false,
			'type' => 'checkbox',
			'label' => 'With Circle',
			'checkbox_text' => 'Place Icon into Circle',
			'desc' => '',
		),
		'link' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Link (optional)',
			'desc' => '',
		),
		'external' => array(
			'std' => false,
			'type' => 'checkbox',
			'label' => 'External Link',
			'checkbox_text' => 'Opens in new tab',
			'desc' => '',
		),
	),
	'shortcode' => '[vc_icon icon="{{icon}}" color="{{color}}" size="{{size}}" with_circle="{{with_circle}}" link="{{link}}" external="{{external}}"]',
	'popup_title' => 'Insert Icon shortcode'
);


/*-----------------------------------------------------------------------------------*/
/*	Counter Config
/*-----------------------------------------------------------------------------------*/

$us_zilla_shortcodes['counter'] = array(
	'no_preview' => true,
	'params' => array(
		'count' => array(
			'std' => '99',
			'type' => 'text',
			'label' => 'Number for Counter',
			'desc' => '',
		),
		'color' => array(
			'type' => 'select',
			'label' => 'Number Color',
			'desc' => '',
			'options' => array(
				'' => 'Default (theme color)',
				'primary' => 'Primary (theme color)',
				'secondary' => 'Secondary (theme color)',
			)
		),
		'title' => array(
			'std' => 'Projects completed',
			'type' => 'text',
			'label' => 'Title for Counter',
			'desc' => '',
		),
		'prefix' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Prefix (optional)',
			'desc' => 'Text before number',
		),
		'suffix' => array(
			'std' => '',
			'type' => 'text',
			'label' => 'Suffix (optional)',
			'desc' => 'Text after number',
		),
	),
	'shortcode' => '[vc_counter count="{{count}}" prefix="{{prefix}}" suffix="{{suffix}}" color="{{color}}" title="{{title}}"]',
	'popup_title' => 'Insert Counter shortcode'
);

/*-----------------------------------------------------------------------------------*/
/*	Clients Config
/*-----------------------------------------------------------------------------------*/

$us_zilla_shortcodes['clients'] = array(
	'no_preview' => true,
	'params' => array(
		'auto_scroll' => array(
			'std' => '0',
			'type' => 'checkbox',
			'label' => 'Auto Scroll',
			'checkbox_text' => 'Auto Scroll Clients Carousel',
			'desc' => '',
		),
		'interval' => array(
			'std' => '1',
			'type' => 'text',
			'label' => 'Auto Scroll Interval',
			'desc' => 'Interval in seconds between Scroll when Auto Scroll is enabled',
		),

	),
	'shortcode' => '[vc_clients auto_scroll="{{auto_scroll}}" interval="{{interval}}"]',
	'popup_title' => 'Insert Clients shortcode'
);
