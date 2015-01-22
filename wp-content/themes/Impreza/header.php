<?php global $smof_data; ?><!DOCTYPE HTML>
<?php
$no_responsive_class = ( ! isset($smof_data['responsive_layout']) OR $smof_data['responsive_layout'] == 1) ? '':'no-responsive';
?>
<html class="<?php echo $no_responsive_class;?>" <?php language_attributes('html')?>>
<head>
	<meta charset="UTF-8">
	<title><?php if (defined('WPSEO_VERSION')) { wp_title(); } else { bloginfo('name'); wp_title(' - ', true, 'left'); } ?></title>

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />

	<?php if(@$smof_data['custom_favicon'] != "") { ?><link rel="shortcut icon" href="<?php echo @$smof_data['custom_favicon']; ?>"><?php } ?>

	<?php wp_head(); ?>
	<?php
	global $load_styles_directly;
	if (isset($load_styles_directly) AND $load_styles_directly)
	{
		get_template_part('templates/custom_css');
	}
	?>

</head><?php
$body_background_styles_text = '';

$body_background_image = (@$smof_data['body_background_image'] != '')?@$smof_data['body_background_image']:'';

if ($body_background_image != '')
{
	$body_background_styles = array( 'background-image' => 'url('.$body_background_image.')');

	$body_background_image_stretch = (@$smof_data['body_background_image_stretch'] == 1)?TRUE:FALSE;
	if ($body_background_image_stretch) {
		$body_background_styles['background-size'] = 'cover';
	}

	if (@$smof_data['body_background_image_repeat'] != '') {
		$backgroundRepeatCss = array(
			'Repeat' => 'repeat',
			'Repeat Horizontally' => 'repeat-x',
			'Repeat Vertically' => 'repeat-y',
			'Do Not Repeat' => 'no-repeat',
		);
		$body_background_styles['background-repeat'] = $backgroundRepeatCss[@$smof_data['body_background_image_repeat']];
	}

	if (@$smof_data['body_background_image_position'] != '') {
		$body_background_styles['background-position'] = @$smof_data['body_background_image_position'];
	}

	if (@$smof_data['body_background_image_attachment_fixed'] == 1) {

		$body_background_styles['background-attachment'] = 'fixed';
	}

	foreach ($body_background_styles as $body_background_style => $body_background_style_val)
	{
		$body_background_styles_text .= $body_background_style.': '.$body_background_style_val.';';
	}
}
$woocommerce_class = '';
if (defined('COLUMNS_QTY_CLASS')) {
	$woocommerce_class .= ' '.COLUMNS_QTY_CLASS;
}

$theme = wp_get_theme();
$theme_version = str_replace('.', '-', $theme->get('Version'));
$theme_class = 'us-theme_impreza_'.$theme_version;
?>
<body <?php body_class('l-body '.$theme_class.$woocommerce_class); ?><?php echo  ($body_background_styles_text != '')?' style="'.$body_background_styles_text.'"':''; ?>>
<?php
if (defined('IS_FULLWIDTH') AND IS_FULLWIDTH)
{
	$sidebar_position_class = 'col_cont';
}
elseif (defined('IS_POST') AND IS_POST)
{
	$sidebar_position_class = (@$smof_data['post_sidebar_pos'] == 'Right')?'col_contside':'col_sidecont';
}
elseif (defined('IS_BLOG') AND IS_BLOG)
{
	$sidebar_position_class = (@$smof_data['blog_sidebar_pos'] == 'Right')?'col_contside':'col_sidecont';
}
else
{
	$sidebar_position_class = (defined('SIDEBAR_POS') AND SIDEBAR_POS == 'right')?'col_contside':'col_sidecont';
}

$layout_class = (isset($smof_data['boxed_layout']) AND $smof_data['boxed_layout'] == 1)?'type_boxed':'type_wide';

$extended_header_class = ' headerlayout_standard';
if (isset($smof_data['main_header_layout'])){
	$extended_header_class = ' headerlayout_'.$smof_data['main_header_layout'];
}

$logo_pos_class = '';
if (isset($smof_data['header_invert_logo_pos']) AND $smof_data['header_invert_logo_pos']) {
	$logo_pos_class = ' logopos_right';
}

