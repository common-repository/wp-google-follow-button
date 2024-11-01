<?php /**
 * Plugin Name: Wp Viva Google Follow 
 * Plugin URI: http://vivacityinfotech.net
 * Description: A simple Google plus Follow Button plugin for your Website in your own language. 
 * Version: 1.0
 * Author: Vivacity Infotech Pvt. Ltd.
 * Author URI: http://vivacityinfotech.net
 * License: GPL2
* Text Domain: viva-follow-google
* Domain Path: /languages
*/
//ob_start();
//**************** getting field values of google follow button *****//
   	
$msg = "no";
if(isset($_REQUEST['submit'])) {
$user_url = $_REQUEST['g-plus-profile-url'];	
$bubble = $_REQUEST['bubble'];	
$size = $_REQUEST['size'];	
$lang = $_REQUEST['lang'];	

update_option('g-plus-profile-url',$user_url);
update_option('bubble',$bubble);
update_option('size',$size);
update_option('lang',$lang);

//$msg = __("Changes Saved", "viva-follow-google" );
$msg = "yes";
}
	//**************** getting field values of google badge button *****//
if(isset($_REQUEST['b_submit'])) {
$b_profile_url = $_REQUEST['b_profile_url'];	
$layout = $_REQUEST['layout'];	
$b_lang = $_REQUEST['b_lang'];	
$showtagline = $_REQUEST['showtagline'];	
$b_theme = $_REQUEST['b_theme'];	
$b_width = $_REQUEST['b_width'];	
$showcoverphoto = $_REQUEST['showcoverphoto'];

update_option('b_profile_url',$b_profile_url);
update_option('layout',$layout);
update_option('b_lang',$b_lang);
update_option('showtagline',$showtagline);
update_option('b_theme',$b_theme);
update_option('b_width',$b_width);
update_option('showcoverphoto',$showcoverphoto);

//$msg = __("Changes Saved", "viva-follow-google" );
$msg = "yes";
}	

	

add_shortcode( 'viva-google-follow', 'google_follow_shortcode' );
function google_follow_shortcode( $atts ){
         $user_url = get_option('g-plus-profile-url',true);	
         $bubble = get_option('bubble',true);
         $size = get_option('size',true);		
         $lang = get_option('lang',true);	
         
	$follow_button = "<script src='https://apis.google.com/js/platform.js' async defer></script>

<br><div class='g-follow' data-annotation='".$bubble."' data-height='".$size."' data-href='".$user_url."' 
data-rel='author'></div>
<script src='https://apis.google.com/js/platform.js' async defer>
  {lang: '".$lang."'}
</script>
";
return $follow_button;
}


add_shortcode( 'viva-google-badge-follow', 'google_follow_badge_shortcode1' );
function google_follow_badge_shortcode1( $atts ){
	
         $b_profile_url = get_option('b_profile_url',true);	
			$layout = get_option('layout',true);	
			$b_lang = get_option('b_lang',true);	
			$showtagline = get_option('showtagline',true);	
			$b_theme = get_option('b_theme',true);	
			$b_width = get_option('b_width',true);	
			$showcoverphoto = get_option('showcoverphoto',true);
         
	$follow_badge_button = "<!-- Place this tag in your head or just before your close body tag. -->
<script src='https://apis.google.com/js/platform.js' async defer></script>

<!-- Place this tag where you want the widget to render. -->
<br><div class='g-person' data-layout='".$layout."' data-showcoverphoto='".$showcoverphoto."' data-showtagline='".$showtagline."' 
data-theme='".$b_theme."' data-width='".$b_width."' data-href='".$b_profile_url."' data-rel='author'></div>
<script src='https://apis.google.com/js/platform.js' async defer>
  {lang: '".$b_lang."'}
</script>
";
return $follow_badge_button;
}




add_action('init', 'load_viva_transl_google');
function load_viva_transl_google()
   {
       load_plugin_textdomain('viva-follow-google', FALSE, dirname(plugin_basename(__FILE__)).'/languages/');
   }
   
 function viva_follow_call(){	
		add_submenu_page(
						'options-general.php', // the slud name of the parent menu
						'Google Plus Follow Setting', // menu title of the plugin
						'Google Plus Follow Setting', // menu text to be displayed on the menu option
						'administrator', // capabilities of the menu
						'viva-follow-google', // menu slud
						'viva_follow_google_gui'	 // function to be called.
					);
	}
add_action('admin_menu', 'viva_follow_call');


