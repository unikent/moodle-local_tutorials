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
    public static function on_load(\moodle_page $page) {
        global $CFG, $SESSION, $USER, $OUTPUT;

        // Are we enabled?
        if (!isset($CFG->local_tutorials_enabled) || !$CFG->local_tutorials_enabled) {
            return false;
        }

        // Only show up for some page layouts.
        if (in_array($page->pagelayout, array('admin', 'maintenance', 'redirect'))) {
            return false;
        }

        // We must be logged in for tutorials.
        if (!isloggedin() || isguestuser()) {
            return false;
        }

        // Does this user want us to inject?
        $showtutorial = get_user_preferences('showtutorials', true, $USER);
        if (!$showtutorial) {
            return false;
        }

        // Check we have some tutorials.
        $localurl = $page->url->out_as_local_url();
        $tutorials = \local_tutorials\Tutorial::get_tutorials($localurl);
        if (count($tutorials) <= 0) {
            return false;
        }

        // Okay! We want to show tutorials!
        $page->requires->jquery();
        $page->requires->js_call_amd('local_tutorials/page', 'init', array($localurl));
        $page->requires->css('/local/tutorials/less/build/build.css');

        $page->set_button($OUTPUT->single_button(new \moodle_url('/local/tutorial/view.php', array()), 'Help', 'get', array(
            'formid' => 'tutorial-play',
            'tooltip' => 'Help is available for this page'
        )) . $page->button);

        return true;
    }
}