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
 * Helper functions
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   moodle-auth_cfour
 * @copyright 2019-02-22 Mfreak.nl | LdesignMedia.nl - Luuk Verhoeven
 * @author    Luuk Verhoeven
 **/

namespace auth_cfour;
defined('MOODLE_INTERNAL') || die();

 class helper{

     /**
      * Encrypt a string
      *
      * @param string $string
      *
      * @return string
      * @throws \dml_exception
      */
     public static function encrypt(string $string)
     {
         $cipher_alg = MCRYPT_TRIPLEDES;
         $iv = mcrypt_create_iv(mcrypt_get_iv_size($cipher_alg, MCRYPT_MODE_ECB), MCRYPT_RAND);
         $encrypted_string = mcrypt_encrypt($cipher_alg, get_config('auth_cfour' , 'key'), $string, MCRYPT_MODE_ECB, $iv);
         $sso_code = base64_encode($encrypted_string);
         return $sso_code;
     }
 }