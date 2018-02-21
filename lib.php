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

require_once($CFG->dirroot . '/lib/moodlelib.php');

/**
 * Lib class
 *
 * @package    enrol_notificationeabc
 * @copyright  2017 e-ABC Learning
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author     Osvaldo Arriola <osvaldo@e-abclearning.com>
 */
class enrol_notificationeabc_plugin extends enrol_plugin
{
    /** @var log.*/
    private $log = '';

    // Funcion que envia las notificaciones a los usuarios.

    /**
     *  Send mail method
     * @param stdClass $user instancia usuario
     * @param stdClass $course instancia curso
     * @param int $type aviso matriculacion, actualizacion o desmatriculacion
     * @return bool
     */
    public function send_email(stdClass $user, stdClass $course, $type) {
        global $CFG, $DB, $COURSE;

        $course->url = $CFG->wwwroot . '/course/view.php?id=' . $course->id;

        $enrol = $DB->get_record('enrol', array('enrol' => 'notificationeabc', 'courseid' => $course->id, 'status' => 0));
        $activeglobalenrol = $this->get_config('activarglobalenrolalert');
        $activarglobalunenrolalert = $this->get_config('activarglobalunenrolalert');
        $activarglobalenrolupdated = $this->get_config('activarglobalenrolupdated');
        $enrolmessage = $this->get_config('enrolmessage');
        $plainmensajeenrol = strip_tags($enrolmessage);
        $unenrolmessage = $this->get_config('unenrolmessage');
        $plainmensajeunenrol = strip_tags($unenrolmessage);
        $updatedenrolmessage = $this->get_config('updatedenrolmessage');
        $plainmensajeupdateenrol = strip_tags($updatedenrolmessage);

        switch ((int)$type) {
            case 1:
                // Si no se configuro un mensaje personalizado se envia uno por defecto basico.
                if (!empty($enrol) && !empty($enrol->customtext1)) {
                    $customtext = strip_tags($enrol->customtext1);
                    if (!empty($customtext)) {
                        $message = $this->get_message($enrol->customtext1, $user, $course);
                    } else {
                        $message = get_string('enrolmessagedefault', 'enrol_notificationeabc', $course);
                    }

                } else if (!empty($activeglobalenrol) && !empty($plainmensajeenrol)) {
                    $message = $this->get_message($enrolmessage, $user, $course);
                } else {
                    $message = get_string('enrolmessagedefault', 'enrol_notificationeabc', $course);
                }
                break;
            case 2:
                if (!empty($enrol) && !empty($enrol->customtext2)) {
                    $customtext = strip_tags($enrol->customtext2);
                    if (!empty($customtext)) {
                        $message = $this->get_message($enrol->customtext2, $user, $course);
                    } else {
                        $message = get_string('unenrolmessagedefault', 'enrol_notificationeabc', $course);
                    }

                } else if (!empty($activarglobalunenrolalert) && !empty($plainmensajeunenrol)) {
                    $message = $this->get_message($unenrolmessage, $user, $course);
                } else {
                    $message = get_string('unenrolmessagedefault', 'enrol_notificationeabc', $course);
                }
                break;
            case 3:
                if (!empty($enrol) && !empty($enrol->customtext3)) {
                    $customtext = strip_tags($enrol->customtext3);
                    if (!empty($customtext)) {
                        $message = $this->get_message($enrol->customtext3, $user, $course);
                    } else {
                        $message = get_string('updatedenrolmessagedefault', 'enrol_notificationeabc', $course);
                    }

                } else if (!empty($activarglobalenrolupdated) && !empty($plainmensajeupdateenrol)) {
                    $message = $this->get_message($updatedenrolmessage, $user, $course);
                } else {
                    $message = get_string('updatedenrolmessagedefault', 'enrol_notificationeabc', $course);
                }
                break;

            default:
                break;
        }

        $soporte = core_user::get_support_user();

        $sender = get_admin();

        if (!empty($enrol) && !empty($enrol->customchar1)) {
            $sender->email = $enrol->customchar1;
        } else {
            $sender->email = $soporte->email;
        }

        if (!empty($enrol) && !empty($enrol->customchar2)) {
            $sender->firstname = $enrol->customchar2;
        } else {
            $sender->firstname = $soporte->firstname;
        }

        $sender->lastname = $soporte->lastname;

        $eventdata = new \core\message\message();
        $eventdata->courseid = $course->id;
        $eventdata->modulename = 'moodle';
        $eventdata->component = 'enrol_notificationeabc';
        $eventdata->name = 'notificationeabc_enrolment';
        $eventdata->userfrom = $sender;
        $eventdata->userto = $user->id;
        $eventdata->subject = get_string('subject', 'enrol_notificationeabc');
        $eventdata->fullmessage = '';
        $eventdata->fullmessageformat = FORMAT_HTML;
        $eventdata->fullmessagehtml = $message;
        $eventdata->smallmessage = '';
        $strdata = new stdClass();
        $strdata->username = $user->username;
        $strdata->coursename = $course->fullname;
        if (message_send($eventdata)) {
            $this->log .= get_string('succefullsend', 'enrol_notificationeabc', $strdata);
            return true;
        } else {
            $this->log .= get_string('failsend', 'enrol_notificationeabc', $strdata);
            return false;
        }
    } // End of function.

