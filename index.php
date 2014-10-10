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

// Initial setup.
$sitecontext = context_system::instance();
$PAGE->set_context($sitecontext);
$PAGE->set_url('/local/tutorials/index.php');
$PAGE->set_pagelayout('admin');

echo $OUTPUT->header();
echo $OUTPUT->heading('Tutorial Editor');

$a = html_writer::tag('a', 'create a new one', array(
	'href' => new moodle_url('/local/tutorials/edit.php?action=new')
));
echo "<p>Enter a URL to search for an existing tutorial, or $a.</p>";

$content = html_writer::start_tag('form', array(
	'class' => 'tutorialsearchform',
	'method' => 'get',
	'action' => new moodle_url('/local/tutorials/list.php'),
	'role' => 'search'
));
$content .= html_writer::start_tag('div');
$content .= html_writer::tag('label', "Search Tutorials", array(
	'for' => 'tutorialsearchform',
	'class' => 'accesshide'
));
$content .= html_writer::empty_tag('input', array(
	'id' => 'tutorialsearchquery',
	'type' => 'text',
	'name' => 'query',
	'value'=> ''
));
$content .= html_writer::empty_tag('input', array(
	'type' => 'submit',
	'value'=> 'Search'
));
$content .= html_writer::end_tag('div');
$content .= html_writer::end_tag('form');
echo $content;

echo $OUTPUT->footer();