$header_transparent_class = $header_position_class = '';
if (isset($smof_data['header_is_sticky']) AND $smof_data['header_is_sticky'] == 1){
	$header_position_class = ' headerpos_fixed';
	if (isset($smof_data['header_bg_transparent']) AND $smof_data['header_bg_transparent'] == 1){
		$header_position_class .= ' headerbg_transparent';
		$header_transparent_class = ' transparent';
	}
}else{
	$header_position_class = ' headerpos_static';
}

$menu_hover_animation = 'opacity';
if (isset($smof_data['menu_hover_animation'])){
	if ($smof_data['menu_hover_animation'] == 'FadeIn'){
		$menu_hover_animation = 'opacity';
	}
	elseif ($smof_data['menu_hover_animation'] == 'FadeIn + SlideDown'){
		$menu_hover_animation = 'height';
	}
	elseif ($smof_data['menu_hover_animation'] == 'Material Design Effect'){
		$menu_hover_animation = 'mdesign';
	}
}

if (rwmb_meta('us_header_type') == 'Sticky Transparent') {
	$header_position_class = ' headerpos_fixed headerbg_transparent';
	$header_transparent_class = ' transparent';
} elseif (rwmb_meta('us_header_type') == 'Sticky Solid') {
	$header_position_class = ' headerpos_fixed';
	$header_transparent_class = '';
} elseif (rwmb_meta('us_header_type') == 'Non-sticky') {
	$header_position_class = '';
	$header_transparent_class = '';
}

$lang_class = (defined('ICL_LANGUAGE_CODE') AND ICL_LANGUAGE_CODE != '')?' wpml_lang_'.ICL_LANGUAGE_CODE:'';


