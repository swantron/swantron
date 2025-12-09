function TinyMCE_zenpress_getInfo() { return { longname : 'ZenPhoto Gallery Plugin for WordPress', author : 'Alessandro Morandi', authorurl : 'http://www.simbul.net', infourl : 'http://www.simbul.net/zenpress', version : "1.0"
};}
function TinyMCE_zenpress_getControlHTML(control_name) { switch (control_name) { case "zenpress":
return '<img id="{$editor_id}_zenpress" src="{$pluginurl}/images/zenpress.gif" title="zenpress" width="20" height="20" class="mceButtonNormal" onmouseover="tinyMCE.switchClass(this,\'mceButtonOver\');" onmouseout="tinyMCE.restoreClass(this);" onmousedown="tinyMCE.restoreAndSwitchClass(this,\'mceButtonDown\');" onclick="tinyMCE.execInstanceCommand(\'{$editor_id}\',\'zenpress\');">';}
return "";}
function TinyMCE_zenpress_execCommand(editor_id, element, command, user_interface, value) { switch (command) { case "zenpress":
var template = new Array(); template['file'] = tinyMCE.baseURL + '/plugins/zenpress/popup_zp.php?tinyMCE=1'; template['width'] = 480; template['height'] = 400; args = { resizable : 'yes', scrollbars : 'yes'
}; tinyMCE.openWindow(template, args); return true;}
return false;}
