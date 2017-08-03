<?php
/*
Plugin Name: RBCode
Plugin URI: http://www.madebyfiga.com/labs/rbcode
Description: A customisable syntax highlighter for REALbasic code
Version: 1.1.1
Author: Garry Pettet
Author URI: http://www.madebyfiga.com
*/

// Copyright (c) 2011 Figa Software, Garry Pettet. All rights reserved.
//
// Released under the GPL license
// http://www.opensource.org/licenses/gpl-license.php
//
// This is an add-on for WordPress
// http://wordpress.org/
//
// Heavily based on code originally written for phpBB by Jonathan Johnson, formally of REAL Software
//
// **********************************************************************
// This program is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
// **********************************************************************

// Default stylesheet (can be overridden by the theme's stylesheet)
add_action('wp_head', 'rb_include_css');
function rb_include_css() {
	echo '<link type="text/css" rel="stylesheet" href="' . get_bloginfo('wpurl') . '/wp-content/plugins/rbcode/style.css" />' . "\n";
}

// Include the required files
include 'highlighter.php';
include 'rbcode-admin.php';

add_shortcode( 'rbcode', 'rbcode_shortcode_handler' );

function rbcode_shortcode_handler( $atts, $content=null, $code="" ) {
   // $atts    ::= array of attributes
   // $content ::= text within enclosing form of shortcode element
   // $code    ::= the shortcode found, when == callback name
   
   
	// Allow overriding of global line number and capitalisation options via shortcode attibutes 
	// Put the passed attributes in an array $a and populate it with the global options in case the user doesn't pass any attributes
	// Note: shortcode attributes will ALWAYS override the global option on a per-snippet basis.
	$a = shortcode_atts( array(
		'numbers' => get_option('rbcode_linenumbers'),
		'caps' => get_option('rbcode_capitalise'),
	), $atts );

	// Get the user's colour preferences chosen in the options page
	$colours = array("comment" => get_option('rbcode_comment'),
		"integer" => get_option('rbcode_integer'),
		"real" => get_option('rbcode_float'),
		"keyword" => get_option('rbcode_keyword'),
		"string" => get_option('rbcode_string'),
		"text" => get_option('rbcode_text')
	);
	
	// Assign the line number and caps values
	// Note: the user types "true" or "false" but we need to convert this to 1 or 0 respectively
	if (strcasecmp($a['numbers'], "true")==0):
		$linenumbers = 1;
	elseif (strcasecmp($a['numbers'], "false")==0) : 
		$linenumbers = 0;
	else:
		$linenumbers = $a['numbers'];
	endif;
	
	if (strcasecmp($a['caps'], "true")==0): 
		$capitalise = 1; 
	elseif (strcasecmp($a['caps'], "false")==0) : 
		$capitalise = 0; 
	else :
		$capitalise = $a['caps'];
	endif;
	
// Make sure that all colours have more than just an empty string (if they do - unset them and the highlighter will use it's defaults)
if ($colours["comment"]=='') unset($colours["comment"]);
if ($colours["integer"]=='') unset($colours["integer"]);
if ($colours["float"]=='') unset($colours["float"]);
if ($colours["keyword"]=='') unset($colours["keyword"]);
if ($colours["string"]=='') unset($colours["string"]);
if ($colours["text"]=='') unset($colours["text"]);

	// Do the highlighting
	// Params = source, line numbers, line break, colours array, capitalise keywords
	$output = FormatRBCode($content, $linenumbers, '<br />', $colours, $capitalise);
	
	// Wrap the highlighted text in a rbcode div block
	$output = '<div class="rbcode">' . $output . '</div>';
	
	return $output;
}

// Provide an options page for this plugin
add_action('admin_menu', 'rbc_admin_menu');

?>