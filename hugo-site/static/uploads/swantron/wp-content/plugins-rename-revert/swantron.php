<?php

/*
Plugin Name: IntelliLinks
Plugin URI: http://www.intellilinks.com
Description: IntelliLinks plugin for inserting links on your blog.
Author: IntelliLinks
Version: 1.12
Author URI: http://www.intellilinks.com
*/


$intelliLinks = null;


add_action('init',            				'intellilinks_init');
add_action('plugins_loaded',  				'swantron_widget_init');
add_action('publish_post',    				'intellilinks_post_add');
add_action('edit_post',       				'intellilinks_post_update');
add_action('delete_post',     				'intellilinks_post_delete');
add_filter('the_content', 'intellilinks_content', 1);


function intellilinks_init()
{
	global $intelliLinks;
	$intelliLinks = new IntelliLinks();
	
	$intelliLinks->remoteAction($_REQUEST['intellilinks_key'], $_REQUEST['intellilinks_action'], $_REQUEST['intellilinks_post_id']);
}


function intellilinks_post_add($id)
{
	global $intelliLinks;
	if($intelliLinks == null) intellilinks_init();
	$intelliLinks->sendAlert('add', $id);
}


function intellilinks_post_update($id)
{
	global $intelliLinks;
	if($intelliLinks == null) intellilinks_init();
	$intelliLinks->sendAlert('update', $id);
}


function intellilinks_post_delete($id)
{
	global $intelliLinks;
	if($intelliLinks == null) intellilinks_init();
	$intelliLinks->sendAlert('delete', $id);
}


function intellilinks_content($content = '')
{
    global $intelliLinks, $post;
    
    if($intelliLinks == null) intellilinks_init();

    if(is_object($post)) $content = $intelliLinks->insertContentLink($post->ID, $content);

    return $content;
}


function output_template_ads($links = false)
{
	global $intelliLinks;
	if($intelliLinks == null) intellilinks_init();
	$intelliLinks->outputRegularLinks($links);
}


function swantron_widget_init()
{
    if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') ) return;
    
    register_sidebar_widget('swantron', 'swantron_widget');
    register_widget_control('swantron', 'swantron_widget_control');
}
 

function swantron_widget($args)
{
    global $intelliLinks, $post;
    
    if(	is_home() || $_SERVER['REQUEST_URI'] == '/' || ($post->ID && $post->ID == get_option('page_on_front')) ){
	
		extract($args);
	
	    $options = get_option('widget_swantron');
	    $title = $options['title'];
	    
	    if($intelliLinks == null) intellilinks_init();
	
		$regularLinks = $intelliLinks->getRegularAds();
			
		if(count($regularLinks) > 0){
		    echo $before_widget;
		    echo $before_title . $title . $after_title;
		    output_template_ads($regularLinks);
		    echo $after_widget;
	    }
    
    }
}


function swantron_widget_control()
{
    $options = $newoptions = get_option('widget_swantron');

    if ( $_POST['swantron-title'] ) {
        $newoptions['title'] = strip_tags(stripslashes($_POST['swantron-title']));
    }

    if ( $options != $newoptions ) {
        $options = $newoptions;
        update_option('widget_swantron', $options);
    }

    ?>
            <p><label for="swantron-title">Title: <input type="text" style="width: 250px;" id="swantron-title" name="swantron-title" value="<?php echo htmlspecialchars($options['title']); ?>" /></label></p>
            <input type="hidden" name="swantron-submit" id="swantron-submit" value="1" />
<?php
}






class IntelliLinks {
	
