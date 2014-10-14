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
    $tutorial = new \stdClass();

    // Is this an existing tutorial?
    if (!empty($data->id)) {
        $tutorial = $DB->get_record('tutorials', array(
            'id' => $data->id
        ));
    }

    $fields = array('url', 'step', 'element', 'contents', 'position');
    foreach ($fields as $field) {
        if (isset($data->$field)) {
            $tutorial->$field = $data->$field;
        }
    }

    if (!empty($tutorial->id)) {
        $DB->update_record('tutorials', $tutorial);
    } else {
        $DB->insert_record('tutorials', $tutorial);
    }

    redirect(new moodle_url('/local/tutorials/?msg=success'));
    die;
} else {
    $id = optional_param('id', null, PARAM_INT);
    if ($id) {
        $tutorial = $DB->get_record('tutorials', array(
            'id' => $id
        ));

        if ($tutorial) {
            $mform->set_data($tutorial);
        }
    }
}

echo $OUTPUT->header();
echo $OUTPUT->heading('Tutorial Editor');

$mform->display();

echo $OUTPUT->footer();