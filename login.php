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
 * Login page needs to be called directly.
 * Users needs to have auth -> cfour
 *
 * Sample request:
 * http://moodle362.web04.webv.nl/auth/cfour/login.php?sso_username=user1&sso_code=Ly5Y%2FiH9cNI%3D&wantsurl=%2Fcourse%2Fview.php%3Fid%3D2
 *
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package    auth_cfour
 * @copyright  2019-02-22  Mfreak.nl | LdesignMedia.nl - Luuk Verhoeven
 * @author     Luuk Verhoeven
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once(__DIR__ . "../../../config.php");
defined('MOODLE_INTERNAL') || die;

// Params.
$sso_username = required_param('sso_username', PARAM_TEXT);
$sso_code = required_param('sso_code', PARAM_RAW);
$wantsurl = optional_param('wantsurl', '', PARAM_RAW);

if (!is_enabled_auth('cfour')) {
    print_error('disabled', 'auth_cfour');
}

// Sets the wantsurl.
$wantsurl = (new moodle_url(urldecode($wantsurl)))->out(false);

// Try login.
$user = authenticate_user_login($sso_username, urldecode($sso_code), false, $reason);
if ($user) {
    complete_user_login($user);
    redirect($wantsurl);
}

// Still here.
print_error('error:credentails_incorrect', 'auth_cfour', '', (object)['reason' => $reason]);