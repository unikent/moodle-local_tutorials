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
 * A Tutorial.
 */
class Tutorial
{
    private $id;
    private $uuid;
    private $element;
    private $contents;
    private $position;
    private $seen;

    /**
     * Returns all tutorials for a given page.
     */
    public static function get_tutorials($url) {
        global $DB, $USER;

        $select = $DB->sql_compare_text('url') . '=' . $DB->sql_compare_text(':url');
        $results = $DB->get_records_sql("
            SELECT t.id, t.uuid, t.element, t.contents, t.position, COALESCE(ts.value, 0) as seen
            FROM {tutorials} t
            LEFT OUTER JOIN {tutorials_seen} ts
                ON ts.tutorialuuid=t.uuid AND ts.userid=:uid
            WHERE $select
            ORDER BY t.step ASC
        ", array(
            'uid' => $USER->id,
            'url' => $url
        ));

        $tutorials = array();
        foreach ($results as $result) {
            $tutorial = new static();
            $tutorial->id = $result->id;
            $tutorial->uuid = $result->uuid;
            $tutorial->element = $result->element;
            $tutorial->contents = $result->contents;
            $tutorial->position = $result->position;
            $tutorial->seen = $result->seen;

            $tutorials[] = array(
                'id' => $result->id,
                'element' => $tutorial->get_element(),
                'intro' => $tutorial->get_contents(),
                'position' => $tutorial->get_position(),
                'seen' => $tutorial->has_seen()
            );
        }

        return $tutorials;
    }

    /**
     * Get tutorial by ID.
     */
    public static function get_tutorial($id) {
        global $DB;

        $result = $DB->get_record('tutorials', array(
            'id' => $id
        ));

        if (!$result) {
            return false;
        }

        $obj = new static();
        $obj->id = $result->id;
        $obj->element = $result->element;
        $obj->contents = $result->contents;
        $obj->position = $result->position;

        return $obj;
    }

    /**
     * Returns the element of the tutorial.
     */
    public function get_element() {
        return $this->element;
    }

    /**
     * Returns the content of the tutorial.
     */
    public function get_contents() {
        return $this->contents;
    }

    /**
     * Returns the position of the tutorial.
     */
    public function get_position() {
        switch ($this->position) {
            case '1':
                return 'bottom';
            case '2':
                return 'left';
            case '3':
                return 'top';
            case '4':
                return 'right';
            default:
                return $this->position;
        }
    }

    /**
     * Mark the tutorial as seen by the current user.
     */
    public function mark_seen() {
        global $DB, $USER;

        $record = array(
            'userid' => $USER->id,
            'tutorialuuid' => $this->uuid
        );

        $obj = $DB->get_record('tutorials_seen', $record);
        if ($obj) {
            $obj->value = 1;
            return $DB->update_record('tutorials_seen', $obj);
        }

        $record['value'] = 1;
        return $DB->insert_record('tutorials_seen', $record);
    }

    /**
     * Has the user seen this tutorial?
     */
    public function has_seen() {
        global $DB, $USER;

        if (!isset($this->seen)) {
            $this->seen = $DB->get_field('tutorials_seen', 'value', array(
                'userid' => $USER->id,
                'tutorialuuid' => $this->uuid
            ));

            if (!$this->seen) {
                $this->seen = false;
            }
        }

        return $this->seen === 1;
    }
}
