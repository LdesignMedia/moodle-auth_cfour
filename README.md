## a Moodle link based authentication plugin

![MFreak.nl](https://MFreak.nl/logo_small.png)

* Author: Luuk Verhoeven, [MFreak.nl](https://MFreak.nl/)
* Min. required: Moodle 3.6.x
* Supports PHP: 7.0 | 7.1 | 7.2 

![Moodle36](https://img.shields.io/badge/moodle-3.6-brightgreen.svg)
![PHP7.0](https://img.shields.io/badge/PHP-7.0-brightgreen.svg)

## List of features
- Shared key encryption.
- Authenticate a user with a direct link.
- Redirect after login to a redirect url.
- Allow locking userfields. 

## Installation
1.  Copy this plugin to the `auth\cfour` folder on the server
2.  Login as administrator
3.  Go to Site Administrator > Notification
4.  Install the plugin
5.  Add the correct **AUTHENTICATION** key to the settings `/admin/settings.php?section=authsettingcfour`.
6.  Enable the authentication module `/admin/category.php?category=authsettings`.

## Usage
1. A user should already be created in Moodle. You can add a new user with the API, make sure **auth** property must have the value `cfour` for security reasons. 
2. Build a link on a external system, see the example below.

```php
<?php
#External system, samplecode
define('SHARED_AUTHENTICION_KEY' , 'LONG_KEY_HERE');

/**
* Encrypt a string
*
* @param string $string
*
* @return string
*/
function encrypt(string $string)
{
 $cipher_alg = MCRYPT_TRIPLEDES;
 $iv = mcrypt_create_iv(mcrypt_get_iv_size($cipher_alg, MCRYPT_MODE_ECB), MCRYPT_RAND);
 $encrypted_string = mcrypt_encrypt($cipher_alg, SHARED_AUTHENTICION_KEY, $string, MCRYPT_MODE_ECB, $iv);
 $sso_code = base64_encode($encrypted_string);
 return $sso_code;
}

// Building the link.
$domain = 'https://moodle.test.domain.com/';
$plugin = 'auth/cfour/login.php';

// The user that exists in Moodle and has `cfour` auth property in there account.
$moodleusername = 'student1';
$moodleuserid = 2;

$params = [
    'sso_username' => $moodleusername,
    'sso_code' => encrypt($moodleuserid . '+' . $moodleusername),
    'wantsurl' => '/course/view.php?id=2'
];

// Make sure all params get urlencoded!
$url = $domain . $plugin . http_build_query($params);

// https://moodle.test.domain.com/auth/cfour/login.phpsso_username=student1&sso_code=&wantsurl=%2Fcourse%2Fview.php%3Fid%3D2
header('Location: ' . $url);
die;

```
3. Use the link where you want. Keep in mind there is no expiry date implemented.
 

## Security

If you discover any security related issues, please email [luuk@MFreak.nl](mailto:luuk@MFreak.nl) instead of using the issue tracker.

## License

The GNU GENERAL PUBLIC LICENSE. Please see [License File](LICENSE) for more information.

## Changelog

See version control for the complete history. Major changes in this version will be listed below.
