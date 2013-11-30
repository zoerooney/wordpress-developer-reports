<?php
/*
Plugin Name: WordPress Developer Reports
Plugin URI: http://zoerooney.com
Description: Simple but useful reports on core, themes, and plugins for Wordpress.
Version: 0.0.5
Author: Zoe Rooney
Author URI: http://zoerooney.com
License: GPL2

Copyright 2013  Zoe Rooney  (email : hello@zoerooney.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/* Enqueue our scripts and stylesheets
=============================================*/
function wp_dev_reports_init() {
    
  if ( is_admin() ) {
  	
	  wp_register_style('fontawesome', WP_PLUGIN_URL . '/'.basename(dirname(__FILE__)).'/admin/font-awesome.min.css'); 
	  wp_enqueue_style('fontawesome');
	 
	  // Not using this currently, just a placeholder for now
	  // wp_register_script('wp_dev_reportsjs', WP_PLUGIN_URL . '/'.basename(dirname(__FILE__)).'/jquery.wp_dev_reports.js', array('jquery'), false, false);
	  // wp_enqueue_script('wp_dev_reportsjs');
	  
  }
}
add_action('init', 'wp_dev_reports_init');

	
/* Create menu link to the settings page
=============================================*/
add_action('admin_menu', 'wp_dev_reports_menu_register_page');
function wp_dev_reports_menu_register_page() {
	add_submenu_page( 'tools.php', 'Generate Developer Reports', 'Developer Reports', 'manage_options', 'wp-dev-reports', 'wp_dev_reports_page_callback' );
}

/* Create the settings page
=============================================*/
function wp_dev_reports_page_callback() {
	$options = get_option( 'wp_dev_reports_settings' );

	/* Make sure the user has permission to access these settings */
	
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	} 	?>
	
	<!-- Set up our basic page structure -->
	<div class="wrap">
	<h2 id="wp_dev_reports">Generate Developer Reports</h2>
		<div class="module">
			<h3>Right Now</h3>
			<p>Your data is current as of <? echo date( 'F d, Y h:ia', current_time( 'timestamp', 0 ) ); ?> (right now).</p>
			<p><em>Not your current local time? <a href="/wp-admin/options-general.php#default_role">Update your time zone.</a></em></p>
		</div>
		<div class="module">
			<h3>About WordPress</h3>
			<p>You are running WordPress <?php echo get_bloginfo('version'); ?>.</p>
			<p>The latest version is <?php echo wp_version_check(); ?></p>
		</div>
		<form action="options.php" method="post">
			<?php settings_fields('wp_dev_reports_options'); ?>
			<?php do_settings_sections('wp_dev_reports'); ?>
			<input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
		</form>
		
	</div>
				
<?php }

/* Register all the necessary settings
=============================================*/
/*
add_action('admin_init', 'wp_dev_reports_admin_init');
function wp_dev_reports_admin_init(){
//  TO DO: NEED TO FIGURE OUT WHAT I WANT HERE, THIS IS ALL STUFF FROM JOYRIDE

	register_setting(
		'wp_dev_reports_options',
		'wp_dev_reports_options',
		'wp_dev_reports_validation'
	);
	add_settings_section(
		'wp_dev_reports_display_options',
		'Display Options <i class="icon-cog"></i>',
		'wp_dev_reports_display_options_text',
		'wp_dev_reports'
	);
	add_settings_section(
		'wp_dev_reports_feature_tips',
		'Feature Tour Tips <i class="icon-map-marker"></i>',
		'wp_dev_reports_feature_tips_text',
		'wp_dev_reports'
	);
	
	// wp_dev_reports Options
	add_settings_field(
		'wp_dev_reports_tiplocation',
		'Tip location relative to the parent element',
		'wp_dev_reports_tiplocation_input',
		'wp_dev_reports',
		'wp_dev_reports_display_options'
	);
	add_settings_field(
		'wp_dev_reports_scrollspeed',
		'Page scroll speed, in ms',
		'wp_dev_reports_scrollspeed_input',
		'wp_dev_reports',
		'wp_dev_reports_display_options'
	);
	add_settings_field(
		'wp_dev_reports_timer',
		'Duration of each tour stop, 0 = off',
		'wp_dev_reports_timer_input',
		'wp_dev_reports',
		'wp_dev_reports_display_options'
	);
	add_settings_field(
		'wp_dev_reports_starttimeronclick',
		'Start the timer on the first click',
		'wp_dev_reports_starttimeronclick_input',
		'wp_dev_reports',
		'wp_dev_reports_display_options'
	);
	add_settings_field(
		'wp_dev_reports_nextbutton',
		'Show the "Next" button',
		'wp_dev_reports_nextbutton_input',
		'wp_dev_reports',
		'wp_dev_reports_display_options'
	);
	add_settings_field(
		'wp_dev_reports_tipanimation',
		'Animation style',
		'wp_dev_reports_tipanimation_input',
		'wp_dev_reports',
		'wp_dev_reports_display_options'
	);
	add_settings_field(
		'wp_dev_reports_tipanimationfadespeed',
		'Speed of the fade animation',
		'wp_dev_reports_tipanimationfadespeed_input',
		'wp_dev_reports',
		'wp_dev_reports_display_options'
	);
	
	// The tips

	add_settings_field(
		'wp_dev_reports_tipid',
		'Tip ID (all lowercase, no spaces)',
		'wp_dev_reports_tipid_input',
		'wp_dev_reports',
		'wp_dev_reports_feature_tips'
	);
	add_settings_field(
		'wp_dev_reports_tipcontent',
		'Tip Content',
		'wp_dev_reports_tipcontent_input',
		'wp_dev_reports',
		'wp_dev_reports_feature_tips'
	);

}
*/


