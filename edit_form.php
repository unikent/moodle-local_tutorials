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
 * Form for tutorials editing
 */
class tutorials_edit_form extends moodleform {
    public function definition() {
        global $USER, $CFG;

        $mform    =& $this->_form;

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        $mform->setDefault('id', 0);

        $mform->addElement('text', 'url', 'URL', array('size' => 50));
        $mform->setType('url', PARAM_URL);
        $mform->setDefault('url', '/my/');

        $mform->addElement('text', 'step', 'Step');
        $mform->setType('step', PARAM_INT);
        $mform->setDefault('step', '1');

        $mform->addElement('text', 'element', 'Element', array('size' => 50));
        $mform->setType('element', PARAM_RAW);
        $mform->setDefault('element', 'body');

        $mform->addElement('textarea', 'contents', 'Contents', array('rows' => 5));
        $mform->setType('contents', PARAM_RAW);
        $mform->setDefault('contents', 'This element is for doing x and y');

        $mform->addElement('select', 'position', "Position", array(
            '1' => "Bottom",
            '2' => "Left",
            '3' => "Top",
            '4' => "Right"
        ));
        $mform->setType('position', PARAM_INT);

        $this->add_action_buttons();
    }
}
