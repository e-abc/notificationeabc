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

require_once($CFG->dirroot . '/lib/moodlelib.php');

/**
 * Lib class
 *
 * @package    enrol_notification
 * @copyright  2017 e-ABC Learning
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author     Osvaldo Arriola <osvaldo@e-abclearning.com>
 */
class enrol_notification_plugin extends enrol_plugin {
    /** @var log.*/
    private $log = '';

    // Funcion que envia las notificaciones a los usuarios.

    /**
     * Send mail method
     * @param stdClass $user user instance
     * @param stdClass $course course instance
     * @param int $type notice enrollment, update or unenrollment
     * @return bool
     */
    public function send_email(stdClass $user, stdClass $course, $type) {
        global $CFG, $DB;

        $enrol = $DB->get_record('enrol', array('enrol' => 'notification', 'courseid' => $course->id, 'status' => 0));

        $pluginconfig = get_config('enrol_notification');

        if ($type == 1) {
            $enrolalert = $pluginconfig->enrolalert;
            $globalenrolalert = $pluginconfig->globalenrolalert;

            if (!$message = $enrol->customtext1) { // Course level.
                if (!$message = $pluginconfig->enrolmessage) { // Plugin level.
                    $message = get_string('enrolmessagedefault', 'enrol_notification');
                }
            }
        }

        if ($type == 2) {
            $unenrolalert = $pluginconfig->unenrolalert;
            $globalunenrolalert = $pluginconfig->globalunenrolalert;

            if (!$message = $enrol->customtext2) { // Course level.
                if (!$message = $pluginconfig->unenrolmessage) { // Plugin level.
                    $message = get_string('unenrolmessagedefault', 'enrol_notification');
                }
            }
        }

        if ($type == 3) {
            $enrolmentupdatealert = $pluginconfig->enrolmentupdatealert;
            $globalenrolmentupdatealert = $pluginconfig->globalenrolmentupdatealert;

            if (!$message = $enrol->customtext3) { // Course level.
                if (!$message = $pluginconfig->enrolmentupdatemessage) { // Plugin level.
                    $message = get_string('enrolmentupdatemessagedefault', 'enrol_notification');
                }
            }
        }

        $message = $this->get_message($message, $user, $course);

        $supportuser = \core_user::get_support_user();

        $eventdata = new \core\message\message();
        $eventdata->courseid = $course->id;
        $eventdata->modulename = 'moodle';
        $eventdata->component = 'enrol_notification';
        $eventdata->name = 'notification_enrolment';
        $eventdata->userfrom = $supportuser;
        $eventdata->userto = $user->id;
        $eventdata->subject = get_string('subject', 'enrol_notification');
        $eventdata->fullmessage = '';
        $eventdata->fullmessageformat = FORMAT_HTML;
        $eventdata->fullmessagehtml = $message;
        $eventdata->smallmessage = '';
        $strdata = new stdClass();
        $strdata->username = $user->username;
        $strdata->coursename = $course->fullname;
        if (message_send($eventdata)) {
            $this->log .= get_string('succefullsend', 'enrol_notification', $strdata);
            return true;
        } else {
            $this->log .= get_string('failsend', 'enrol_notification', $strdata);
            return false;
        }
    } // End of function.

    // Procesa el mensaje para aceptar marcadores.
    /**
     * Proccess message method
     * @param String $message the raw message
     * @param stdClass $user user instance
     * @param stdClass $course course instance
     * @return String the processed message
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

        $numenrol = $DB->count_records('enrol', array('courseid' => $courseid, 'enrol' => 'notification'));
        $context = context_course::instance($courseid, MUST_EXIST);

        if (!has_capability('enrol/notification:manage', $context) or $numenrol >= 1) {
            return null;
        }

        return new moodle_url('/enrol/notification/edit.php', array('courseid' => $courseid));
    }


    /**
     * Returns defaults for new instances.
     * @return array
     */
    public function get_instance_defaults() {
        $fields = array();

        $pluginconfig = get_config('enrol_notification');

        $fields['status'] = 1;
        $fields['customint1'] = $this->get_config('enrolalert');
        $fields['customint2'] = $this->get_config('unenrolalert');
        $fields['customint3'] = $this->get_config('enrolmentupdatealert');

        $fields['customtext1'] = array();
        $fields['customtext1']['text'] = $pluginconfig->enrolmessage;
        $fields['customtext1']['format'] = '1';

        $fields['customtext2'] = array();
        $fields['customtext2']['text'] = $pluginconfig->unenrolmessage;
        $fields['customtext2']['format'] = '1';

        $fields['customtext3'] = array();
        $fields['customtext3']['text'] = $pluginconfig->enrolmentupdatemessage;
        $fields['customtext3']['format'] = '1';

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

        $context = context_course::instance($instance->courseid);

        $icons = array();

        if (has_capability('enrol/notification:manage', $context)) {
            $editlink = new moodle_url(
                '/enrol/editinstance.php',
                array('courseid' => $instance->courseid, 'id' => $instance->id, 'type' => 'notification')
            );
            $icons[] = $OUTPUT->action_icon(
                $editlink,
                new pix_icon( 't/edit', get_string('edit'), 'core', array('class' => 'icon iconsmall'))
            );
        }

        return $icons;
    }

