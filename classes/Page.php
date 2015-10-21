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

namespace local_tutorials;

defined('MOODLE_INTERNAL') || die();

/**
 * Tutorials Page Manager.
 */
class Page
{
    /**
     * Page load event.
     */
    public static function on_load() {
        global $PAGE, $SESSION, $USER, $OUTPUT;

        if (!isloggedin() || isguestuser()) {
            return false;
        }

        // Does this user want us to inject?
        $showtutorial = get_user_preferences('showtutorials', true, $USER);
        if (!$showtutorial) {
            return false;
        }

        // Check we have some tutorials.
        $localurl = $PAGE->url->out_as_local_url();
        $tutorials = \local_tutorials\Tutorial::get_tutorials($localurl);
        if (count($tutorials) <= 0) {
            return false;
        }

        // Okay! We want to show tutorials!
        $PAGE->requires->jquery();
        $PAGE->requires->js_call_amd('local_tutorials/page', 'init', array($localurl));
        $PAGE->requires->css('/local/tutorials/media/css/intro.min.css');
        $PAGE->requires->css('/local/tutorials/media/css/intro.theme.css');
        $PAGE->requires->css('/local/tutorials/media/css/custom.css');

        $PAGE->set_button($OUTPUT->single_button(new \moodle_url('/local/tutorial/view.php', array()), 'Help', 'get', array(
            'formid' => 'tutorial-play',
            'tooltip' => 'Help is available for this page'
        )) . $PAGE->button);

        return true;
    }
}