function viva_follow_google_gui() {
			$user_url = get_option('g-plus-profile-url','');	
			$getdata = get_option('select_custom_post_type');
         $bubble = get_option('bubble','bubble');
         $size = get_option('size','20');		
         $lang = get_option('lang','en');	
         

?>

<div class="google_container">
<?php 
if(isset($_GET['type'])){
$follow_type = $_GET['type'];
}
else{$follow_type = '';}

if($follow_type == 'button_follow' || $follow_type == ''){
?>
<div id="cssmenu">
<ul>
	<li class="active"><a href="<?php echo site_url() ?>/wp-admin/options-general.php?page=viva-follow-google&type=button_follow" class="active">
  <span><?php _e('Follow Button' , 'viva-follow-google'); ?></span></a></li>
	<li><span><a href="<?php echo site_url() ?>/wp-admin/options-general.php?page=viva-follow-google&type=badge_follow">
	<?php _e('Badge' , 'viva-follow-google'); ?></span></a></li>	
</ul>
</div>
  <?php
	}
	else{
?>
<div id="cssmenu">
<ul>
	<li><span><a href="<?php echo site_url() ?>/wp-admin/options-general.php?page=viva-follow-google&type=button_follow">
	<?php _e('Follow Button' , 'viva-follow-google');  ?></a></span></li>
	<li class="active"><span><a href="<?php echo site_url() ?>/wp-admin/options-general.php?page=viva-follow-google&type=badge_follow"
	 class="active">
	<?php _e('Badge' , 'viva-follow-google');  ?></span></a></li>	
</ul>
</div>

<?php
}
?>

<div class="wrapper">

<div class="left">
<div class="page_heading">
<h1 class="page_heading_text"><?php _e('WP Google Follow Button Settings' , 'viva-follow-google');  ?></h1>
</div>
<h4 style="color:green;"><?php 
global $msg;
 //printf('%s', $msg); 
if($msg=="yes"){
	_e('Changes Saved' , 'viva-follow-google');
	}
//sprintf(__('%s','viva-follow-google'),$msg);
//printf( __('%s','viva-follow-google'), $msg );
?>
</h4>
 <div id="result"></div>
<?php
if(isset($_GET['type'])){
$follow_type = $_GET['type'];
}
else{$follow_type = '';}
if($follow_type == 'button_follow' || $follow_type == ''){

?><form action="" method="post">
<?php
         $user_url = get_option('g-plus-profile-url','');	
         $bubble = get_option('bubble','bubble');
         $size = get_option('size','20');		
         $lang = get_option('lang', 'en');  
?>
<table>
		<tr>
				<td>
<?php _e('Google Plus Profile URL' , 'viva-follow-google');  ?>
				:</td>     
				
				<td> 
				     <input class="input_field" type="text" 
				     value="<?php echo $user_url; ?>" name="g-plus-profile-url"
				      placeholder="https://plus.google.com/u/0/xxxxxxxxxxxxxxxxxxxxx"> <br>
				</td>     
		</tr>    
	
		<tr>	
			<td>	
			<?php _e('Bubble options' , 'viva-follow-google');  ?>		:
	      </td>
	      <td>		
			 <select name="bubble" class="input_field">
								<option value="bubble" <?php if($bubble == 'bubble') { echo ' selected'; } ?>><?php _e('Horizontal Bubble' , 'viva-follow-google');  ?>
								</option>
								<option value="vertical-Bubble" <?php if($bubble == 'vertical-Bubble') { echo ' selected'; } ?>><?php _e('Vertical Bubble' , 'viva-follow-google');  ?></option>
								<option value="none" <?php if($bubble == 'none') { echo ' selected'; } ?>><?php _e('None' , 'viva-follow-google');  ?></option>
	
			</select><br>
			</td>	
		</tr>			
		
		<tr>
		<td>
	    <?php _e('Button Size' , 'viva-follow-google');  ?>	    :
      </td>	
      
      <td> 
     <select name="size" class="input_field">
					<option value="15" <?php if($size == '15') { echo ' selected'; } ?>><?php _e('Small' , 'viva-follow-google');  ?></option>
					<option value="20" <?php if($size == '20') { echo ' selected'; } ?>><?php _e('Medium' , 'viva-follow-google');  ?></option>
					<option value="24" <?php if($size == '24') { echo ' selected'; } ?>><?php _e('Large' , 'viva-follow-google');  ?></option>
           </select><br>
      </td>           
                 
      </tr>      
      
      <tr>     
      <td>
      	    <?php _e('Language' , 'viva-follow-google');  ?>
					: 
					
      </td>		
      <td>			
					<select name="lang" class="input_field">
											<option value="af"<?php if($lang == 'af') { echo ' selected'; } ?>>Afrikaans</option>
											<option value="am"<?php if($lang == 'am') { echo ' selected'; } ?>>Amharic - ‪አማርኛ‬'</option>
											<option value="ar"<?php if($lang == 'ar') { echo ' selected'; } ?>>Arabic - ‫العربية‬</option>
											<option value="eq"<?php if($lang == 'eq') { echo ' selected'; } ?>>Basque - ‪euskara‬</option>
											<option value="bn"<?php if($lang == 'bn') { echo ' selected'; } ?>>Bengali - ‪বাংলা‬'</option>
											<option value="bg"<?php if($lang == 'bg') { echo ' selected'; } ?>>Bulgarian - ‪български‬</option>
											<option value="ca"<?php if($lang == 'ca') { echo ' selected'; } ?>>Catalan - ‪català‬</option>
											<option value="zh-HK"<?php if($lang == 'zh-HK') { echo ' selected'; } ?>>Chinese (Hong Kong) - ‪中文（香港</option>
											<option value="zh-CN"<?php if($lang == 'zh-CN') { echo ' selected'; } ?>>Chinese (Simplified) - ‪简体中文‬</option>
											<option value="zh-TW"<?php if($lang == 'zh-TW') { echo ' selected'; } ?>>Chinese (Traditional) - ‪繁體中文‬</option>
											<option value="hr"<?php if($lang == 'hr') { echo ' selected'; } ?>>Croatian - ‪Hrvatski‬</option>
											<option value="cs"<?php if($lang == 'cs') { echo ' selected'; } ?>>Czech - ‪Čeština‬</option>
											<option value="da"<?php if($lang == 'da') { echo ' selected'; } ?>>Danish - ‪Dansk‬</option>
											<option value="ni"<?php if($lang == 'ni') { echo ' selected'; } ?>>Dutch - ‪Nederlands‬</option>
											<option value="en-GB"<?php if($lang == 'en-GB') { echo ' selected'; } ?>>English (United Kingdom)</option>
											<option value="en"<?php if($lang == 'en') { echo ' selected'; } ?>>English (USA)</option>
											<option value="et"<?php if($lang == 'et') { echo ' selected'; } ?>>Estonian - ‪eesti‬</option>
											<option value="fil"<?php if($lang == 'fil') { echo ' selected'; } ?>>Filipino</option>
											<option value="fi"<?php if($lang == 'fi') { echo ' selected'; } ?>>Finnish - ‪Suomi‬</option>
											<option value="fr-CA"<?php if($lang == 'fr-CA') { echo ' selected'; } ?>>French (Canada) - ‪Français (Canada)‬</option>
											<option value="fr"<?php if($lang == 'fr') { echo ' selected'; } ?>>French (France) - ‪Français (France)</option>
											<option value="gl"<?php if($lang == 'gl') { echo ' selected'; } ?>>Galician - ‪galego‬</option>
											<option value="de"<?php if($lang == 'de') { echo ' selected'; } ?>>German -Deutsch</option>
											<option value="el"<?php if($lang == 'el') { echo ' selected'; } ?>>Greek - ‪Ελληνικά‬</option>
											<option value="gu"<?php if($lang == 'gu') { echo ' selected'; } ?>>Gujarati - ‪ગુજરાતી‬</option>
											<option value="iw"<?php if($lang == 'iw') { echo ' selected'; } ?>>Hebrew - ‫עברית‬</option>
											<option value="hi"<?php if($lang == 'hi') { echo ' selected'; } ?>>Hindi - ‪हिन्दी</option>
											<option value="hu"<?php if($lang == 'hu') { echo ' selected'; } ?>>Hungarian - ‪magyar‬</option>
											<option value="is"<?php if($lang == 'is') { echo ' selected'; } ?>>Icelandic - ‪íslenska‬</option>
											<option value="id"<?php if($lang == 'id') { echo ' selected'; } ?>>Indonesian - ‪Bahasa Indonesia‬</option>
											<option value="it"<?php if($lang == 'it') { echo ' selected'; } ?>>Italian - ‪Italiano</option>
											<option value="ja"<?php if($lang == 'ja') { echo ' selected'; } ?>>Japanese - ‪日本語‬</option>
											<option value="kn"<?php if($lang == 'kn') { echo ' selected'; } ?>>Kannada - ‪ಕನ್ನಡ‬</option>
											<option value="ko"<?php if($lang == 'ko') { echo ' selected'; } ?>>Korean - ‪한국어</option>
											<option value="lv"<?php if($lang == 'lv') { echo ' selected'; } ?>>Latvian - ‪latviešu‬</option>
											<option value="lt"<?php if($lang == 'lt') { echo ' selected'; } ?>>Lithuanian - ‪lietuvių</option>
											<option value="ms"<?php if($lang == 'ms') { echo ' selected'; } ?>>Malay - ‪Bahasa Melayu‬</option>
											<option value="ml"<?php if($lang == 'ml') { echo ' selected'; } ?>>Malayalam - ‪മലയാളം‬‬</option>
											<option value="mr"<?php if($lang == 'mr') { echo ' selected'; } ?>>Marathi - ‪मराठी‬‬</option>
											<option value="no"<?php if($lang == 'no') { echo ' selected'; } ?>>Norwegian - ‪norsk‬</option>
											<option value="fa"<?php if($lang == 'fa') { echo ' selected'; } ?>>Persian - ‫فارسی‬‬</option>
											<option value="pl"<?php if($lang == 'pl') { echo ' selected'; } ?>>Polish - ‪polski‬‬</option>
											<option value="pt-PR"<?php if($lang == 'pt-PR') { echo ' selected'; } ?>>Portuguese (Brazil) - ‪Português (Brasil)‬‬‬</option>
											<option value="pt-PT"<?php if($lang == 'pt-PT') { echo ' selected'; } ?>>Portuguese (Portugal) - ‪Português (Portugal)</option>
											<option value="ro"<?php if($lang == 'ro') { echo ' selected'; } ?>>Romanian - ‪română‬</option>
											<option value="ru"<?php if($lang == 'ru') { echo ' selected'; } ?>>Russian - ‪Русский‬</option>
											<option value="sr"<?php if($lang == 'sr') { echo ' selected'; } ?>>Serbian - ‪Српски‬</option>
											<option value="sk"<?php if($lang == 'sk') { echo ' selected'; } ?>>Slovak - ‪Slovenčina‬‬</option>
											<option value="sl"<?php if($lang == 'sl') { echo ' selected'; } ?>>Slovenian - ‪slovenščina‬‬</option>
											<option value="es-419"<?php if($lang == 'es-419') { echo ' selected'; } ?>>Spanish (Latin America) - ‪Español (Latinoamérica)‬</option>
											<option value="es"<?php if($lang == 'es') { echo ' selected'; } ?>>Spanish (Spain) - ‪Español (España)</option>
											<option value="sw"<?php if($lang == 'sw') { echo ' selected'; } ?>>Swahili - ‪Kiswahili‬</option>
											<option value="sv"<?php if($lang == 'sv') { echo ' selected'; } ?>>Swedish - ‪Svenska‬</option>
											<option value="ta"<?php if($lang == 'ta') { echo ' selected'; } ?>>Tamil - ‪தமிழ்‬</option>
											<option value="te"<?php if($lang  == 'te') { echo ' selected'; } ?>>Telugu - ‪తెలుగు‬</option>
											<option value="th"<?php if($lang  == 'th') { echo ' selected'; } ?>>Thai - ‪ไทย‬</option>
											<option value="tr"<?php if($lang  == 'tr') { echo ' selected'; } ?>>Turkish - ‪Türkçe</option>
											<option value="uk"<?php if($lang  == 'uk') { echo ' selected'; } ?>>Ukrainian - ‪Українська</option>
											<option value="ur"<?php if($lang  == 'ur') { echo ' selected'; } ?>>Urdu - ‫اردو‬</option>
											<option value="vi"<?php if($lang  == 'vi') { echo ' selected'; } ?>>Vietnamese - ‪Tiếng Việt‬</option>
											<option value="zu"<?php if($lang  == 'zu') { echo ' selected'; } ?>>Zulu - ‪isiZulu‬</option>

										</select><br>
				</td>						
	</tr>					
	<tr>
		 <td>
<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Save Changes' , 'viva-follow-google');  ?>"  />
	   </td>          
   </tr>            
   
   </table>
   </form>
<?php 
}

if(isset($_GET['type'])){
$follow_type = $_GET['type'];
}
else{}

if($follow_type == 'badge_follow'){
$b_profile_url = get_option('b_profile_url','');	
	$layout = get_option('layout','landscape');	
		$b_lang = get_option('b_lang','en');	
		$showtagline = get_option('showtagline','true');	
		$b_theme = get_option('b_theme','dark');	
		$b_width = get_option('b_width','180');	
		$showcoverphoto = get_option('showcoverphoto','false');
 ?>
   <form action="" method="post">
<table>
		<tr>
				<td>
<?php _e('Google Plus Profile URL' , 'viva-follow-google');  ?>
				:</td>     
				
				<td> 
				     <input class="input_field" type="text" value="<?php echo $b_profile_url; ?>" name="b_profile_url" 
				     placeholder="https://plus.google.com/u/0/xxxxxxxxxxxxxxxxxxxxx"> <br>
				</td>     
		</tr>    
    	
		 <tr>
		<td>
	    <?php _e('Width' , 'viva-follow-google');  ?>
	    :
      </td>	
      
      <td> 
	  		<input class="input_field" type="text" value="<?php echo $b_width; ?>" name="b_width" placeholder="Badge Width"><br> 
<span>Note: You can take minimum width 180px and maximum width 450px </span>	  		
	  		<br>
               
      </td>           
                 
      </tr>
		<tr>	
			<td>	
			<?php _e('Layout' , 'viva-follow-google');  ?>
			:
	      </td>
	      <td>		
			 <select name="layout" class="input_field">
			               <option value="portrait" <?php if($layout == 'portrait') { echo ' selected'; } ?>><?php _e('Portrait' , 'viva-follow-google');  ?>
								</option>
								<option value="landscape" <?php if($layout == 'landscape') { echo ' selected'; } ?>><?php _e('landscape' , 'viva-follow-google');  ?></option>

          </select><br>
			</td>	
		</tr>			
		
		<tr>
		<td>
	    <?php _e('Show cover photo' , 'viva-follow-google');  ?>
	    :
      </td>	
      
      <td> 
	  <select name="showcoverphoto" class="input_field">
							<option value="true" <?php if($showcoverphoto == 'true') { echo ' selected'; } ?>><?php _e('True' , 'viva-follow-google');  ?></option>
							<option value="false" <?php if($showcoverphoto == 'false') { echo ' selected'; } ?>><?php _e('False' , 'viva-follow-google');  ?></option>
                 </select><br>
      </td>           
                 
      </tr>      
      
      <tr>     
      <td>
      	    <?php _e('Language' , 'viva-follow-google');  ?>
					: 
</td>		
      <td>			
					<select name="b_lang" class="input_field">
											<option value="af"<?php if($lang == 'af') { echo ' selected'; } ?>>Afrikaans</option>
											<option value="am"<?php if($lang == 'am') { echo ' selected'; } ?>>Amharic - ‪አማርኛ‬'</option>
											<option value="ar"<?php if($lang == 'ar') { echo ' selected'; } ?>>Arabic - ‫العربية‬</option>
											<option value="eq"<?php if($lang == 'eq') { echo ' selected'; } ?>>Basque - ‪euskara‬</option>
											<option value="bn"<?php if($lang == 'bn') { echo ' selected'; } ?>>Bengali - ‪বাংলা‬'</option>
											<option value="bg"<?php if($lang == 'bg') { echo ' selected'; } ?>>Bulgarian - ‪български‬</option>
											<option value="ca"<?php if($lang == 'ca') { echo ' selected'; } ?>>Catalan - ‪català‬</option>
											<option value="zh-HK"<?php if($lang == 'zh-HK') { echo ' selected'; } ?>>Chinese (Hong Kong) - ‪中文（香港</option>
											<option value="zh-CN"<?php if($lang == 'zh-CN') { echo ' selected'; } ?>>Chinese (Simplified) - ‪简体中文‬</option>
											<option value="zh-TW"<?php if($lang == 'zh-TW') { echo ' selected'; } ?>>Chinese (Traditional) - ‪繁體中文‬</option>
											<option value="hr"<?php if($lang == 'hr') { echo ' selected'; } ?>>Croatian - ‪Hrvatski‬</option>
											<option value="cs"<?php if($lang == 'cs') { echo ' selected'; } ?>>Czech - ‪Čeština‬</option>
											<option value="da"<?php if($lang == 'da') { echo ' selected'; } ?>>Danish - ‪Dansk‬</option>
											<option value="ni"<?php if($lang == 'ni') { echo ' selected'; } ?>>Dutch - ‪Nederlands‬</option>
											<option value="en-GB"<?php if($lang == 'en-GB') { echo ' selected'; } ?>>English (United Kingdom)</option>
											<option value="en"<?php if($lang == 'en') { echo ' selected'; } ?>>English (USA)</option>
											<option value="et"<?php if($lang == 'et') { echo ' selected'; } ?>>Estonian - ‪eesti‬</option>
											<option value="fil"<?php if($lang == 'fil') { echo ' selected'; } ?>>Filipino</option>
											<option value="fi"<?php if($lang == 'fi') { echo ' selected'; } ?>>Finnish - ‪Suomi‬</option>
											<option value="fr-CA"<?php if($lang == 'fr-CA') { echo ' selected'; } ?>>French (Canada) - ‪Français (Canada)‬</option>
											<option value="fr"<?php if($lang == 'fr') { echo ' selected'; } ?>>French (France) - ‪Français (France)</option>
											<option value="gl"<?php if($lang == 'gl') { echo ' selected'; } ?>>Galician - ‪galego‬</option>
											<option value="de"<?php if($lang == 'de') { echo ' selected'; } ?>>German -Deutsch</option>
											<option value="el"<?php if($lang == 'el') { echo ' selected'; } ?>>Greek - ‪Ελληνικά‬</option>
											<option value="gu"<?php if($lang == 'gu') { echo ' selected'; } ?>>Gujarati - ‪ગુજરાતી‬</option>
											<option value="iw"<?php if($lang == 'iw') { echo ' selected'; } ?>>Hebrew - ‫עברית‬</option>
											<option value="hi"<?php if($lang == 'hi') { echo ' selected'; } ?>>Hindi - ‪हिन्दी</option>
											<option value="hu"<?php if($lang == 'hu') { echo ' selected'; } ?>>Hungarian - ‪magyar‬</option>
											<option value="is"<?php if($lang == 'is') { echo ' selected'; } ?>>Icelandic - ‪íslenska‬</option>
											<option value="id"<?php if($lang == 'id') { echo ' selected'; } ?>>Indonesian - ‪Bahasa Indonesia‬</option>
											<option value="it"<?php if($lang == 'it') { echo ' selected'; } ?>>Italian - ‪Italiano</option>
											<option value="ja"<?php if($lang == 'ja') { echo ' selected'; } ?>>Japanese - ‪日本語‬</option>
											<option value="kn"<?php if($lang == 'kn') { echo ' selected'; } ?>>Kannada - ‪ಕನ್ನಡ‬</option>
											<option value="ko"<?php if($lang == 'ko') { echo ' selected'; } ?>>Korean - ‪한국어</option>
											<option value="lv"<?php if($lang == 'lv') { echo ' selected'; } ?>>Latvian - ‪latviešu‬</option>
											<option value="lt"<?php if($lang == 'lt') { echo ' selected'; } ?>>Lithuanian - ‪lietuvių</option>
											<option value="ms"<?php if($lang == 'ms') { echo ' selected'; } ?>>Malay - ‪Bahasa Melayu‬</option>
											<option value="ml"<?php if($lang == 'ml') { echo ' selected'; } ?>>Malayalam - ‪മലയാളം‬‬</option>
											<option value="mr"<?php if($lang == 'mr') { echo ' selected'; } ?>>Marathi - ‪मराठी‬‬</option>
											<option value="no"<?php if($lang == 'no') { echo ' selected'; } ?>>Norwegian - ‪norsk‬</option>
											<option value="fa"<?php if($lang == 'fa') { echo ' selected'; } ?>>Persian - ‫فارسی‬‬</option>
											<option value="pl"<?php if($lang == 'pl') { echo ' selected'; } ?>>Polish - ‪polski‬‬</option>
											<option value="pt-PR"<?php if($lang == 'pt-PR') { echo ' selected'; } ?>>Portuguese (Brazil) - ‪Português (Brasil)‬‬‬</option>
											<option value="pt-PT"<?php if($lang == 'pt-PT') { echo ' selected'; } ?>>Portuguese (Portugal) - ‪Português (Portugal)</option>
											<option value="ro"<?php if($lang == 'ro') { echo ' selected'; } ?>>Romanian - ‪română‬</option>
											<option value="ru"<?php if($lang == 'ru') { echo ' selected'; } ?>>Russian - ‪Русский‬</option>
											<option value="sr"<?php if($lang == 'sr') { echo ' selected'; } ?>>Serbian - ‪Српски‬</option>
											<option value="sk"<?php if($lang == 'sk') { echo ' selected'; } ?>>Slovak - ‪Slovenčina‬‬</option>
											<option value="sl"<?php if($lang == 'sl') { echo ' selected'; } ?>>Slovenian - ‪slovenščina‬‬</option>
											<option value="es-419"<?php if($lang == 'es-419') { echo ' selected'; } ?>>Spanish (Latin America) - ‪Español (Latinoamérica)‬</option>
											<option value="es"<?php if($lang == 'es') { echo ' selected'; } ?>>Spanish (Spain) - ‪Español (España)</option>
											<option value="sw"<?php if($lang == 'sw') { echo ' selected'; } ?>>Swahili - ‪Kiswahili‬</option>
											<option value="sv"<?php if($lang == 'sv') { echo ' selected'; } ?>>Swedish - ‪Svenska‬</option>
											<option value="ta"<?php if($lang == 'ta') { echo ' selected'; } ?>>Tamil - ‪தமிழ்‬</option>
											<option value="te"<?php if($lang  == 'te') { echo ' selected'; } ?>>Telugu - ‪తెలుగు‬</option>
											<option value="th"<?php if($lang  == 'th') { echo ' selected'; } ?>>Thai - ‪ไทย‬</option>
											<option value="tr"<?php if($lang  == 'tr') { echo ' selected'; } ?>>Turkish - ‪Türkçe</option>
											<option value="uk"<?php if($lang  == 'uk') { echo ' selected'; } ?>>Ukrainian - ‪Українська</option>
											<option value="ur"<?php if($lang  == 'ur') { echo ' selected'; } ?>>Urdu - ‫اردو‬</option>
											<option value="vi"<?php if($lang  == 'vi') { echo ' selected'; } ?>>Vietnamese - ‪Tiếng Việt‬</option>
											<option value="zu"<?php if($lang  == 'zu') { echo ' selected'; } ?>>Zulu - ‪isiZulu‬</option>

										</select><br>
				</td>						
	</tr>
	<tr>
		<td>
	    <?php _e('Show Tagline' , 'viva-follow-google');  ?>
	    :
      </td>	
      
      <td> 
	  <select name="showtagline" class="input_field">
							<option value="true" <?php if($showtagline == 'true') { echo ' selected'; } ?>><?php _e('True' , 'viva-follow-google');  ?></option>
							<option value="false" <?php if($showtagline == 'false') { echo ' selected'; } ?>><?php _e('False' , 'viva-follow-google');  ?></option>
                 </select><br>
      </td>           
                 
      </tr>
        
      <tr>
		<td>
	    <?php _e('Theme' , 'viva-follow-google');  ?>
	    :
      </td>	
      
      <td> 
	  <select name="b_theme" class="input_field">
							<option value="light" <?php if($b_theme == 'light') { echo ' selected'; } ?>><?php _e('Light' , 'viva-follow-google');  ?></option>
							<option value="dark" <?php if($b_theme == 'dark') { echo ' selected'; } ?>><?php _e('Dark' , 'viva-follow-google');  ?></option>
                 </select><br>
      </td>           
                 
      </tr> 

         
      					
	<tr>
		 <td>
<input type="submit" name="b_submit" id="submit" class="button button-primary" value="<?php _e('Save Changes' , 'viva-follow-google');  ?>"  />
	   </td>          
   </tr>            
   
   </table>
   </form>
<?php } ?>
</div>

   <!-- ******* promotion ****** -->
    
   <div class="right">
                                <center>
                                    <div class="bottom">
                                    <div class="title" >
                                        <h3 id="download-comments-wvpd" style="text-align:justify"><?php _e('Download Free Plugins', 'viva-follow-google'); ?></h3>
                                       </div>
                                        <div id="downloadtbl-comments-wvpd" class="togglediv"  style="text-align: justify;">  
                                                                                
                                            <h3 class="company">
                                          <p><?php _e('Vivacity InfoTech Pvt. Ltd. is an ISO 9001:2008 Certified Company is a Global IT Services company with expertise in outsourced product development and custom software development with focusing on software development, IT consulting, customized development.We have 200+ satisfied clients worldwide.', 'viva-follow-google') ?></p>	
                                          <div class="title" >                                                
                                                <?php _e('Our Top 5 Latest Plugins', 'viva-follow-google'); ?>
                                              </div>   
                                            </h3>
                                            
                                            <ul class="">
                                                <li><a target="_blank" href="https://wordpress.org/plugins/woocommerce-social-buttons/"><?php _e("Woocommerce Social Buttons", 'viva-follow-google'); ?></a></li>
                                                <li><a target="_blank" href="https://wordpress.org/plugins/vi-random-posts-widget/"><?php _e("Vi Random Post Widget", 'viva-follow-google'); ?></a></li>
                                                <li><a target="_blank" href="http://wordpress.org/plugins/wp-infinite-scroll-posts/"></a><?php _e("WP EasyScroll Posts", 'viva-follow-google'); ?></li>
                                                <li><a target="_blank" href="https://wordpress.org/plugins/buddypress-social-icons/"><?php _e("BuddyPress Social Icons", 'viva-follow-google'); ?></a></li>
                                                <li><a target="_blank" href="http://wordpress.org/plugins/wp-fb-share-like-button/"><?php _e("WP Facebook Like Button", 'viva-follow-google'); ?></a></li>
                                            </ul>
                                        </div> 
                                    </div>		
                                    <div class="bottom">
                                     
                                        <h3 id="donatehere-comments-wvpd" class="title" style="text-align:justify"><?php _e('Donate Here', 'viva-follow-google'); ?></h3>
                                                                         
                                        <div id="donateheretbl-comments-wvpd" class="togglediv">  
                                            <p><?php _e('If you want to donate , please click on below image.', 'viva-follow-google'); ?></p>
                                            <a href="http://bit.ly/1icl56K" target="_blank"><img class="donate" src="<?php echo plugins_url('assets/paypal.gif', __FILE__); ?>" width="" height="" title="<?php _e('Donate Here', 'viva-follow-google'); ?>"></a>		
                                        </div> 
                                    </div>	
                                    <div class="bottom">
                                     <div class="title1" >
                                        <h3 id="donatehere-comments-wvpd"  style="text-align:justify"><?php _e('Woocommerce Frontend Plugin', 'viva-follow-google'); ?></h3>
                                     </div>                                        
                                        <div id="donateheretbl-comments-wvpd" class="togglediv">  
                                            <p><?php _e('If you want to purchase , please click on below image.', 'viva-follow-google'); ?></p>
                                            <a href="http://bit.ly/1HZGRBg" target="_blank"><img class="donate" src="<?php echo plugins_url('assets/woo_frontend_banner.png', __FILE__); ?>" width="" height="" title="<?php _e('Donate Here', 'viva-follow-google'); ?>"></a>		
                                        </div> 
                                    </div>
                                    <div class="bottom">
                                     <div class="title" >
                                        <h3 id="donatehere-comments-wvpd"  style="text-align:justify"><?php _e('Blue Frog Template', 'viva-follow-google'); ?></h3>
                                      </div>                                        
                                        <div id="donateheretbl-comments-wvpd" class="togglediv">  
                                            <p><?php _e('If you want to purchase , please click on below image.', 'viva-follow-google'); ?></p>
                                            <a href="http://bit.ly/1Gwp4Vv" target="_blank"><img class="donate" src="<?php echo plugins_url('assets/blue_frog_banner.png', __FILE__); ?>" width="" height="" title="<?php _e('Donate Here', 'viva-follow-google'); ?>"></a>		
                                        </div> 
                                    </div>
                                </center>
                            </div>
                           
   </div>
   <div class="clear"></div>
   </div>
   
<?php	
}

