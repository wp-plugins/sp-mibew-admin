<?php
/*
Plugin Name: Smarty Pants Mibew Admin
Plugin URI: http://smartypantsplugins.com/
Description: A WordPress plug-in that allows you to embed your mibew control panel into wordpress.
Author: Smarty
Version: 1.0.0
Author URI: http://smartypantsplugins.com
*/

global $sp_ma;
$sp_ma = "1.0.0";



add_action('admin_menu', 'sp_ma_menu');



function sp_ma_init() {
	wp_enqueue_script('jquery');
}

function sp_ma_css(){
	
}

add_action('wp_head', 'sp_ma_css');	
add_action('init', 'sp_ma_init');



function sp_ma_install() {
   global $wpdb;
   global $sp_ma;


   require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

  
   update_option("sp_ma_version", $sp_ma);



}
register_activation_hook(__FILE__,'sp_ma_install');



function sp_ma_menu() {


      add_menu_page( 'sp_ma', 'Mibew Admin',  'manage_options', 'sp_ma', 'sp_ma_mibew' , get_bloginfo('wpurl').'/wp-content/plugins/sp-mibew-admin/icon.png' );
	  add_submenu_page( 'sp_ma', 'Settings', 'Settings', 'manage_options', 'sp_ma_settings', 'sp_ma_settings');
		  
		 
	
		 
}

function sp_ma_mibew(){
	global $wpdb;
	
	if(get_option('sp_ma_url') == '' or  get_option('sp_ma_user') == '' or get_option('sp_ma_password') == ''){
		
	echo '<p style="font-size:1.5em;color:Red">Error, <a href="admin.php?page=sp_ma_settings">please click here</a> to go to the mibew admin settings page to configure your mibew settings!</p>';	
	}else{
		echo'
		
				<script type="text/javascript">
		jQuery(document).ready(function() {
		document.forms["smallLogin"].submit();
		jQuery("#show_mibew").show();
		 
	
		});
		</script>
		
		<form id="smallLogin" action="'.stripslashes(get_option('sp_ma_url')).'operator/login.php" target="mibew_admin" method="post" name="smallLogin">
			<input type="hidden" name="login" value="'.stripslashes(get_option('sp_ma_user')).'"> 	<input type="hidden" name="password" value="'.stripslashes(get_option('sp_ma_password')).'"> 
			</form>
			<div style="height:2000px;width:100%" id="show_mibew"><iframe src="'.stripslashes(get_option('sp_ma_url')).'operator/login.php" frameborder="0" scrolling="auto" height="2000" width="100%" name="mibew_admin"></iframe></div>
			';
	}
	
}
function sp_ma_settings(){
		global $wpdb;
	echo '<h1>Mibew Admin settings</h1>';
	
	
	if($_GET['sp_ma_save_options'] == 1){
	
		
		update_option( 'sp_ma_url',esc_html($_POST['sp_ma_url']) ); 
		update_option( 'sp_ma_user',esc_html($_POST['sp_ma_user']) ); 
		update_option( 'sp_ma_password',esc_html($_POST['sp_ma_password']) ); 
			
	}
		echo '

		<p>Please fill out settings below. Settings are saved and your will automaticly be logged into mibew when you click on the "Mibew Admin" Link. We are not affiliated with Mibew but chose to write those plugin for a nice and easy hook into the open source live chat software.  </p>
		<div style="padding:10px">
		
		
		<a href="http://mibew.org/" class="button" target="_blank">Download Mibew live Chat!</a>  
		<a href="http://www.smartypantsplugins.com" class="button" target="_blank">View Our Plugins</a> <a href="http://www.smartypantsplugins.com/donate/" class="button" target="_blank">Donate to Smarty</a> <a href="http://www.smartypantsplugins.com/contact/" class="button" target="_blank">Get Support</a>
		</div>
		<form action="admin.php?page=sp_ma_settings&sp_ma_save_options=1" method="post" >
	 <table class="wp-list-table widefat fixed posts" cellspacing="0">
  
   

      <tr>
    <td width="300"><strong>Mibew URL</strong><br><em>Full absolute URL for your mibew installation folder with trailing slash! ex: http://www.example.com/mibew/</em></td>
    <td><input type="text" name="sp_ma_url"  value="'.stripslashes(get_option('sp_ma_url')).'"  size=80"> </td>
  </tr>
        <tr>
    <td width="300"><strong>Mibew Admin Username</strong><br><em>Admin username for your mibew installation</em></td>
    <td><input type="text" name="sp_ma_user"  value="'.stripslashes(get_option('sp_ma_user')).'"  size=80"> </td>
  </tr>
          <tr>
    <td width="300"><strong>Mibew Admin Password</strong><br><em>Admin password for your mibew installation</em></td>
    <td><input type="password" name="sp_ma_password"  value="'.stripslashes(get_option('sp_ma_password')).'"  size=80"> </td>
  </tr>
   <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="save_options" value="Save Options"></td>
  </tr>
</table>
</form>
  ';		

			
	
}
?>