    /**
     * Is it possible to delete enrol instance via standard UI?
     *
     * @param object $instance
     * @return bool
     */
    public function can_delete_instance($instance) {
        $context = context_course::instance($instance->courseid);
        if (!has_capability('enrol/notification:manage', $context)) {
            return false;
        }

        return true;
    }

    /**
     * Is it possible to hide/show enrol instance via standard UI?
     *
     * @param stdClass $instance
     * @return bool
     */
    public function can_hide_show_instance($instance) {
        $context = context_course::instance($instance->courseid);
        return has_capability('enrol/notification:config', $context);
    }

    /**
     * get info icons method
     * @param array $instances
     * @return array
     */
    public function get_info_icons(array $instances) {
        $icons = array();
        $icons[] = new pix_icon('email', get_string('pluginname', 'enrol_notification'), 'enrol_notification');
        return $icons;
    }

    /**
     * We are a good plugin and don't invent our own UI/validation code path.
     *
     * @return boolean
     */
    public function use_standard_editing_ui() {
        return true;
    }

    /**
     * Return an array of valid options for the status.
     *
     * @return array
     */
    protected function get_status_options() {
        $options = array(ENROL_INSTANCE_ENABLED  => get_string('yes'),
                         ENROL_INSTANCE_DISABLED => get_string('no'));
        return $options;
    }

    /**
     * Add elements to the edit instance form.
     *
     * @param stdClass $instance
     * @param MoodleQuickForm $mform
     * @param context $context
     * @return bool
     */
    public function edit_instance_form($instance, MoodleQuickForm $mform, $context) {

        // Bloody hack!
        if (!is_array($instance->customtext1)) {
            $temp = $instance->customtext1;
            $instance->customtext1 = array();
            $instance->customtext1['text'] = $temp;
            $instance->customtext1['format'] = '1';

            $temp = $instance->customtext2;
            $instance->customtext2 = array();
            $instance->customtext2['text'] = $temp;
            $instance->customtext2['format'] = '1';

            $temp = $instance->customtext3;
            $instance->customtext3 = array();
            $instance->customtext3['text'] = $temp;
            $instance->customtext3['format'] = '1';
        }
        // End of bloody hack!

        $textareaparams = array('rows' => 8, 'cols' => 60);

        $mform->addElement('text', 'name', get_string('custominstancename', 'enrol'));
        $mform->setType('name', PARAM_RAW);
        $mform->setDefault('name', get_string('pluginname', 'enrol_notification'));

        $options = $this->get_status_options();
        $mform->addElement('select', 'status', get_string('status', 'enrol_notification'), $options);
        $mform->setDefault('status', $this->get_config('status'));

        // Enrol notifications -> 'enrolalert'.
        $mform->addElement('advcheckbox', 'customint1', get_string('enrolalert', 'enrol_notification'));
        $mform->addHelpButton('customint1', 'enrolalert', 'enrol_notification');
        $mform->setDefault('customint1', $this->get_config('enrolalert'));

        // Enrol notifications -> 'enrolmessage'
        $mform->addElement('editor', 'customtext1', get_string('enrolmessage', 'enrol_notification'), $textareaparams);
        $mform->addHelpButton('customtext1', 'enrolmessage', 'enrol_notification');
        $mform->setType('customtext1', PARAM_RAW);
        $mform->setDefault('customtext1', $this->get_config('enrolmessage'));

        // Unenrol notifications -> 'unenrolalert'.
        $mform->addElement('advcheckbox', 'customint2', get_string('unenrolalert', 'enrol_notification'));
        $mform->addHelpButton('customint2', 'unenrolalert', 'enrol_notification');
        $mform->setDefault('customint2', $this->get_config('unenrolalert'));

        // Unenrol notifications -> 'unenrolmessage'.
        $mform->addElement('editor', 'customtext2', get_string('unenrolmessage', 'enrol_notification'), $textareaparams);
        $mform->addHelpButton('customtext2', 'unenrolmessage', 'enrol_notification');
        $mform->setType('customtext2', PARAM_RAW);
        $mform->setDefault('customtext2', $this->get_config('unenrolmessage'));

        // Update enrolment notifications -> 'enrolmentupdatealert'.
        $mform->addElement('advcheckbox', 'customint3', get_string('enrolmentupdatealert', 'enrol_notification'));
        $mform->addHelpButton('customint3', 'enrolmentupdatealert', 'enrol_notification');
        $mform->setDefault('customint3', $this->get_config('enrolmentupdatealert'));

        // Update enrolment notifications -> 'enrolmentupdatemessage'.
        $mform->addElement('editor', 'customtext3', get_string('enrolmentupdatemessage', 'enrol_notification'), $textareaparams);
        $mform->addHelpButton('customtext3', 'enrolmentupdatemessage', 'enrol_notification');
        $mform->setType('customtext3', PARAM_RAW);
        $mform->setDefault('customtext3', $this->get_config('enrolmentupdatemessage'));

        if (enrol_accessing_via_instance($instance)) {
            $warntext = get_string('instanceeditselfwarningtext', 'core_enrol');
            $mform->addElement('static', 'selfwarn', get_string('instanceeditselfwarning', 'core_enrol'), $warntext);
        }
    }

