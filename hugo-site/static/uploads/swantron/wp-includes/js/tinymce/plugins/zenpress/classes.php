<?php
/**
 * Copyright 2006  Alessandro Morandi  (email : webmaster@simbul.net)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */
 
/**
 * This is a (static) class meant to manage all the GUI construction
 */
class ZenPressGUI {
	
	/**
	 * Print the image selection form, with all the options
	 * @param $albumid	ID of the album the images belong to
	 */
	function print_image_select($albumid) {
		global $zp_web_path,$conf,$zp_eh,$zp_db,$_POST;
		
		if ($albumid) {
			$_POST['imgperpage'] ? $imgperpage = $_POST['imgperpage'] : $imgperpage = 15;	// Default value
			$_POST['orderby'] ? $order = $_POST['orderby'] : $order = 'sort_order';			// Default value
			$_POST['page'] ? $curpage = $_POST['page'] : $curpage = 1;						// Default value
			
			$limit_start = ($curpage - 1) * $imgperpage;
			
			$_POST['what'] ? $wh = $_POST['what'] : $wh = 'thumb';
			$_POST['link'] ? $lk = $_POST['link'] : $lk = 'image';
			$_POST['close'] ? $cl = $_POST['close'] : $cl = 'true';
			
			$sql = "SELECT title AS name, folder AS url FROM db_albums_table WHERE id = ".$albumid." LIMIT 0,1";
			$query = $zp_db->query($sql);
			$album = @mysql_fetch_assoc($query);

			$sql = "SELECT i.id AS id, i.filename AS url, i.title AS name " .
					"FROM db_images_table AS i " .
					"WHERE albumid=".$albumid." AND i.filename<>'' " .
					"ORDER BY ".$order." " .
					"LIMIT $limit_start,$imgperpage";
			$query = $zp_db->query($sql);
			
			$sql = "SELECT COUNT(id) " .
					"FROM db_images_table " .
					"WHERE albumid=".$albumid." AND filename<>''";
			$imagesnum = $zp_db->querySingle($sql);
			
			$zp_web_path = get_option('zp_web_path');
			?>
	<form id="options" name="options" action="?tinyMCE=<?php echo $_GET[tinyMCE]; ?>" method="POST">
	<fieldset>
		<legend><a href="#"><span id="toggle_what" onclick="zenpressPopup.toggleMenu(this)"><?php echo $_POST['toggle_what_status']=='open' ? '[-]' : '[+]'; ?></span></a> What do you want to include?</legend>
		<div id="fields_what" class="<?php echo $_POST['toggle_what_status']=='open' ? 'zpOpen' : 'zpClosed'; ?>">
			<?php
			$options = array(	array('value' => 'thumb','title' => 'Image Thumbnail','onclick' => 'zenpressPopup.changeHandler()'),
								array('value' => 'title','title' => 'Image Title','onclick' => 'zenpressPopup.changeHandler()'),
								array('value' => 'album','title' => 'Album Name','onclick' => 'zenpressPopup.changeHandler()'),
								array('value' => 'custom','title' => 'Custom Text:','textfield_name' => 'what_custom_text','onclick' => 'zenpressPopup.changeHandler()'));
			ZenPressGUI::printFormRadio('what',$options,$wh,$_POST['what_custom_text']);
			?>
		</div>
	</fieldset>
	<fieldset>
		<legend><a href="#"><span id="toggle_link" onclick="zenpressPopup.toggleMenu(this)"><?php echo $_POST['toggle_link_status']=='open' ? '[-]' : '[+]'; ?></span></a> Do you want to link it?</legend>
		<div id="fields_link" class="<?php echo $_POST['toggle_link_status']=='open' ? 'zpOpen' : 'zpClosed'; ?>">
			<?php
			$options = array(	array('value' => 'image','title' => 'Link to Image','onclick' => 'zenpressPopup.changeHandler()'),
								array('value' => 'album','title' => 'Link to Album','onclick' => 'zenpressPopup.changeHandler()'),
								array('value' => 'none','title' => 'No Link','onclick' => 'zenpressPopup.changeHandler()'),
								array('value' => 'custom','title' => 'Custom URL:','textfield_name' => 'link_custom_url','onclick' => 'zenpressPopup.changeHandler()'));
			ZenPressGUI::printFormRadio('link',$options,$lk,$_POST['link_custom_url']);
			?>
		</div>
	</fieldset>
	<fieldset>
		<legend><a href="#"><span id="toggle_close" onclick="zenpressPopup.toggleMenu(this)"><?php echo $_POST['toggle_close_status']=='open' ? '[-]' : '[+]'; ?></span></a> Do you want to close this window?</legend>
		<div id="fields_close" class="<?php echo $_POST['toggle_close_status']=='open' ? 'zpOpen' : 'zpClosed'; ?>">
			<?php
			$options = array(	array('value' => 'true','title' => 'Close after inserting'),
								array('value' => 'false','title' => 'Keep open'));
			ZenPressGUI::printFormRadio('close',$options,$cl);
			?>
		</div>
	</fieldset>
	<fieldset>
		<legend><a href="#"><span id="toggle_order" onclick="zenpressPopup.toggleMenu(this)"><?php echo $_POST['toggle_order_status']=='open' ? '[-]' : '[+]'; ?></span></a> Popup options</legend>
		<div id="fields_order"  class="<?php echo $_POST['toggle_order_status']=='open' ? 'zpOpen' : 'zpClosed'; ?>">
			Show
			<?php
				$opts = array(	array('name' => 10, 'value' => 10),
								array('name' => 15, 'value' => 15),
								array('name' => 20, 'value' => 20),
								array('name' => 30, 'value' => 30),
								array('name' => 50, 'value' => 50)); 
				ZenPressGUI::printFormSelect('imgperpage',$opts,$imgperpage);
			?>
			images in a page, ordered by
			<?php
				$opts = array(	array('name' => 'Title', 'value' => 'title'),
								array('name' => 'Sort Order', 'value' => 'sort_order'),
								array('name' => 'ID', 'value' => 'id')); 
				ZenPressGUI::printFormSelect('orderby',$opts,$order);
			?>
			<input type="submit" value="Update">
		</div>
	</fieldset>
	<input type="hidden" name="album" value="<?php echo $albumid; ?>">
	<input type="hidden" name="album_name" value="<?php echo $album[name]; ?>">
	<input type="hidden" name="album_url" value="<?php echo $album[url]; ?>">
	<input type="hidden" name="zp_web_path" value="<?php echo $zp_web_path; ?>">
	<input type="hidden" name="mod_rewrite" value="<?php echo $conf[mod_rewrite]; ?>">
	<input type="hidden" name="page" value="">
	<input type="hidden" id="toggle_what_status" name="toggle_what_status" value="<?php echo $_POST['toggle_what_status']=='open' ? 'open' : 'closed'; ?>">
	<input type="hidden" id="toggle_link_status" name="toggle_link_status" value="<?php echo $_POST['toggle_link_status']=='open' ? 'open' : 'closed'; ?>">
	<input type="hidden" id="toggle_close_status" name="toggle_close_status" value="<?php echo $_POST['toggle_close_status']=='open' ? 'open' : 'closed'; ?>">
	<input type="hidden" id="toggle_order_status" name="toggle_order_status" value="<?php echo $_POST['toggle_order_status']=='open' ? 'open' : 'closed'; ?>">
	</form>
	<fieldset>
		<legend>Select Image</legend>
		<div id="fields_image" class="normal">
			<div class="normal">
			<?php ZenPressGUI::printPageIndex($imagesnum,$imgperpage,$curpage); ?>
			<?php
			while ($image = @mysql_fetch_assoc($query)) {
				if ($conf['mod_rewrite']) {
					$thumbpath = $zp_web_path."/setupzen" . urlencode($album[url]) . "/image/thumb/" . urlencode($image[url]);
				} else {			
					$thumbpath = $zp_web_path."/setupzen/i.php?a=" . urlencode($album[url]) . "&i=" . urlencode($image[url]) . "&s=thumb";
				}
				echo '<div class="thumb"><img title="'.$image[name].'" alt="'.$image[name].'" src="'.$thumbpath.'" onClick="zenpressPopup.insertImage(\''.$image[id].'\',\''.$image[url].'\',\''.str_replace("'","\'",$image[name]).'\');return false;" /></div>';
			}
			?>
			</div>
			<div class="alt">
				No image selection needed.<br />
				<input type="button" value="INSERT" onClick="zenpressPopup.insertImage(null,null,null);return false;" />
			</div>
		</div>
		
	</fieldset>
			<?php
		}
	}
	