$plugin_url = plugin_dir_url(__FILE__);
 function viva_google_follow() 
     {
         wp_register_style('follow', plugins_url('css/googlestyle.css',__FILE__));
        wp_enqueue_style('follow');        
        wp_register_script('follow1', plugins_url('js/script.js',__FILE__));
        wp_enqueue_script('follow1');
     }				
add_action('admin_init', 'viva_google_follow');
  
  
      
class wpb_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'wpb_widget', 

// Widget name will appear in UI
__('Google plus follow Widget', 'wpb_widget_domain'), 

// Widget description
array( 'description' => __( 'Sample widget based on Google plus follow button', 'wpb_widget_domain' ), ) 
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
$user_url = get_option('g-plus-profile-url',true);	

$bubble = get_option('bubble',true);
$size = get_option('size',true);		
$lang = get_option('lang',true);		
$title = apply_filters( 'widget_title', $instance['title'] );
// before and after widget arguments are defined by themes
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];

// This is where you run the code and display the output
echo "<script src='https://apis.google.com/js/platform.js' async defer></script>

<br><div class='g-follow' data-annotation='".$bubble."' data-height='".$size."' data-href='".$user_url."' 
data-rel='author'></div>
<script src='https://apis.google.com/js/platform.js' async defer>
  {lang: '".$lang."'}
