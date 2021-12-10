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
        'enrol_notificationeabc/activeenrolalert',
        get_string('activeenrolalert', 'enrol_notificationeabc'),
        get_string('activeenrolalert_help', 'enrol_notificationeabc'),
        '',
        '1')
    );
    $settings->add(new admin_setting_configcheckbox(
        'enrol_notificationeabc/activarglobal',
        get_string('activarglobal', 'enrol_notificationeabc'),
        get_string('activarglobal_help', 'enrol_notificationeabc'),
        '')
    );
    $settings->add(new admin_setting_heading(
        'enrol_notificationeabc_settings',
        '',
        get_string('pluginname_desc', 'enrol_notificationeabc'),
        '')
    );
    $settings->add(new admin_setting_confightmleditor(
        'enrol_notificationeabc/location',
        get_string('location', 'enrol_notificationeabc'),
        get_string('location_help', 'enrol_notificationeabc'),
        '')
    );

    // Unenrol notification.
    $settings->add(new admin_setting_configcheckbox(
        'enrol_notificationeabc/activeunenrolalert',
        get_string('activeunenrolalert', 'enrol_notificationeabc'),
        get_string('activeunenrolalert_help', 'enrol_notificationeabc'),
        '',
        '1')
    );
    $settings->add(new admin_setting_configcheckbox(
        'enrol_notificationeabc/activarglobalunenrolalert',
        get_string('activarglobalunenrolalert', 'enrol_notificationeabc'),
        get_string('activarglobalunenrolalert_help', 'enrol_notificationeabc'),
        '')
    );
    $settings->add(new admin_setting_confightmleditor(
        'enrol_notificationeabc/unenrolmessage',
        get_string('unenrolmessage', 'enrol_notificationeabc'),
        get_string('unenrolmessage_help', 'enrol_notificationeabc'),
        '')
    );

    // Update enrol notification.
    $settings->add(new admin_setting_configcheckbox(
        'enrol_notificationeabc/activeenrolupdatedalert',
        get_string('activeenrolupdatedalert', 'enrol_notificationeabc'),
        get_string('activeenrolupdatedalert_help', 'enrol_notificationeabc'),
        '',
        '1')
    );
    $settings->add(new admin_setting_configcheckbox(
        'enrol_notificationeabc/activarglobalenrolupdated',
        get_string('activarglobalenrolupdated', 'enrol_notificationeabc'),
        get_string('activarglobalenrolupdated_help', 'enrol_notificationeabc'),
        '')
    );
    $settings->add(new admin_setting_confightmleditor(
        'enrol_notificationeabc/updatedenrolmessage',
        get_string('updatedenrolmessage', 'enrol_notificationeabc'),
        get_string('updatedenrolmessage_help', 'enrol_notificationeabc'),
        '')
    );
    $settings->add(new admin_setting_configtext(
        'enrol_notificationeabc/emailsender',
        get_string('emailsender', 'enrol_notificationeabc'),
        get_string('emailsender_help', 'enrol_notificationeabc'),
        '')
    );
    $settings->add(new admin_setting_configtext(
        'enrol_notificationeabc/namesender',
        get_string('namesender', 'enrol_notificationeabc'),
        get_string('namesender_help', 'enrol_notificationeabc'),
        '')
    );
}
