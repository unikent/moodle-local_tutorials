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
require_once(dirname(__FILE__) . "/edit_form.php");
require_once($CFG->libdir . '/adminlib.php');

// Initial setup.
admin_externalpage_setup('tutorialsedit', '', null, '', array('pagelayout' => 'report'));

$mform = new tutorials_edit_form('edit.php');

if ($mform->is_cancelled()) {
    redirect(new moodle_url('/local/tutorials/'));
    die;
}

if ($data = $mform->get_data()) {
}

echo $OUTPUT->header();
echo $OUTPUT->heading('Tutorial Editor');

$mform->display();

echo $OUTPUT->footer();