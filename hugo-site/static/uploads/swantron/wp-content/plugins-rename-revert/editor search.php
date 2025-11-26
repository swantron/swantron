<?php
/*
Plugin Name: Editor Search
Plugin URI: http://www.theoneandtheonly.com/wordpress-editor-search/
Description: Adds search feature to theme and plug-in editors in the WordPress admin area.  Also offers a 'go to line number' feature.  Requires JavaScript to be enabled in your browser.
Version: 1.3
Author: Andrew Buckman
Author URI: http://www.theoneandtheonly.com/
*/

# The Editor Search plugin now has the ability to load the javascript "externally" IF desired.
# This should save a bit of bandwidth as your browser should cache the external javascript,
# however I noticed a slight delay in adding the form inputs when using this method. A small
# nitpick I grant you, but it annoys me so I'm leaving the default method as the way it's
# always been.  That said, if you would prefer the external method, you have two choices below.
# Leave them both commented (default) if you don't want the external method.

# Editor Search can attempt to determine its filename, however if you've named the plugin without
# BOTH 'editor' and 'search' in the title, it won't find it.  In that case it will revert back to
# including the javascript source on the page.  To try the auto-detect routine, uncomment the
# line below.  If you're wondering if it worked, view the source of a page the plugin loads on,
# near the bottom you'll see a script referencing an external file, or the full source printed.
# $ajbES_filename = 'AUTO';

# If you have problems with the auto-detect or would simply prefer to set it to the proper location,
# uncomment the line below and set the variable to the proper location of the plugin file.
# $ajbES_filename = '/wp-content/plugins/editor-search.php';

# ---------- STOP EDITING ----------

# Output Javascript Code
if ( !function_exists('ajbES_output_js') ) {
  function ajbES_output_js() {
?>
  // WordPress Editor Search Plugin :: Javascript Code
  // ©2005 Andrew Buckman
  // http://www.theoneandtheonly.com/wordpress-editor-search/

        var ajbES_insBeforeMe = document.getElementById("templateside");
        var ajbES_insParent = ajbES_insBeforeMe.parentNode;
        var ajbES_insMe = document.getElementById("ajbESdiv");
        ajbES_insParent.insertBefore(ajbES_insMe, ajbES_insBeforeMe);

        function ajbES_Search() {
          var a = document.getElementById("ajbES_SearchInput");
          var b = document.getElementById("newcontent");
          if (b.setSelectionRange) {
            ajbES_Search_Firefox(a, b);
          } else if (b.createTextRange) {
            ajbES_Search_IE(a, b);
          }
        }

        function ajbES_Search_IE(a, b) {
          b.focus();
          // Internet Explorer
          var rc = document.selection.createRange().duplicate();
          var r = document.selection.createRange(); // b.createTextRange()
          r.setEndPoint("StartToEnd", rc);
          foundPos = r.findText(a.value);
          if (!foundPos) {
            // Not found, wrap-around
            r = b.createTextRange();
            foundPos = r.findText(a.value);
          }
          if (foundPos) {
            r.expand("word");
            r.select();
          } else {
            alert('No match found!');
          }
        }

        function ajbES_Search_Firefox(a, b) {
          // grab cursor position for starting point of search
          var cursorPos = 0;
          if (b.selectionStart!=b.value.length) cursorPos = b.selectionStart + 1;

          // find text

          var foundPos;
          foundPos = b.value.indexOf(a.value, cursorPos);
          if ((foundPos < 0) && (cursorPos > 0)) {
            // text not found, try looping to the start and looking again
            foundPos = b.value.indexOf(a.value);
          }

          if (foundPos < 0) {
            alert('No match found!');
          } else {
            // select textarea (b) and move cursor to foundPos
            b.focus();
            b.selectionStart = foundPos;
            b.selectionEnd = foundPos + a.value.length;
            ajbES_scrollToCursor();
          }
        }

        function ajbES_FindLineNumber() {
          var a = document.getElementById("ajbES_LineNumInput");
          if (a.value) {
            a = a.value - 1;
            var b = document.getElementById("newcontent");
            var lines = b.value.split('\n');
            if (a<lines.length && a>=0) {
              var i;
              var cursorPos=0;
              for (i=0; i<a; i++) {
                cursorPos += lines[i].length;
              }
              if (lines[a].length==0) alert('Warning, your selected line is blank, the cursor will show up at end of previous line.');
              b.focus();
              if (b.setSelectionRange) {
                // Firefox
                cursorPos += a; // Adjust to account for newline chars
                b.selectionStart = cursorPos;
                b.selectionEnd = cursorPos;
                ajbES_scrollToCursor();
              } else if (b.createTextRange) {
                // Internet Explorer
                var r = b.createTextRange();
                r.move("character", cursorPos);
                r.select();
                // IE doesn't appear to need scrolling function
              }
            } else if (a>=lines.length) {
              alert('Sorry there are only ' + lines.length + ' lines in the textarea.');
            } else {


              alert('Please enter a valid line number to go to.');
            }
          }
        }

        function ajbES_scrollToCursor() {
          // scrolls the textarea so the cursor / highlight are onscreen
          var b = document.getElementById("newcontent");

          var cursorPos  = b.selectionStart;
          var linesTotal = b.value.split('\n').length;
          var linesAbove = b.value.slice(0, cursorPos).split('\n').length - 1;
          if (linesAbove<(b.rows/2)) linesAbove = 0;
          var scrollTo = (linesAbove / (linesTotal-b.rows)) * (b.scrollHeight - b.clientHeight);
          b.scrollTop = scrollTo;
        }

        function ajbES_clearbox(a) {
          // When user clicks in an input field, clear the other one
          if (a=='search') {
            document.getElementById('ajbES_LineNumInput').value='';
          } else if (a=='linenum') {
            document.getElementById('ajbES_SearchInput').value='';
          }
        }
<?php
  }
}

