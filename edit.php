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
 * Notificationeabc enrolment plugin.
 *
 * This plugin notifies users when an event occurs on their enrolments (enrol, unenrol, update enrolment)
 *
 * @package    enrol_notificationeabc
 * @copyright  2017 e-ABC Learning
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author     Osvaldo Arriola <osvaldo@e-abclearning.com>
 */


require('../../config.php');
require_once('edit_form.php');

$courseid = required_param('courseid', PARAM_INT);
$instanceid = optional_param('id', 0, PARAM_INT);

$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
$context = context_course::instance($course->id, MUST_EXIST);

require_login($course);
require_capability('enrol/notificationeabc:manage', $context);

$PAGE->set_url('/enrol/notificationeabc/edit.php', array('courseid' => $course->id, 'id' => $instanceid));
$PAGE->set_pagelayout('admin');

$return = new moodle_url('/enrol/instances.php', array('id' => $course->id));
if (!enrol_is_enabled('notificationeabc')) {
    redirect($return);
}

/** @var enrol_notificationeabc_plugin $plugin */
$plugin = enrol_get_plugin('notificationeabc');

if ($instanceid) {
    $instance = $DB->get_record('enrol',
        array(
        'courseid' => $course->id,
        'enrol' => 'notificationeabc',
        'id' => $instanceid
    ), '*', MUST_EXIST);

} else {
    require_capability('moodle/course:enrolconfig', $context);
    // No instance yet, we have to add new instance.
    navigation_node::override_active_url(new moodle_url('/enrol/instances.php', array('id' => $course->id)));

    $instance = (object)$plugin->get_instance_defaults();
    $instance->id = null;
    $instance->courseid = $course->id;
    $instance->status = ENROL_INSTANCE_ENABLED; // Do not use default for automatically created instances here.
}


$mform = new enrol_notificationeabc_edit_form(null, array($instance, $plugin, $context));

if ($mform->is_cancelled()) {
    redirect($return);

} else if ($data = $mform->get_data()) {
    if ($instance->id) {
        $reset = ($instance->status != $data->status);

        $instance->status = $data->status;
        $instance->name = $data->name;
        $instance->customint1 = $data->customint1;
        if (isset($data->customint2)) {
            $instance->customint2 = $data->customint2;
        } else {
            $instance->customint2 = 0;
        }

        if (isset($data->customint3)) {
            $instance->customint3 = $data->customint3;
        } else {
            $instance->customint3 = 0;
        }

        if (isset($data->customint4)) {
            $instance->customint4 = $data->customint4;
        } else {
            $instance->customint4 = 0;
        }

        if (isset($data->customint5)) {
            $instance->customint5 = $data->customint5;
        } else {
            $instance->customint5 = 0;
        }

        $instance->customtext1 = $data->customtext1['text'];
        $instance->customtext2 = $data->customtext2['text'];
        $instance->customtext3 = $data->customtext3['text'];
        $instance->customchar1 = $data->customchar1;
        $instance->customchar2 = $data->customchar2;
        $instance->timemodified = time();
        $DB->update_record('enrol', $instance);

        if ($reset) {
            $context->mark_dirty();
        }

    } else {
        $fields = array(
            'status' => $data->status,
            'name' => $data->name,
            'customint1' => $data->customint1,
            'customint2' => $data->customint2,
            'customint3' => $data->customint3,
            'customint4' => $data->customint4,
            'customint5' => $data->customint5,
            'customtext1' => $data->customtext1['text'],
            'customtext2' => $data->customtext2['text'],
            'customtext3' => $data->customtext3['text'],
            'customchar1' => $data->customchar1,
            'customchar2' => $data->customchar2);
        $plugin->add_instance($course, $fields);
    }

    redirect($return);
}

$PAGE->set_heading($course->fullname);
$PAGE->set_title(get_string('pluginname', 'enrol_notificationeabc'));

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('pluginname', 'enrol_notificationeabc'));
$mform->display();
echo $OUTPUT->footer();