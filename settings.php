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

if ($ADMIN->fulltree) {

    // General settings.

    // Enrol notification.
    $settings->add(new admin_setting_configcheckbox(
        'enrol_notificationeabc/enrolalert',
        get_string('enrolalert', 'enrol_notificationeabc'),
        get_string('enrolalert_help', 'enrol_notificationeabc'),
        '',
        '1')
    );
    $settings->add(new admin_setting_configcheckbox(
        'enrol_notificationeabc/globalenrolalert',
        get_string('globalenrolalert', 'enrol_notificationeabc'),
        get_string('globalenrolalert_help', 'enrol_notificationeabc'),
        '')
    );
    $settings->add(new admin_setting_configtextarea(
        'enrol_notificationeabc/enrolmessage',
        get_string('enrolmessage', 'enrol_notificationeabc'),
        get_string('enrolmessage_help', 'enrol_notificationeabc'),
        null)
    );

    // Unenrol notification.
    $settings->add(new admin_setting_configcheckbox(
        'enrol_notificationeabc/unenrolalert',
        get_string('unenrolalert', 'enrol_notificationeabc'),
        get_string('unenrolalert_help', 'enrol_notificationeabc'),
        '',
        '1')
    );
    $settings->add(new admin_setting_configcheckbox(
        'enrol_notificationeabc/globalunenrolalert',
        get_string('globalunenrolalert', 'enrol_notificationeabc'),
        get_string('globalunenrolalert_help', 'enrol_notificationeabc'),
        '')
    );
    $settings->add(new admin_setting_configtextarea(
        'enrol_notificationeabc/unenrolmessage',
        get_string('unenrolmessage', 'enrol_notificationeabc'),
        get_string('unenrolmessage_help', 'enrol_notificationeabc'),
        null)
    );

    // Update enrol notification.
    $settings->add(new admin_setting_configcheckbox(
        'enrol_notificationeabc/enrolupdatealert',
        get_string('enrolupdatealert', 'enrol_notificationeabc'),
        get_string('enrolupdatealert_help', 'enrol_notificationeabc'),
        '',
        '1')
    );
    $settings->add(new admin_setting_configcheckbox(
        'enrol_notificationeabc/globalenrolupdatealert',
        get_string('globalenrolupdatealert', 'enrol_notificationeabc'),
        get_string('globalenrolupdatealert_help', 'enrol_notificationeabc'),
        '')
    );
    $settings->add(new admin_setting_configtextarea(
        'enrol_notificationeabc/enrolupdatemessage',
        get_string('enrolupdatemessage', 'enrol_notificationeabc'),
        get_string('enrolupdatemessage_help', 'enrol_notificationeabc'),
        null)
    );
}
