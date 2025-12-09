/**
 * ZenPress plugin for tinyMCE. To be used with the ZenPress plugin for WordPress.
 * Author: Alessandro Morandi
 * Website: http://www.simbul.net/zenpress
 * Version: 1.0
 */

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
 * Information about the plugin.
 */
function TinyMCE_zenpress_getInfo() {
	return {
		longname  : 'ZenPhoto Gallery Plugin for WordPress',
		author    : 'Alessandro Morandi',
		authorurl : 'http://www.simbul.net',
		infourl   : 'http://www.simbul.net/zenpress',
		version   : "1.0"
	};
}

/**
 * Gets executed when the editor needs to generate a button.
 */
function TinyMCE_zenpress_getControlHTML(control_name) {
	switch (control_name) {
		case "zenpress":
		return '<img id="{$editor_id}_zenpress" src="{$pluginurl}/images/zenpress.gif" title="zenpress" width="20" height="20" class="mceButtonNormal" onmouseover="tinyMCE.switchClass(this,\'mceButtonOver\');" onmouseout="tinyMCE.restoreClass(this);" onmousedown="tinyMCE.restoreAndSwitchClass(this,\'mceButtonDown\');" onclick="tinyMCE.execInstanceCommand(\'{$editor_id}\',\'zenpress\');">';
	}

	return "";
}

/**
 * Executed when a command is issued
 */
function TinyMCE_zenpress_execCommand(editor_id, element, command, user_interface, value) {
	// Handle commands
	switch (command) {
		case "zenpress":
			var template = new Array();

			template['file']   = tinyMCE.baseURL + '/plugins/zenpress/popup_zp.php?tinyMCE=1';
			template['width']  = 480;
			template['height'] = 400;

			args = {
				resizable : 'yes',
				scrollbars : 'yes'
			};

			tinyMCE.openWindow(template, args);
			return true;
	}

	// Pass to next handler in chain
	return false;
}