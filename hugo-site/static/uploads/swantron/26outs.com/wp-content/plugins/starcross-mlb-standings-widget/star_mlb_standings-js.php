<?php

// Include wp-config.php
@require('../../../wp-config.php');
cache_javascript_headers();

// Include the needed classes and functions.
require_once('star_mlb_standings.php');

// These are the widget's options.
$options	= get_option('widget_star_mlb_standings');

// Instantiate standings object.
$star_mlb_standings	= new star_mlb_standings($options);

// Include the cached MLB standings javascript.
$standings_js	= get_option('star_mlb_standings_js');
echo $standings_js;

// Build JavaScript array of divisions.
$js_divs	= '[';
foreach ($star_mlb_standings->div_array as $div => $div_name) {
	$js_divs	.= '"' . $div . '",';
}
$js_divs	= trim($js_divs, ',');
$js_divs	.= ']';

// Build JavaScript array of team nicknames.
$js_teams	= '[';
foreach ($star_mlb_standings->teams as $nick => $mascot) {
	$js_teams	.= '"' . $nick . '",';
}
$js_teams	= trim($js_teams, ',');
$js_teams	.= ']';
?>

/**
 * @desc function star_mlb_standings()
 * The function star_mlb_standings() builds a small table of current standings
 *   and outputs it as a table inside the given html object.
 *
 * @param string division
 * @param string team
 */