/* Now, display all those settings
=============================================*/
//  TO DO: UPDATE FOR THIS PLUGIN
/*
// Section header text
function wp_dev_reports_section_text() {
}

// Form fields

function wp_dev_reports_tiplocation_input() {
	$options = get_option( 'wp_dev_reports_options' );?>
	
	<select name="wp_dev_reports_options[tiplocation]" value="<?php echo $options[tiplocation]; ?>" />
		<option value="top" <?php if ( $options['tiplocation'] == 'top' ) echo " selected='selected'";?>>Top</option>
		<option value="bottom" <?php if ( $options['tiplocation'] == 'bottom' ) echo " selected='selected'";?>>Bottom</option>
	</select>
<?php }


function wp_dev_reports_scrollspeed_input() {
	$options = get_option( 'wp_dev_reports_options' );
	echo '<input name="wp_dev_reports_options[scrollspeed]" type="text" size="5" value="' . $options[scrollspeed] . '" placeholder="300" /> ms';
}

function wp_dev_reports_timer_input() {
	$options = get_option( 'wp_dev_reports_options' );
	echo '<input name="wp_dev_reports_options[timer]" type="text" size="5" value="' . $options[timer] . '" placeholder="2000" /> ms';
}

function wp_dev_reports_starttimeronclick_input() {
	$options = get_option( 'wp_dev_reports_options' );	?>
	<input type="checkbox" name="wp_dev_reports_options[starttimeronclick]" value="true" <?php checked( "true", $options['starttimeronclick'] ); ?> />
<?php }

function wp_dev_reports_nextbutton_input() {
	$options = get_option( 'wp_dev_reports_options' );	 ?>
	<input type="checkbox" name="wp_dev_reports_options[nextbutton]" value="true" <?php checked( "true", $options['nextbutton'] ); ?> />
<?php }

function wp_dev_reports_tipanimation_input() {
	$options = get_option( 'wp_dev_reports_options' );?>
	
	<select name="wp_dev_reports_options[tipanimation]" value="<?php echo $options[tipanimation]; ?>" />
		<option value="pop" <?php if ( $options['tipanimation'] == 'pop' ) echo " selected='selected'";?>>Pop</option>
		<option value="fade" <?php if ( $options['tipanimation'] == 'fade' ) echo " selected='selected'";?>>Fade</option>
	</select>
<?php }

function wp_dev_reports_tipanimationfadespeed_input() {
	$options = get_option( 'wp_dev_reports_options' );
	echo '<input name="wp_dev_reports_options[tipanimationfadespeed]" type="text" size="5" value="' . $options[tipanimationfadespeed] . '" placeholder="300" /> ms';
}

function wp_dev_reports_tipid_input() {
	$options = get_option( 'wp_dev_reports_options' );
	echo '<div><input name="wp_dev_reports_options[tipid]" type="text" value="' . $options[tipid] . '" />';
	echo '<input name="shortcode" type="text" value="[tourstop id=' . $options[tipid] . ']" readonly/>';
}
function wp_dev_reports_tipcontent_input() {
	echo '<textarea name="wp_dev_reports_options[tipcontent]">' . $options[tipcontent] . '</textarea></div>';
}
*/
/**
 * Let's validate this stuff
 
function wp_dev_reports_validation( $input ) {
//  TO DO: VALIDATION

  if ( ! $input['scrollspeed'] )
    $input['scrollspeed'] = '300';
    
  if ( ! $input['timer'] )
    $input['timer'] = '2000';
  
  if ( ! $input['tipanimationfadespeed'] )
    $input['tipanimationfadespeed'] = '300';
      
  if ( ! isset( $input['starttimeronclick'] ) )
	$input['starttimeronclick'] = null;
	$input['starttimeronclick'] = ( $input['starttimeronclick'] == "true" ? "true" : "false" );

  if ( ! isset( $input['nextbutton'] ) )
  	$input['nextbutton'] = null;
  	$input['nextbutton'] = ( $input['nextbutton'] == "true" ? "true" : "false" );
   	
  return $input;
}
*/ 
// TO DO: NEED TO OUTPUT THIS STUFF SOMEPLACE...


// Close it down ?>