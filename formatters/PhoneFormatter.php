<?php
/**
 * PhoneFormatter class file.
 * @author Igor Maliy <imaliy.filsh@gmail.com>
 * @copyright Copyright &copy; Igor Maliy 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

require_once dirname(__FILE__) . '/libphonenumber/libphonenumber.php';

use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;

class PhoneFormatter extends BaseFormatter
{
    /**
     * Formats the given value.
     * @param string $value the value to format.
     * @return string the formatted value.
     */
    public function format($value)
    {
        $util = PhoneNumberUtil::getInstance();
        $mPhoneNumber = $util->parse($value, 'UA');

        if (!$util->isValidNumber($mPhoneNumber)) {
            return '';
        } else {
            return $util->format($mPhoneNumber, PhoneNumberFormat::RFC3966);
        }
    }
}
