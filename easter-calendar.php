<?php
/*
Plugin Name: Påskenøtter
Plugin URI: http://http://www.xn--pskentter-52a7s.com/
Description: The easy way to embed your easter-calendar [from påskenøtter.com] in Wordpress.
Version: 1.0
Author: Stian B Pedersen
Author URI: http://påskenøtter.com
*/

require("easter_plugin.php");

function make_easter_admin_menu() {
	make_easter::add_menu_page(); //kjør add_menu_page metode på init admin_menu
}
add_action('admin_menu','make_easter_admin_menu');

function make_easter_setup() {
	new make_easter;
}
add_action('admin_init', 'make_easter_setup');

function make_easter_add_calendar($atts) {
	$opt = get_option('make_easter_plugin_options');
	$atts = shortcode_atts(
		array(
			'height' => '800',
			'width'  => '100',
			'border' => '0',
			'bordercolor' => 'fff'
		), $atts
	);

	extract($atts);
	extract($opt);

	if( strlen($make_easter_subdomain) > 1 ) {
		( preg_match('/(%|px)/', $width) ) ? $c_width = $width : $c_width = $width . "%";
		( preg_match('/#/', $bordercolor) ) ? $c_bordercolor = $bordercolor : $c_bordercolor = "#" . $bordercolor;
		( preg_match('/(px)/', $border) ) ? $c_border = $border : $c_border = $border . "px";
		( preg_match('/(px)/', $height) ) ? $c_height = $height : $c_height = $height . "px";
		return "<iframe class='make_easter_{$make_easter_subdomain}' frameborder='0' style='width:{$c_width};height:{$c_height};border:{$c_border} solid {$c_bordercolor}' marginwidth='0' marginheight='0' src='https://{$make_easter_subdomain}.paskenotter.no'></iframe>";
	}else{
		return '';	
	}
}

add_shortcode('easter_quiz', 'make_easter_add_calendar');

register_deactivation_hook( __FILE__, array('make_easter','make_easter_remove') );
?>