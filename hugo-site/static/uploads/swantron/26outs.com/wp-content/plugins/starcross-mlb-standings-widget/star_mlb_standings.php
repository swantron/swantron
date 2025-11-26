<?php
/*
Plugin Name: Starcross MLB Standings Widget
Plugin URI: http://www.starcrossonline.com/mlb-standings-widget/
Description: Adds a sidebar widget to display MLB standings. Year, division, and default team are all customizable.
Author: Jonathan Cross
Version: 1.4.1
Author URI: http://www.starcrossonline.com/
*/

/**
 * @desc function widget_star_mlb_standings_init()
 */
function widget_star_mlb_standings_init() {
	if (!function_exists('register_sidebar_widget')) {
		return;
	}

	class star_mlb_standings {
		/**
		 * Class variables.
		 */
		// Set name of widget directory.
		var $widget_name	= 'starcross-mlb-standings-widget';
		// Division array.
		var $div_array	= array(
			'alc'	=> 'AL Central',
			'ale'	=> 'AL East',
			'alw'	=> 'AL West',
			'nlc'	=> 'NL Central',
			'nle'	=> 'NL East',
			'nlw'	=> 'NL West'
		);
		// Team array.
		var $teams		= array(
			'oak'	=> "A's",
			'ana'	=> 'Angels',
			'hou'	=> 'Astros',
			'tor'	=> 'Blue Jays',
			'atl'	=> 'Braves',
			'mil'	=> 'Brewers',
			'stl'	=> 'Cardinals',
			'chc'	=> 'Cubs',
			'tb'	=> 'Devil Rays',
			'ari'	=> 'Diamondbacks',
			'la'	=> 'Dodgers',
			'sf'	=> 'Giants',
			'cle'	=> 'Indians',
			'sea'	=> 'Mariners',
			'fla'	=> 'Marlins',
			'nym'	=> 'Mets',
			'was'	=> 'Nationals',
			'bal'	=> 'Orioles',
			'sd'	=> 'Padres',
			'phi'	=> 'Phillies',
			'pit'	=> 'Pirates',
			'tex'	=> 'Rangers',
			'cin'	=> 'Reds',
			'bos'	=> 'Red Sox',
			'col'	=> 'Rockies',
			'kc'	=> 'Royals',
			'det'	=> 'Tigers',
			'min'	=> 'Twins',
			'cws'	=> 'White Sox',
			'nyy'	=> 'Yankees'
		);
		// Variables to store options.
		var $date;
		var $division;
		var $refresh		= '6';
		var $showDivs		= true;
		var $showSubHead	= true;
		var $team;
		var $title;

		/**
		 * @desc function star_mlb_standings()
		 * The function star_mlb_standings() is the constructor for the class. It sets
		 *   variables.
		 * 
		 * @param array $options
		 */
		function star_mlb_standings($options) {
			$this->set_date($options['date']);
			$this->set_division($options['division']);
			$this->set_refresh($options['refresh']);
			$this->set_team($options['team']);
			$this->set_title($options['title']);
			$this->set_showDivs($options['showDivs']);
			$this->set_showSubHead($options['showSubHead']);
		}

		/**
		 * @desc function get_date()
		 * The function get_date() returns the date array.
		 *
		 * @return array $date
		 */
		function get_date() {
			return $this->date;
		}

		/**
		 * @desc function get_division()
		 * The function get_division() returns the division array.
		 *
		 * @return array $division
		 */
		function get_division() {
			return $this->division;
		}

		/**
		 * @desc function get_refresh()
		 * The function get_refresh() returns the refresh rate.
		 *
		 * @return integer $refresh
		 */
		function get_refresh() {
			return $this->refresh;
		}

		/**
		 * @desc function get_showDivs()
		 * The function get_showDivs() returns the showDivs option.
		 *
		 * @return boolean $showDivs
		 */
		function get_showDivs() {
			return $this->showDivs;
		}

		/**
		 * @desc function get_showSubHead()
		 * The function get_showSubHead() returns the showSubHead option.
		 *
		 * @return boolean $showSubHead
		 */
		function get_showSubHead() {
			return $this->showSubHead;
		}

		/**
		 * @desc function get_team()
		 * The function get_team() returns the selected team.
		 *
		 * @return array $team
		 */
		function get_team() {
			return $this->team;
		}

		/**
		 * @desc function get_title()
		 * The function get_title() returns the widget title.
		 *
		 * @return array $title
		 */
		function get_title() {
			return $this->title;
		}

		/**
		 * @desc function set_date()
		 * The function set_date() sets the date array for the widget. It accepts
		 *   either 'previous' or 'current' for which season to display.
		 *
		 * @param enum(previous, current) $date
		 * @return boolean
		 */
		function set_date($date) {
			if ($date == 'previous' && date('n') < 4) {
				// Set to the December 31 of the previous year when the current month
				//   is not yet April.
				$year	= date('Y') - 1;
				$month	= '12';
				$day	= '31';
			} else {
				$year	= date('Y');
				$month	= date('m');
				$day	= date('d');
			}

			$this->date	= array(
				'year'	=> $year,
				'month'	=> $month,
				'day'	=> $day
			);

			return true;
		}

		/**
		 * @desc function set_division()
		 * The function set_division() sets the division array for the selected
		 *   division. The given division must be in the div_array.
		 *
		 * @param string $division
		 * @return boolean
		 */
		function set_division($division) {
			if (empty($division) || !array_key_exists($division, $this->div_array)) {
				$division	= 'nlc';
			}

			$this->division	= array(
				'abbr'	=> $division,
				'name'	=> $this->div_array[$division]
			);

			return true;
		}

		/**
		 * @desc function set_refresh()
		 * The function set_refresh() sets how often the widget should refresh
		 *   the standings data.
		 *
		 * @param integer $refresh
		 * @return boolean
		 */
		function set_refresh($refresh) {
			if (!ctype_digit((string)$refresh) || $refresh <= 0) {
				return false;
			}

			$this->refresh	= $refresh;
			return true;
		}

		/**
		 * @desc function set_showDivs()
		 * The function set_showDivs() sets whether to display the division
		 *   links.
		 *
		 * @param boolean $showDivs
		 * @return boolean
		 */
		function set_showDivs($showDivs) {
			if ($showDivs !== false) {
				$showDivs	= true;
			}

			$this->showDivs	= $showDivs;
			return true;
		}

		/**
		 * @desc function set_showSubHead()
		 * The function set_showSubHead() sets whether to display the current
		 *   division.
		 *
		 * @param boolean $showSubHead
		 * @return boolean
		 */
		function set_showSubHead($showSubHead) {
			if ($showSubHead !== false) {
				$showSubHead	= true;
			}

			$this->showSubHead	= $showSubHead;
			return true;
		}

		/**
		 * @desc function set_team()
		 * The function set_team() sets the selected team. The given team must
		 *   be in the teams array.
		 *
		 * @param string $team
		 * @return boolean
		 */
		function set_team($team) {
			if (array_key_exists($team, $this->teams)) {
				$this->team	= $team;
			}

			return true;
		}

		/**
		 * @desc function set_title()
		 * The function set_title() sets the title for the widget.
		 *
		 * @param string $title
		 * @return boolean
		 */
		function set_title($title) {
			$this->title	= $title;

			return true;
		}

		function is_division($division) {
			if (array_key_exists($division, $this->div_array)) {
				return true;
			} else {
				return false;
			}
		}

		function is_team($team) {
			if (array_key_exists($team, $this->teams)) {
				return true;
			} else {
				return false;
			}
		}

		/**
		 * @desc function include_js_css()
		 * The function include_js_css() includes the needed JavaScript and CSS
		 *  files for the widget.
		 * 
		 * @return string $js_css
		 */
		function include_js_css() {
			// Buffer content.
			ob_start();

?>
	<script type="text/javascript" src="<?php bloginfo('wpurl'); ?>/wp-content/plugins/<?php echo $this->widget_name; ?>/star_mlb_standings-js.php"></script>
	<link rel="stylesheet" href="<?php bloginfo('wpurl'); ?>/wp-content/plugins/<?php echo $this->widget_name; ?>/standings.css" type="text/css" media="screen" />
<?php

			// Return string to output.
			return ob_get_clean();
		}

		/**
		 * @desc function update_js()
		 * The function update_js() updates the MLB JavaScript if it's not been
		 *   touched for 24 hours.
		 *
		 * @return boolean
		 */
		function update_js($override = false) {
			// Check override variable.
			if ($override !== true) {
				$override	= false;
			}

			// Get and cache the javascript if it hasn't been updated in more than
			//   24 hours.
			$last_update	= get_option('star_mlb_standings_update');
			$refresh		= $this->refresh;
			if (empty($refresh)) {
				$refresh	= 6;
			}
			if ((time() - intval($last_update) >= ($refresh * 3600)) || $override == true) {
				$standings_js	= '';
				foreach ($this->div_array as $abbr => $name) {
					$standings_js	.= wp_remote_fopen('http://mlb.mlb.com/components/game/year_' . $this->date['year'] . '/month_' .  $this->date['month'] . '/day_' . $this->date['day'] . '/standings_rs_' . $abbr . '.js');
				}

				update_option('star_mlb_standings_js', $standings_js);
				update_option('star_mlb_standings_update', time());
			}

			return true;
		}
	} // End class star_mlb_standings.

	/**
	 * @desc function widget_star_mlb_standings()
	 * The function widget_star_mlb_standings() gathers the widget's options and
	 *   prints the HTML that the JavaScript requires.
	 * 
	 * @param array $args
	 */
	function widget_star_mlb_standings($args) {
		// Make the standings object global.
		global $star_mlb_standings;
		
		// "$args is an array of strings that help widgets to conform to
		// the active theme: before_widget, before_title, after_widget,
		// and after_title are the array keys." - These are set up by the theme
		extract($args);

		if (!is_object($star_mlb_standings)) {
			// These are the widget's options.
			$options	= get_option('widget_star_mlb_standings');

			// Instantiate standings object.
			$star_mlb_standings	= new star_mlb_standings($options);
		}

		// Title in sidebar for widget.
		$title		= $star_mlb_standings->get_title();
		if (empty($title)) {
			$title	= 'MLB Standings';
		}

		// Output before widget stuff.
		echo $before_widget . $before_title . $title . $after_title;

		// Output standings.
		ob_start();
?>
<div id="star_mlb_standings_head"></div>
<div id="star_mlb_standings_body"></div>

<?php
		echo ob_get_clean();

		// Output widget closing tag.
		echo $after_widget;
	}

	/**
	 * @desc function widget_star_mlb_standings_js_css()
	 * The function widget_star_mlb_standings_js_css() initiates the widget's
	 *   standings class, if it hasn't been initiated already, and includes
	 *   the required CSS and JavaScript files.
	 */
	function widget_star_mlb_standings_js_css() {
		global $star_mlb_standings;

		if (!is_object($star_mlb_standings)) {
			// These are the widget's options.
			$options	= get_option('widget_star_mlb_standings');

			// Instantiate standings object.
			$star_mlb_standings	= new star_mlb_standings($options);
		}

		$star_mlb_standings->update_js();

		echo $star_mlb_standings->include_js_css();
	}

	/**
	 * @desc function widget_featured_control()
	 */
	function widget_star_mlb_standings_control() {
		// Get options.
		$options	= get_option('widget_star_mlb_standings');

		// Make sure that the options are defined.
		if (!is_array($options)) {
			// The options haven't been defined. Set default values.
			$options	= array(
				'date'			=> 'current',
				'division'		=> 'nlc',
				'refresh'		=> '6',
				'showDivs'		=> true,
				'showSubHead'	=> true,
				'team'			=> 'cin',
				'title'			=> 'MLB Standings'
			);
		}

		// Instantiate the standings class.
		$standings	= new star_mlb_standings($options);

		// Check to see if the form was posted.
		if (!empty($_POST['star_mlb_standings-submit'])) {
			// Reset options array.
			$options	= array();

			// Remember to sanitize and format use input appropriately.
			// Set season.
			if ($_POST['star_mlb_standings-date'] != 'current') {
				$options['date']	= 'previous';
			} else {
				$options['date']	= 'current';
			}

			// Set division.
			if ($standings->is_division($_POST['star_mlb_standings-division'])) {
				$options['division']	= $_POST['star_mlb_standings-division'];
			} else {
				$options['division']	= 'nlc';
			}

			// Set refresh rate.
			if (ctype_digit($_POST['star_mlb_standings-refresh']) && $_POST['star_mlb_standings-refresh'] > 0) {
				$options['refresh']	= $_POST['star_mlb_standings-refresh'];
			} else {
				$options['refresh']	= '6';
			}

			$options['showDivs']	= ($_POST['star_mlb_standings-showDivs'] == 'yes') ? true : false;
			$options['showSubHead']	= ($_POST['star_mlb_standings-showSubHead'] == 'yes') ? true : false;

			// Set team.
			if ($standings->is_team($_POST['star_mlb_standings-team'])) {
				$options['team']	= $_POST['star_mlb_standings-team'];
			} else {
				$options['team']	= 'cin';
			}

			// Set widget title.
			$options['title']		= strip_tags(stripslashes($_POST['star_mlb_standings-title']));

			update_option('widget_star_mlb_standings', $options);
			$standings->update_js(true);
		}

		// Get options for form fields to show
		$standings->set_date($options['date']);
		$standings->set_division($options['division']);
		$standings->set_refresh($options['refresh']);
		$standings->set_showDivs($options['showDivs']);
		$standings->set_showSubHead($options['showSubHead']);
		$standings->set_team($options['team']);
		$standings->set_title(htmlspecialchars($options['title'], ENT_QUOTES));

		// Display the form.
		ob_start();
?>
<style type="text/css">
<!--
#star_mlb_standings_admin {
	height: 275px;
	overflow-y: auto;
}
#star_mlb_standings_admin label {
	display: block;
}
#star_mlb_standings_admin input {
	width: 250px;
}
#star_mlb_standings_admin select {
	width: 250px;
}
-->
</style>
<div id="star_mlb_standings_admin">
	<div>
		<label for="star_mlb_standings-title"><?php echo __('Widget Title:'); ?></label>
		<input id="star_mlb_standings-title" name="star_mlb_standings-title" type="text" value="<?php echo $standings->get_title(); ?>" />
	</div>
	<div>
		<label for="star_mlb_standings-refresh"><?php echo __('Refresh Every # Hours:'); ?></label>
		<input id="star_mlb_standings-refresh" name="star_mlb_standings-refresh" type="text" value="<?php echo $standings->get_refresh(); ?>" />
	</div>
	<div>
		<label for="star_mlb_standings-date"><?php echo __('Select Season:'); ?></label>
		<select id="star_mlb_standings-date" name="star_mlb_standings-date" size="1">
			<option value="current"<?php echo ($options['date'] == 'current') ? ' selected="selected"' : ''; ?>>Current</option>
			<option value="previous"<?php echo ($options['date'] == 'previous') ? ' selected="selected"' : ''; ?>>Previous</option>
		</select>
	</div>
	<div>
		<label for="star_mlb_standings-division"><?php echo __('Select Division:'); ?></label>
		<select id="star_mlb_standings-division" name="star_mlb_standings-division" size="1">
