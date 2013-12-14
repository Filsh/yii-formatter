<?php
/**
 * CurrencyFormatter class file.
 * @author Christoffer Niska <christoffer.niska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package crisu83.yii-formatter.formatters
 */

class CurrencyFormatter extends BaseFormatter
{
    /**
     * @var string 3-letter ISO 4217 code.
     * For example, the code "USD" represents the US Dollar and "EUR" represents the Euro currency.
     */
    public $currency;
    /**
     * @var string the formatting pattern.
     * @see CNumberFormatter::format
     */
    public $pattern;

    /**
     * Formats the given value.
     * @param string $value the value to format.
     * @return string the formatted value.
     */
    public function format($value)
    {
        return !isset($this->pattern)
            ? Yii::app()->numberFormatter->formatCurrency($value, $this->currency)
            : Yii::app()->numberFormatter->format($this->pattern, $value, $this->currency);
    }
}