?>
<!-- CANVAS -->
<div class="l-canvas <?php echo $layout_class.' '.$sidebar_position_class.$extended_header_class.$header_position_class.$lang_class; ?>">

	<!-- HEADER -->
	<div class="l-header<?php echo $logo_pos_class.$header_transparent_class; ?>">

		<div class="l-subheader at_top"<?php if ( ! empty($smof_data['header_extra_height']) AND $smof_data['header_extra_height'] >= 36 AND $smof_data['header_extra_height'] <= 60) { echo ' style="line-height: '.$smof_data['header_extra_height'].'px; "'; } ?>>
			<div class="l-subheader-h i-cf">
			<?php if (@$smof_data['main_header_layout'] == 'extended') { ?>
			<?php if (@$smof_data['header_show_contacts'] OR @$smof_data['header_show_custom']) { ?>
				<div class="w-contacts">
					<div class="w-contacts-list">
					<?php if (@$smof_data['header_phone'] != '') { ?>
						<div class="w-contacts-item for_phone">
							<i class="fa fa-phone"></i>
							<span class="w-contacts-item-value"><?php echo $smof_data['header_phone']; ?></span>
						</div>
					<?php } ?>
					<?php if (@$smof_data['header_email'] != '') { ?>
						<div class="w-contacts-item for_email">
							<i class="fa fa-envelope"></i>
							<span class="w-contacts-item-value"><a href="mailto:<?php echo $smof_data['header_email']; ?>"><?php echo $smof_data['header_email']; ?></a></span>
						</div>
					<?php } ?>
					<?php if (@$smof_data['header_show_custom'] AND @$smof_data['header_custom_icon'] != '' AND @$smof_data['header_custom_text'] != '') { ?>
						<div class="w-contacts-item for_custom">
							<i class="fa fa-<?php echo $smof_data['header_custom_icon']; ?>"></i>
							<span class="w-contacts-item-value"><?php echo $smof_data['header_custom_text']; ?></span>
						</div>
					<?php } ?>
					</div>
				</div>
			<?php } ?>
			<?php if ($smof_data['header_show_language']) { get_template_part('templates/lang_switcher'); } ?>

			<?php
			if ($smof_data['header_show_socials']) {
				$socials = array (
					'email' => 'Email',
					'facebook' => 'Facebook',
					'twitter' => 'Twitter',
					'google' => 'Google+',
					'linkedin' => 'LinkedIn',
					'youtube' => 'YouTube',
					'vimeo' => 'Vimeo',
					'flickr' => 'Flickr',
					'instagram' => 'Instagram',
					'behance' => 'Behance',
					'xing' => 'Xing',
					'pinterest' => 'Pinterest',
					'skype' => 'Skype',
					'tumblr' => 'Tumblr',
					'dribbble' => 'Dribbble',
					'vk' => 'Vkontakte',
					'soundcloud' => 'SoundCloud',
					'yelp' => 'Yelp',
					'twitch' => 'Twitch',
					'rss' => 'RSS',
				);

				$output = '';
				foreach ($socials as $social_key => $social)
				{
					if (@$smof_data['header_social_'.$social_key] != '')
					{
						if ($social_key == 'email')
						{
							$output .= '<div class="w-socials-item '.$social_key.'">
										<a class="w-socials-item-link" href="mailto:'.$smof_data['header_social_'.$social_key].'">
											<i class="fa fa-envelope"></i>
										</a>
										<div class="w-socials-item-popup">
											<div class="w-socials-item-popup-h">
												<span class="w-socials-item-popup-text">'.$social.'</span>
											</div>
										</div>
										</div>';

						}
						elseif ($social_key == 'google')
						{
							$output .= '<div class="w-socials-item gplus">
										<a class="w-socials-item-link" target="_blank" href="'.$smof_data['header_social_'.$social_key].'">
											<i class="fa fa-google-plus"></i>
										</a>
										<div class="w-socials-item-popup">
											<div class="w-socials-item-popup-h">
												<span class="w-socials-item-popup-text">'.$social.'</span>
											</div>
										</div>
										</div>';

						}
						elseif ($social_key == 'youtube')
						{
							$output .= '<div class="w-socials-item '.$social_key.'">
										<a class="w-socials-item-link" target="_blank" href="'.$smof_data['header_social_'.$social_key].'">
											<i class="fa fa-youtube-play"></i>
										</a>
										<div class="w-socials-item-popup">
											<div class="w-socials-item-popup-h">
												<span class="w-socials-item-popup-text">'.$social.'</span>
											</div>
										</div>
										</div>';

						}
						elseif ($social_key == 'vimeo')
						{
							$output .= '<div class="w-socials-item '.$social_key.'">
										<a class="w-socials-item-link" target="_blank" href="'.$smof_data['header_social_'.$social_key].'">
											<i class="fa fa-vimeo-square"></i>
										</a>
										<div class="w-socials-item-popup">
											<div class="w-socials-item-popup-h">
												<span class="w-socials-item-popup-text">'.$social.'</span>
											</div>
										</div>
										</div>';

						}
						else
						{
							$output .= '<div class="w-socials-item '.$social_key.'">
										<a class="w-socials-item-link" target="_blank" href="'.$smof_data['header_social_'.$social_key].'">
											<i class="fa fa-'.$social_key.'"></i>
										</a>
										<div class="w-socials-item-popup">
											<div class="w-socials-item-popup-h">
												<span class="w-socials-item-popup-text">'.$social.'</span>
											</div>
										</div>
										</div>';
						}

					}
				}

				if ($output != '') {
					?><div class="w-socials">
					<div class="w-socials-list"><?php
					echo $output;
					?></div>
					</div><?php
				}
			}
			?>

			<?php } ?>
			</div>
		</div>
		<?php
			if (! empty($smof_data['logo_height']) AND (@$smof_data['header_main_height'] < $smof_data['logo_height'])) {
				$smof_data['header_main_height'] = $smof_data['logo_height'];
			}
		?>
		<div class="l-subheader at_middle" <?php if ( ! empty($smof_data['header_main_height']) AND $smof_data['header_main_height'] >= 50 AND $smof_data['header_main_height'] <= 150) {
			$height_part = '';
			if (@$smof_data['main_header_layout'] == 'advanced'OR @$smof_data['main_header_layout'] == 'centered') {
				$height_part = 'height: '.$smof_data['header_main_height'].'px; ';
			}
			echo ' style="'.$height_part.'line-height: '.$smof_data['header_main_height'].'px;"';
		} ?>>
			<div class="l-subheader-h i-widgets i-cf">

				<div class="w-logo <?php if (@$smof_data['logo_as_text'] == 1) { echo ' with_title'; } ?><?php if ( ! empty($smof_data['custom_logo_transparent'])) { echo ' with_transparent'; } ?>">
					<a class="w-logo-link" href="<?php if (function_exists('icl_get_home_url')) echo icl_get_home_url(); else echo esc_url(home_url('/')); ?>">
						<?php if ( ! empty($smof_data['custom_logo']) OR ! empty($smof_data['custom_logo_transparent'])): ?>
						<span class="w-logo-img" style="height: <?php echo (empty($smof_data['logo_height']))?30:$smof_data['logo_height'];?>px;">
							<?php if ( ! empty($smof_data['custom_logo'])): ?>
								<img class="for_default" src="<?php echo $smof_data['custom_logo']; ?>" alt="<?php bloginfo('name'); ?>" style="margin-bottom: -<?php echo (empty($smof_data['logo_height']))?30:$smof_data['logo_height'];?>px;">
							<?php endif; ?>
							<?php if ( ! empty($smof_data['custom_logo_transparent'])): ?>
								<img class="for_transparent" src="<?php echo $smof_data['custom_logo_transparent']; ?>" alt="<?php bloginfo('name'); ?>">
							<?php endif; ?>
						</span>
						<?php endif; ?>
						<span class="w-logo-title"><?php if (@$smof_data['logo_text'] != ''){ echo @$smof_data['logo_text']; } else { bloginfo('name'); } ?></span>
					</a>
				</div>

				<?php if (@$smof_data['main_header_layout'] == 'advanced') { ?>
					<?php
					if ($smof_data['header_show_socials']) {
						$socials = array (
							'email' => 'Email',
							'facebook' => 'Facebook',
							'twitter' => 'Twitter',
							'google' => 'Google+',
							'linkedin' => 'LinkedIn',
							'youtube' => 'YouTube',
							'vimeo' => 'Vimeo',
							'flickr' => 'Flickr',
							'instagram' => 'Instagram',
							'behance' => 'Behance',
							'xing' => 'Xing',
							'pinterest' => 'Pinterest',
							'skype' => 'Skype',
							'tumblr' => 'Tumblr',
							'dribbble' => 'Dribbble',
							'vk' => 'Vkontakte',
							'soundcloud' => 'SoundCloud',
							'yelp' => 'Yelp',
							'twitch' => 'Twitch',
							'rss' => 'RSS',
						);

						$output = '';
						foreach ($socials as $social_key => $social)
						{
							if (@$smof_data['header_social_'.$social_key] != '')
							{
								if ($social_key == 'email')
								{
									$output .= '<div class="w-socials-item '.$social_key.'">
										<a class="w-socials-item-link" href="mailto:'.$smof_data['header_social_'.$social_key].'">
											<i class="fa fa-envelope"></i>
										</a>
										<div class="w-socials-item-popup">
											<div class="w-socials-item-popup-h">
												<span class="w-socials-item-popup-text">'.$social.'</span>
											</div>
										</div>
										</div>';

								}
								elseif ($social_key == 'google')
								{
									$output .= '<div class="w-socials-item gplus">
										<a class="w-socials-item-link" target="_blank" href="'.$smof_data['header_social_'.$social_key].'">
											<i class="fa fa-google-plus"></i>
										</a>
										<div class="w-socials-item-popup">
											<div class="w-socials-item-popup-h">
												<span class="w-socials-item-popup-text">'.$social.'</span>
											</div>
										</div>
										</div>';

								}
								elseif ($social_key == 'youtube')
								{
									$output .= '<div class="w-socials-item '.$social_key.'">
										<a class="w-socials-item-link" target="_blank" href="'.$smof_data['header_social_'.$social_key].'">
											<i class="fa fa-youtube-play"></i>
										</a>
										<div class="w-socials-item-popup">
											<div class="w-socials-item-popup-h">
												<span class="w-socials-item-popup-text">'.$social.'</span>
											</div>
										</div>
										</div>';

								}
								elseif ($social_key == 'vimeo')
								{
									$output .= '<div class="w-socials-item '.$social_key.'">
										<a class="w-socials-item-link" target="_blank" href="'.$smof_data['header_social_'.$social_key].'">
											<i class="fa fa-vimeo-square"></i>
										</a>
										<div class="w-socials-item-popup">
											<div class="w-socials-item-popup-h">
												<span class="w-socials-item-popup-text">'.$social.'</span>
											</div>
										</div>
										</div>';

								}
								else
								{
									$output .= '<div class="w-socials-item '.$social_key.'">
										<a class="w-socials-item-link" target="_blank" href="'.$smof_data['header_social_'.$social_key].'">
											<i class="fa fa-'.$social_key.'"></i>
										</a>
										<div class="w-socials-item-popup">
											<div class="w-socials-item-popup-h">
												<span class="w-socials-item-popup-text">'.$social.'</span>
											</div>
										</div>
										</div>';
								}

							}
						}

						if ($output != '') {
							?><div class="w-socials">
							<div class="w-socials-list"><?php
								echo $output;
								?></div>
							</div><?php
						}
					}
					?>

					<?php if (@$smof_data['header_show_contacts'] OR @$smof_data['header_show_custom']) { ?>
						<div class="w-contacts">
							<div class="w-contacts-list">
								<?php if (@$smof_data['header_phone'] != '') { ?>
									<div class="w-contacts-item for_phone">
										<i class="fa fa-phone"></i>
										<span class="w-contacts-item-value"><?php echo $smof_data['header_phone']; ?></span>
									</div>
								<?php } ?>
								<?php if (@$smof_data['header_email'] != '') { ?>
									<div class="w-contacts-item for_email">
										<i class="fa fa-envelope"></i>
										<span class="w-contacts-item-value"><a href="mailto:<?php echo $smof_data['header_email']; ?>"><?php echo $smof_data['header_email']; ?></a></span>
									</div>
								<?php } ?>
								<?php if (@$smof_data['header_show_custom'] AND @$smof_data['header_custom_icon'] != '' AND @$smof_data['header_custom_text'] != '') { ?>
									<div class="w-contacts-item for_custom">
										<i class="fa fa-<?php echo $smof_data['header_custom_icon']; ?>"></i>
										<span class="w-contacts-item-value"><?php echo $smof_data['header_custom_text']; ?></span>
									</div>
								<?php } ?>
							</div>
						</div>
					<?php } ?>
					<?php if ($smof_data['header_show_language']) { get_template_part('templates/lang_switcher'); } ?>

				<?php } elseif (@$smof_data['main_header_layout'] != 'centered') { ?>

				<?php if ( ! @$smof_data['header_invert_logo_pos']) get_template_part('templates/cart_dropdown'); ?>

				<?php if (@$smof_data['header_show_search'] AND ( ! @$smof_data['header_invert_logo_pos'])) { ?>
				<div class="w-search">
					<span class="w-search-show"><i class="fa fa-search"></i></span>
					<form class="w-search-form show_hidden" action="<?php echo home_url( '/' ); ?>">
						<div class="w-search-form-h">
							<div class="w-search-form-row">
								<?php if (@ICL_LANGUAGE_CODE != '' AND @ICL_LANGUAGE_CODE != 'ICL_LANGUAGE_CODE') { ?><input type="hidden" name="lang" value="<?php echo(ICL_LANGUAGE_CODE); ?>"><?php } ?>
								<div class="w-search-label">
									<label for="s"><?php echo __("Just type and press 'enter'", 'us' ); ?></label>
								</div>
								<div class="w-search-input">
									<input type="text" value="" id="s" name="s"/>
								</div>
								<div class="w-search-submit">
									<input type="submit" id="searchsubmit"  value="<?php echo __('Search', 'us' ); ?>" />
								</div>
								<div class="w-search-close"> &#10005; </div>
							</div>
						</div>
					</form>
				</div>
				<?php } ?>

				<!-- NAV -->
				<nav class="w-nav layout_hor animation_<?php echo $menu_hover_animation; ?>">
					<div class="w-nav-control">
						<i class="fa fa-bars"></i>
					</div>
					<ul class="w-nav-list level_1">
						<?php wp_nav_menu(
							array(
								'theme_location' => 'impeza_main_menu',
								'container'       => 'ul',
								'container_class' => 'w-nav-list',
								'walker' => new Walker_Nav_Menu_us(),
								'items_wrap' => '%3$s',
								'fallback_cb' => false,

							)
						); ?>
					</ul>
				</nav><!-- /NAV -->

				<?php if (@$smof_data['header_show_search'] AND @$smof_data['header_invert_logo_pos']) { ?>
					<div class="w-search">
						<span class="w-search-show"><i class="fa fa-search"></i></span>
						<form class="w-search-form show_hidden" action="<?php echo home_url( '/' ); ?>">
							<div class="w-search-form-h">
								<div class="w-search-form-row">
									<?php if (@ICL_LANGUAGE_CODE != '' AND @ICL_LANGUAGE_CODE != 'ICL_LANGUAGE_CODE') { ?><input type="hidden" name="lang" value="<?php echo(ICL_LANGUAGE_CODE); ?>"><?php } ?>
									<div class="w-search-label">
										<label for="s"><?php echo __("Just type and press 'enter'", 'us' ); ?></label>
									</div>
									<div class="w-search-input">
										<input type="text" value="" id="s" name="s"/>
									</div>
									<div class="w-search-submit">
										<input type="submit" id="searchsubmit"  value="<?php echo __('Search', 'us' ); ?>" />
									</div>
									<div class="w-search-close"> &#10005; </div>
								</div>
							</div>
						</form>
					</div>
				<?php } ?>

				<?php if (@$smof_data['header_invert_logo_pos']) get_template_part('templates/cart_dropdown'); ?>

				<?php } ?>
			</div>
		</div>
		<?php if (@$smof_data['main_header_layout'] == 'advanced' OR @$smof_data['main_header_layout'] == 'centered') { ?>
		<div class="l-subheader at_bottom"<?php if ( ! empty($smof_data['header_extra_height']) AND $smof_data['header_extra_height'] >= 36 AND $smof_data['header_extra_height'] <= 60) { echo ' style="line-height: '.$smof_data['header_extra_height'].'px; "'; } ?>>
			<div class="l-subheader-h i-cf">
				<?php if (@$smof_data['main_header_layout'] == 'advanced') { get_template_part('templates/cart_dropdown'); } ?>

				<?php if (@$smof_data['header_show_search'] AND (@$smof_data['main_header_layout'] == 'advanced')) { ?>
					<div class="w-search">
						<span class="w-search-show"><i class="fa fa-search"></i></span>
						<form class="w-search-form show_hidden" action="<?php echo home_url( '/' ); ?>">
							<div class="w-search-form-h">
								<div class="w-search-form-row">
									<?php if (@ICL_LANGUAGE_CODE != '' AND @ICL_LANGUAGE_CODE != 'ICL_LANGUAGE_CODE') { ?><input type="hidden" name="lang" value="<?php echo(ICL_LANGUAGE_CODE); ?>"><?php } ?>
									<div class="w-search-label">
										<label for="s"><?php echo __("Just type and press 'enter'", 'us' ); ?></label>
									</div>
									<div class="w-search-input">
										<input type="text" value="" id="s" name="s"/>
									</div>
									<div class="w-search-submit">
										<input type="submit" id="searchsubmit"  value="<?php echo __('Search', 'us' ); ?>" />
									</div>
									<div class="w-search-close"> &#10005; </div>
								</div>
							</div>
						</form>
					</div>
				<?php } ?>

				<!-- NAV -->
				<nav class="w-nav layout_hor animation_<?php echo $menu_hover_animation; ?>">
					<div class="w-nav-control">
						<i class="fa fa-bars"></i>
					</div>
					<ul class="w-nav-list level_1">
						<?php wp_nav_menu(
							array(
								'theme_location' => 'impeza_main_menu',
								'container'       => 'ul',
								'container_class' => 'w-nav-list',
								'walker' => new Walker_Nav_Menu_us(),
								'items_wrap' => '%3$s',
								'fallback_cb' => false,

							));
						?>
					</ul>
				</nav><!-- /NAV -->

				<?php if (@$smof_data['header_show_search'] AND (@$smof_data['main_header_layout'] == 'centered')) { ?>
					<div class="w-search">
						<span class="w-search-show"><i class="fa fa-search"></i></span>
						<form class="w-search-form show_hidden" action="<?php echo home_url( '/' ); ?>">
							<div class="w-search-form-h">
								<div class="w-search-form-row">
									<?php if (@ICL_LANGUAGE_CODE != '' AND @ICL_LANGUAGE_CODE != 'ICL_LANGUAGE_CODE') { ?><input type="hidden" name="lang" value="<?php echo(ICL_LANGUAGE_CODE); ?>"><?php } ?>
									<div class="w-search-label">
										<label for="s"><?php echo __("Just type and press 'enter'", 'us' ); ?></label>
									</div>
									<div class="w-search-input">
										<input type="text" value="" id="s" name="s"/>
									</div>
									<div class="w-search-submit">
										<input type="submit" id="searchsubmit"  value="<?php echo __('Search', 'us' ); ?>" />
									</div>
									<div class="w-search-close"> &#10005; </div>
								</div>
							</div>
						</form>
					</div>
				<?php } ?>

				<?php if (@$smof_data['main_header_layout'] == 'centered') get_template_part('templates/cart_dropdown'); ?>
			</div>
		</div>
		<?php } ?>

	</div>
	<!-- /HEADER -->

	<!-- MAIN -->
	<div class="l-main">
<?php
if ( ! defined('THEME_TEMPLATE') AND FALSE) {
	// Disabling Section shortcode
	global $disable_section_shortcode;
	$disable_section_shortcode = TRUE;
?>
		<div class="l-submain">
			<div class="l-submain-h g-html i-cf">
<?php } ?>
