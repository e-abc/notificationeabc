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

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/formslib.php');

/**
 * Edit form class
 *
 * @package    enrol_notificationeabc
 * @copyright  2016 e-ABC Learning
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class enrol_notificationeabc_edit_form extends moodleform
{
    /**
     * Main definition
     */
    public function definition() {

        $mform = $this->_form;

        list($instance, $plugin, $context) = $this->_customdata;

        $mform->addElement('header', 'header', get_string('pluginname', 'enrol_notificationeabc'));
        $mform->addElement('text', 'name', get_string('custominstancename', 'enrol'));

        $options = array(ENROL_INSTANCE_ENABLED => get_string('yes'),
            ENROL_INSTANCE_DISABLED => get_string('no'));
        $mform->addElement('select', 'status', get_string('status', 'enrol_notificationeabc'), $options);

        // Enrol notifications.
        $mform->addElement('advcheckbox', 'customint3', get_string('activeenrolalert', 'enrol_notificationeabc'));
        $mform->addHelpButton('customint3', 'activeenrolalert', 'enrol_notificationeabc');

        $mform->addElement('editor', 'customtext1', get_string('location', 'enrol_notificationeabc'), null);
        $mform->setType('customtext1', PARAM_RAW);
        $mform->addHelpButton('customtext1', 'location', 'enrol_notificationeabc');

        // Unenrol notifications.
        $mform->addElement('advcheckbox', 'customint4', get_string('activeunenrolalert', 'enrol_notificationeabc'));
        $mform->addHelpButton('customint4', 'activeunenrolalert', 'enrol_notificationeabc');

        $mform->addElement('editor', 'customtext2', get_string('unenrolmessage', 'enrol_notificationeabc'), null);
        $mform->setType('customtext2', PARAM_RAW);
        $mform->addHelpButton('customtext2', 'unenrolmessage', 'enrol_notificationeabc');

        // Update enrolment notifications.
        $mform->addElement('advcheckbox', 'customint5', get_string('activeenrolupdatedalert', 'enrol_notificationeabc'));
        $mform->addHelpButton('customint5', 'activeenrolupdatedalert', 'enrol_notificationeabc');

        $mform->addElement('editor', 'customtext3', get_string('updatedenrolmessage', 'enrol_notificationeabc'), null);
        $mform->setType('customtext3', PARAM_RAW);
        $mform->addHelpButton('customtext3', 'updatedenrolmessage', 'enrol_notificationeabc');

        // Email y nombre del remitente.
        $mform->addElement('text', 'customchar1', get_string('emailsender', 'enrol_notificationeabc'));
        $mform->addHelpButton('customchar1', 'emailsender', 'enrol_notificationeabc');

        $mform->addElement('text', 'customchar2', get_string('namesender', 'enrol_notificationeabc'));
        $mform->addHelpButton('customchar2', 'namesender', 'enrol_notificationeabc');

        $this->add_action_buttons(true, ($instance->id ? null : get_string('addinstance', 'enrol')));

        if (!empty($instance->courseid)) {
            $mform->addElement('hidden', 'courseid', $instance->courseid);
            $mform->setType('courseid', PARAM_INT);
        }

        if (!empty($instance->id)) {
            $mform->addElement('hidden', 'id', $instance->id);
            $mform->setType('id', PARAM_INT);
        }

        if (!empty($instance)) {
            $mform->setDefault('customtext1', array('text' => $instance->customtext1));
            $mform->setDefault('customtext2', array('text' => $instance->customtext2));
            $mform->setDefault('customtext3', array('text' => $instance->customtext3));
            $mform->setDefault('customchar1', $instance->customchar1);
            $mform->setDefault('customchar2', $instance->customchar2);
            $mform->setDefault('customint3', $instance->customint3);
            $mform->setDefault('customint4', $instance->customint4);
            $mform->setDefault('customint5', $instance->customint5);
            if (!empty($instance->name)) {
                $mform->setDefault('name', $instance->name);
            } else {
                $mform->setDefault('name', 'notificationeabc');
            }
        }
        $this->set_data($instance);

    }


}
