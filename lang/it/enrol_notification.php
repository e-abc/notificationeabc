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

$string['subject'] = 'Notifica sullo stato di iscrizione';
$string['enrolmessagedefault'] = 'Sei stato iscritto al corso "{COURSENAME}" all\'indirizzo: {URL}';
$string['unenrolmessagedefault'] = 'Sei stato disiscritto dal corso "{COURSENAME}" all\'indirizzo: {URL}';
$string['enrolmentupdatemessagedefault'] = 'La tua iscrizione al corso {COURSENAME} all\'indirizzo: {URL} è stata modificata';
