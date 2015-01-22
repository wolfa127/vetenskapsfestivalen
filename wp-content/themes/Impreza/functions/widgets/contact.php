<?php

class US_Widget_Contact extends WP_Widget {

	function __construct()
	{
		$widget_ops = array('classname' => 'widget_contact', 'description' => 'Contact Information');
		$control_ops = array();
		$this->WP_Widget('contact', 'Impreza: Contacts', $widget_ops, $control_ops);
	}

	function form($instance)
	{
		$defaults = array('title' => 'Contacts', 'address' => '', 'phone' => '', 'fax' => '', 'email' => '', );
		$instance = wp_parse_args((array) $instance, $defaults);
		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php echo 'Title' ?>:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" /></p>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('address'); ?>"><?php echo 'Address' ?>:</label>
			<textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id('address'); ?>" name="<?php echo $this->get_field_name('address'); ?>"><?php echo esc_textarea($instance['address']); ?></textarea>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('phone'); ?>"><?php echo 'Phone(s)' ?>:</label>
			<textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id('phone'); ?>" name="<?php echo $this->get_field_name('phone'); ?>" style="height: 47px;"><?php echo esc_textarea($instance['phone']); ?></textarea>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('fax'); ?>"><?php echo 'Fax' ?>:</label>
			<textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id('fax'); ?>" name="<?php echo $this->get_field_name('fax'); ?>" style="height: 47px;"><?php echo esc_textarea($instance['fax']); ?></textarea>
		</p>

		<label for="<?php echo $this->get_field_id('email'); ?>"><?php echo 'Email' ?>:</label>
		<input class="widefat" id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" type="text" value="<?php echo esc_attr($instance['email']); ?>" />
		</p>

	<?php
	}

	function widget($args, $instance)
	{
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Contacts', 'us') : $instance['title'], $instance, $this->id_base);

		echo $args['before_widget'];
		if ($title){
			echo '<h4>'.$title.'</h4>';
		}
		?><div class="w-contacts"><div class="w-contacts-h"><?php

			?><div class="w-contacts-list"><?php
				if ($instance['address']){
					echo '<div class="w-contacts-item">
						<i class="fa fa-map-marker"></i>
						<span class="w-contacts-item-value">'.$instance['address'].'</span>
					</div>';
				}
				if ($instance['phone']){
					echo '<div class="w-contacts-item">
						<i class="fa fa-phone"></i>
						<span class="w-contacts-item-value">'.$instance['phone'].'</span>
					</div>';
				}
				if ($instance['fax']){
					echo '<div class="w-contacts-item">
						<i class="fa fa-print"></i>
						<span class="w-contacts-item-value">'.$instance['fax'].'</span>
					</div>';
				}
				if ($instance['email']){
					echo '<div class="w-contacts-item">
						<i class="fa fa-envelope-o"></i>
						<span class="w-contacts-item-value"><a href="mailto:'.$instance['email'].'">'.$instance['email'].'</a></span>
					</div>';
				}
				?></div></div></div><?php
		echo $args['after_widget'];
	}
}

add_action('widgets_init', 'us_register_contact_widget');

function us_register_contact_widget()
{
	register_widget('US_Widget_Contact');
}
