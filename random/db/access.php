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
 * Plugin capabilities
 *
 * @package    mod_assignment
 * @copyright  2006 Martin Dougiamas
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
 $capabilities = array(
 
    'mod/random:addinstance' => array(
        'riskbitmask' => RISK_XSS,
        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
 ),
        'clonepermissionsfrom' => 'moodle/course:manageactivities'
    ),


    'mod/random:view' => array(
    	'captype' => 'read',
    	'contextlevel' => CONTEXT_MODULE,
    	'archetypes' => array(
        	'guest' => CAP_ALLOW,
        	'student' => CAP_ALLOW,
        	'teacher' => CAP_ALLOW,
            	'editingteacher' => CAP_ALLOW,
            	'manager' => CAP_ALLOW
 ),
),
 'mod/random:create_question' => array(
    	'captype' => 'read',
    	'contextlevel' => CONTEXT_MODULE,
    	'archetypes' => array(
        	'guest' => CAP_PROHIBIT,
        	'student' => CAP_PROHIBIT,
        	'teacher' => CAP_ALLOW,
            	'editingteacher' => CAP_ALLOW,
            	'manager' => CAP_ALLOW
            	),
            ),

             'mod/random:get_question' => array(
    	'captype' => 'write',
    	'contextlevel' => CONTEXT_MODULE,
    	'archetypes' => array(
        	'guest' => CAP_PROHIBIT,
        	'student' => CAP_ALLOW,
        	'teacher' => CAP_PROHIBIT,
            	'editingteacher' => CAP_PROHIBIT,
            	'manager' => CAP_PROHIBIT
            	),
            ),

);
/*defined('MOODLE_INTERNAL') || die();

$capabilities = array(

    'mod/random:view' => array(

        'captype' => 'read',
        'contextlevel' => CONTEXT_MODULE,
        'archetypes' => array(
            'guest' => CAP_ALLOW,
            'student' => CAP_ALLOW,
            'teacher' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        )
    ),

    'mod/random:addinstance' => array(
        'riskbitmask' => RISK_XSS,

        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        ),
        'clonepermissionsfrom' => 'moodle/course:manageactivities'
    ),

    'mod/random:submit' => array(

        'captype' => 'write',
        'contextlevel' => CONTEXT_MODULE,
        'archetypes' => array(
            'student' => CAP_ALLOW
        )
    ),

    'mod/random:grade' => array(
        'riskbitmask' => RISK_XSS,

        'captype' => 'write',
        'contextlevel' => CONTEXT_MODULE,
        'archetypes' => array(
            'teacher' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        )
    ),

    'mod/random:exportownsubmission' => array(

        'captype' => 'read',
        'contextlevel' => CONTEXT_MODULE,
        'archetypes' => array(
            'teacher' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW,
            'student' => CAP_ALLOW,
        )
    ),
);


*/
