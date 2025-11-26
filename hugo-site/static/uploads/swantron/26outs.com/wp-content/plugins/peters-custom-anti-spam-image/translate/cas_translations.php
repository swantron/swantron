<?php

// Translation stuff. If your blog is in a different language, edit these fields to suit your language!
$cas_displaytext = array(); // <-- This line should not be changed

// This is the name of the label for the comment form
$cas_displaytext['label'] = 'Anti-spam word: (Required)';

// These are the instructions for filling in the anti-spam word in the comment form
$cas_displaytext['instructions'] = 'To prove you\'re a person (not a spam script), type the security word shown in the picture.';

if ($cas_wav) {
// Additional instructions for the audio-impaired users
$cas_displaytext['instructions'] .= ' Click on the picture to hear an audio file of the word.';
}

// Error message if someone has not typed anything into the anti-spam field
$cas_displaytext['emptyfield'] = 'Error: Please enter the anti-spam word.';

// Error message if the particular anti-spam image has already been used on a comment
$cas_displaytext['alreadyused'] = 'Error: The anti-spam word is invalid. Please report this error to the webmaster. Go back and refresh the page to re-submit your comment.';

// Error message if someone has typed the wrong word into the anti-spam field
$cas_displaytext['wrongfield'] = 'Error: Please enter the correct anti-spam word. Press the back button and try again.';

// Error message instructions to copy the text of the comment before pressing the back button:
$cas_displaytext['copyfield'] = 'Copy your comment in case this site forces a page reload whenever you press the Back button:';

// Error message when trying to generate an audio file and the anti-spam image has already been used
$cas_displaytext['not_valid'] = 'That anti-spam number is no longer valid.';

// Text to show in an invalid image
$cas_displaytext['invalid'] = '* * * INVALID * * *';

// Error message to point the webmaster to edit the plugin configuration settings
$cas_displaytext['manually_configure'] = 'The site administrator needs to manually configure his site address in the plugin configuration file!';

// Error message if the GD Library is not installed
$cas_displaytext['no_gd'] = 'Cannot initialize new GD image stream';

if (!$cas_wav) {
// Text for the normal alt tag of the image
$cas_displaytext['alt_tag'] = 'Anti-spam image';
}
else {
// Text for the alt tag of the image for visually impaired users
$cas_displaytext['alt_tag'] = 'Click to hear an audio file of the anti-spam word';
}

// Error messages for the registration form only 

// Error if the particular anti-spam image has already been used
$cas_displaytext['register_alreadyused'] = 'ERROR: The anti-spam word is no longer valid.';

// Error message if someone has typed the wrong answer into the anti-spam field
$cas_displaytext['register_wrongfield'] = 'ERROR: Please enter the correct anti-spam word.';

// Error message if someone has typed a blocked e-mail address
$cas_displaytext['register_blocked'] = 'ERROR: That e-mail address has been blocked.';

?>