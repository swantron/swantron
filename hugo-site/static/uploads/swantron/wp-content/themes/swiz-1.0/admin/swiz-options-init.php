<?php 
//Access the WordPress Categories via an Array
$swiz_categories = array();  
$swiz_categories_obj = get_categories('hide_empty=0');
foreach ($swiz_categories_obj as $swiz_cat) 
{$swiz_categories[$swiz_cat->cat_ID] = $swiz_cat->cat_name;}
$categories_tmp = array_unshift($swiz_categories, "Show recent posts");   
       
//Access the WordPress Pages via an Array
$swiz_pages = array();
$swiz_pages_obj = get_pages('sort_column=post_parent,menu_order');    
foreach ($swiz_pages_obj as $swiz_page) 
{$swiz_pages[$swiz_page->ID] = $swiz_page->post_name; }
$swiz_pages_tmp = array_unshift($swiz_pages, "Select a page:");  


$themename = "Swiz";
$shortname = "swiz";
$GLOBALS['template_path'] = get_bloginfo('template_directory');
global $themename, $shortname, $swiz_options;
////////////////////////
$swiz_options[] = array(); 
$swiz_options[] =array("type" => "open-options-div");

$swiz_options[] = array( "name" => "General-Settings",
                    "type" => "heading");


$swiz_options[] = array( "name" => "Custom Favicon",
					"desc" => "Enter the URL of a 16px x 16px PNG/GIG image that will be used as your website's favicon.",
					"id" => $shortname."_favicon",
					"std" => "",
					"type" => "text"); 

$swiz_options[] = array( "name" => "Header Scripts",
					"desc" => "If you need to add scripts to your header (like Mint tracking code, perhaps), you should enter them in the box below. They will be added before &lt;/head&gt; tag",
					"id" => $shortname."_header_scripts",
					"std" => "",
					"type" => "textarea"); 

$swiz_options[] = array( "name" => "Footer Scripts",
					"desc" => "Paste your Google Analytics (or other) tracking code here. They will be added before &lt;/body&gt; tag",
					"id" => $shortname."_footer_scripts",
					"std" => "",
					"type" => "textarea"); 


$swiz_options[] = array(	"name" => "Feedburner ID",
						"desc" => "Enter your Feedburner ID here. This is required for the RSS widget and subscribe by email box on the single post page.",
			    		"id" => $shortname."_feedburner_id",
			    		"std" => "",
			    		"type" => "text");	

$swiz_options[] =array("type" => "close");

//Header Options Start

$swiz_options[] = array( "name" => "Header-Options",
                    "type" => "heading");

$swiz_options[] = array( "name" => "Custom Logo",
					"desc" => "Enter the URL of your logo (http://yoursite.com/logo.png)",
					"id" => $shortname."_logo",
					"std" => "",
					"type" => "text");    


$swiz_options[] = array( "name" => "Top Navigation Bar",
					"desc" => "Select what you want to display in top navigation, select none if you dont want to have navigation links above logo/sitename.",
					"id" => $shortname."_nav1",
					"std" => "Pages",
					"type" => "radio",
					"options" => array('Disable','Pages','Categories'));

$swiz_options[] = array( "name" => "Bottom Navigation Bar",
					"desc" => "Select what you want to display in top navigation, select none if you dont want to have navigation links below logo/sitename.",
					"id" => $shortname."_nav2",
					"std" => "Categories",
					"type" => "radio",
					"options" => array('Disable','Pages','Categories'));

$swiz_options[] = array(    "name" => "Links to be appended to the navigation bar showing the list of pages",
        "desc" => 'Add your links in the following format &lt;li&gt;&lt; a href="http://yourURL.com"&gt; SwizThems&lt;/a&gt;&lt;/li&gt;',
        "id" => $shortname."_pagenav_links",
        "type" => "textarea");

$swiz_options[] = array(    "name" => "Links to be appended to the navigation bar showing the list of categories",
        "desc" => 'Add your links in the following format &lt;li&gt;&lt; a href="http://yourURL.com"&gt; SwizThems&lt;/a&gt;&lt;/li&gt;',
        "id" => $shortname."_catnav_links",
        "type" => "textarea");

$swiz_options[] = array(    "name" => "Enter you custom search code",
        "desc" => 'If you have a custom search code, such as <strong>Adsense for Search</strong>, add it here',
        "id" => $shortname."_search_code",
        "type" => "textarea");

$swiz_options[] = array(  "name" => "Disable RSS links",
        			"desc" => "Check this box if you don't want to display your RSS links in the top navigation bar.",
        			"id" => $shortname."_rsslinks_disable",
        			"type" => "checkbox",
        			"std" => "false");

