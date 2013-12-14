<?php
/**
 * PhoneFormatter class file.
 * @author Igor Maliy <imaliy.filsh@gmail.com>
 * @copyright Copyright &copy; Igor Maliy 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

class PhoneFormatter extends BaseFormatter
{
    /**
     * Formats the given value.
     * @param string $value the value to format.
     * @return string the formatted value.
     */
    public function format($value)
    {
        $cc = $this->locale->getTerritoryID($this->locale->getId());
        $phoneNumber = Yii::app()->phoneNumber;
        $mPhoneNumber = $phoneNumber->parse($value, $cc);

        if (!$phoneNumber->validate($mPhoneNumber)) {
            return '';
        } else {
            return $phoneNumber->toInternational($mPhoneNumber);
        }
    }
}
