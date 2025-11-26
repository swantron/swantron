<?php 
/*
custom function time...takes categories, etc
Author: Joseph Swanson
URL: http://swantron.com
Contact: http://swantron.com/contact
*/
function swiz_list_cats($num){
	$temp=get_the_category(); 
	$count=count($temp);// Grap post category number.
	for($i=0;$i<$num&&$i<$count;$i++){
		//Format
		$cat_string.='<a href="'.get_category_link( $temp[$i]->cat_ID  ).'">'.$temp[$i]->cat_name.'</a>';
		if($i!=$num-1&&$i+1<$count)
		//Add comma if not last
		//Custom separator
		$cat_string.=', ';
	}
	echo $cat_string;
} 

//Create array with wordpress categories
$swiz_categories = array();  
$swiz_categories_obj = get_categories('hide_empty=0');
foreach ($swiz_categories_obj as $swiz_cat) 
{$swiz_categories[$swiz_cat->cat_ID] = $swiz_cat->cat_name;}
$categories_tmp = array_unshift($swiz_categories, "Select-a-category:");    
       
//use array to access pages in wordpress
$swiz_pages = array();
$swiz_pages_obj = get_pages('sort_column=post_parent,menu_order');    
foreach ($swiz_pages_obj as $swiz_page) 
{$swiz_pages[$swiz_page->ID] = $swiz_page->post_name; }
$swiz_pages_tmp = array_unshift($swiz_pages, "Select a page:");  


function get_tiny_url($url) {
 
 if (function_exists('curl_init')) {
   $url = 'http://tinyurl.com/api-create.php?url=' . $url;
 
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_HEADER, 0);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($ch, CURLOPT_URL, $url);
   $tinyurl = curl_exec($ch);
   curl_close($ch);
 
   return $tinyurl;
 }
 
 else {
   # if tiny url is disabled use long
   return $url;
 }
 
}
?>
