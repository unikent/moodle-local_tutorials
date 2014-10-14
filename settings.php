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

defined('MOODLE_INTERNAL') || die;

if ($hassiteconfig) {
    $category = new admin_category('tutorials', new lang_string('pluginname', 'local_tutorials'));

    $settings = new admin_settingpage('local_tutorials', 'Settings');

    $settings->add(new admin_setting_configcheckbox(
        'local_tutorials_enabled',
        get_string('enable', 'local_tutorials'),
        '',
        0
    ));

    $category->add('tutorials', $settings);

    $taindex = new admin_externalpage('tutorialsedit', "Add Tutorial", "$CFG->wwwroot/local/tutorials/edit.php",
        'moodle/site:config');
    $category->add('tutorials', $taindex);

    $tindex = new admin_externalpage('tutorialsindex', "Edit Tutorial", "$CFG->wwwroot/local/tutorials/index.php",
        'moodle/site:config');
    $category->add('tutorials', $tindex);

    $ADMIN->add('modules', $category);
}
