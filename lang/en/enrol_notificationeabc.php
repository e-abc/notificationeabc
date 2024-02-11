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

$string['filelockedmail'] = 'You have been enroled in {$a->fullname} ({$a->url})';
$string['location'] = 'Custom Message';
$string['messageprovider:notificationeabc_enrolment'] = 'Enrol notification messages';
$string['notificationeabc:manage'] = 'Manage notificationeabc';
$string['pluginname'] = 'Enrol Notification';
$string['pluginname_desc'] = 'Enrol notifications via mail';
$string['location_help'] = 'Personalize the message that send to users to be enrolled. This field accepts the following markers which then will be replaced by the corresponding values dynamically
<pre>
{COURSENAME} = course fullname
{USERNAME} = username
{NOMBRE} = firstname
{APELLIDO} = lastname
{URL} = course url
</pre>';
$string['fecha_help'] = 'Place the period for which you want to perform the first verification';
$string['fecha'] = 'Period for verification of users enrolled courses';
$string['activar'] = 'Enable initial verification';
$string['activar_help'] = 'When activated will be verified by the immediate execution of cron later, users who were enrolled for the period specified above';
$string['activarglobal'] = 'Activate globally';
$string['activarglobal_help'] = 'Activate enrol notifications for entire site';
$string['emailsender'] = 'Sender email address ';
$string['emailsender_help'] = 'By default it takes the email address set to the user support ';
$string['namesender'] = 'Sender email name ';
$string['namesender_help'] = 'By default it takes the name set to the user support';
$string['status'] = 'Activate enrol notification';
$string['subject'] = 'Enrolment notification';
$string['activeenrolalert'] = 'Activate enrol notifications';
$string['activeenrolalert_help'] = 'Activate enrol notifications';
// Unenrol notifications.
$string['activeunenrolalert'] = 'Activate unenrol notifications';
$string['activeunenrolalert_help'] = 'Activate unenrol notifications';
$string['activarglobalunenrolalert'] = 'Activate globally';
$string['activarglobalunenrolalert_help'] = 'Activate unenrol notifications for entire site';
$string['unenrolmessage'] = 'Custom Message';
$string['unenrolmessage_help'] = 'Personalize the message that send to users to be unenrolled. This field accepts the following markers which then will be replaced by the corresponding values dynamically
<pre>
{COURSENAME} = course fullname
{USERNAME} = username
{NOMBRE} = firstname
{APELLIDO} = lastname
{URL} = course url
</pre>';
$string['unenrolmessagedefault'] = 'You have been unenrolled from {$a->fullname} ({$a->url})';
// Update enrol notifications.
$string['activeenrolupdatedalert'] = 'Activate update enrol notifications';
$string['activeenrolupdatedalert_help'] = 'Activate update enrol notifications';
$string['activarglobalenrolupdated'] = 'Activate globally';
$string['activarglobalenrolupdated_help'] = 'Activate update enrol notifications for entire site';
$string['updatedenrolmessage'] = 'Custom message';
$string['updatedenrolmessage_help'] = 'Personalize the message that send to users to be updated. This field accepts the following markers which then will be replaced by the corresponding values dynamically
<pre>
{COURSENAME} = course fullname
{USERNAME} = username
{NOMBRE} = firstname
{APELLIDO} = lastname
{URL} = course url
</pre>';
$string['updatedenrolmessagedefault'] = 'Your enrolment to {$a->fullname} has been updated ({$a->url})';
$string['succefullsend'] = 'The user {$a->username} has been notified about his enrollment in the {$a->coursename} course'."\n";
$string['failsend'] = 'WARNING: Unable to notify the {$a->username} user about his enrollment in the {$a->coursename} course'."\n";