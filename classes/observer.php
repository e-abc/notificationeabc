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
require_once($CFG->dirroot . '/enrol/notificationeabc/lib.php');

/**
 * Observer definition
 *
 * @package    enrol_notificationeabc
 * @copyright  2017 e-ABC Learning
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author     Osvaldo Arriola <osvaldo@e-abclearning.com>
 */
class enrol_notificationeabc_observer
{

    /**
     * hook enrol event
     * @param \core\event\user_enrolment_deleted $event
     */
    public static function user_unenrolled(\core\event\user_enrolment_deleted $event) {
        global $DB;

        // Validate status plugin.
        $enableplugins = get_config(null, 'enrol_plugins_enabled');
        $enableplugins = explode(',', $enableplugins);
        $enabled = false;
        foreach ($enableplugins as $enableplugin) {
            if ($enableplugin === 'notificationeabc') {
                $enabled = true;
            }
        }
        if ($enabled) {
            $user = $DB->get_record('user', array('id' => $event->relateduserid));
            $course = $DB->get_record('course', array('id' => $event->courseid));

            $notificationeabc = new enrol_notificationeabc_plugin();

            $activeglobal = $notificationeabc->get_config('globalunenrolalert');
            $unenrolalert = $notificationeabc->get_config('unenrolalert');

            $enrol = $DB->get_record('enrol', array('enrol' => 'notificationeabc', 'courseid' => $event->courseid));

            /*
            * check the instance status
            * status = 0 enabled and status = 1 disabled
            */
            $instanceenabled = false;
            if (!empty($enrol)) {
                if (!$enrol->status) {
                    $instanceenabled = true;
                }
            }

            if ($activeglobal == 1 && $unenrolalert == 1) {
                $notificationeabc->send_email($user, $course, 2);
            } else if (!empty($enrol) && !empty($unenrolalert) && $instanceenabled) {
                $notificationeabc->send_email($user, $course, 2);
            }
        }
    }

    /**
     * hook user update event
     * @param \core\event\user_enrolment_updated $event
     */
    public static function user_updated(\core\event\user_enrolment_updated $event) {
        global $DB;

        // Validate plugin status in system context.
        $enableplugins = get_config(null, 'enrol_plugins_enabled');
        $enableplugins = explode(',', $enableplugins);
        $enabled = false;
        foreach ($enableplugins as $enableplugin) {
            if ($enableplugin === 'notificationeabc') {
                $enabled = true;
            }
        }
        if ($enabled) {
            $user = $DB->get_record('user', array('id' => $event->relateduserid));
            $course = $DB->get_record('course', array('id' => $event->courseid));

            $notificationeabc = new enrol_notificationeabc_plugin();

            $activeglobal = $notificationeabc->get_config('globalenrolupdatealert');
            $enrolupdatealert = $notificationeabc->get_config('enrolupdatealert');

            // Plugin instance in course.
            $enrol = $DB->get_record('enrol', array('enrol' => 'notificationeabc', 'courseid' => $event->courseid));

            /*
            * check the instance status
            * status = 0 enabled and status = 1 disabled
            */
            $instanceenabled = false;
            if (!empty($enrol)) {
                if (!$enrol->status) {
                    $instanceenabled = true;
                }
            }

            if ($activeglobal == 1 && $enrolupdatealert == 1) {
                $notificationeabc->send_email($user, $course, 3);
            } else if (!empty($enrol) && !empty($enrolupdatealert) && $instanceenabled) {
                $notificationeabc->send_email($user, $course, 3);
            }
        }
    }

    /**
     * hook enrolment event
     * @param \core\event\user_enrolment_created $event
     */
    public static function user_enrolled(\core\event\user_enrolment_created $event) {
        global $DB;

        // Validate plugin status in system context.
        $enableplugins = get_config(null, 'enrol_plugins_enabled');
        $enableplugins = explode(',', $enableplugins);
        $enabled = false;
        foreach ($enableplugins as $enableplugin) {
            if ($enableplugin === 'notificationeabc') {
                $enabled = true;
            }
        }

        if ($enabled) {
            $user = $DB->get_record('user', array('id' => $event->relateduserid));
            $course = $DB->get_record('course', array('id' => $event->courseid));

            $notificationeabc = new enrol_notificationeabc_plugin();

            $activeglobal = $notificationeabc->get_config('globalenrolalert');
            $enrolalert = $notificationeabc->get_config('enrolalert');

            $enrol = $DB->get_record('enrol', array('enrol' => 'notificationeabc', 'courseid' => $event->courseid));

            // Check the instance status.
            // Legend: status = 0 enabled; status = 1 disabled.
            $instanceenabled = false;
            if (!empty($enrol)) {
                if (!$enrol->status) {
                    $instanceenabled = true;
                }
            }

            if ($activeglobal == 1 && $enrolalert == 1) {
                $notificationeabc->send_email($user, $course, 1);
            } else if (!empty($enrol) && !empty($enrolalert) && $instanceenabled) {
                $notificationeabc->send_email($user, $course, 1);
            }
        }
    }
}