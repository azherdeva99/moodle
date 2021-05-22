<?php

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    ///  It must be included from a Moodle page
}
require_once($CFG->libdir . '/formslib.php');

class random_view_teacher extends moodleform
{
    public $id;

    function definition() {
    
        global $SESSION;
        
        $mform =& $this->_form;
        $attributes=array('size'=>'200');
        $id = optional_param('id', '0', PARAM_INT);  
        if ($id == 0){
            $id = $SESSION->cmid;
        }
        $context = context_module::instance($id);
        $submitlabel = 'сабмит';
        
        if (has_capability('mod/random:create_question', $context)) {
            $submitlabel = 'Сохранить вопрос'; //или 'Получить билет'
            $mform->addElement('static', 'header', 'Введите вопрос', 'Введите вопрос:');
            $mform->addElement('text', 'question_field', 'Введите впрос', $attributes);
        }
        
        if (has_capability('mod/random:get_question', $context)) {
            $submitlabel = 'Получить вопрос';
        }
//         $mform->addElement('textarea', 'introduction', 'Введите вопрос', 'wrap="virtual" rows="20" cols="50"');
        
        $this->add_action_buttons($cancel = true, $submitlabel);
        
    }   
}