if ($_GET['ajbESjs']=='true') {
  # Output Javascript
  header('Content-type: text/javascript');
  ajbES_output_js();

} else {
  # Wordpress Integration Follows

  if ( !function_exists('ajbES_insert_code') ) {
    # Inserts Code into Wordpress Page
    function ajbES_insert_code() {
      # Locate Plugin File for Javascript Inclusion
      global $ajbES_filename;

      # This routine auto-detects the location of the editor search plugin.
      # It only runs if the filename is set to auto at the top of the script indicating
      # the user would prefer an external inclusion of the javascript source.
      if ($ajbES_filename=='AUTO') {
        unset($ajbES_filename);
        if ($ajbPlugs=get_settings('active_plugins')) {
          if (is_array($ajbPlugs)) {
            foreach ($ajbPlugs AS $ajbPlug) {
              if (strpos(strtolower($ajbPlug),'editor')!==false && strpos(strtolower($ajbPlug), 'search')!==false) {
                if (file_exists(ABSPATH . 'wp-content/plugins/' . $ajbPlug)) {
                  $ajbES_filename = get_settings('siteurl') . '/wp-content/plugins/' . $ajbPlug;
                  break;
                }
              }
            }
          }
        }
        unset($ajbPlug,$ajbPlugs);
      }
?>
      <div id="ajbESdiv" style="display: inline;">
        <div style="display:inline">
          <form style="display:inline" action="#" onsubmit="ajbES_Search(); return false;">
            <input id="ajbES_SearchInput" type="text" value="" onclick="ajbES_clearbox('search')"/>
            <input type="button" value="Find Below" onclick="ajbES_Search(); return false;" />
          </form>
        </div>
        <div style="display:inline; border-left: 1px solid gray; padding-left: 8px; margin-left: 5px;">
        <form style="display:inline" action="#" onsubmit="ajbES_FindLineNumber(); return false;">
          <input id="ajbES_LineNumInput" type="text" value="" style="width: 40px; text-align: right" onclick="ajbES_clearbox('linenum')"/>
          <input type="button" value="GoTo Line#" onclick="ajbES_FindLineNumber(); return false;" />
        </form>
        </div>
      </div>
  <?php
      if ($ajbES_filename) {
        # Found filename, use external method
        echo "      <script type=\"text/javascript\" src=\"{$ajbES_filename}?ajbESjs=true\"></script>\n";
      } else {
        # Print out javascript here
        echo "      <script type=\"text/javascript\"><!--//--><![CDATA[//><!--\n";
        ajbES_output_js();
        echo "      //--><!]]></script>\n";
      }
    }
  }

  if ( !function_exists('ajbES_admin_footer') )  {
    function ajbES_admin_footer($content) {
      if((preg_match('|theme-editor.php|i', $_SERVER["REQUEST_URI"])) ||
         (preg_match('|plugin-editor.php|i', $_SERVER["REQUEST_URI"]))) {
        ajbES_insert_code();
      }
    }
  }
  add_filter ('admin_footer', 'ajbES_admin_footer');
}
?>