	var $key 		= 'j9ast50boydg81hm';
	var $version 	= '1.12';
	var $feed;
	var $links;
	var $feedUrl;
	var $interfaceUrl;
	var $cacheTime 	= 900;
	var $timeout 	= 10;
	
	
	function IntelliLinks()
	{
		$this->feedUrl		= 'http://www.intellilinks.com/feed/'.$this->key;
		$this->interfaceUrl	= 'http://www.intellilinks.com/interface/?key='.$this->key;
		$this->links		= array();
		
		$this->loadFeed();
	}
	
		
	function initialInstall($reset = false)
	{
		global $wpdb;
		
		add_option('intellilinks_links', '');
		add_option('intellilinks_updated', '0');
		add_option('intellilinks_sync_last_id', '0');
		
		update_option('intellilinks_links', '');
		update_option('intellilinks_updated', '0');
		update_option('intellilinks_sync_last_id', '0');

		$maxId = $wpdb->get_var("SELECT ID FROM {$wpdb->posts} WHERE post_status = 'publish' ORDER BY ID DESC LIMIT 1");
        if($maxId === '') $maxId = '0';
		
		add_option('intellilinks_sync_max_id', $maxId);
		
		$this->sendAlert('install', '', get_option('siteurl'));
	}
	
	
	function loadFeed()
	{
		$lastUpdate = get_option('intellilinks_updated');
		
		if($lastUpdate === '' || $lastUpdate === 0){
			$this->initialInstall();
		}
		
		if( $lastUpdate > (time() - $this->cacheTime) ){
			$this->loadCache();
		}else{
			$this->touchCache();
			$this->downloadFeed();
			
			if($this->feed){
				$this->parseFeed();
				$this->cacheFeed();
				if (function_exists('wp_cache_flush')) wp_cache_flush();		
			}else{
				$this->loadCache();
			}
		}
		
		
	}
	
	
	function parseFeed()
	{
		if(!$this->feed) return;
		
		$values = array();
		$index  = array();
		
		$parser = xml_parser_create();
        xml_parse_into_struct($parser, $this->feed, $values, $index);
        xml_parser_free($parser);

        $linkIndex = $index['LINK'];
        $textIndex = $index['TITLE'];
        $postIndex = $index['DESCRIPTION'];
        
        if(is_array($linkIndex)){
	        foreach($linkIndex as $idx1 => $idx2){
	        	if($idx1 == 0) continue;
	        	
	        	$this->links[] = array(
	        		'post'		=> $values[$postIndex[$idx1]]['value'],
	        		'url'		=> $values[$linkIndex[$idx1]]['value'],
	        		'text'		=> $values[$textIndex[$idx1]]['value']
	        	);
	        }
        }
	}
	
	
	function loadCache()
	{
		$this->links = get_option('intellilinks_links');
	}
	
	
	function touchCache()
	{
		update_option('intellilinks_updated', time());
	}
	
	
	function cacheFeed()
	{
		update_option('intellilinks_links', $this->links);
	}
	
	
	function downloadFeed()
	{
		$result		= '';
		$errorNum	= '';
		$errorStr	= '';
		
		$url = parse_url($this->feedUrl);
	
		if ($handle = @fsockopen ($url['host'], 80, $errorNum, $errorStr, $this->timeout))
		{
			if(function_exists('socket_set_timeout')) {
				socket_set_timeout($handle, $this->timeout, 0);
			}
			if(function_exists('stream_set_timeout')) {
				stream_set_timeout($handle, $this->timeout, 0);
			}
	
			fwrite ($handle, "GET {$url['path']} HTTP/1.0\r\nHost: {$url['host']}\r\nConnection: Close\r\n\r\n");
			while(!feof($handle)){
				$result .= @fread($handle, 8192);
			}
			fclose($handle);
		}
		
		if(strpos($result, '<?xml') !== false){
			$this->feed = trim(substr($result, strpos($result, '<?xml')));
		}
	}
	
	
	function sendAlert($action, $id = '', $siteUrl = '')
	{
		$errorNum	= '';
		$errorStr	= '';
		
		$interfaceUrl  = $this->interfaceUrl;
		$interfaceUrl .= "&action={$action}";
		if($id) $interfaceUrl .= "&post_id=".$id;
		if($siteUrl) $interfaceUrl .= "&url=".urlencode($siteUrl);
		
		$url = parse_url($interfaceUrl);
	
		if ($handle = @fsockopen ($url['host'], 80, $errorNum, $errorStr, $this->timeout))
		{
			if(function_exists('socket_set_timeout')) {
				socket_set_timeout($handle, $this->timeout, 0);
			}
			if(function_exists('stream_set_timeout')) {
				stream_set_timeout($handle, $this->timeout, 0);
			}
	
			fwrite ($handle, "GET {$url['path']}?{$url['query']} HTTP/1.0\r\nHost: {$url['host']}\r\nConnection: Close\r\n\r\n");
			fclose($handle);
		}
	}
	
	
	function getRegularAds()
	{
		$regularLinks = array();
			
		if(is_array($this->links)){
			foreach($this->links as $link){
				if($link['post']) continue;
				$regularLinks[] = $link;
			}
		}
		
		return $regularLinks;
	}
	
	
	function outputRegularLinks($links = false)
	{
		global $post;
		
		if(	is_home() || $_SERVER['REQUEST_URI'] == '/' || ($post->ID && $post->ID == get_option('page_on_front')) ){
		
			if(is_array($links)){
				$regularLinks = $links;
			}else{
				$regularLinks = $this->getRegularAds();
			}
			
			if(count($regularLinks) > 0)
			{
				echo("<ul>\n");
				foreach($regularLinks as $link)
				{
					echo("<li><a href=\"{$link['url']}\">{$link['text']}</a></li>\n");
				}
				echo("</ul>\n");
			}
		
		}
	}
	
	
	function insertContentLink($id, $content)
	{
		if(is_array($this->links)){
						
			foreach($this->links as $link){

				if($link['post'] == $id && $link['text']){
					
					$availableContent = $content;
					$availableContent = strtolower($availableContent);
					$availableContent = $this->filterUnavailableContent('/<h[1-6][^>]*>[^<]*<\/h[1-6]>/i', $availableContent);
					$availableContent = $this->filterUnavailableContent('/<a [^>]*>[^<]*<\/a>/i', $availableContent);
					$availableContent = $this->filterUnavailableContent('/<script[^>]*>[^<]*<\/script>/i', $availableContent);
					$availableContent = $this->filterUnavailableContent('/href=("|\')[^"\']+[^"\']+("|\')/i', $availableContent);
					$availableContent = $this->filterUnavailableContent('/src=("|\')[^"\']+[^"\']+("|\')/i', $availableContent);
					$availableContent = $this->filterUnavailableContent('/alt=("|\')[^"\']+[^"\']+("|\')/i', $availableContent);
					$availableContent = $this->filterUnavailableContent('/title=("|\')[^"\']+[^"\']+("|\')/i', $availableContent);
					$availableContent = $this->filterUnavailableContent('/content=("|\')[^"\']+[^"\']+("|\')/i', $availableContent);
					$availableContent = $this->filterUnavailableContent('/name=("|\')[^"\']+[^"\']+("|\')/i', $availableContent);
					$availableContent = $this->filterUnavailableContent('/value=("|\')[^"\']+[^"\']+("|\')/i', $availableContent);
					$availableContent = $this->filterUnavailableContent('/class=("|\')[^"\']+[^"\']+("|\')/i', $availableContent);
					
					$linkText   = strtolower($link['text']);
					$linkLength = strlen($link['text']);
					$offset     = 0;
					$position   = strpos($availableContent, $linkText, $offset);
					
					while($position !== false)
					{
						if( $this->isKeywordLinkable(substr($availableContent, $offset, $position + $linkLength + 1 - $offset), $linkText) ) break;
						
						$offset   = $position + $linkLength;
						$position = strpos($availableContent, $linkText, $offset);
					}
					
					if($position !== false){
						$linkCode = "<a href=\"{$link['url']}\">".substr($content, $position, $linkLength)."</a>";
						$content = substr($content, 0, $position).$linkCode.substr($content, $position + $linkLength);
					}
					
				}
			}
		}
		
		return $content;
	}
	
	
	function isKeywordLinkable($body, $keyword)
	{
		if(
			(
				strpos($body, " {$keyword}") === false &&
				strpos($body, "\n{$keyword}") === false &&
				strpos($body, ".{$keyword}") === false &&
				strpos($body, ",{$keyword}") === false &&
				strpos($body, "?{$keyword}") === false &&
				strpos($body, "!{$keyword}") === false &&
				strpos($body, "\"{$keyword}") === false &&
				strpos($body, ";{$keyword}") === false &&
				strpos($body, "({$keyword}") === false &&
				strpos($body, "[{$keyword}") === false &&
				strpos($body, ">{$keyword}") === false
			) || (
				strpos($body, "{$keyword} ") === false &&
				strpos($body, "{$keyword}\n") === false &&
				strpos($body, "{$keyword}.") === false &&
				strpos($body, "{$keyword},") === false &&
				strpos($body, "{$keyword}?") === false &&
				strpos($body, "{$keyword}!") === false &&
				strpos($body, "{$keyword};") === false &&
				strpos($body, "{$keyword}\"") === false &&
				strpos($body, "{$keyword}&") === false &&
				strpos($body, "{$keyword})") === false &&
				strpos($body, "{$keyword}]") === false &&
				strpos($body, "{$keyword}<") === false
			)
		){
			return false;
		}
		
		return true;
	}
	
	
	function filterUnavailableContent($pattern, $str)
	{
		$removals = array();
		$matches = array();
		
		preg_match_all($pattern, $str, $matches);
		
		$removals = $matches[0];
		
		if(is_array($removals) && count($removals) > 0)
		{
			foreach($removals as $removal){
				$str = str_replace($removal, str_repeat('*', strlen($removal)), $str);
			}
		}
		
		return $str;
	}
	
	
	function remoteAction($key, $action, $id = '')
	{
		if($key != $this->key) return;
		
		switch($action)
		{
			case 'sync':	$this->syncPosts($id);
							exit;
							
			case 'reset':	$this->initialInstall(true);
							exit;
							
			case 'debug':	$this->debug();
							exit;
		}
	}
	
	
	function syncPosts($id = '')
	{
		global $wpdb;
		
		header('Content-type: application/xml');

		echo('<?xml version="1.0" encoding="UTF-8"?>
<posts>');

		
		if($id){
        	$query   = "SELECT ID, post_date_gmt, post_content, post_title FROM {$wpdb->posts} WHERE ID <= '{$id}'";
		}else{
        	$query   = "SELECT ID, post_date_gmt, post_content, post_title
        				FROM {$wpdb->posts}
                    	WHERE 1
                    		AND (post_type = 'page' OR post_type = 'post')
                    		AND post_status = 'publish'
                    		AND ID >  '".get_option('intellilinks_sync_last_id')."'
                    		AND ID <= '".get_option('intellilinks_sync_max_id')."'
                    	ORDER BY ID LIMIT 100";
		}
		
		$posts = $wpdb->get_results($query);
		
		if(is_array($posts) && count($posts) > 0){
			
			foreach($posts as $post){
				
				echo '
<post>
<id>'.$post->ID.'</id>
<link>'.get_permalink($post->ID).'</link>
<pubDate>'.date('Y-m-d', strtotime($post->post_date_gmt)).'</pubDate>
<title><![CDATA['.$post->post_title.']]></title>
<description><![CDATA['.$post->post_content.']]></description>
</post>';
				$lastId = $post->ID;
			}
			
			if(!$id){
	    		update_option('intellilinks_sync_last_id', $lastId);
	    	}
			
		}

		echo '
</posts>';

	}
		
	
	function debug()
	{
		echo("<strong>Plugin Version:</strong> ".$this->version."<br />\n");
		echo("<strong>Last Update:</strong> ".date('Y-m-d H:i:s', get_option('intellilinks_updated'))."<br /><br />\n");
		
		if(is_array($this->links) && count($this->links) > 0){
			echo("<table border=\"1\">");
			echo("<tr><th>Link Text</th><th>Link URL</th><th>Post ID</th></tr>\n");
			foreach($this->links as $link){
				echo("<tr><td>{$link['text']}</td><td>{$link['url']}</td><td>{$link['post']}</td></tr>\n");
			}
			echo("</table>\n");
		}
	}
	
}


?>