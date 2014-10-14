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
admin_externalpage_setup('tutorialsindex', '', null, '', array('pagelayout' => 'report'));
$query = required_param('query', PARAM_RAW);

echo $OUTPUT->header();
echo $OUTPUT->heading('Tutorial Editor');

// Search.
$like = $DB->sql_like('url', ':url');
$results = $DB->get_records_select('tutorials', $like, array(
    'url' => "%" . $query . "%"
));

if (empty($results)) {
    echo \html_writer::tag('p', 'No results found.');
} else {
    $table = new html_table();
    $table->head  = array(
        'ID',
        'URL',
        'Content',
        'Action'
    );
    $table->attributes['class'] = 'admintable generaltable';
    $table->data = array();

    foreach ($results as $result) {
        $editlink = new \moodle_url('/local/tutorials/edit.php', array(
            'id' => $result->id
        ));
        $editlink = \html_writer::tag('a', 'Edit', array(
            'href' => $editlink
        ));

        $table->data[] = new html_table_row(array(
            $result->id,
            $result->url,
            $result->contents,
            new html_table_cell($editlink)
        ));
    }

    echo \html_writer::table($table);
}

echo $OUTPUT->footer();