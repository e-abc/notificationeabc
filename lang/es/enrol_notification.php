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

$string['failsend'] = 'ATENCION: No se pudo notificar al usuario {$a->username} sobre su matriculación en el curso {$a->coursename}'."\n";
$string['messageprovider:notification_enrolment'] = 'Enrol notification messages';
$string['notification:manage'] = 'Gestionar notificaciones de matriculación';

$string['pluginname'] = 'Notificación de Matriculación';
$string['status'] = 'Activar notification de matriculación';
$string['subject'] = 'Notificación de Matriculación';
$string['succefullsend'] = 'Se notifico al usuario {$a->username} sobre su matriculación en el curso {$a->coursename}'. "\n";

// Aviso de matriculacion.
$string['globalenrolalert'] = 'Activar para todo el sitio';
$string['globalenrolalert_help'] = 'Activa la notificacion de matriculacion para todo los cursos';
$string['enrolalert'] = 'Activar aviso de matriculación';
$string['enrolalert_help'] = 'Activar aviso de matriculación';
$string['enrolmessage'] = 'Mensaje personalizado';
$string['enrolmessage_help'] = 'Personalice el mensaje que le llegará a los usuarios al ser matriculados. Este campo acepta los siguientes marcadores que luego seran reemplazados dinámicamente por los valores correspondientes
<pre>
{COURSENAME} = Nombre completo del curso
{USERNAME} = Nombre de usuario
{FIRSTNAME} = Nombre
{LASTNAME} = Apellido
{URL} = Url del curso
</pre>';
$string['enrolmessagedefault'] = 'Ud ha sido matriculado en el curso {$a->fullname} ({$a->url})';

// Aviso de desmatriculacion.
$string['globalunenrolalert'] = 'Activar para todo el sitio';
$string['globalunenrolalert_help'] = 'Activar la notificacion de desmatriculacion para todo el sitio';
$string['unenrolalert'] = 'Activar aviso de desmatriculacion';
$string['unenrolalert_help'] = 'Activar aviso de desmatriculacion';
$string['unenrolmessage'] = 'Mensaje personalizado';
$string['unenrolmessage_help'] = 'Personalice el mensaje que le llegará a los usuarios al ser desmatriculados. Este campo acepta los siguientes marcadores que luego seran reemplazados dinámicamente por los valores correspondientes
<pre>
{COURSENAME} = Nombre completo del curso
{USERNAME} = Nombre de usuario
{FIRSTNAME} = Nombre
{LASTNAME} = Apellido
{URL} = Url del curso
</pre>';
$string['unenrolmessagedefault'] = 'Ud ha sido desmatriculado del curso {$a->fullname} ({$a->url})';

// Aviso de actualizacion de matriculacion.
$string['globalenrolmentupdatealert'] = 'Activar para todo el sitio';
$string['globalenrolmentupdatealert_help'] = 'Activar la notificacion de actualizacion de matriculacion para todo el sitio';
$string['enrolmentupdatealert'] = 'Activar aviso de actualizacion de matriculacion';
$string['enrolmentupdatealert_help'] = 'Activar aviso de actualizacion de matriculacion';
$string['enrolmentupdatemessage'] = 'Mensaje personalizado';
$string['enrolmentupdatemessage_help'] = 'Personalice el mensaje que le llegará a los usuarios al realizar alguna actualizacion en su matriculacion. Este campo acepta los siguientes marcadores que luego seran reemplazados dinámicamente por los valores correspondientes
<pre>
{COURSENAME} = Nombre completo del curso
{USERNAME} = Nombre de usuario
{FIRSTNAME} = Nombre
{LASTNAME} = Apellido
{URL} = Url del curso
</pre>';
$string['enrolmentupdatemessagedefault'] = 'Su matriculacion en el curso {$a->fullname} ha sido actualizada ({$a->url})';
