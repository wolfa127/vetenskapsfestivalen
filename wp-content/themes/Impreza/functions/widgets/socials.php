<?php

class US_Widget_Socials extends WP_Widget {

	function __construct()
	{
		$widget_ops = array('classname' => 'widget_socials', 'description' => 'Social Links');
		$control_ops = array();
		$this->WP_Widget('socials', 'Impeza: Social Links', $widget_ops, $control_ops);
	}

	function form($instance)
	{
		$defaults = array(
			'title' => '',
			'size' => '',
			'email' => '',
			'facebook' => '',
			'twitter' => '',
			'google' => '',
			'linkedin' => '',
			'youtube' => '',
			'vimeo' => '',
			'flickr' => '',
			'instagram' => '',
			'behance' => '',
			'xing' => '',
			'pinterest' => '',
			'skype' => '',
			'tumblr' => '',
			'dribbble' => '',
			'vk' => '',
			'soundcloud' => '',
			'yelp' => '',
			'twitch' => '',
			'rss' => '',
		);
		$instance = wp_parse_args((array) $instance, $defaults);

		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php echo 'Title' ?>:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" /></p>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('size'); ?>">Size:</label>
			<select name="<?php echo $this->get_field_name('size'); ?>" id="<?php echo $this->get_field_id('size'); ?>" class="widefat">
				<option value="normal"<?php selected( $instance['size'], 'normal' ); ?>>Normal</option>
				<option value="small"<?php selected( $instance['size'], 'small' ); ?>>Small</option>
				<option value="big"<?php selected( $instance['size'], 'big' ); ?>>Big</option>
			</select>
		</p>

		<?php

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

		foreach ($socials as $social_key => $social)
		{
?>

		<p>
			<label for="<?php echo $this->get_field_id($social_key); ?>"><?php echo $social ?>:</label>
			<input class="widefat" id="<?php echo $this->get_field_id($social_key); ?>" name="<?php echo $this->get_field_name($social_key); ?>" type="text" value="<?php echo esc_attr($instance[$social_key]); ?>" /></p>
		</p>

<?php
		}

	}

	function widget($args, $instance)
	{
		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);

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

		echo $args['before_widget'];
		if ($title){
			echo '<h4>'.$title.'</h4>';
		}
		$output = '<div class="w-socials size_'.$instance['size'].'">
			<div class="w-socials-h">
				<div class="w-socials-list">';

		foreach ($socials as $social_key => $social)
		{
			if ($instance[$social_key] != '')
			{
				if ($social_key == 'email')
				{
					$output .= '<div class="w-socials-item '.$social_key.'">
					<a class="w-socials-item-link" href="mailto:'.$instance[$social_key].'">
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
					<a class="w-socials-item-link" target="_blank" href="'.$instance[$social_key].'">
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
					<a class="w-socials-item-link" target="_blank" href="'.$instance[$social_key].'">
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
					<a class="w-socials-item-link" target="_blank" href="'.$instance[$social_key].'">
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
					<a class="w-socials-item-link" target="_blank" href="'.$instance[$social_key].'">
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

		$output .= '</div></div></div>';

		echo $output;
		echo $args['after_widget'];
	}
}

add_action('widgets_init', 'us_register_socials_widget');

function us_register_socials_widget()
{
	register_widget('US_Widget_Socials');
}
