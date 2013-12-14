<?php
/**
 * Formatter class file.
 * @author Christoffer Niska <christoffer.niska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package crisu83.yii-formatter.components
 */

class Formatter extends CFormatter
{
    /**
     * @var array an array of formatter default configurations (name=>config).
     */
    public $formatters = array();

    /**
     * @var CLocale the locale currently used for formatting values
     */
    private $_locale;
    
    /**
     * Calls the run formatter method when its shortcut is invoked.
     * @param string $name the method name.
     * @param array $parameters method parameters.
     * @return mixed the method return value.
     */
    public function __call($name, $parameters)
    {
        $args = $parameters;
        array_unshift($args, $name);
        
        if ($this->isFormatter($name)) {
            return call_user_func_array(array($this, 'runFormatter'), $args);
        } else if (is_callable($name)) {
            return call_user_func_array(array($this, 'formatInline'), $args);
        } else {
            return parent::__call($name, $parameters);
        }
    }

    /**
     * Set the locale to use for formatting values.
     * @param CLocale|string $locale an instance of CLocale or a locale ID
     */
    public function setLocale($locale)
    {
        if(is_string($locale)) {
            $locale = CLocale::getInstance($locale);
        }
        
        $this->sizeFormat['decimalSeparator'] = $locale->getNumberSymbol('decimal');
        $this->_locale=$locale;
    }

    /**
     * @return CLocale $locale the locale currently used for formatting values
     */
    public function getLocale()
    {
        if($this->_locale === null) {
            $this->setLocale(Yii::app()->locale);
        }
        
        return $this->_locale;
    }
    
    /**
     * Runs the formatter with the given name.
     * @param string $format the name of the formatter.
     * @param string $value the value to be formatted.
     * @param array $params initial values to be applied to the formatter properties.
     * @return string the formatted value.
     */
    public function runFormatter($format, $value, $params = array())
    {
        if (is_string($format) && isset($this->formatters[$format])) {
            $params = CMap::mergeArray($this->formatters[$format], $params);
        }
        
        return $this->createFormatter($format, $params)->format($value);
    }

    /**
     * Formats the given value using an inline formatter.
     * @param array $callback the callback.
     * @param string $value the value to be formatted.
     * @param array $params additional parameters that are passed to the formatting method..
     * @return string the formatted value.
     */
    public function formatInline($callback, $value, $params = array())
    {
        return $this->runFormatter($callback, $value, $params);
    }

    /**
     * Returns whether the given name is a formatter.
     * @param string $name the name of the formatter.
     * @return boolean the result.
     */
    protected function isFormatter($name)
    {
        return array_key_exists($name, BaseFormatter::$builtInFormatters) || Yii::getPathOfAlias($name) !== false;
    }

    /**
     * Creates a new formatter instance.
     * @param string $format the name of the formatter.
     * @param array $params initial values to be applied to the formatter properties.
     * @return BaseFormatter the formatter.
     */
    protected function createFormatter($format, $params)
    {
        if(!isset($params['locale'])) {
            $params['locale'] = $this->getLocale();
        }
        
        return BaseFormatter::createFormatter($format, $params);
    }
}