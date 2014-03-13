<?php
/*
Plugin Name: Custom Post Type Attachment ( PDF )
Plugin URI: http://avifoujdar.wordpress.com/category/my-wp-plugins/
Description: This plugin will allow you to upload pdf files to your post or pages or any other custom post types. You can either use shortcodes or functions to display attachments. You can upload at most 10 PDF files as attachments. :)
Version: 2.0.1
Author: AFO
Author URI: http://avifoujdar.wordpress.com/
*/

/**
	  |||||   
	<(`0_0`)> 	
	()(afo)()
	  ()-()
**/

include_once dirname( __FILE__ ) . '/pdf_attachment.php';
include_once dirname( __FILE__ ) . '/shortcode_function.php';

add_action('admin_menu', 'custom_pdf_attachment_plugin_menu');

function custom_pdf_attachment_plugin_menu() {  
  add_options_page( 'Custom Pdf Attachment', 'Custom PDF Attachment', 1, 'custom_pdf_attachment', 'custom_pdf_attachment_options');
}

function custom_pdf_attachment_options() {
global $wpdb;

$saved_types = get_option('saved_post_types_for_pdf_attachment');
$saved_no_of_pdf_attachment = get_option('saved_no_of_pdf_attachment');
?>

<table width="98%" border="0" style="background-color:#FFFFD2; border:1px solid #FFFF00;">
 <tr>
 <td align="right"><h3>Even $0.60 Can Make A Difference</h3></td>
    <td><form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
          <input type="hidden" name="cmd" value="_xclick">
          <input type="hidden" name="business" value="avifoujdar@gmail.com">
          <input type="hidden" name="item_name" value="Donation for plugins">
          <input type="hidden" name="currency_code" value="USD">
          <input type="hidden" name="amount" value="0.60">
          <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="Make a donation with PayPal">
        </form></td>
  </tr>
</table>
<form name="f" method="post" action="">
<input type="hidden" name="option" value="save_custom_pdf_attachment_settings" />
<table width="100%" border="0">
  <tr>
    <td><h1>Settings</h1></td>
  </tr>
  <tr>
    <td><strong>Select Post Types ( You want custom attachments )</strong></td>
  </tr>
  <tr>
    <td><?php
	$args = array(
   	'public'   => true,
	);
	$post_types = get_post_types( $args, 'names' ); 
	$post_types = array_diff($post_types, array('attachment'));
	foreach ( $post_types as $post_type ) {
		if(is_array($saved_types) and in_array($post_type,$saved_types)){
			echo '<p><input type="checkbox" name="attachment_post_types[]" value="'.$post_type.'" checked="checked" />&nbsp;'.$post_type.'</p>';
		} else{
			echo '<p><input type="checkbox" name="attachment_post_types[]" value="'.$post_type.'" />&nbsp;'.$post_type.'</p>';
		}
	}
	?></td>
  </tr>
  <tr>
    <td><strong>Number of attachment Files</strong></td>
  </tr>
  <tr>
    <td><?php	
		echo '<select name="no_of_pdf_attachment">';
			echo '<option value="">--</option>';
			for($i=1; $i<=10;$i++){
				if($saved_no_of_pdf_attachment == $i){
					echo '<option value="'.$i.'" selected="selected">'.$i.'</option>';
				} else {
					echo '<option value="'.$i.'">'.$i.'</option>';
				}
			}
		echo '</select>';
	?></td>
  </tr>
  
  <tr>
    <td><?php	
		if($saved_no_of_pdf_attachment > 0 and $saved_no_of_pdf_attachment <= 10){
			echo '<table width="100%" border="0">';
			for($i=1; $i<=$saved_no_of_pdf_attachment;$i++){
				echo '<tr>
					<td><strong>Shortcode :</strong> <span style="color:#FF0000">[pdf_attachment file="'.$i.'" name="optional file_name"]</span></td>
					<td><strong>Custom function :</strong> <span style="color:#FF0000">&lt;?php echo pdf_attachment_file('.$i.',"optional file_name");?&gt;</span></td>
				  </tr>';
			}
			echo '</table>';
		}
	?></td>
  </tr>
  
  <tr>
    <td><input type="submit" name="submit" value="Save" class="button button-primary button-large" /></td>
  </tr>
</table>
</form>
<?php 
} // end of function

function custom_pdf_attachment_post_date(){
	if($_POST['option'] == "save_custom_pdf_attachment_settings"){
		update_option( 'saved_post_types_for_pdf_attachment', $_POST['attachment_post_types'] );
		update_option( 'saved_no_of_pdf_attachment', $_POST['no_of_pdf_attachment'] );
	}
}

add_action( 'admin_init', 'custom_pdf_attachment_post_date' );

register_activation_hook(__FILE__,'plug_install_custom_pdf_attachment');
register_deactivation_hook(__FILE__,'plug_unins_custom_pdf_attachment');
function plug_install_custom_pdf_attachment(){}
function plug_unins_custom_pdf_attachment(){}
