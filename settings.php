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
 * Notification enrolment plugin.
 *
 * This plugin notifies users when an event occurs on their enrolments (enrol, unenrol, update enrolment)
 *
 * @package    enrol_notification
 * @copyright  2017 e-ABC Learning
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author     Osvaldo Arriola <osvaldo@e-abclearning.com>
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {

    // General settings.

    // Enrol notification.
    $settings->add(new admin_setting_configcheckbox(
        'enrol_notification/globalenrolalert',
        get_string('globalenrolalert', 'enrol_notification'),
        get_string('globalenrolalert_help', 'enrol_notification'),
        '')
    );
    $settings->add(new admin_setting_confightmleditor(
        'enrol_notification/enrolmessage',
        get_string('enrolmessage', 'enrol_notification'),
        get_string('enrolmessage_help', 'enrol_notification'),
        new lang_string('enrolmessagedefault', 'enrol_notification'))
    );

    // Unenrol notification.
    $settings->add(new admin_setting_configcheckbox(
        'enrol_notification/globalunenrolalert',
        get_string('globalunenrolalert', 'enrol_notification'),
        get_string('globalunenrolalert_help', 'enrol_notification'),
        '')
    );
    $settings->add(new admin_setting_confightmleditor(
        'enrol_notification/unenrolmessage',
        get_string('unenrolmessage', 'enrol_notification'),
        get_string('unenrolmessage_help', 'enrol_notification'),
        new lang_string('unenrolmessagedefault', 'enrol_notification'))
    );

    // Update enrol notification.
    $settings->add(new admin_setting_configcheckbox(
        'enrol_notification/globalenrolmentupdatealert',
        get_string('globalenrolmentupdatealert', 'enrol_notification'),
        get_string('globalenrolmentupdatealert_help', 'enrol_notification'),
        '')
    );
    $settings->add(new admin_setting_confightmleditor(
        'enrol_notification/enrolmentupdatemessage',
        get_string('enrolmentupdatemessage', 'enrol_notification'),
        get_string('enrolmentupdatemessage_help', 'enrol_notification'),
        new lang_string('enrolmentupdatemessagedefault', 'enrol_notification'))
    );
}
