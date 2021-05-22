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
 * This file is the entry point to the random module. All pages are rendered from here
 *
 * @package   mod_random
 * @copyright 2012 NetSpot {@link http://www.netspot.com.au}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
//require_once($CFG->dirroot . '/mod/random/locallib.php');
require_once('lib.php');
require_once('view_form.php');

$id = optional_param('id', '0', PARAM_INT);  
if ($id == 0){
    $id = $SESSION->cmid;
}

list ($course, $cm) = get_course_and_cm_from_cmid($id, 'random');

require_login($course, true, $cm);

$context = context_module::instance($cm->id);

require_capability('mod/random:view', $context);

//$random = new random($context, $cm, $course);
/*$urlparams = array('id' => $id,
                  'action' => optional_param('action', '', PARAM_ALPHA),
                  'rownum' => optional_param('rownum', 0, PARAM_INT),
                  'useridlistid' => optional_param('useridlistid', $random->get_useridlist_key_id(), PARAM_ALPHANUM));
*/

$urlparams = array('id' => $id);
$url = new moodle_url('/mod/random/view.php', $urlparams);
$PAGE->set_url($url);
$PAGE->set_pagelayout('standart');
$PAGE->set_title(get_string('pluginname', 'random'));
$PAGE->set_heading(get_string('pluginname', 'random'));
echo $OUTPUT->header();

$mform = new random_view_teacher();

if ($mform->is_cancelled()) {
    //При нажатии кнопки отмена, пользователь возвращается на страницу курса
    $urlparams = array('id' => $course->id);
    $url = new moodle_url('/course/view.php', $urlparams);
    redirect($url);

} else if ($fromform = $mform->get_data()) {
     //if ($USER->id !== $submission->userid && !has_capability('mod/random:grade', \context_module::instance($cm->id))) {
         //return array('status' => 'nopermission');
     //};

    if (has_capability('mod/random:create_question', $context)) {
        $question = new stdClass();
        $question->id = '';
        $question->moduleid = $id;
        $question->question = $fromform->question_field;
        $question->userid = 0;
        $question->took = 0;
        $DB->insert_record('random_data', $question, $returnid = false);
        echo 'Вопрос успешно сохранён';
        $data = new stdClass();
        $data->question_field = '';
        $mform->set_data($data);
        $mform->display();
    }    
    
    else if (has_capability('mod/random:get_question', $context)) {
        $records = $DB->get_records('random_data', ['moduleid' => $id, 'took' => 0]);
        $i = 0;
        $array_of_random_numbers = array();
        foreach ($records as $key=>$record) {
            $array_of_random_numbers[$i] = $key;
            $i++;
        };
        $random_number = random_int(0, count($array_of_random_numbers));    //TODO: $random_number
        $question_text = $records[$random_number]->question;
        $row = $records[$random_number];
        $row->question = $question_text;
        $row->took = 1;
        $row->userid = $USER->id;
        $result = $DB->insert_record('random_data', $row);
        if ($result) {
            echo $question_text;
        } else {
            echo 'неудача, на пересдачу';
        };
    } else {
        echo 'Вы не преподаватель и не студент';
    }
} else {
    $SESSION->cmid = $id;
    $mform->display();

};


// Update module completion status.
//$random->set_module_viewed();

// Apply overrides.
//$random->update_effective_access($USER->id);

// Get the random class to
// render the page.
//echo $random->view(optional_param('action', '', PARAM_ALPHA));
