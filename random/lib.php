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
 * assignment_base is the base class for assignment types
 *
 * This class provides all the functionality for an assignment
 *
 * @package   mod_assignment
 * @copyright 1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Adds an assignment instance
 *
 * Only used by generators so we can create old assignments to test the upgrade.
 *
 * @param stdClass $assignment
 * @param mod_assignment_mod_form $mform
 * @return int intance id
 */
function random_add_instance($random, $mform = null) {
    global $DB;

    $random->timemodified = time();
    $random->courseid = $random->course;
    $returnid = $DB->insert_record("random", $random);
    $random->id = $returnid;
    return $returnid;
}

/**
 * Deletes an assignment instance
 *
 * @param $id
 */
function random_delete_instance($id){
    global $CFG, $DB;

    if (! $random = $DB->get_record('random', array('id'=>$id))) {
        return false;
    }

    $result = true;
    // Now get rid of all files
    $fs = get_file_storage();
    if ($cm = get_coursemodule_from_instance('random', $random->id)) {
        $context = context_module::instance($cm->id);
        $fs->delete_area_files($context->id);
    }

    if (! $DB->delete_records('random_submissions', array('random'=>$random->id))) {
        $result = false;
    }

    if (! $DB->delete_records('event', array('modulename'=>'random', 'instance'=>$random->id))) {
        $result = false;
    }

    grade_update('mod/random', $random->course, 'mod', 'random', $random->id, 0, NULL, array('deleted'=>1));

    // We must delete the module record after we delete the grade item.
    if (! $DB->delete_records('random', array('id'=>$random->id))) {
        $result = false;
    }

    return $result;
}

/**
 * @param string $feature FEATURE_xx constant for requested feature
 * @return mixed True if module supports feature, null if doesn't know
 */
function random_supports($feature) {
    switch($feature) {
        case FEATURE_BACKUP_MOODLE2:          return true;

        default: return null;
    }
}
