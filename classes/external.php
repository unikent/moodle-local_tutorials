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

/**
 * Local stuff for Moodle tutorials
 *
 * @package    local_tutorials
 * @copyright  2015 Skylar Kelty <S.Kelty@kent.ac.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_tutorials;

defined('MOODLE_INTERNAL') || die();

require_once("{$CFG->libdir}/externallib.php");

use external_api;
use external_value;
use external_single_structure;
use external_multiple_structure;
use external_function_parameters;

/**
 * Tutorials's external services.
 */
class external extends external_api
{
    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function get_tutorials_parameters() {
        return new external_function_parameters(array(
            'url' => new external_value(
                PARAM_URL,
                'The URL to get tutorials for.',
                VALUE_REQUIRED
            )
        ));
    }

    /**
     * get_tutorials a list of tutorials for the given URL.
     *
     * @param $url
     * @return array [string]
     * @throws \invalid_parameter_exception
     */
    public static function get_tutorials($url) {
        $params = self::validate_parameters(self::get_tutorials_parameters(), array(
            'url' => $url
        ));
        $url = $params['url'];

        return \local_tutorials\tutorial::get_tutorials($url);
    }

    /**
     * Returns description of get_tutorials() result value.
     *
     * @return external_description
     */
    public static function get_tutorials_returns() {
        return new external_multiple_structure(new external_single_structure(array(
            'id' => new external_value(PARAM_INT, 'The tutorial ID.'),
            'element' => new external_value(PARAM_TEXT, 'The tutorial DOM element reference.'),
            'intro' => new external_value(PARAM_TEXT, 'The tutorial contents.'),
            'position' => new external_value(PARAM_TEXT, 'The tutorial position.'),
            'seen' => new external_value(PARAM_BOOL, 'The tutorial seen.')
        )));
    }

    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function mark_seen_parameters() {
        return new external_function_parameters(array(
            'id' => new external_value(
                PARAM_INT,
                'The tutorial step we have just seen.',
                VALUE_REQUIRED
            )
        ));
    }

    /**
     * mark_seen a list of tutorials for the given URL.
     *
     * @param $id
     * @return array [string]
     * @throws \invalid_parameter_exception
     */
    public static function mark_seen($id) {
        $params = self::validate_parameters(self::mark_seen_parameters(), array(
            'id' => $id
        ));
        $id = $params['id'];

        $tutorial = \local_tutorials\tutorial::get_tutorial($id);
        if ($tutorial) {
            $tutorial->mark_seen();
        }
    }

    /**
     * Returns description of mark_seen() result value.
     *
     * @return external_description
     */
    public static function mark_seen_returns() {
        return null;
    }
}
