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

defined('MOODLE_INTERNAL') || die();

function xmldb_local_tutorials_upgrade($oldversion) {
    global $CFG, $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2014100201) {
        // Define table tutorials to be created.
        $table = new xmldb_table('tutorials');

        // Adding fields to table tutorials.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('url', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL, null, null);
        $table->add_field('order', XMLDB_TYPE_INTEGER, '2', null, null, null, '1');
        $table->add_field('element', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL, null, null);
        $table->add_field('contents', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('position', XMLDB_TYPE_INTEGER, '1', null, null, null, '1');

        // Adding keys to table tutorials.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table for tutorials.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Tutorials savepoint reached.
        upgrade_plugin_savepoint(true, 2014100201, 'local', 'tutorials');
    }

    if ($oldversion < 2014100202) {
        // Define table tutorials_user_prefs to be created.
        $table = new xmldb_table('tutorials_user_prefs');

        // Adding fields to table tutorials_user_prefs.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '11', null, XMLDB_NOTNULL, null, null);
        $table->add_field('tutorialid', XMLDB_TYPE_INTEGER, '11', null, XMLDB_NOTNULL, null, null);
        $table->add_field('value', XMLDB_TYPE_INTEGER, '1', null, null, null, '0');

        // Adding keys to table tutorials_user_prefs.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
        $table->add_key('k_userid_tutorialid', XMLDB_KEY_UNIQUE, array('userid', 'tutorialid'));

        // Adding indexes to table tutorials_user_prefs.
        $table->add_index('i_userid', XMLDB_INDEX_NOTUNIQUE, array('userid'));
        $table->add_index('i_tutorialid', XMLDB_INDEX_NOTUNIQUE, array('tutorialid'));

        // Conditionally launch create table for tutorials_user_prefs.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Tutorials savepoint reached.
        upgrade_plugin_savepoint(true, 2014100202, 'local', 'tutorials');
    }

    if ($oldversion < 2014100800) {
        // Define table tutorials to be modified.
        $table = new xmldb_table('tutorials');
        $field = new xmldb_field('order', XMLDB_TYPE_INTEGER, '2', null, null, null, '1', 'url');

        if ($dbman->field_exists($table, $field)) {
            $DB->execute('ALTER TABLE {tutorials} CHANGE `order` `step` TINYINT(2) NULL DEFAULT \'1\';');
        }

        // Tutorials savepoint reached.
        upgrade_plugin_savepoint(true, 2014100800, 'local', 'tutorials');
    }

    if ($oldversion < 2016040400) {
        // Define field uuid to be added to tutorials.
        $table = new xmldb_table('tutorials');
        $field = new xmldb_field('uuid', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null, 'id');

        // Conditionally launch add field uuid.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Define key k_uuid (unique) to be added to tutorials.
        $table = new xmldb_table('tutorials');
        $key = new xmldb_key('k_uuid', XMLDB_KEY_UNIQUE, array('uuid'));

        // Launch add key k_uuid.
        $dbman->add_key($table, $key);

        // Tutorials savepoint reached.
        upgrade_plugin_savepoint(true, 2016040400, 'local', 'tutorials');
    }

    if ($oldversion < 2016040401) {
        // Define table tutorials_user_prefs to be dropped.
        $table = new xmldb_table('tutorials_user_prefs');

        // Conditionally launch drop table for tutorials_user_prefs.
        if ($dbman->table_exists($table)) {
            $dbman->drop_table($table);
        }

        // Tutorials savepoint reached.
        upgrade_plugin_savepoint(true, 2016040401, 'local', 'tutorials');
    }

    if ($oldversion < 2016040402) {
        // Define table tutorials_seen to be created.
        $table = new xmldb_table('tutorials_seen');

        // Adding fields to table tutorials_seen.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '11', null, XMLDB_NOTNULL, null, null);
        $table->add_field('tutorialuuid', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null);
        $table->add_field('value', XMLDB_TYPE_INTEGER, '1', null, null, null, '0');

        // Adding keys to table tutorials_seen.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
        $table->add_key('k_userid_tutorialuuid', XMLDB_KEY_UNIQUE, array('userid', 'tutorialuuid'));

        // Adding indexes to table tutorials_seen.
        $table->add_index('i_userid', XMLDB_INDEX_NOTUNIQUE, array('userid'));
        $table->add_index('i_tutorialuuid', XMLDB_INDEX_NOTUNIQUE, array('tutorialuuid'));

        // Conditionally launch create table for tutorials_seen.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Tutorials savepoint reached.
        upgrade_plugin_savepoint(true, 2016040402, 'local', 'tutorials');
    }

    return true;
}
