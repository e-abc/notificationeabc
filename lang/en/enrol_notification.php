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

$string['failsend'] = 'WARNING: it has no been able to notify the {$a->username} user about his enrollment in the {$a->coursename} course'."\n";
$string['messageprovider:notification_enrolment'] = 'Enrol email notification messages';
$string['notification:config'] = 'Configure email notification instances';
$string['notification:manage'] = 'Manage email notification';
$string['pluginname'] = 'Enrol notification';
$string['status'] = 'Active email notification';
$string['subject'] = 'Enrolment status notification';
$string['succefullsend'] = 'The user {$a->username} has been notified about his enrollment in the {$a->coursename} course'."\n";

// Enrol notifications.
$string['globalenrolalert'] = 'Enable global enrol message';
$string['globalenrolalert_help'] = 'Enable enrol message for each course in this site';
$string['enrolalert'] = 'Enable enrol message';
$string['enrolalert_help'] = 'Enable enrol message';
$string['enrolmessage'] = 'Custom enrol message';
$string['enrolmessage_help'] = 'Personalize the message that users will come to be enrolled. This field accepts the following markers which then will be replaced by the corresponding values ​​dynamically
<pre>
{COURSENAME} = course fullname
{USERNAME} = username
{FIRSTNAME} = firstname
{LASTNAME} = lastname
{URL} = course url
</pre>
Leave this field empty (or untouched to its default) to use the site level default settings for this plugin.';
$string['enrolmessagedefault'] = 'You have been enrolled to course "{COURSENAME}" at {URL}';

// Unenrol notifications.
$string['globalunenrolalert'] = 'Enable global unenrol message';
$string['globalunenrolalert_help'] = 'Enable unenrol message for each course in this site';
$string['unenrolalert'] = 'Enable unenrol message';
$string['unenrolalert_help'] = 'Enable unenrol message';
$string['unenrolmessage'] = 'Custom unenrol message';
$string['unenrolmessage_help'] = 'Personalize the message that users will come to be unenrolled. This field accepts the following markers which then will be replaced by the corresponding values ​​dynamically
<pre>
{COURSENAME} = course fullname
{USERNAME} = username
{FIRSTNAME} = firstname
{LASTNAME} = lastname
{URL} = course url
</pre>
Leave this field empty (or untouched to its default) to use the site level default settings for this plugin.';
$string['unenrolmessagedefault'] = 'You have been unenrolled from course "{COURSENAME}" at {URL}';

// Update enrol notifications.
$string['globalenrolmentupdatealert'] = 'Enable global enrol update message';
$string['globalenrolmentupdatealert_help'] = 'Enable enrol update message for each course in this site';
$string['enrolmentupdatealert'] = 'Enable enrol update message';
$string['enrolmentupdatealert_help'] = 'Enable enrol update message';
$string['enrolmentupdatemessage'] = 'Custom enrol update message';
$string['enrolmentupdatemessage_help'] = 'Personalize the message that users will come to be updated. This field accepts the following markers which then will be replaced by the corresponding values ​​dynamically
<pre>
{COURSENAME} = course fullname
{USERNAME} = username
{FIRSTNAME} = firstname
{LASTNAME} = lastname
{URL} = course url
</pre>
Leave this field empty (or untouched to its default) to use the site level default settings for this plugin.';
$string['enrolmentupdatemessagedefault'] = 'Your enrolment to course "{COURSENAME}" at {URL} has been updated';
