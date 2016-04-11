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
 * Tutorials JSON Loader.
 * Handles loading of JSON tutorial sets into the DB.
 */
class loader
{
    /**
     * Updates all tutorials.
     */
    public static function update() {
        global $DB;

        $uuids = array();

        $filelist = self::scan();
        foreach ($filelist as $filename => $component) {
            $json = file_get_contents($filename);
            $obj = json_decode($json);
            $obj->uuid = "{$component}_{$obj->uuid}";
            $uuids[] = $obj->uuid;

            if (!$DB->record_exists('tutorials', array('uuid' => $obj->uuid))) {
                $DB->insert_record('tutorials', $obj);
            }
        }

        // Delete all uuids that are not in the array.
        $dbids = $DB->get_fieldset_select('tutorials', 'uuid', '');
        $diff = array_diff($dbids, $uuids);
        $deleteset = array_map(function($b) {
            return array('uuid' => $b);
        }, $diff);
        $DB->delete_records('tutorials', $deleteset);
        $DB->delete_records('tutorials_seen', $deleteset);
    }

    /**
     * Scan plugins and find any tutorial files.
     */
    private static function scan() {
        $filelist = array();

        // Go through every plugin and see if we have a db/nagios.php file.
        $types = \core_component::get_plugin_types();
        foreach ($types as $type => $fulltype) {
            $pluginins = \core_component::get_plugin_list($type);
            foreach ($pluginins as $plugin => $fulldir) {
                $filename = $fulldir . '/db/tutorials.json';
                if (is_readable($filename)) {
                    $component = clean_param($type . '_' . $plugin, PARAM_COMPONENT);
                    $filelist[$filename] = $component;
                }
            }
        }

        return $filelist;
    }
}
