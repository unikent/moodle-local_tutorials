<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

require_once(dirname(__FILE__) . "/../../config.php");
require_once(dirname(__FILE__) . "/preferences_form.php");

// Initial setup.
$sitecontext = context_system::instance();
$PAGE->set_context($sitecontext);
$PAGE->set_url('/local/tutorials/preferences.php');
$PAGE->set_pagelayout('admin');

echo $OUTPUT->header();
echo $OUTPUT->heading('User Preferences');

$mform = new tutorials_preferences_form('preferences.php');

if (!$mform->is_cancelled() && $data = $mform->get_data()) {
    if (isset($data->showtutorials) && $data->showtutorials) {
        set_user_preference('showtutorials', 1);
    } else {
        set_user_preference('showtutorials', 0);
    }
}

$mform->set_data(array('showtutorials' => get_user_preferences('showtutorials', 1)));
$mform->display();

echo $OUTPUT->footer();