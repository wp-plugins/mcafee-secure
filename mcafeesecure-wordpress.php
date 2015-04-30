<?php
/**
 * ------------------------------------------------------------------------------------------------------------------
 * @package mcafeesecure
 * @version 1.0
 * Plugin Name: McAfee SECURE
 * Plugin URI: https://www.mcafeesecure.com/
 * Description: McAfee SECURE displays the trustmark on your website, increasing visitor confidence and conversion rates.
 * Author: McAfeeSECURE
 * Version: 1.0
 * Author URI: https://www.mcafeesecure.com/
 * ------------------------------------------------------------------------------------------------------------------
*/
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Core Functions
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function mcafeesecure_register_options_page() {
   add_options_page('McAfee SECURE Settings', 'McAfee SECURE', 'manage_options', 'mcafeesecure-options', 'mcafeesecure_options_page');
}
add_action('admin_menu', 'mcafeesecure_register_options_page');
function mcafeesecure_add_action_links($links) {
   $links[] = '<a href="'. get_admin_url(null, 'options-general.php?page=mcafeesecure-options') .'">Settings</a>';
   //$links[] = '<a href="https://www.mcafeesecure.com/user/" target="_blank">Account</a>';
   return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'mcafeesecure_add_action_links' );

wp_enqueue_style('mcafeesecure_css',plugins_url('/assets/common.css',__FILE__),array(),'1.0',false);
wp_enqueue_script('mcafeesecure_js',plugins_url('/assets/common.js',__FILE__),array('jquery'),'1.0',false);


register_deactivation_hook( __FILE__, 'mcafeesecure_deactivate' );
function mcafeesecure_deactivate() {
   delete_option("mcafeesecure_active");
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Run on every page load
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
add_action('wp_footer', 'mcafeesecure_inject_code');
function mcafeesecure_inject_code() {

echo "
<script type=\"text/javascript\">
  (function() {
    var sa = document.createElement('script'); sa.type = 'text/javascript'; sa.async = true;
    sa.src = ('https:' == document.location.protocol ? 'https://cdn' : 'http://cdn') + '.ywxi.net/js/1.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(sa, s);
  })();
</script>
";
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// HTML for Settings Page
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function mcafeesecure_admin_notice() {
   if($_GET["page"] == "mcafeesecure-options") return;
?>
<div class="error">
<p>Complete McAfee SECURE Setup.  <a href="options-general.php?page=mcafeesecure-options">Click here.</a></p>
</div>
<?php
}
if(!get_option("mcafeesecure_active")) {
   add_action( 'admin_notices', 'mcafeesecure_admin_notice' );
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// HTML for Settings Page
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function mcafeesecure_options_page() {
   $arrHost = parse_url(home_url($path,$scheme = http));
   $host = $arrHost['host'];
   $email = get_userdata(get_current_user_id())->user_email;
   $partner = 'wp-generic';
   $affiliate = '221269'; //Change to your affiliateId
   $assets = WP_PLUGIN_URL . '/mcafeesecure-wordpressplugin/assets/';
   if($_GET["active"] == 1) update_option("mcafeesecure_active","1");
?>
<div class="wrap">
<h2>McAfee SECURE</h2>
<div id="mcafeesecure" data-host="<?php echo $host ?>"></div>

<div id="mfes-loading">
<h3 class="title">Loading Account</h3>
<p><img src="<?php echo $assets ?>loader.gif"></p>
</div>

<div id="mfes-secure" style="display:none;">
<h3 class="title">Security Certification</h3>
<p><img src="<?php echo $assets ?>icon-secure.png" width="16" height="16">&nbsp; All tests passed! Your website is certified SECURE.</p>
</div>

<div id="mfes-notsecure" style="display:none;">
<h3 class="title">Security Certification</h3>
<p><img src="<?php echo $assets ?>icon-notsecure.png" width="16" height="16">&nbsp; Security issues found.  Please access your account for details.</p>
</div>

<div id="mfes-overlimit" style="display:none;">
<h3 class="title">Security Certification</h3>
<p><img src="<?php echo $assets ?>icon-notsecure.png" width="16" height="16">&nbsp; Exceeded service level.  Please access your account for details.</p>
</div>

<div id="mfes-login" style="display:none;">
<h3 class="title">Manage Account</h3>
<p>Login to your McAfee SECURE account for additional options and information.</p>
<form action="https://www.mcafeesecure.com/app/wordpress/login" method="post" target="_blank">
<input type="hidden" name="aff" value="<?php echo $affiliate ?>">
<input type="hidden" name="host" value="<?php echo $host ?>">
<input type="hidden" name="partner" value="<?php echo $partner ?>">
<input type="hidden" name="source" value="wordpress">
<input type="submit" name="submit" class="button button-primary" value="Login Now">
</form>
</div>

<div id="mfes-signup" style="display:none;">
<h3 class="title">Active Account</h3>
<p>To active your account, simply enter your email address and website URL.</p>
<form action="https://www.mcafeesecure.com/app/wordpress/signup" method="post" target="_blank">
<input type="hidden" name="aff" value="<?php echo $affiliate ?>">
<input type="hidden" name="partner" value="<?php echo $partner ?>">
<input type="hidden" name="source" value="wordpress">
<table class="form-table">
 <tr>
  <th><label for="signup_email">Email Address</label></th>
  <td><input name="email" id="signup_email" type="text" value="<?php echo $email ?>" class="regular-text code" placeholder="yourname@example.com"></td>
 </tr>
 <tr>
  <th><label for="signup_url">Website URL</label></th>
  <td><input name="host" id="signup_url" type="text" value="<?php echo $host ?>" class="regular-text code" placeholder="www.example.com"></td>
 </tr>
</table>
<p><input type="submit" name="submit" class="button button-primary" value="Get Started"></p>
</form>

<div id="pitch">
<div class="pitch-content">
<div class="pitch-title">Join the SECURE web.<br>Increase your <b>conversions</b>.</div>
<div class="pitch-text">
Every conversion starts with trust. Our service eases visitor doubts by letting them know your site is part of the SECURE web. With McAfee SECURE Lite, your first 500 monthly visitors will see the trustmark and know they're on a safe site. The best part is, McAfee SECURE Lite is <b>completely free</b>. 
<br><br>
<a href="https://www.mcafeesecure.com/?utm_source=wordpress-plugin">Learn More &raquo;</a>
</div>
</div>
</div>

</div>



</div>
<?php
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
