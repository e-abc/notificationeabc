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
    public static function user_unenroled(\core\event\user_enrolment_deleted $event) {
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

            $activeglobal = $notificationeabc->get_config('activarglobalunenrolalert');
            $activeunenrolalert = $notificationeabc->get_config('activeunenrolalert');

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
            if (!empty($enrol) && $instanceenabled) {
                $activeunenrolalert = $enrol->customint4;
            }

            if ($activeglobal == 1 && $activeunenrolalert == 1) {
                $notificationeabc->enviarmail($user, $course, 2);
            } else if (!empty($enrol) && !empty($activeunenrolalert) && $instanceenabled) {
                $notificationeabc->enviarmail($user, $course, 2);
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

            $activeglobal = $notificationeabc->get_config('activarglobalenrolupdated');
            $activeenrolupdatedalert = $notificationeabc->get_config('activeenrolupdatedalert');

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
            if (!empty($enrol) && $instanceenabled) {
                $activeenrolupdatedalert = $enrol->customint5;
            }

            if ($activeglobal == 1 && $activeenrolupdatedalert == 1) {
                $notificationeabc->enviarmail($user, $course, 3);
            } else if (!empty($enrol) && !empty($activeenrolupdatedalert) && $instanceenabled) {
                $notificationeabc->enviarmail($user, $course, 3);
            }
        }
    }

    /**
     * hook enrolment event
     * @param \core\event\user_enrolment_created $event
     */
    public static function user_enroled(\core\event\user_enrolment_created $event) {
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

            $activeglobal = $notificationeabc->get_config('activarglobal');
            $activeenrolalert = $notificationeabc->get_config('activeenrolalert');

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

            if (!empty($enrol) && $instanceenabled) {
                $activeenrolalert = $enrol->customint3;
            }

            if ($activeglobal == 1 && $activeenrolalert == 1) {
                $notificationeabc->enviarmail($user, $course, 1);
            } else if (!empty($enrol) && !empty($activeenrolalert) && $instanceenabled) {
                $notificationeabc->enviarmail($user, $course, 1);
            }
        }
    }
}