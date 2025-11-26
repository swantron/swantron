function TinyMCE_inlinemore_initInstance(inst)
{
    tinyMCE.importCSS(inst.getDoc(), tinyMCE.baseURL + "/plugins/inlinemore/inlinemore.css");
}


function TinyMCE_inlinemore_getControlHTML(control_name)
{
    switch (control_name) {
		case "inlinemore":
            var buttons = '<a href="javascript:tinyMCE.execInstanceCommand(\'{$editor_id}\',\'mceinlinemore\')" target="_self" onclick="tinyMCE.execInstanceCommand(\'{$editor_id}\',\'mceinlinemore\');return false;"><img id="{$editor_id}_inline_more" src="{$pluginurl}/inlinemore_toolbar.gif" title="Inline More" width="20" height="20" class="mceButtonNormal" /></a>';
            return buttons;
    }

    return '';
}

function TinyMCE_inlinemore_execCommand(editor_id, element, command, user_interface, value)
{
    var inst = tinyMCE.getInstanceById(editor_id);
	var focusElm = inst.getFocusElement();
	var doc = inst.getDoc();

	function getAttrib(elm, name) { return elm.getAttribute(name) ? elm.getAttribute(name) : ""; }

    switch (command)
    {
        case "mceinlinemore":
            var flag = "";
            var template = new Array();

            // Is selection a image
            if (focusElm != null && focusElm.nodeName.toLowerCase() == "img") {
                flag = getAttrib(focusElm, 'class');

                if (flag != 'mce_plugin_inlinemore')
                    return true;

                action = "update";
            }

            html = '<img src="' + (tinyMCE.getParam("theme_href") + "/images/spacer.gif") + '" '
                 + 'alt="Inline More" title="Inline More" class="mce_plugin_inlinemore" name="mce_plugin_inlinemore" />';
            tinyMCE.execCommand("mceInsertContent",true,html);
            tinyMCE.selectedInstance.repaint();
            return true;
    }

    return false;
}



function TinyMCE_inlinemore_cleanup(type, content)
{
    var token = tinyMCE.settings['inlinemore_token'];
    var token_len = token.length;

    switch (type)
    {
		case "insert_to_editor":
			var startPos = 0;

			// Parse all <!--more|inline--> tags and replace them with images
			while ((startPos = content.indexOf(token, startPos)) != -1)
            {
				// Insert image
				var contentAfter = content.substring(startPos + token_len);
				content = content.substring(0, startPos);
				content += '<img src="' + (tinyMCE.getParam("theme_href") + "/images/spacer.gif") + '" '
                         + ' width="100%" height="10px" '
                         + 'alt="Inline More" title="Inline More" class="mce_plugin_inlinemore" name="mce_plugin_inlinemore" />';
				content += contentAfter;

				startPos++;
			}
			var startPos = 0;
            break;

       case "get_from_editor":
			// Parse all img tags and replace them with <!--more-->
			var startPos = -1;
			while ((startPos = content.indexOf('<img', startPos+1)) != -1)
            {
				var endPos = content.indexOf('/>', startPos);
				var attribs = TinyMCE_wordpressPlugin._parseAttributes(content.substring(startPos + 4, endPos));

				if (attribs['class'] == "mce_plugin_inlinemore") {
					endPos += 2;
	
					var embedHTML = token;
	
					// Insert embed/object chunk
					chunkBefore = content.substring(0, startPos);
					chunkAfter = content.substring(endPos);
					content = chunkBefore + embedHTML + chunkAfter;
				}
			}
            break;
    }

    return content;
}