<?php 
/*
	RBCode plugin admin part
	http:www.madebyfiga.com/labs/rbcode

    Copyright 2011 Garry Pettet <garry@madebyfiga.com>

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
*/
?>
<?php
function rbc_admin_menu() {
// Put a link to our options page in the Dashboard sidebar
	add_options_page('RBCode Options', 'RBCode', 'manage_options', 'rbc_options_identifier', 'rbc_options_page');
}
?>
<?php
function rbc_options_page() {
	// This function outputs the HTML for our options page in the Dashboard.
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
?>
<!-- Are we displaying this page before or after the user has clicked 'Update Options'? -->
<?php  
    if($_POST['rbcode_hidden'] == 'Y') {  
        //Form data sent  
		$rbcomment = $_POST['rbcode_comment'];
		update_option('rbcode_comment', $rbcomment);
		
		$rbfloat = $_POST['rbcode_float'];
		update_option('rbcode_float', $rbfloat);
		
		$rbkeyword = $_POST['rbcode_keyword'];
		update_option('rbcode_keyword', $rbkeyword);
		
		$rbinteger = $_POST['rbcode_integer'];
		update_option('rbcode_integer', $rbinteger);
		
		$rbtext = $_POST['rbcode_text'];
		update_option('rbcode_text', $rbtext);
		
		$rbstring = $_POST['rbcode_string'];
		update_option('rbcode_string', $rbstring);
		
		$rblinenumbers = $_POST['rbcode_linenumbers'];
		update_option('rbcode_linenumbers', $rblinenumbers);
		
		$rbcapitalise = $_POST['rbcode_capitalise'];
		update_option('rbcode_capitalise', $rbcapitalise);
?>  
<div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div><?php  
    } else {  
        //Normal page display  
        $rbcomment = get_option('rbcode_comment');
        $rbfloat = get_option('rbcode_float');
        $rbkeyword = get_option('rbcode_keyword');
        $rbinteger = get_option('rbcode_integer');
        $rbtext = get_option('rbcode_text');
        $rbstring = get_option('rbcode_string');
        $rblinenumbers = get_option('rbcode_linenumbers');
        $rbcapitalise = get_option('rbcode_capitalise');
    }  
    
    	// Handle the checkboxes
		if(!$options['rbcode_linenumbers']){$options['rbcode_linenumbers'] = 0; }
		if(!$options['rbcode_capitalise']){$options['rbcode_capitalise'] = 0; }
		if($rblinenumbers == 1){ $lnchecked = 'checked="checked"'; }
		if($rbcapitalise == 1){ $capchecked = 'checked="checked"'; }
	
?>
<!-- Create the HTML -->
<div class="wrap">
<?php screen_icon(); echo "<h2>RBCode Options</h2>"; ?>  
    <form name="rbcode_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">  
        <input type="hidden" name="rbcode_hidden" value="Y">  
        <h4>Syntax highlighting colours</h4>
		<p><?php echo "Comments: "; ?><input type="text" name="rbcode_comment" value="<?php echo $rbcomment; ?>" size="20"></p>
		<p><?php echo "Floats: "; ?><input type="text" name="rbcode_float" value="<?php echo $rbfloat; ?>" size="20"></p>
		<p><?php echo "Integers: "; ?><input type="text" name="rbcode_integer" value="<?php echo $rbinteger; ?>" size="20"></p>
        <p><?php echo "Keywords: "; ?><input type="text" name="rbcode_keyword" value="<?php echo $rbkeyword; ?>" size="20"></p>  
		<p><?php echo "Strings: "; ?><input type="text" name="rbcode_string" value="<?php echo $rbstring; ?>" size="20"></p>
		<p><?php echo "Text: "; ?><input type="text" name="rbcode_text" value="<?php echo $rbtext; ?>" size="20"></p>
		<p><?php echo "Show line numbers: "; ?><input type="checkbox" name="rbcode_linenumbers" value="1" <?php echo $lnchecked; ?>" size="20"><span style="padding-left:10px;font-style:italic";">Can be overridden on a per-snippet basis with the shortcode attributes numbers="true" or numbers="false"</span></p>
		<p><?php echo "Capitalise keywords: "; ?><input type="checkbox" name="rbcode_capitalise" value="1" <?php echo $capchecked; ?>" size="20"><span style="padding-left:10px;font-style:italic";">Override with shortcode attributes caps="true" or caps="false"</span></p>  
		<p class="submit">  
        <input type="submit" name="Submit" value="Update Options" />
        </p>  
    </form>  

</div><!-- wrap div -->
<?php
}
?>