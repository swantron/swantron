<?php
// CHANGE THIS if you changed the text token
define('OLD_TEXT_TOKEN', '<!--more|inline-->');

// CHANGE THIS if you changed the new text token
define('NEW_TEXT_TOKEN', '<!--inline-more-->');







require('../wp-config.php');
@header('Content-type: ' . get_option('html_type') . '; charset=' . get_option('blog_charset'));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_option('blog_charset'); ?>" />
	<title>MoreLink Upgrade</title>
	<link rel="stylesheet" href="<?php echo get_option('siteurl') ?>/wp-admin/install.css?version=<?php bloginfo('version'); ?>" type="text/css" />
</head>
<body>
<h1 id="logo"><img alt="WordPress" src="images/wordpress-logo.png" /></h1>
<?php
$_GET['step'] = (isset($_GET['step']) ? $_GET['step'] : 0);





##################################################
# 1. Intro / Confirm
##################################################
if ($_GET['step'] == 0) {
	?>
	
	<strong>What needs updating?</strong><br />
	To upgrade the MoreLink plugin, it is required to search-and-replace the old text token,
	<code>&lt;!--more|inline--&gt;</code> to a new token, <code>&lt;!--inline-more--&gt;</code>
	<br /><br />
	
	<strong>Why?</strong><br />
	As you know, WordPress lets you split up a post using <code>&lt;!--more--&gt;</code>. A new feature
	just added lets you also supply text in palce of the default "Read More" link text. For example,
	<code>&lt;!--more Read the rest of my amazing story--&gt;</code>. This means that
	WordPress now interprets the "|inline" part as the link text, which isn't what we want at all.
	<br /><br />
	
	<strong>I've changed my text token, does it need updating?</strong><br />
	If you changed the text token to anything other then something that begins with
	<code>&lt;!--more</code>, then you are fine and you don't need to run this upgrade script.
	<em>If you changed the token but it still follows that pattern, edit this PHP file and change the
	'OLD_TEXT_TOKEN' constant at the top, and then run the script. If you changed the new one, you 
	should also edit this script but edit the 'NEW_TEXT_TOKEN' constant.</em>
	<br /><br />
	
	<strong>What will happen?</strong><br />
	This script will perform a query that will do a simple search and replace for the old token
	in the new token.<br /><br />
	
	<strong>You should backup</strong> before proceeding. While it is a simple search and replace,
	you should always do a backup before making changes to your database "just in case" :)
	
	<div style="border:3px solid #ccc;margin:15px;padding:15px;text-align:center;">
		<form action="morelink-upgrade-beta11.php" method="get">
		<input type="hidden" name="step" value="1" id="step" />
		<label for="read">
			<input type="checkbox" name="read" value="1" id="read" />
			I've read this page and understand what is going to happen
		</label><br />
		<input type="submit" name="go" value="Do Upgrade" id="go">
	</div>
	
	<?php
}






##################################################
# 2. Intro / Confirm
##################################################
if ($_GET['step'] == 1) {
	$old_token = $wpdb->escape(OLD_TEXT_TOKEN);
	$new_token = $wpdb->escape(NEW_TEXT_TOKEN);
	$sql = "UPDATE {$wpdb->posts} SET post_content = replace(post_content, '$old_token', '$new_token')";
	
	echo "<strong>Performing Query...</strong> ";
	$num = $wpdb->query($sql);
	echo "Done ($num posts updated)<br /><br />";
	
	echo "That's it :) You can now delete this file and be on your way.";
}

?>
</body>
</html>