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
 * Admin settings and defaults.
 *
 * @package    auth_cfour
 * @copyright  2019-02-22  Mfreak.nl | LdesignMedia.nl - Luuk Verhoeven
 * @author     Luuk Verhoeven
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {

    // Introductory explanation.
    $settings->add(new admin_setting_heading('auth_cfour/pluginname', '',
        new lang_string('auth_cfourdescription', 'auth_cfour')));

    $settings->add(new admin_setting_configtext('auth_cfour/key' , get_string('setting:key' , 'auth_cfour') , '' ,'ENCRYPTION_KEY'));
    // Display locking / mapping of profile fields.
    $authplugin = get_auth_plugin('cfour');
    display_auth_lock_options($settings, $authplugin->authtype, $authplugin->userfields,
        get_string('auth_fieldlocks_help', 'auth'), false, false);
}