$swiz_options[] = array(  "name" => "Disable search sox",
        			"desc" => "Check this box if you don't want to display the search box in the bottom navigation bar.",
        			"id" => $shortname."_searchbox_disable",
        			"type" => "checkbox",
        			"std" => "false"); 
 
$swiz_options[] =array("type" => "ordering");
$swiz_options[] =array("type" => "close");

//Home Page Options
$swiz_options[] = array( "name" => "Homepage",
                    "type" => "heading");

$swiz_options[] = array(  "name" => "ENABLE featured posts slider",
        "desc" => "Check this box if you would like to enabke featured posts slider.",
        "id" => $shortname."_featured_enable",
        "type" => "checkbox",
        "std" => "false");

$swiz_options[] = array( "name" => "Featured Category",
					"desc" => "Select the category whose posts you want to have displayed in the Featured Posts slider on your home page.",
					"id" => $shortname."_featured_category",
					"std" => "Show recent posts",
					"type" => "select",
					"options" => $swiz_categories);

$swiz_options[] = array( "name" => "Number of featured posts",
					"desc" => "Select the number of featured posts to display in the slider.",
					"id" => $shortname."_featured_posts_number",
					"std" => 3,
					"type" => "select",
					"options" => array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20));
$swiz_options[] = array(  "name" => "DISABLE thumbnails in slider",
        "desc" => "Check this box if you would like to disable thumbnails in the slider.",
        "id" => $shortname."_thumbs_slider_disable",
        "type" => "checkbox",
        "std" => "false");


$swiz_options[] = array(  "name" => "DISABLE thumbnails on home page",
        "desc" => "Check this box if you would like to disable thumbnails on the home page. Applies to all except the slider thumbnails.",
        "id" => $shortname."_thumbs_disable",
        "type" => "checkbox",
        "std" => "false");

$swiz_options[] = array(  "name" => "Display excerpts on home page",
        "desc" => "Check this box if you would like to display excerpts rather than full posts on the home page. Excerpts are summaries or descriptions of a post. This option doesn't affect the <strong>more</strong> WordPress function.",
        "id" => $shortname."_excerpts_enable",
        "type" => "checkbox",
        "std" => "false");

$swiz_options[] = array(  "name" => "Display excerpts on archive pages",
        "desc" => "Check this box if you would like to display excerpts rather than full posts on archive pages. Excerpts are summaries or descriptions of a post. This option doesn't affect the <strong>more</strong> WordPress function.",
        "id" => $shortname."_archive_excerpts_enable",
        "type" => "checkbox",
        "std" => "false");

$swiz_options[] = array( "name" => "Home page full content posts:",
					"desc" => "If you set the home page to show excerpts, select here the number of posts you still want to be shown in their entirety.",
					"id" => $shortname."_full_posts_number",
					"std" => "2",
					"type" => "select",
					"options" => array(0,1,2,3,4,5));

$swiz_options[] = array(  "name" => "ENABLE popular posts on home page",
        "desc" => "Check this box if you would like to enable showing popular posts on the home page. Note: this feature doesn't work in magazine layout.",
        "id" => $shortname."_popular_enable",
        "type" => "checkbox",
        "std" => "false");

$swiz_options[] = array( "name" => "Number of popular posts",
					"desc" => "Select the number of popular posts you want to display on the home page.",
					"id" => $shortname."_popular_posts_number",
					"std" => "6",
					"type" => "select",
					"options" => array(1,2,3,4,5,6,7,8,9,10));


$swiz_options[] =array("type" => "close");

//Single Page

$swiz_options[] = array( "name" => "SinglePage",
                    "type" => "heading");

$swiz_options[] = array(  "name" => "Display the Subscribe by E-mail box",
        "desc" => "Check this box if you'd like to display the Subscribe by E-Mail Subscription box at the post's end. You have to enter your Feedburner ID in the General settings page for this to work.",
        "id" => $shortname."_email_subscription_enable",
        "type" => "checkbox",
        "std" => "true");

$swiz_options[] = array(  "name" => "Display social bookmarking icons",
        "desc" => "Check this box if you'd like to display social bookmarking icons at the post's end.",
        "id" => $shortname."_socialmedia_enable",
        "type" => "checkbox",
        "std" => "true");

$swiz_options[] = array(  "name" => "Display author biography",
        "desc" => "Check this box if you'd like to display the author biography at the post's end.",
        "id" => $shortname."_author_info_enable",
        "type" => "checkbox",
        "std" => "true");

$swiz_options[] =array("type" => "close");
//Ad Management