function star_mlb_standings() {
	// Deal with any passed arguments.
	if (arguments[0] != null && arguments[0] != 'undefined' && in_array(arguments[0], <?php echo $js_divs; ?>)) {
		star_mlb_options['division']	= arguments[0];
	}
	if (arguments[1] != null && arguments[1] != 'undefined' && in_array(arguments[1], <?php echo $js_teams; ?>)) {
		star_mlb_options['team']		= arguments[1];
	}

	var showDivs	= <?php echo ($options['showDivs'] === false) ? 'false' : 'true'; ?>;
	var showSubHead	= <?php echo ($options['showSubHead'] === false) ? 'false' : 'true'; ?>;

	// Build team mascots array.
	var mascots	= new Object;
<?php
foreach ($star_mlb_standings->teams as $nick => $mascot) {
?>
	mascots['<?php echo addslashes($nick); ?>']	= '<?php echo addslashes($mascot); ?>';
<?php
}
?>

	// Get the object to contain the standings content.
	var standingsBody	= document.getElementById('star_mlb_standings_body');

	// Get the object to contain the standings head.
	var standingsHead	= document.getElementById('star_mlb_standings_head');

	// Get the variable that contains the current standings and the head.
	var standings_rs	= '';
	var standings_head	= '';

	// Deal with the division.
	var division	= star_mlb_options['division'];
	if (division == null || division == 'undefined') {
		division	= 'nlc';
	}

	// Deal with the team.
	var team		= star_mlb_options['team'];

	switch (division) {
		// American League East.
		case 'ale':
			standings_rs	= eval('standings_rs_' + division);
			standings_head	= '<acronym title="American League">AL</acronym> East';
		break;

		// American League Central.
		case 'alc':
			standings_rs	= eval('standings_rs_' + division);
			standings_head	= '<acronym title="American League">AL</acronym> Central';
		break;

		// American League West.
		case 'alw':
			standings_rs	= eval('standings_rs_' + division);
			standings_head	= '<acronym title="American League">AL</acronym> West';
		break;

		// National League East.
		case 'nle':
			standings_rs	= eval('standings_rs_' + division);
			standings_head	= '<acronym title="National League">NL</acronym> East';
		break;

		// National League West.
		case 'nlw':
			standings_rs	= eval('standings_rs_' + division);
			standings_head	= '<acronym title="National League">NL</acronym> West';
		break;

		// National League Central.
		case 'nlc':
		default:
			standings_rs	= eval('standings_rs_' + division);
			standings_head	= '<acronym title="National League">NL</acronym> Central';
		break;
	}

	if (!showSubHead) {
		standings_head	= '';
	}

	// Build the links.
	var standings	= '';
	if (showDivs) {
		standings	+= '<div class="center">';
		if (division == 'alw') {
			standings	+= '<acronym title="American League West">ALW</acronym>\n';
		} else {
			standings	+= '<a href="javascript:star_mlb_standings(\'alw\');"><acronym title="American League West">ALW</acronym></a>\n';
		}
		if (division == 'alc') {
			standings	+= '<acronym title="American League Central">ALC</acronym>\n';
		} else {
			standings	+= '<a href="javascript:star_mlb_standings(\'alc\');"><acronym title="American League Central">ALC</acronym></a>\n';
		}
		if (division == 'ale') {
			standings	+= '<acronym title="American League East">ALE</acronym>\n';
		} else {
			standings	+= '<a href="javascript:star_mlb_standings(\'ale\');"><acronym title="American League East">ALE</acronym></a>\n';
		}
		if (division == 'nlw') {
			standings	+= '<acronym title="National League West">NLW</acronym>\n';
		} else {
			standings	+= '<a href="javascript:star_mlb_standings(\'nlw\');"><acronym title="National League West">NLW</acronym></a>\n';
		}
		if (division == 'nlc') {
			standings	+= '<acronym title="National League Central">NLC</acronym>\n';
		} else {
			standings	+= '<a href="javascript:star_mlb_standings(\'nlc\');"><acronym title="National League Central">NLC</acronym></a>\n';
		}
		if (division == 'nle') {
			standings	+= '<acronym title="National League East">NLE</acronym>\n';
		} else {
			standings	+= '<a href="javascript:star_mlb_standings(\'nle\');"><acronym title="National League East">NLE</acronym></a><br />\n';
		}
		standings	+= '</div>';
	}

	// Start the standings table.
	standings		+= '<table class="ruler"><thead><tr><th>Team</th><th><acronym title="Wins">W</acronym></th><th><acronym title="Losses">L</acronym></th><th><acronym title="Winning Percentage">Pct.</acronym></th><th><acronym title="Games Back">GB</acronym></th></tr></thead><tbody>';

	// Iterate through each of the teams, displaying their data.
	for (i = 0; i < standings_rs.length; i++) {
		// Bold the selected team.
		if (standings_rs[i].code == team) {
			standings_rs[i].league_sensitive_team_name	= standings_rs[i].league_sensitive_team_name;
		}

		// Check URL for last game wrap.
		if (standings_rs[i].wrap != null) {
			var url	= '<a href="http://mlb.mlb.com/news/boxscore.jsp?gid=' + standings_rs[i].gameid + '" title="Last game: ' + standings_rs[i].lastg + '">' + standings_rs[i].league_sensitive_team_name + '</a>';
		} else {
			var url	= '<span title="Last game: ' + standings_rs[i].lastg + '">' + standings_rs[i].league_sensitive_team_name + '</span>';
		}
		standings	+= '<tr>';
		standings	+= '<td>' + url + '</td>';
		standings	+= '<td>' + standings_rs[i].w + '</td>';
		standings	+= '<td>' + standings_rs[i].l + '</td>';
		standings	+= '<td>' + standings_rs[i].pct + '</td>';
		standings	+= '<td>' + standings_rs[i].gb + '</td>';
		standings	+= '</tr>';
	}

	// Close the table.
	standings	+= '</tbody></table>';

	// Include a link to full standings.
	standings	+= '<a class="bold" href="http://mlb.mlb.com/mlb/standings/index.jsp">Expanded Standings</a>';

	// Set the standings object to the standings table.
	standingsBody.innerHTML	= standings;
	standingsHead.innerHTML	= standings_head;
	if (typeof(tableruler) == 'function') {
		tableruler();
	}
}

function in_array(needle, haystack, strict) {
	// http://kevin.vanzonneveld.net
	// +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	// *     example 1: in_array('van', ['Kevin', 'van', 'Zonneveld']);
	// *     returns 1: true

	var found = false, key, strict = !!strict;

	for (key in haystack) {
		if ((strict && haystack[key] === needle) || (!strict && haystack[key] == needle)) {
			found	= true;
			break;
		}
	}

	return found;
}

function addLoadEvent(func) {
	var oldonload	= window.onload;
	if (typeof window.onload != 'function') {
		window.onload	= func;
	} else {
		window.onload	= function() {
			if (oldonload) {
				oldonload();
			}
			func();
		}
	}
}

var star_mlb_options = new Object;
star_mlb_options['division']	= '<?php echo $star_mlb_standings->division['abbr']; ?>';
star_mlb_options['team']		= '<?php echo $star_mlb_standings->team; ?>';
addLoadEvent(star_mlb_standings);
