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

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/formslib.php');

/**
 * Form for tutorials preferences
 */
class tutorials_preferences_form extends moodleform {
    public function definition() {
        $mform =& $this->_form;

        $mform->addElement('checkbox', 'showtutorials', get_string('enable', 'local_tutorials'));
        $mform->setDefault('showtutorials', 1);

        $mform->addElement('checkbox', 'resettutorials', get_string('reset', 'local_tutorials'));
        $mform->setDefault('resettutorials', 0);

        $this->add_action_buttons();
    }
}
