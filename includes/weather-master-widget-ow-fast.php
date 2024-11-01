<?php
//Hook Widget
add_action( 'widgets_init', 'weather_master_widget_fast' );
//Register Widget
function weather_master_widget_fast() {
register_widget( 'weather_master_widget_fast' );
}

class weather_master_widget_fast extends WP_Widget {
	function __construct(){
	$widget_ops = array( 'classname' => 'Weather Master Fast', 'description' => __('Weather Master OpenWeatherMap Fast Widget is easy to deploy and uses the latest weather forecast information for your city.', 'weather_master') );
	$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'weather_master_widget_fast' );
	parent::__construct( 'weather_master_widget_fast', __('Weather Master Fast', 'weather_master'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
	global $wpdb, $blog_id;
		extract( $args );
		//Set Tittle
		$weather_title = isset( $instance['weather_title'] ) ? $instance['weather_title'] :false;
		$weather_title_new = isset( $instance['weather_title_new'] ) ? $instance['weather_title_new'] :false;
		//Set Wide Map Options
		$weathermapsspacer ="'";
		$show_weather_master = isset( $instance['show_weather_master'] ) ? $instance['show_weather_master'] :false;
		$weather_master_location = isset( $instance['weather_master_location'] ) ? $instance['weather_master_location'] :false;
		$weather_master_unit = isset( $instance['weather_master_unit'] ) ? $instance['weather_master_unit'] :false;
		$weather_master_ow_api = isset( $instance['weather_master_ow_api'] ) ? $instance['weather_master_ow_api'] :false;
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
	//Prepare Location
	if(empty($weather_master_location)){
		echo '<div class="weather-master-error">Location Error. Insert location <b>number</b>.</div>';
		$weather_master_location = '2643743';
		
	}
	//Prepare API KEY
	if(empty($weather_master_ow_api)){
		echo '<div class="weather-master-error">API Error. Insert API <b>key</b>.</div>';
		$weather_master_ow_api = "";
	}
	//Prepare Units
	if(empty($weather_master_unit)){
		 $weather_master_unit = 'metric';
	}
	//END Display Weather
	if ( $show_weather_master ){
?>
<div id="openweathermap-widget-22" style="min-height: 250px;"></div>
<script>window.myWidgetParam ? window.myWidgetParam : window.myWidgetParam = [];  window.myWidgetParam.push({id: 22,cityid: '<?php echo $weather_master_location; ?>',appid: '<?php echo $weather_master_ow_api; ?>',units: '<?php echo $weather_master_unit; ?>',containerid: 'openweathermap-widget-22',  });  (function() {var script = document.createElement('script');script.async = true;script.charset = "utf-8";script.src = "//openweathermap.org/themes/openweathermap/assets/vendor/owm/js/weather-widget-generator.js";var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(script, s);  })();</script>
<?php
	}
	else{
	}
	echo $after_widget;
	}
	//Update the widget
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		//Strip tags from title and name to remove HTML
		@$instance['weather_title'] = strip_tags( $new_instance['weather_title'] );
		$instance['weather_title_new'] = $new_instance['weather_title_new'];
		//Store Wide Map Options
		@$instance['show_weather_master'] = $new_instance['show_weather_master'];
		$instance['weather_master_location'] = htmlspecialchars($new_instance['weather_master_location']);
		$instance['weather_master_unit'] = $new_instance['weather_master_unit'];
		$instance['weather_master_ow_api'] = $new_instance['weather_master_ow_api'];
		return $instance;
	}
	function form( $instance ) {
	$plugin_master_name = constant('WEATHER_MASTER_NAME');
	//Set up some default widget settings.
	$defaults = array( 'weather_title_new' => __('Weather Master', 'weather_master'), 'weather_title' => true, 'weather_title_new' => false, 'show_weather_master' => false, 'weather_master_location' => false, 'weather_master_unit' => false, 'weather_master_ow_api' => false );
	$instance = wp_parse_args( (array) $instance, $defaults );
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
	<label for="<?php echo $this->get_field_id( 'weather_master_ow_api' ); ?>"><b><?php _e('OpenWeatherMap API Key:', 'weather_master'); ?></b></label><br>
	<input id="<?php echo $this->get_field_id( 'weather_master_ow_api' ); ?>" name="<?php echo $this->get_field_name( 'weather_master_ow_api' ); ?>" value="<?php echo $instance['weather_master_ow_api']; ?>" style="width:auto;" />
	<div class="description"><a href="http://openweathermap.org/" target="_blank">Get free OpenWeatherMap Api Key</a>.</div>
	</p>
	<p>
	<label for="<?php echo $this->get_field_id( 'weather_master_location' ); ?>"><b><?php _e('Weather Location Number:', 'weather_master'); ?></b></label><br>
	<input id="<?php echo $this->get_field_id( 'weather_master_location' ); ?>" name="<?php echo $this->get_field_name( 'weather_master_location' ); ?>" value="<?php echo $instance['weather_master_location']; ?>" style="width:auto;" />
	<div class="description">Insert your city location number. Example: <b>2988507</b> for Paris, FR or <b>2643743</b> for London GB. <a href="https://openweathermap.org/city/" target="_blank">Get your location number</a> (Copy number for browser url)</div>
	</p>
	<p>
	<label for="<?php echo $this->get_field_id( 'weather_master_unit' ); ?>"><b><?php _e('Weather Unit:', 'weather_master'); ?></b></label><br>
	<input id="<?php echo $this->get_field_id( 'weather_master_unit' ); ?>" name="<?php echo $this->get_field_name( 'weather_master_unit' ); ?>" value="<?php echo $instance['weather_master_unit']; ?>" style="width:auto;" />
	<div class="description">Example: <b>metric</b> for Celsius, <b>imperial</b> for Fahrenheit.</div>
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