$swiz_options[] = array( "name" => "Ad-Management",
                    "type" => "heading");
$swiz_options[] = array(  "name" => "ENABLE the header ad area",
        "desc" => "Check this box if you'd like to display an advertisement on the empty header area to the right of the blog name or logo.",
        "id" => $shortname."_header_ad_enable",
        "type" => "checkbox",
        "std" => "false");
$swiz_options[] = array(    "name" => "Ad Code",
        "desc" => "Enter your ad code here, preferably 468*60 ad",
        "id" => $shortname."_header_adcode",
        "type" => "textarea");

$swiz_options[] = array(  "name" => "ENABLE the ad area below the bottom navigation bar",
        "desc" => "Check this box if you'd like to display an advertisement below the bottom navigation bar.",
        "id" => $shortname."_nav_adsense_enable",
        "type" => "checkbox",
        "std" => "false");
$swiz_options[] = array(    "name" => "Ad Code",
        "desc" => "Enter on the box to the left the ad code you received from your ad-network, preferably a 728*15 link list unit, or a 728*90 lead-board ad.",
        "id" => $shortname."_nav_adcode",
        "type" => "textarea");

$swiz_options[] = array(  "name" => "ENABLE ad's below title on single post page",
        "desc" => "Check this box if you'd like to display an advertisement below the post title on single post pages.",
        "id" => $shortname."_adsense_enable",
        "type" => "checkbox",
        "std" => "false");
$swiz_options[] = array(    "name" => "Ad Code",
        "desc" => "Enter on the box to the left the ad code you received from your ad-network, preferably a 468*60 ad to be displayed between the post's title and text, or a 120*600 skyscraper ad to be float-positioned to the left or the right of the post text. To float a skyscraper ad surround the ad code like this: &lt;div style=\"float: left; clear: left; margin: 0px 10px 10px 0px;\"&gt;AD CODE HERE&lt;/div&gt; or &lt;div style=\"float: right; clear: right; margin: 0px 0px 10px 10px;\"&gt;AD CODE HERE&lt;/div&gt;",
        "id" => $shortname."_adcode",
        "type" => "textarea");

$swiz_options[] = array(  "name" => "ENABLE the ad area below the post text",
        "desc" => "Check this box if you'd like to display an advertisement after the post contents on single post pages.",
        "id" => $shortname."_adsense_afterpost_enable",
        "type" => "checkbox",
        "std" => "false");
$swiz_options[] = array(    "name" => "Ad Code",
        "desc" => "Enter on the box to the left the ad code you received from your ad-network, preferably a 468*60 ad to be displayed after the post's content. For best results clear and center it surrounding the ad code like this: &lt;div style=\"clear: both; text-align: center; margin: 10px 0px 0px 0px;\"&gt;AD CODE HERE&lt;/div&gt;",
        "id" => $shortname."_adsense_afterpost",
        "type" => "textarea");


$swiz_options[] = array(    "name" => "Banner-1",
        "desc" => "Enter your image url here",
        "id" => $shortname."_banner1image",
        "type" => "text");
$swiz_options[] = array(    "name" => "Banner destination",
        "desc" => "Enter destination url (link) here",
        "id" => $shortname."_banner1destination",
        "type" => "text");
$swiz_options[] = array(    "name" => "Banner-2",
        "desc" => "Enter your image url here",
        "id" => $shortname."_banner2image",
        "type" => "text");
$swiz_options[] = array(    "name" => "Banner destination",
        "desc" => "Enter destination url (link) here",
        "id" => $shortname."_banner2destination",
        "type" => "text");

$swiz_options[] = array(    "name" => "Banner-3",
        "desc" => "Enter your image url here",
        "id" => $shortname."_banner3image",
        "type" => "text");
$swiz_options[] = array(    "name" => "Banner destination",
        "desc" => "Enter destination url (link) here",
        "id" => $shortname."_banner3destination",
        "type" => "text");

$swiz_options[] = array(    "name" => "Banner-4",
        "desc" => "Enter your image url here",
        "id" => $shortname."_banner4image",
        "type" => "text");
$swiz_options[] = array(    "name" => "Banner destination",
        "desc" => "Enter destination url (link) here",
        "id" => $shortname."_banner4destination",
        "type" => "text");
$swiz_options[] =array("type" => "clear");
$swiz_options[] =array("type" => "close");



//never remove this option (it will reset theme options)
$swiz_options[] = array( "name" => "",
					"desc" => "this is a random variable just to know that the options have been changed, it wont be displayed any where",
					"id" => $shortname."_random",
					"std" => "FFF",
					"type" => "hidden");



                    
?>