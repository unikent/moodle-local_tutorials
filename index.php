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
require_once($CFG->libdir . '/adminlib.php');

// Initial setup.
admin_externalpage_setup('tutorialsdemo', '', null, '', array('pagelayout' => 'report'));

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('demo_title', 'local_tutorials'));

echo $OUTPUT->notification(get_string('demo_notification', 'local_tutorials'), 'notifyproblem testnotification');

echo \html_writer::tag('button', get_string('demo_button', 'local_tutorials'), array('id' => 'testid1', 'class' => 'btn btn-primary')) . " ";
echo \html_writer::tag('button', get_string('demo_button', 'local_tutorials'), array('id' => 'testid2', 'class' => 'btn btn-danger'));

echo $OUTPUT->footer();