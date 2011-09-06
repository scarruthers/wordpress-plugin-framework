<?php
/*
Plugin Name: 
Plugin URI: N/A
Description: This plugin allows for easy management of auctions, specifically designed for Al Hughes' Auction Site.
Author: Sean Carruthers (Carruthers Coding)
License: GPLv2 or later
*/

/*

Copyright (C) 2011 Sean Carruthers (Carruthers Coding)  (email : sean_carruthers@hotmail.com)

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

*/

$display_name = "";
$plugin_name = ""; // Folder name
$errors = false;

if ( $errors )
	error_reporting( E_ALL );	ini_set( 'display_errors', '1' );

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

global $wpdb;

DEFINE( 'CC_PATH', 'wp-content/plugins/' . $plugin_name . '/' );
DEFINE( 'CC_DATA', $wpdb->prefix . "cc_" . $plugin_name);
DEFINE( 'CC_VERSION', '1.0');

require_once( ABSPATH . CC_PATH . 'functions.php' );

// soccer_main() handles everything, including displaying information, processing data, etc
function cc_main() {
	require_once( ABSPATH . CC_PATH . 'main.php' );		# main php file
}

// soccer_create_menu() generates and displays the navigation menu
function cc_create_menu() {
	global $display_name;
	add_menu_page( $display_name, $display_name, 'manage_options', 'cc-main', 'cc_main' );
}

// soccer_install() will create the table the plugin needs to operate - only run on plugin activation
function cc_install() {
	require_once( ABSPATH . CC_PATH . 'install.php' );
}

// add_stylesheet() enqueues the plugin's stylesheet, so that the css is loaded
function add_stylesheets() {
   global $plugin_name;
	
   $stylesheets = array( "style.css", "jqueryui/css/dark-hive/jquery-ui-1.8.16.custom.css", "jqueryui/css/timepicker.css", "uploadify/uploadify.css" );
   
   $n = 0;
   foreach( $stylesheets as $stylesheet ) {
      $styleUrl = WP_PLUGIN_URL . '/' . $plugin_name . '/' . $stylesheet;
      $styleFile = WP_PLUGIN_DIR . '/' . $plugin_name . '/' . $stylesheet;

      if ( file_exists($styleFile) ) {
	 wp_register_style( 'ccStyleSheets-' . $n, $styleUrl );
	 wp_enqueue_style(  'ccStyleSheets-' . $n );
      }
   $n++;
   }
}

function add_scripts() {
   global $plugin_name;
   
   wp_deregister_script( 'jquery' );
   wp_deregister_script( 'jqueryui' );
   wp_deregister_script( 'jquerytime' );
   
   wp_register_script( 'jquery', WP_PLUGIN_URL . '/' . $plugin_name . '/jqueryui/js/jquery-1.6.2.min.js');
   wp_register_script( 'jqueryui', WP_PLUGIN_URL . '/' . $plugin_name . '/jqueryui/js/jquery-ui-1.8.16.custom.min.js' );
   wp_register_script( 'jquerytime', WP_PLUGIN_URL . '/' . $plugin_name . '/jqueryui/js/jquery-ui-timepicker-addon.js' );
   wp_register_script( 'uploadifyswf', WP_PLUGIN_URL . '/' . $plugin_name . '/uploadify/swfobject.js' );
   wp_register_script( 'uploadify', WP_PLUGIN_URL . '/' . $plugin_name . '/uploadify/jquery.uploadify.v2.1.4.min.js' );
   
   wp_enqueue_script( 'jquery' );
   wp_enqueue_script( 'jqueryui' );
   wp_enqueue_script( 'jquerytime' );
   wp_enqueue_script( 'uploadifyswf' );
   wp_enqueue_script( 'uploadify' );

}

// Actions, Filters, Hooks

   // Menu
   add_action( 'admin_menu', 'cc_create_menu' );	# Create the administration menu
   
   // Stylesheets
   add_action('wp_print_styles', 'add_stylesheets');	# Enqueue the plugin css file for frontend
   add_action('admin_print_styles', 'add_stylesheets'); # Enqueue the plugin css file for backend
   
   // Scripts
   add_action('wp_enqueue_scripts', 'add_scripts');     # Enqueue scripts on frontend
   add_action('admin_enqueue_scripts', 'add_scripts');  # Enqueue scripts on backend
   
   // Install
   register_activation_hook( __FILE__, 'cc_install' );	# call cc_install() when the plugin is activated
?>