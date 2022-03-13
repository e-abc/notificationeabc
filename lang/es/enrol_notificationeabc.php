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

$string['filelockedmail'] = 'Ud ha sido matriculado en el curso {$a->fullname} ({$a->url})';
$string['location'] = 'Mensaje personalizado';
$string['messageprovider:notificationeabc_enrolment'] = 'Enrol notification messages';
$string['notificationeabc:manage'] = 'Gestionar notificaciones de matriculación';
$string['pluginname'] = 'Notificación de Matriculación';
$string['pluginname_desc'] = 'Notificación de matriculaciones a cursos via mail';
$string['location_help'] = 'Personalice el mensaje que le llegará a los usuarios al ser matriculados. Este campo acepta los siguientes marcadores que luego seran reemplazados dinámicamente por los valores correspondientes
<pre>
{COURSENAME} = Nombre completo del curso
{USERNAME} = Nombre de usuario
{NOMBRE} = Nombre
{APELLIDO} = Apellido
{URL} = Url del curso
</pre>';
$string['fecha_help'] = 'Coloque el periodo por el cual desea que se realice la virificación inicial de usuarios matriculados';
$string['fecha'] = 'Período para realizar la verificación de usuarios que se matricularon a cursos';
$string['activar'] = 'Activar verificación inicial';
$string['activar_help'] = 'Al activarse se verificará, mediante la ejecucion del cron inmediata posterior, los usuarios que fueron matriculados en el periodo establecido arriba';
$string['activarglobal'] = 'Activar para todo el sitio';
$string['activarglobal_help'] = 'Activa la notificacion de matriculacion para todo los cursos';
$string['emailsender'] = 'Email del remitente ';
$string['emailsender_help'] = 'Por defecto toma el email configurado como el usuario de soporte ';
$string['namesender'] = 'Nombre del remitente ';
$string['namesender_help'] = 'Por defecto toma el nombre configurado como el usuario de soporte ';
$string['status'] = 'Activar notification de matriculación';
$string['subject'] = 'Notificación de Matriculación';
$string['activeenrolalert'] = 'Activar aviso de matriculación';
$string['activeenrolalert_help'] = 'Activar aviso de matriculación';
// Aviso de desmatriculacion.
$string['activeunenrolalert'] = 'Activar aviso de desmatriculacion';
$string['activeunenrolalert_help'] = 'Activar aviso de desmatriculacion';
$string['activarglobalunenrolalert'] = 'Activar para todo el sitio';
$string['activarglobalunenrolalert_help'] = 'Activar la notificacion de desmatriculacion para todo el sitio';
$string['unenrolmessage'] = 'Mensaje personalizado';
$string['unenrolmessage_help'] = 'Personalice el mensaje que le llegará a los usuarios al ser desmatriculados. Este campo acepta los siguientes marcadores que luego seran reemplazados dinámicamente por los valores correspondientes
<pre>
{COURSENAME} = Nombre completo del curso
{USERNAME} = Nombre de usuario
{NOMBRE} = Nombre
{APELLIDO} = Apellido
{URL} = Url del curso
</pre>';
$string['unenrolmessagedefault'] = 'Ud ha sido desmatriculado del curso {$a->fullname} ({$a->url})';
// Aviso de actualizacion de matriculacion.
$string['activeenrolupdatedalert'] = 'Activar aviso de actualizacion de matriculacion';
$string['activeenrolupdatedalert_help'] = 'Activar aviso de actualizacion de matriculacion';
$string['activarglobalenrolupdated'] = 'Activar para todo el sitio';
$string['activarglobalenrolupdated_help'] = 'Activar la notificacion de actualizacion de matriculacion para todo el sitio';
$string['updatedenrolmessage'] = 'Mensaje personalizado';
$string['updatedenrolmessage_help'] = 'Personalice el mensaje que le llegará a los usuarios al realizar alguna actualizacion en su matriculacion. Este campo acepta los siguientes marcadores que luego seran reemplazados dinámicamente por los valores correspondientes
<pre>
{COURSENAME} = Nombre completo del curso
{USERNAME} = Nombre de usuario
{NOMBRE} = Nombre
{APELLIDO} = Apellido
{URL} = Url del curso
</pre>';
$string['updatedenrolmessagedefault'] = 'Su matriculacion en el curso {$a->fullname} ha sido actualizada ({$a->url})';
$string['succefullsend'] = 'Se notifico al usuario {$a->username} sobre su matriculación en el curso {$a->coursename}'. "\n";
$string['failsend'] = 'ATENCION: No se pudo notificar al usuario {$a->username} sobre su matriculación en el curso {$a->coursename}'."\n";