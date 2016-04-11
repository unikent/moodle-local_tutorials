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
            $tutorials = json_decode($json);
            if (!$tutorials || !is_array($tutorials)) {
                $err = json_last_error_msg();
                debugging("Error parsing tutorial JSON for {$component} ($err).", DEBUG_DEVELOPER);
                continue;
            }

            foreach ($tutorials as $tutorial) {
                if (!self::validate($tutorial, $component)) {
                    continue;
                }

                $tutorial->uuid = "{$component}_{$tutorial->uuid}";
                $uuids[] = $tutorial->uuid;

                if (!$DB->record_exists('tutorials', array('uuid' => $tutorial->uuid))) {
                    $DB->insert_record('tutorials', $tutorial);
                }
            }
        }

        // Delete all uuids that are not in the array.
        $dbids = $DB->get_fieldset_select('tutorials', 'uuid', '');
        $diff = array_diff($dbids, $uuids);
        if (!empty($diff)) {
            $DB->delete_records_list('tutorials', 'uuid', $diff);
            $DB->delete_records_list('tutorials_seen', 'tutorialuuid', $diff);
        }
    }

    /**
     * Validates a tutorial.
     */
    private static function validate($tutorial, $component) {
        if (empty($tutorial->uuid)) {
            debugging("Error parsing tutorial for {$component} - no UUID.", DEBUG_DEVELOPER);
            return false;
        }

        if (empty($tutorial->element)) {
            debugging("Error parsing tutorial for {$component}/{$tutorial->uuid} - no element.", DEBUG_DEVELOPER);
            return false;
        }

        if (empty($tutorial->contents)) {
            debugging("Error parsing tutorial for {$component}/{$tutorial->uuid} - no contents.", DEBUG_DEVELOPER);
            return false;
        }

        return true;
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
