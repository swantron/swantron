<?php
add_action('admin_menu', 'swiz_headers1');
add_action('admin_head', 'swiz_headers2');
?>
<?php
function swiz_headers1(){
	if ( $_GET['page'] == "swiz-options"||$_GET['page'] == "swiz-design-options" ){
		wp_enqueue_script('jquery' ); 
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-tabs');
		wp_enqueue_script('jquery-ui-sortable');
	}
}
?>
<?php 
function swiz_headers2(){ 
if ( $_GET['page'] == "swiz-options"||$_GET['page'] == "swiz-design-options" ):
?>
<script type="text/javascript">
	jQuery(function() {
	jQuery(".tabmenu").removeClass("hidden");
	jQuery(".tabs h2").addClass("hidden");
	jQuery(".tabs").tabs();
	});
</script> 
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url')?>/admin/admin-styles.css" media="screen" />	
<?php endif;
if ($_GET['page'] == "swiz-design-options" ):
?>
	<script language="javascript" type="text/javascript" src="<?php bloginfo('template_url')?>/admin/jscolor/jscolor.js"></script> 
<?php endif; 
}//end of fucntion ?>
<?php
add_action('admin_menu', 'swiz_themes_menu');

function swiz_themes_menu() {
add_menu_page('Swiz Theme Options', 'Swiz Options', '10', 'swiz-options', 'swizOptions','http://swantron.com/favicon.ico',62);
add_submenu_page( 'swiz-options', 'Design Options', 'Design Options', '10', 'swiz-design-options', 'swizDesignOptions');
}

function swizOptions() {
 include(ADMIN.'/swiz-options.php');
}
function swizDesignOptions() {
 include(ADMIN.'/swiz-design-options.php');
}

function resetSwizOptions(){
	if( 'Reset' == $_POST['general-reset'] || 'Reset' == $_POST['design-reset'] ) {
	global $swiz_design_options;
	global $swiz_options;
	if('Reset' == $_POST['general-reset']) $options=$swiz_options;
	else  $options=$swiz_design_options;
            foreach ($options as $value) {
 				delete_option($value['id']);
				update_option($value['id'],$value['std']);	 
				}
				create_style_sheet();
			}
}

function first_run_options() {

  if ( get_option('swiz_activation_check')!="set" ) {
    // DO INITIALISATION STUFF
	//if (!is_dir(U_DIR)) $make = @mkdir(U_DIR,0777);
	
	$filename = U_DIR.'/swiz_default.jpg';
		if (!file_exists($filename)):
			$file = TEMPLATEPATH.'/images/default.jpg';
			copy($file, $filename);
		endif;
		
		//Creates the timthumb cache folder
		$swiz_custom=U_DIR.'/swiz_custom';
		$cache= $swiz_custom.'/cache';
		if (!is_dir($swiz_custom)) $make = @mkdir($swiz_custom,0777);
		if (!is_dir($cache)) $make = @mkdir($cache,0777);
		
		
		//Copy the timthumb.php script
		$final=U_DIR. '/swiz_custom/timthumb.php';//timthumb.php will be copied to uploads/swiz-custom
		$fp=fopen($final,'w');
		$base=TEMPLATEPATH.'/includes/timthumb.php';
		$fh0=fopen($base,'r');	
		$data.= fread($fh0, filesize($base));
		fwrite($fp,$data);
		
		//Copy the custom-style.css
		$final_style=U_DIR. '/swiz_custom/custom-style.css';
		$fp1=fopen($final_style,'w');
		$base_style=TEMPLATEPATH.'/includes/custom-style.css';
		$fh1=fopen($base_style,'r');	
		$data2.= fread($fh1, filesize($base_style));
		fwrite($fp1,$data2);
		
    // Add marker so it doesn't run in future
    update_option('swiz_activation_check', "set");
  }
  
  if(!get_option('swiz_random')){
	global $swiz_design_options;
	global $swiz_options;	
	foreach ($swiz_options as $value) {
 				delete_option($value['id']);
				update_option($value['id'],$value['std']);	 
				}
	foreach ($swiz_design_options as $value) {
 				delete_option($value['id']);
				update_option($value['id'],$value['std']);	 
				}
	 }
}


function delete_stuff() {
  delete_option('swiz_activation_check');
} 
?>