	/**
	 * Print the album selection menu
	 * @param $selected	ID of the selected album (if any)
	 */
	function print_albums($selected) {
		global $zp_db,$zp_eh;
		
		$sql = "SELECT id AS value, title AS name FROM db_albums_table ORDER BY title ASC";
		$opts = $zp_db->queryArray($sql);
		?>
	<form action="?tinyMCE=<?php echo $_GET[tinyMCE]; ?>" method="POST">
	<fieldset>
		<legend>Select Album</legend>
		<?php ZenPressGUI::printFormSelect('album',$opts,$selected); ?>
		<input type="submit" value="Select">
	</fieldset>
	</form>		
		<?php
	}
	
	/**
	 * Print a <select> HTML element.
	 * @param $name	Name of the element
	 * @param $options	Array of select options. Each option is an array of name and value
	 * @param $selected	Value of the selected option (if any)
	 */
	function printFormSelect($name,$options,$selected=NULL) {
		echo '<select name="'.$name.'">';
		foreach ($options as $value) {
			$value[value]==$selected ? $sel=' selected="selected"' : $sel = '';
			echo '<option value="'.$value[value].'"'.$sel.'>'.$value[name].'</option>';
		}
		echo '</select>';
	}
	
	/**
	 * Print a group of <radio> HTML element.
	 * @param $name	Name of the element
	 * @param $options	Array of options. Each option is an array of title, value and onclick
	 * @param $selected	Value of the selected option (if any)
	 * @param $textvalue	Value of the textfield (if any)
	 */
	function printFormRadio($name,$options,$selected=NULL,$textvalue=NULL) {
		foreach ($options as $value) {
			"$value[value]"=="$selected" ? $ch=' checked="checked" ' : $ch = '';
			echo '<input type="radio" id="'.$name.'_'.$value[value].'" name="'.$name.'" value="'.$value[value].'" onclick="'.$value[onclick].'"'.$ch.'/> '.$value[title];
			if ($value[textfield_name]) {
				echo '<input type="text" id="'.$value[textfield_name].'" name="'.$value[textfield_name].'" '.($textvalue ? 'value="'.$textvalue.'" ' : '').'/>';
			}
			echo '<br />';
		}
	}
	