    // Procesa el mensaje para aceptar marcadores.
    /**
     * Proccess message method
     * @param String $message el mensaje en bruto
     * @param stdClass $user instancia usuario
     * @param stdClass $course instancia curso
     * @return String el mensaje procesado
     */
    public function get_message($message, stdClass $user, stdClass $course) {
        global $CFG;
        $m = $message;
        $url = new moodle_url($CFG->wwwroot . '/course/view.php', array('id' => $course->id));
        $m = str_replace('{COURSENAME}', $course->fullname, $m);
        $m = str_replace('{USERNAME}', $user->username, $m);
        $m = str_replace('{FIRSTNAME}', $user->firstname, $m);
        $m = str_replace('{LASTNAME}', $user->lastname, $m);
        $m = str_replace('{URL}', $url, $m);
        return $m;
    }


    /**
     * Returns link to page which may be used to add new instance of enrolment plugin in course.
     * @param int $courseid
     * @return moodle_url page url
     */
    public function get_newinstance_link($courseid) {
        global $DB;
        $numenrol = $DB->count_records('enrol', array('courseid' => $courseid, 'enrol' => 'notificationeabc'));
        $context = context_course::instance($courseid, MUST_EXIST);

        if (!has_capability('enrol/notificationeabc:manage', $context) or $numenrol >= 1) {
            return null;
        }
        return new moodle_url('/enrol/notificationeabc/edit.php', array('courseid' => $courseid));
    }


    /**
     * Returns defaults for new instances.
     * @return array
     */
    public function get_instance_defaults() {

        $fields = array();
        $fields['customtext1'] = $this->get_config('enrolmessage');
        $fields['customtext2'] = $this->get_config('unenrolmessage');
        $fields['customtext3'] = $this->get_config('updatedenrolmessage');
        $fields['status'] = 1;
        $fields['customint1'] = $this->get_config('activeenrolalert');
        $fields['customint2'] = $this->get_config('activeunenrolalert');
        $fields['customint3'] = $this->get_config('activeenrolupdatedalert');
        $fields['customchar1'] = $this->get_config('emailsender');
        $fields['customchar2'] = $this->get_config('namesender');

        return $fields;
    }

    /**
     * Get icons
     * @param stdClass $instance
     * @return array
     * @throws coding_exception
     */
    public function get_action_icons(stdClass $instance) {
        global $OUTPUT;

        if ($instance->enrol !== 'notificationeabc') {
            throw new coding_exception('invalid enrol instance!');
        }
        $context = context_course::instance($instance->courseid);

        $icons = array();

        if (has_capability('enrol/notificationeabc:manage', $context)) {
            $editlink = new moodle_url(
                '/enrol/notificationeabc/edit.php',
                array('courseid' => $instance->courseid, 'id' => $instance->id)
            );
            $icons[] = $OUTPUT->action_icon(
                $editlink,
                new pix_icon(
                    't/edit',
                    get_string('edit'),
                    'core',
                    array('class' => 'icon iconsmall')
                )
            );
        }

        return $icons;
    }


    /**
     * get info icons method
     * @param array $instances
     * @return array
     */
    public function get_info_icons(array $instances) {
        $icons = array();
        $icons[] = new pix_icon('email', get_string('pluginname', 'enrol_notificationeabc'), 'enrol_notificationeabc');
        return $icons;
    }

    /**
     * Is it possible to hide/show enrol instance via standard UI?
     *
     * @param stdClass $instance
     * @return bool
     */
    public function can_hide_show_instance($instance) {
        $context = context_course::instance($instance->courseid);
        return has_capability('enrol/notificationeabc:config', $context);
    }
} // End of class.

