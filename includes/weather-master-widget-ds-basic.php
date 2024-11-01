<?php
//Hook Widget
add_action( 'widgets_init', 'weather_master_widget_ds_basic' );
//Register Widget
function weather_master_widget_ds_basic() {
register_widget( 'weather_master_widget_ds_basic' );
}

class weather_master_widget_ds_basic extends WP_Widget {
	function __construct(){
	$widget_ops = array( 'classname' => 'Weather Master Dark Sky Basic', 'description' => __('Weather Master Dark Sky Basic Weather Layer Widget is easy to deploy and uses the latest Temperature Layer information.', 'weather_master') );
	$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'weather_master_widget_ds_basic' );
	parent::__construct( 'weather_master_widget_ds_basic', __('Weather Master Dark Sky Basic', 'weather_master'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
	global $wpdb, $blog_id;
		extract( $args );
		//Save WPOptions
		$weather_master_load_basic_ds_city = "6";
		$weather_master_load_basic_ds_state = "6";
		$weather_master_load_basic_ds_country = "6";
		if(is_multisite()){
			add_blog_option($blog_id, 'weather_master_view_basic_ds_detail_choice', "6");
			add_blog_option($blog_id, 'weather_master_load_basic_ds_city', $weather_master_load_basic_ds_city);
			add_blog_option($blog_id, 'weather_master_load_basic_ds_state', $weather_master_load_basic_ds_state); 
			add_blog_option($blog_id, 'weather_master_load_basic_ds_country', $weather_master_load_basic_ds_country);
		}
		else{
			add_option('weather_master_view_basic_ds_detail_choice', "6");
			add_option('weather_master_load_basic_ds_city', $weather_master_load_basic_ds_city);
			add_option('weather_master_load_basic_ds_state', $weather_master_load_basic_ds_state); 
			add_option('weather_master_load_basic_ds_country', $weather_master_load_basic_ds_country);
		}
		//Set Tittle
		$weather_title = isset( $instance['weather_title'] ) ? $instance['weather_title'] :false;
		$weather_title_new = isset( $instance['weather_title_new'] ) ? $instance['weather_title_new'] :false;
		//Set Wide Map Options
		$weathermapsspacer ="'";
		$show_weather_master = isset( $instance['show_weather_master'] ) ? $instance['show_weather_master'] :false;
		$weather_master_weather_temp = isset( $instance['weather_master_weather_temp'] ) ? $instance['weather_master_weather_temp'] :false;
		$weather_height = isset( $instance['weather_height'] ) ? $instance['weather_height'] :false;
		$weather_latitude = isset( $instance['weather_latitude'] ) ? $instance['weather_latitude'] :false;
		$weather_longitude = isset( $instance['weather_longitude'] ) ? $instance['weather_longitude'] :false;
		echo $before_widget;
		
		// Display the widget title
	if ( $weather_title ){
		if (empty ($weather_title_new)){
			$weather_title_new = constant('WEATHER_MASTER_NAME');
			echo $before_title . $weather_title_new . $after_title;
		}
		else{
			echo $before_title . $weather_title_new . $after_title;
		}
	}
	else{
	}

	//Display
	if ( $show_weather_master ){
		if (empty($weather_master_view_basic_ds_detail_choice)){
		$weather_master_view_basic_ds_detail_choice = '6';
		}
		if (empty($weather_height)){
		$weather_height = '400';
		}
		if (empty($weather_latitude)){
		//$weather_latitude = '32.720392';
		echo '<font color="red">Please insert latitude in widget backend.</font><br>';
		}
		if (empty($weather_longitude)){
		//$weather_longitude = '-117.228778';
		echo '<font color="red">Please insert longitude in widget backend.</font>';
		}
		//PREPARE TEMP
		if ($weather_master_weather_temp){
			$weather_master_weather_temp_letter = "c";
		}
		else{
			$weather_master_weather_temp_letter = "f";
		}
		echo '<iframe style="height: '.$weather_height.'px;" src="https://maps.darksky.net/@temperature,'.$weather_latitude.','.$weather_longitude.','.$weather_master_view_basic_ds_detail_choice.'?embed=true&amp;timeControl=false&amp;fieldControl=false&amp;defaultField=temperature&amp;defaultUnits=_'.$weather_master_weather_temp_letter.'" width="100%" frameborder="0"></iframe>';
	}
	else{
	}
	echo $after_widget;
	}
	//Update the widget
	function update( $new_instance, $old_instance ) {
	global $wpdb, $blog_id;
		$instance = $old_instance;
		//Strip tags from title and name to remove HTML
		$instance['weather_title'] = strip_tags( $new_instance['weather_title'] );
		$instance['weather_title_new'] = $new_instance['weather_title_new'];
		//Store Wide Map Options
		$instance['show_weather_master'] = $new_instance['show_weather_master'];
		$instance['weather_master_weather_temp'] = $new_instance['weather_master_weather_temp'];
		$instance['weather_master_view_basic_ds_detail_choice'] = $new_instance['weather_master_view_basic_ds_detail_choice'];
		$instance['weather_height'] = $new_instance['weather_height'];
		$instance['weather_latitude'] = $new_instance['weather_latitude'];
		$instance['weather_longitude'] = $new_instance['weather_longitude'];
		return $instance;
	}
	function form( $instance ) {
	global $wpdb, $blog_id;
	$plugin_master_name = constant('WEATHER_MASTER_NAME');
	//Set up some default widget settings.
	$defaults = array( 'weather_title_new' => __('Weather Master', 'weather_master'), 'weather_title' => true, 'weather_title_new' => false, 'show_weather_master' => false, 'weather_master_view_basic_ds_detail_choice' => false, 'weather_master_weather_temp' => false, 'weather_height' => false, 'weather_latitude' => false, 'weather_longitude' => false );
	$instance = wp_parse_args( (array) $instance, $defaults );
	//Lets get data from single and multi to populate the form
	if(is_multisite()){
		$weather_master_view_basic_ds_detail_choice = get_blog_option($blog_id, 'weather_master_view_basic_ds_detail_choice');
		$weather_master_load_basic_ds_state = get_blog_option($blog_id, 'weather_master_load_basic_ds_state');
	}
	else{
		$weather_master_view_basic_ds_detail_choice = get_option('weather_master_view_basic_ds_detail_choice');
		$weather_master_load_basic_ds_state = get_option('weather_master_load_basic_ds_state');
	}
	?>
		<p>
		<b>Check the buttons to be displayed:</b>
		</p>
	<p>
	<img src="<?php echo plugins_url('images/techgasp-minilogo-16.png', dirname(__FILE__)); ?>" style="float:left; height:18px; vertical-align:middle;" />
	&nbsp;
	<input type="checkbox" <?php checked( (bool) $instance['weather_title'], true ); ?> id="<?php echo $this->get_field_id( 'weather_title' ); ?>" name="<?php echo $this->get_field_name( 'weather_title' ); ?>" />
	<label for="<?php echo $this->get_field_id( 'weather_title' ); ?>"><b><?php _e('Display Widget Title', 'weather_master'); ?></b></label></br>
	</p>
	<p>
	<label for="<?php echo $this->get_field_id( 'weather_title_new' ); ?>"><?php _e('Change Title:', 'weather_master'); ?></label>
	<br>
	<input id="<?php echo $this->get_field_id( 'weather_title_new' ); ?>" name="<?php echo $this->get_field_name( 'weather_title_new' ); ?>" value="<?php echo $instance['weather_title_new']; ?>" style="width:auto;" />
	</p>
<div style="background: url(<?php echo plugins_url('images/techgasp-hr.png', dirname(__FILE__)); ?>) repeat-x; height: 10px"></div>
	<h2>Weather Options</h2>
	<p>
	<img src="<?php echo plugins_url('images/techgasp-minilogo-16.png', dirname(__FILE__)); ?>" style="float:left; height:18px; vertical-align:middle;" />
	&nbsp;
	<input type="checkbox" <?php checked( (bool) $instance['show_weather_master'], true ); ?> id="<?php echo $this->get_field_id( 'show_weather_master' ); ?>" name="<?php echo $this->get_field_name( 'show_weather_master' ); ?>" />
	<label for="<?php echo $this->get_field_id( 'show_weather_master' ); ?>"><b><?php _e('Activate Weather Display', 'weather_master'); ?></b></label>
	</p>
	<p>
	<select id="<?php echo $this->get_field_id( 'weather_master_view_basic_ds_detail_choice' ); ?>" name="<?php echo $this->get_field_name( 'weather_master_view_basic_ds_detail_choice' ); ?>" style="width:190px">
	<option value="<?php echo $weather_master_load_basic_ds_state; ?>" <?php echo $weather_master_view_basic_ds_detail_choice == '6' ? 'selected="selected"':''; ?>>State Weather Level</option>
	</select>
	<label for="<?php echo $this->get_field_id( 'weather_master_view_basic_ds_detail_choice' ); ?>"></label>
	</p>
	<p>
	<input type="checkbox" <?php checked( (bool) $instance['weather_master_weather_temp'], true ); ?> id="<?php echo $this->get_field_id( 'weather_master_weather_temp' ); ?>" name="<?php echo $this->get_field_name( 'weather_master_weather_temp' ); ?>" />
	<label for="<?php echo $this->get_field_id( 'weather_master_weather_temp' ); ?>"><b><?php _e('Activate Weather in Celsius', 'weather_master'); ?></b></label>
	<div class="description">Default <b>Off</b> temperature displayed in Fahrenheit.</div>
	</p>
	<p>
	<label for="<?php echo $this->get_field_id( 'weather_height' ); ?>"><?php _e('Plugin Height:', 'weather_master'); ?></label><br>
	<input id="<?php echo $this->get_field_id( 'weather_height' ); ?>" name="<?php echo $this->get_field_name( 'weather_height' ); ?>" value="<?php echo $instance['weather_height']; ?>" style="width:auto;" />
	<div class="description">Default <b>400</b> or <b>empty field</b>. This value, does not affect responsiveness.</div>
	</p>
	<p>
	<label for="<?php echo $this->get_field_id( 'weather_latitude' ); ?>"><?php _e('Weather Latitude:', 'weather_master'); ?></label><br>
	<input id="<?php echo $this->get_field_id( 'weather_latitude' ); ?>" name="<?php echo $this->get_field_name( 'weather_latitude' ); ?>" value="<?php echo $instance['weather_latitude']; ?>" style="width:auto;" />
	<div class="description">Example <b>32.720392</b>. Check below instructions.</div>
	</p>
	<p>
	<label for="<?php echo $this->get_field_id( 'weather_longitude' ); ?>"><?php _e('Weather Longitude:', 'weather_master'); ?></label><br>
	<input id="<?php echo $this->get_field_id( 'weather_longitude' ); ?>" name="<?php echo $this->get_field_name( 'weather_longitude' ); ?>" value="<?php echo $instance['weather_longitude']; ?>" style="width:auto;" />
	<div class="description">Example <b>-117.228778</b>. Check below instructions.</div>
	</p>
	<p>
	<div class="description"><a href="https://maps.google.com" target="_blank">Get Weather Coordinates</a>. Right-click on the desired spot on the map to bring up a menu with options. Click What's here to get the latitude and longitude coordinates. Try to get coordinates roughly from the center of your city, state or country.</div>
	<div class="description"><a href="https://wordpress.techgasp.com/weather-master-documentation/" target="_blank">More about these settings</a>.</div>
	</p>
<div style="background: url(<?php echo plugins_url('images/techgasp-hr.png', dirname(__FILE__)); ?>) repeat-x; height: 10px"></div>
	<p>
	<img src="<?php echo plugins_url('images/techgasp-minilogo-16.png', dirname(__FILE__)); ?>" style="float:left; width:18px; vertical-align:middle;" />
	&nbsp;
	<b><?php echo $plugin_master_name; ?> Website</b>
	</p>
	<p><a class="button-secondary" href="https://wordpress.techgasp.com/weather-master/" target="_blank" title="<?php echo $plugin_master_name; ?> Info Page">Info Page</a> <a class="button-secondary" href="https://wordpress.techgasp.com/weather-master-documentation/" target="_blank" title="<?php echo $plugin_master_name; ?> Documentation">Documentation</a> <a class="button-primary" href="https://wordpress.org/plugins/weather-master/" target="_blank" title="<?php echo $plugin_master_name; ?> Wordpress">RATE US *****</a></p>
	<?php
	}
 }
?>
