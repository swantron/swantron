<?php

// Directory constants
define('INCLUDES', TEMPLATEPATH . '/includes');
define('ADMIN', TEMPLATEPATH . '/admin');
define('WIDGETS', TEMPLATEPATH . '/widgets');
define('FUNCTIONS', TEMPLATEPATH . '/functions');
define('LAYOUTS', TEMPLATEPATH . '/layouts');

$wud = wp_upload_dir();
define('U_DIR', $wud['basedir']);
define('U_URL', $wud['baseurl']);


require_once (INCLUDES . '/sidebar-init.php'); // Initializes the sidebars
require_once (INCLUDES . '/navigation.php');
require_once (INCLUDES . '/thumb.php');
require_once (INCLUDES . '/wp-pagenavi.php');

require_once (ADMIN. '/admin-core.php');
require_once (ADMIN. '/admin-header.php');
require_once (ADMIN. '/swiz-options-init.php');
require_once (ADMIN. '/swiz-design-options-init.php');
require_once (ADMIN. '/pageorder.php');
require_once (ADMIN. '/categoryorder.php');
require_once (ADMIN. '/create-styles.php');

require_once (FUNCTIONS. '/custom-functions.php');

require_once (LAYOUTS. '/blog-loop.php');
require_once (LAYOUTS. '/mag-loop.php');

require_once (WIDGETS . '/widget-functions.php');
require_once (WIDGETS . '/widgets.php'); 

add_action('widgets_init', create_function('', 'return register_widget("swizTabs");'));
add_action('widgets_init', create_function('', 'return register_widget("swizPopularPosts");')); 
add_action('widgets_init', create_function('', 'return register_widget("swizAdsWidget");')); 
add_action('widgets_init', create_function('', 'return register_widget("SubscribeBox");')); 
add_action('widgets_init', create_function('', 'return register_widget("HomePageOnlyText");')); 
 

add_action('update_option', 'create_style_sheet');
add_action('update_option', 'resetSwizOptions');


add_action('admin_head', 'first_run_options');



add_action('switch_theme', 'delete_stuff');




?>
