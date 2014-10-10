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

define("AJAX_SCRIPT", true);

require_once(dirname(__FILE__) . "/../../../config.php");

$PAGE->set_url("/local/tutorials/ajax/progress.php");

$id = required_param('id', PARAM_INT);

if (!isloggedin() || isguestuser()) {
	die;
}

$tutorial = \local_tutorials\Tutorial::get_tutorial($id);
if ($tutorial) {
	$tutorial->mark_seen();
}