	/**
	 * Print an index for page navigation, if the items span multiple pages.
	 * @param $items_num	Number of items
	 * @param $items_perpage	Max number of items on each page
	 * @param $page_selected	Number of the selected page (if any)
	 */
	function printPageIndex($items_num,$items_perpage,$page_selected=1) {
		if ($items_num > $items_perpage) {
			if (!$page_selected) {
				$page_selected=1;
			}
			echo '<div class="ZPpageIndex">Page: ';
			for ($i = 1; $i <= ceil($items_num/$items_perpage); $i++) {
				if ($i == $page_selected) {
					echo '<b>'.$i.'</b>';
				} else {
					echo '<a href="#" onclick="zenpressPopup.gotoPage('.$i.');">'.$i.'</a>';
				}
				
				if ($i < ceil($items_num/$items_perpage)) {
					echo ' - ';
				}
			}
			echo '</div>';
		}
	}
}

define('ZP_E_ALL',0);
define('ZP_E_INFO',1);
define('ZP_E_WARNING',2);
define('ZP_E_ERROR',3);
define('ZP_E_FATAL',4);

/**
 * This is a class to manage error/warning/info messages.
 * It is meant to be used with PHP output buffering.
 */
class ZenPressErrorHandler {
	
	var $messages;
	var $messages_level;	// Highest level in the messages stack
	var $level;
	
