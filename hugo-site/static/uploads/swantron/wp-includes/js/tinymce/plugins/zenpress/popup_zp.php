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

require_once('classes.php');

// Create Error Handling Object
$zp_eh = new ZenPressErrorHandler(ZP_E_ERROR);	// To debug use ZP_E_ALL

// Start output buffering
ob_start(array($zp_eh,'callback'));

$zp_eh->addInfo('PHP Version:',phpversion());
$zp_eh->addInfo('Current working directory:',getcwd());
$zp_eh->addInfo('POST:',$_POST);
$zp_eh->addInfo('GET:',$_GET);

// Determine if in a WordPress installation by checking for wp-config.php
// Strongly inspired by Gallery2WP plugin
for ($count = 1; $count <= 10; $count++) {
	$rel_path = $rel_path.'../';
	if (file_exists($rel_path . 'wp-config.php')) {
		require_once($rel_path.'wp-config.php');
		require_once($rel_path.'wp-admin/admin.php');
		$language = get_locale();
		$zp_web_path = get_option('zp_web_path');
		$zp_admin_path = get_option('zp_admin_path');
		
		$zp_eh->addInfo('Web path:',$zp_web_path);
		$zp_eh->addInfo('Admin path:',$zp_admin_path);
		$zp_eh->addInfo('WordPress ABSPATH:',ABSPATH);
		$zp_eh->addInfo('WordPress siteurl:',get_option('siteurl'));
		
		if ($zp_web_path=="" || $zp_admin_path=="") {	
			$zp_eh->addFatal('Zenphoto paths are not set. Check the configuration page.');
		}
		if (!file_exists($zp_admin_path.'/config.php')) {
			$zp_eh->addWarning('File config.php not found. Looking for zp-config.php');
			// Support for future Zenphoto versions
			if (!file_exists($zp_admin_path.'/zp-config.php')) {
				$zp_eh->addFatal('Cannot find Zenphoto configuration file.');
			} else {
				require_once($zp_admin_path.'/zp-config.php');
			}
		} else {
			require_once($zp_admin_path.'/config.php');
		}
		break;
	}
}
$zp_eh->addInfo('mod_rewrite:',$conf['mod_rewrite']);

// Create Database Object
$zp_db = new ZenPressDB($conf['mysql_host'], $conf['mysql_user'], $conf['mysql_pass'], $conf['mysql_database'], $conf['mysql_prefix']);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>ZenPress Dialog</title>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	<?php if ($_GET[tinyMCE]) {?>
	<script language='javascript' type='text/javascript' src='../../tiny_mce_popup.js'></script>
	<?php } else { ?>
	<link rel='stylesheet' href='css/zenpress.css' type='text/css' />
	<?php } ?>
	<script language='javascript' type='text/javascript' src='js/functions.js'></script>
	<style type="text/css">
		div.zpOpen {
			display:block;
		}
		div.zpClosed {
			display:none;
		}
		#options a {
			text-decoration:none;
		}
		.thumb {
			float:left;
			padding:5px;
			margin:5px;
			border:1px solid black;
		}
		.normal .normal, .alt .alt {
			display:block;
		}
		.normal .alt, .alt .normal {
			display:none;
		}
	</style>
</head>

<body>
<?php
	ZenPressGUI::print_albums($_POST[album]);
	
	if ($_POST[album]) {
		ZenPressGUI::print_image_select($_POST[album]);
	}

	// Stop buffering output
	ob_end_flush();
?>
</body>
</html>