</script>";

echo $args['after_widget'];
}
		
// Widget Backend 
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'New title', 'wpb_widget_domain' );
}
// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<?php 
}
	
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
return $instance;
}
} // Class wpb_widget ends here

// Register and load the widget
function wpb_load_widget() {
	register_widget( 'wpb_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );
//*********** google follow badge button widget*********//

class bwpb_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'bwpb_widget', 

// Widget name will appear in UI
__('Google plus follow badge Widget', 'bwpb_widget_domain'), 

// Widget description
array( 'description' => __( 'Sample widget based on Google plus follow badge button', 'bwpb_widget_domain' ), ) 
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $bargs, $binstance ) {
      $b_profile_url = get_option('b_profile_url',true);	
	   $layout = get_option('layout',true);	
		$b_lang = get_option('b_lang',true);	
		$showtagline = get_option('showtagline',true);	
		$b_theme = get_option('b_theme',true);	
		$b_width = get_option('b_width',true);	
		$showcoverphoto = get_option('showcoverphoto',true);
				
$btitle = apply_filters( 'widget_title', $binstance['title'] );
// before and after widget arguments are defined by themes
echo $bargs['before_widget'];
if ( ! empty( $btitle ) )
echo $bargs['before_title'] . $btitle . $bargs['after_title'];

// This is where you run the code and display the output
echo "<!-- Place this tag in your head or just before your close body tag. -->
<script src='https://apis.google.com/js/platform.js' async defer></script>

<!-- Place this tag where you want the widget to render. -->
<div class='g-person' data-layout='".$layout."' data-showcoverphoto='".$showcoverphoto."' data-showtagline='".$showtagline."' 
data-theme='".$b_theme."' data-width='".$b_width."' data-href='".$b_profile_url."' data-rel='author'></div>
<script src='https://apis.google.com/js/platform.js' async defer>
  {lang: '".$b_lang."'}
</script>";

echo $bargs['after_widget'];
}
		
// Widget Backend 
public function form( $binstance ) {
if ( isset( $binstance[ 'title' ] ) ) {
$btitle = $binstance[ 'title' ];
}
else {
$btitle = __( 'New title', 'bwpb_widget_domain' );
}
// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $btitle ); ?>" />
</p>
<?php }
	
// Updating widget replacing old instances with new
public function update( $bnew_instance, $bold_instance ) {
$binstance = array();
$binstance['title'] = ( ! empty( $bnew_instance['title'] ) ) ? strip_tags( $bnew_instance['title'] ) : '';
return $binstance;
}
} // Class wpb_widget ends here

// Register and load the widget
add_action( 'widgets_init', 'bwpb_load_widget' );
function bwpb_load_widget() {
	register_widget( 'bwpb_widget' );
}