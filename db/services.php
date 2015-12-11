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

$services = array(
    'tutorials service' => array(
        'functions' => array (
            'local_tutorials_get_tutorials',
            'local_tutorials_mark_seen'
        ),
        'requiredcapability' => '',
        'restrictedusers' => 0,
        'enabled' => 1
    )
);

$functions = array(
    'local_tutorials_get_tutorials' => array(
        'classname'   => 'local_tutorials\external',
        'methodname'  => 'get_tutorials',
        'description' => 'Get tutorials.',
        'type'        => 'read',
        'ajax'        => true
    ),
    'local_tutorials_mark_seen' => array(
        'classname'   => 'local_tutorials\external',
        'methodname'  => 'mark_seen',
        'description' => 'Mark a tutorial as seen.',
        'type'        => 'write',
        'ajax'        => true
    )
);