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
require_once($CFG->dirroot . '/enrol/notification/lib.php');

/**
 * Observer definition
 *
 * @package    enrol_notification
 * @copyright  2017 e-ABC Learning
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author     Osvaldo Arriola <osvaldo@e-abclearning.com>
 */
class enrol_notification_observer
{

    /**
     * hook enrolment event
     * @param \core\event\user_enrolment_created $event
     */
    public static function user_enrolled(\core\event\user_enrolment_created $event) {
        global $DB;

        // Validate plugin status in system context.
        $enableplugins = get_config(null, 'enrol_plugins_enabled');
        $enableplugins = explode(',', $enableplugins);
        $enabled = in_array('notification', $enableplugins);

        if ($enabled) {
            $notification = new enrol_notification_plugin();

            $user = $DB->get_record('user', array('id' => $event->relateduserid));
            $course = $DB->get_record('course', array('id' => $event->courseid));

            $globalenrolalert = $notification->get_config('globalenrolalert');

            $enrol = $DB->get_record('enrol', array('enrol' => 'notification', 'courseid' => $event->courseid));

            if (empty($enrol)) {
                // This course does not use this enrolment plugin.
                if (!empty($globalenrolalert)) {
                    // But global use of enrolalert was requested at site level for each course.
                    $notification->send_email($user, $course, 1);
                }
            } else {
                // This course uses this enrolment plugin.
                // Check the instance status. Take care: status = 0 enabled; status = 1 disabled.
                if (empty($enrol->status)) {
                    $localenrolalert = $enrol->customint1;
                    if (!empty($localenrolalert)) {
                        $notification->send_email($user, $course, 1);
                    }
                }
            }
        }
    }

    /**
     * hook unenrolment event
     * @param \core\event\user_enrolment_deleted $event
     */
    public static function user_unenrolled(\core\event\user_enrolment_deleted $event) {
        global $DB;

        // Validate status plugin.
        $enableplugins = get_config(null, 'enrol_plugins_enabled');
        $enableplugins = explode(',', $enableplugins);
        $enabled = in_array('notification', $enableplugins);

        if ($enabled) {
            $notification = new enrol_notification_plugin();

            $user = $DB->get_record('user', array('id' => $event->relateduserid));
            $course = $DB->get_record('course', array('id' => $event->courseid));

            $globalunenrolalert = $notification->get_config('globalunenrolalert');

            $enrol = $DB->get_record('enrol', array('enrol' => 'notification', 'courseid' => $event->courseid));

            if (empty($enrol)) {
                // This course does not use this enrolment plugin.
                if (!empty($globalunenrolalert)) {
                    // But global use of unenrolalert was requested at site level for each course.
                    $notification->send_email($user, $course, 2);
                }
            } else {
                // This course uses this enrolment plugin.
                // Check the instance status. Take care: status = 0 enabled; status = 1 disabled.
                if (empty($enrol->status)) {
                    $localunenrolalert = $enrol->customint2;
                    if (!empty($localunenrolalert)) {
                        $notification->send_email($user, $course, 2);
                    }
                }
            }
        }
    }

    /**
     * hook user enrolment update event
     * @param \core\event\user_enrolment_updated $event
     */
    public static function user_updated(\core\event\user_enrolment_updated $event) {
        global $DB;

        // Validate plugin status in system context.
        $enableplugins = get_config(null, 'enrol_plugins_enabled');
        $enableplugins = explode(',', $enableplugins);
        $enabled = in_array('notification', $enableplugins);

        if ($enabled) {
            $notification = new enrol_notification_plugin();

            $user = $DB->get_record('user', array('id' => $event->relateduserid));
            $course = $DB->get_record('course', array('id' => $event->courseid));

            $globalenrolmentupdatealert = $notification->get_config('globalenrolmentupdatealert');

            $enrol = $DB->get_record('enrol', array('enrol' => 'notification', 'courseid' => $event->courseid));

            if (empty($enrol)) {
                // This course does not use this enrolment plugin.
                if (!empty($globalenrolmentupdatealert)) {
                    // But global use of enrolmentupdatealert was requested at site level for each course.
                    $notification->send_email($user, $course, 3);
                }
            } else {
                // This course uses this enrolment plugin.
                // Check the instance status. Take care: status = 0 enabled; status = 1 disabled.
                if (empty($enrol->status)) {
                    $localenrolmentupdatealert = $enrol->customint3;
                    if (!empty($localenrolmentupdatealert)) {
                        $notification->send_email($user, $course, 3);
                    }
                }
            }
        }
    }
}