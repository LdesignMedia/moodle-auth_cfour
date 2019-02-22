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
 * Base authentication class
 *
 * @package    auth_cfour
 * @copyright  2019-02-22  Mfreak.nl | LdesignMedia.nl - Luuk Verhoeven
 * @author     Luuk Verhoeven
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/authlib.php');

/**
 * Plugin for no authentication.
 */
class auth_plugin_cfour extends auth_plugin_base {

    /**
     * Constructor.
     *
     * @throws dml_exception
     */
    public function __construct() {
        $this->authtype = 'cfour';
        $this->config = get_config('auth_cfour');
    }

    /**
     * Old syntax of class constructor. Deprecated in PHP7.
     *
     * @deprecated since Moodle 3.1
     * @throws dml_exception
     */
    public function auth_plugin_none() {
        debugging('Use of class name as constructor is deprecated', DEBUG_DEVELOPER);
        self::__construct();
    }

    /**
     * Returns true if the username and password work or don't exist and false
     * if the user exists and the password is wrong.
     *
     * @param string $username The username
     * @param string $password The password
     *
     * @return bool Authentication success or failure.
     * @throws dml_exception
     * @throws coding_exception
     */
    function user_login($username, $password) {

        global $DB;
        $sso_code = required_param('sso_code', PARAM_RAW);

        if ($user = $DB->get_record('user', ['username' => $username])) {

            // Validate password.
            if($sso_code == \auth_cfour\helper::encrypt($user->id . '+' . $user->username)){
                return true;
            }
        }

        return false;
    }

    /**
     * Updates the user's password.
     *
     * called when the user password is updated.
     *
     * @param  object $user        User table object
     * @param  string $newpassword Plaintext password
     *
     * @return boolean result
     *
     */
    function user_update_password($user, $newpassword) {
        return false;
    }

    /**
     * Indicates if password hashes should be stored in local moodle database.
     * @return bool true means md5 password hash stored in user table, false means flag 'not_cached' stored there instead
     */
    function prevent_local_passwords() {
        return true;
    }

    /**
     * Returns true if this authentication plugin is 'internal'.
     *
     * @return bool
     */
    function is_internal() {
        return true;
    }

    /**
     * Returns true if this authentication plugin can change the user's
     * password.
     *
     * @return bool
     */
    function can_change_password() {
        return false;
    }

    /**
     * Returns the URL for changing the user's pw, or empty if the default can
     * be used.
     *
     * @return moodle_url
     */
    function change_password_url() {
        return null;
    }

    /**
     * Returns true if plugin allows resetting of internal password.
     *
     * @return bool
     */
    function can_reset_password() {
        return false;
    }

    /**
     * Returns true if plugin can be manually set.
     *
     * @return bool
     */
    function can_be_manually_set() {
        return true;
    }

}