<?php
		// Iterate through each of the divisions and build the select.
		foreach ($standings->div_array as $abbr => $name) {
			// Deal with selected.
			if ($abbr == $standings->division['abbr']) {
				$selected	= ' selected="selected"';
			} else {
				$selected	= '';
			}
?>
			<option value="<?php echo $abbr; ?>"<?php echo $selected; ?>><?php echo $name; ?></option>
<?php
		}
?>
		</select>
	</div>
	<div>
		<label for="star_mlb_standings-team"><?php echo __('Select Team:'); ?></label>
		<select id="star_mlb_standings-team" name="star_mlb_standings-team" size="1">
<?php
		// Iterate through each of the teams and build the select.
		foreach ($standings->teams as $abbr => $mascot) {
			// Deal with selected.
			if ($abbr == $standings->team) {
				$selected	= ' selected="selected"';
			} else {
				$selected	= '';
			}
?>
			<option value="<?php echo $abbr; ?>"<?php echo $selected; ?>><?php echo $mascot; ?></option>
<?php
		}
?>
		</select>
	</div>
	
	<div>
		<label for="star_mlb_standings-showDivs"><?php echo __('Display Links to Divisions:'); ?></label>
		<select id="star_mlb_standings-showDivs" name="star_mlb_standings-showDivs" size="1">
			<option value="yes"<?php echo ($options['showDivs'] !== false) ? ' selected="selected"' : ''; ?>>Yes</option>
			<option value="no"<?php echo ($options['showDivs'] === false) ? ' selected="selected"' : ''; ?>>No</option>
		</select>
	</div>
	<div>
		<label for="star_mlb_standings-showSubHead"><?php echo __('Display Header of Current Division:'); ?></label>
		<select id="star_mlb_standings-showSubHead" name="star_mlb_standings-showSubHead" size="1">
			<option value="yes"<?php echo ($options['showSubHead'] !== false) ? ' selected="selected"' : ''; ?>>Yes</option>
			<option value="no"<?php echo ($options['showSubHead'] === false) ? ' selected="selected"' : ''; ?>>No</option>
		</select>
	</div>

	<div>
		<input type="hidden" id="star_mlb_standings-submit" name="star_mlb_standings-submit" value="1" />
	</div>
</div>
<?php
		echo ob_get_clean();
	}

	// Register widget for use
	register_sidebar_widget(array('MLB Standings', 'widgets'), 'widget_star_mlb_standings');

	// Register settings for use, 300x100 pixel form
	register_widget_control(array('MLB Standings', 'widgets'), 'widget_star_mlb_standings_control', 300, 300);
}

// Include CSS and JavaScript.
add_action('wp_head', 'widget_star_mlb_standings_js_css');
// Add the widget.
add_action('widgets_init', 'widget_star_mlb_standings_init');
		

?>