	/**
	 * Class constructor.
	 * @param $debug	True if debug messages are to be shown, false otherwise
	 */
	function ZenPressErrorHandler($debug=ZP_E_ERROR) {
		$this->messages_level = ZP_E_ALL;	// Set to zero
		
		$this->level = $debug;
	}
	
	/**
	 * Add a message to the error stack
	 * @param $level	Level of the message
	 * @param $msg	Text of the message
	 * @param $add	Additional informations (can be a string or an array)
	 */
	function addMessage($level,$msg,$add) {
		if ($add) {
			if (is_array($add)) {
				ob_start();
				print_r($add);
				$additional = ob_get_contents();
				ob_end_clean();
			} else {
				$additional = $add;
			}
			$message = '<i>'.$msg.'</i> '.$this->sanitize($additional);
		} else {
			$message = $msg;
		}
		
		$this->messages[] = array("level"=>$level,"msg"=>$message);
		if ($this->messages_level < $level) {
			$this->messages_level = $level;
		}
	}
	
	/**
	 * Add a fatal error message to the stack. Wrapper for the addMessage function
	 * @param $msg	Text of the message
	 * @param $add	Additional informations, if any (can be a string or an array)
	 */
	function addFatal($msg,$add=NULL) {
		$this->addMessage(ZP_E_FATAL,$msg,$add);
		die();
	}
	
	/**
	 * Add an error message to the stack. Wrapper for the addMessage function
	 * @param $msg	Text of the message
	 * @param $add	Additional informations, if any (can be a string or an array)
	 */
	function addError($msg,$add=NULL) {
		$this->addMessage(ZP_E_ERROR,$msg,$add);
	}
	
	/**
	 * Add a warning message to the stack. Wrapper for the addMessage function
	 * @param $msg	Text of the message
	 * @param $add	Additional informations, if any (can be a string or an array)
	 */
	function addWarning($msg,$add=NULL) {
		$this->addMessage(ZP_E_WARNING,$msg,$add);
	}
	
	/**
	 * Add an information message to the stack. Wrapper for the addMessage function
	 * @param $msg	Text of the message
	 * @param $add	Additional informations, if any (can be a string or an array)
	 */
	function addInfo($msg,$add=NULL) {
		$this->addMessage(ZP_E_INFO,$msg,$add);
	}
	
	/**
	 * Return a string containing all the messages in HTML format. Select which
	 * messages to show according to the current level.
	 * @return A string containing HTML code
	 */
	function getMessages() {
		$out  = '<div id="zp_errormessage" style="border:1px solid #666;background:#EEE;padding:0.5em;margin-top:0.5em;">';
		$out .= '<em style="font-size:1.5em;">ZenPress Messages</em>';
		foreach($this->messages as $value) {
			if ($value[level] >= $this->level) {
				$out .= '<div class="errormessage" style="border:1px dotted #999;background:#FFF;padding:0;margin-top:0.5em;">';
				if ($value[level]==ZP_E_INFO) {
					$out .= '<p style="background:#9e9;padding:0.2em;margin:0;">INFO</p>';
				}
				if ($value[level]==ZP_E_WARNING) {
					$out .= '<p style="background:#ee6;padding:0.2em;margin:0;">WARNING</p>';
				}
				if ($value[level]==ZP_E_ERROR) {
					$out .= '<p style="background:#e88;padding:0.2em;margin:0;">ERROR</p>';
				}
				if ($value[level]==ZP_E_FATAL) {
					$out .= '<p style="background:#333;color:#DDD;padding:0.2em;margin:0;">FATAL ERROR</p>';
				}
				$out .= '<p style="margin:0.5em;">'.$value[msg].'</p>';
				$out .= '</div>';
			}
		}
		$out .= '</div>';
		return $out;
	}
	