    public function add_instance($course, array $fields = NULL) {
        global $DB;

        if ($course->id == SITEID) {
            throw new coding_exception('Invalid request to add enrol instance to frontpage.');
        }

        $instance = new stdClass();
        $instance->enrol          = $this->get_name();
        $instance->status         = ENROL_INSTANCE_ENABLED;
        $instance->courseid       = $course->id;
        $instance->enrolstartdate = 0;
        $instance->enrolenddate   = 0;
        $instance->timemodified   = time();
        $instance->timecreated    = $instance->timemodified;
        $instance->sortorder      = $DB->get_field('enrol', 'COALESCE(MAX(sortorder), -1) + 1', array('courseid'=>$course->id));

        $fields = (array)$fields;
        unset($fields['enrol']);
        unset($fields['courseid']);
        unset($fields['sortorder']);
        foreach($fields as $field=>$value) {
            $instance->$field = $value;
        }

        $instance->customtext1 = $fields['customtext1']['text'];
        $instance->customtext2 = $fields['customtext2']['text'];
        $instance->customtext3 = $fields['customtext3']['text'];

        $instance->id = $DB->insert_record('enrol', $instance);

        \core\event\enrol_instance_created::create_from_record($instance)->trigger();

        return $instance->id;
    }

    public function update_instance($instance, $data) {
        global $DB;

        $properties = array('status', 'name', 'password', 'customint1', 'customint2', 'customint3',
                            'customint4', 'customint5', 'customint6', 'customint7', 'customint8',
                            'customchar1', 'customchar2', 'customchar3', 'customdec1', 'customdec2',
                            'customtext4', 'roleid',
                            'enrolperiod', 'expirynotify', 'notifyall', 'expirythreshold',
                            'enrolstartdate', 'enrolenddate', 'cost', 'currency');

        foreach ($properties as $key) {
            if (isset($data->$key)) {
                $instance->$key = $data->$key;
            }
        }
        $instance->timemodified = time();

        $instance->customtext1 = $data->customtext1['text'];
        $instance->customtext2 = $data->customtext2['text'];
        $instance->customtext3 = $data->customtext3['text'];

        $update = $DB->update_record('enrol', $instance);
        if ($update) {
            \core\event\enrol_instance_updated::create_from_record($instance)->trigger();
        }

        return $update;
    }

    /**
     * Perform custom validation of the data used to edit the instance.
     *
     * @param array $data array of ("fieldname"=>value) of submitted data
     * @param array $files array of uploaded files "element_name"=>tmp_file_path
     * @param object $instance The instance loaded from the DB
     * @param context $context The context of the instance we are editing
     * @return array of "element_name"=>"error_description" if there are errors,
     *         or an empty array if everything is OK.
     * @return void
     */
    public function edit_instance_validation($data, $files, $instance, $context) {
        $errors = array();
        $validstatus = array_keys($this->get_status_options());
        $tovalidate = array('status' => $validstatus);

        $typeerrors = $this->validate_param_types($data, $tovalidate);
        $errors = array_merge($errors, $typeerrors);

        return $errors;
    }
} // End of class.