	/**
	 * Callback function. It should be called automatically
	 * before flushing the output buffer.
	 * It prints error messages, if present.
	 * @param $buffer	Content of the buffer
	 * @return Content of the buffer with additional error messages
	 */
	function callback($buffer) {
		if(sizeof($this->messages) && $this->messages_level >= $this->level) {
			$buffer .= $this->getMessages();
		}
		return $buffer;
	}
	
	/**
	 * Sanitize input text
	 * @param $text
	 * @return Sanitized text
	 */
	function sanitize($text) {
		$out = str_replace('<','&lt;',$text);
		$out = str_replace('>','&gt;',$out);
		return $out;
	}
}

/**
 * This is a class to manage all database interactions
 */
class ZenPressDB {
	
	var $host;
	var $username;
	var $password;
	var $database;
	var $prefix;
	
	var $link;
	var $zp_eh;
	
	/**
	 * Class constructor. Create a new database connection and store its identifier link
	 * @param $host	Hostname for the connection
	 * @param $username	Username for the connection
	 * @param $password	Password for the connection
	 * @param $database	Database name
	 * @param $prefix	Database tables prefix (if any)
	 */
	function ZenpressDB($host, $username, $password, $database, $prefix) {
		global $zp_eh;
		
		$zp_eh->addInfo('MySQL user@host:',$username.'@'.$host);
		$zp_eh->addInfo('MySQL database:',$database);
		$zp_eh->addInfo('MySQL prefix:',$prefix);
		
		$this->host = $host;
		$this->username = $username;
		$this->password = $password;
		$this->database = $database;
		$this->prefix = $prefix;
		$this->zp_eh = $zp_eh;
		
		if (!$zp_db_link = @mysql_connect($this->host, $this->username, $this->password)) {
			$this->zp_eh->addFatal('Cannot connect to DB.',mysql_error());
		}
		if (!@mysql_select_db($this->database,$zp_db_link)) {
			$this->zp_eh->addFatal('Cannot select DB.',mysql_error());
		}
		$this->link = $zp_db_link;
	}
	
	/**
	 * Perform a simple DB query and return the result as a query object
	 * @param $sql	SQL query
	 * @return A MySQL query object
	 */
	function query($sql) {
		$this->zp_eh->addInfo('Query:',$sql);
		
		$sql = $this->translateTables($sql);
		if (!$query = @mysql_query($sql,$this->link)) {
			$this->zp_eh->addError('Query failed:',mysql_error());
		}
		if (mysql_num_rows($query)==0) {
			$this->zp_eh->addWarning('Query returned no results:',$sql);
		}
		return $query;
	}
	
	/**
	 * Perform a simple DB query and return the result as an associative array
	 * @param $sql	SQL query
	 * @return An associative array
	 */
	function queryArray($sql) {
		$query = $this->query($sql);
		
		while ($row = @mysql_fetch_assoc($query)) {
			$out[] = $row;
		}
		
		return $out;
	}
	
	/**
	 * Perform a query with a single result. Drop other results, should they be returned.
	 * @param $sql	SQL query
	 * @return	The result of the query
	 */
	function querySingle($sql) {
		$query = $this->query($sql);
		
		if (mysql_num_rows($query)>1) {
			$this->zp_eh->addWarning('querySingle returned more than 1 result:',$sql);
		}
		
		if (mysql_num_fields($query)>1) {
			$this->zp_eh->addWarning('querySingle result has more than 1 field:',$sql);
		}
		
		$row = mysql_fetch_row($query);
		return $row[0];
	}
	
	/**
	 * Translate the standard table placeholder to the actual name of the table
	 * in a query. Add table prefix if necessary.
	 * @param $sql	SQL query
	 * @return Translated query
	 */
	function translateTables($sql) {
		$sql = preg_replace('/db_([^ ,]+)_table/i',$this->prefix.'\1',$sql);
		$this->zp_eh->addInfo('Query (translated):',$sql);
		
		return $sql;
	}
}
?>
