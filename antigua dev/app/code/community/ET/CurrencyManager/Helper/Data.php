<?php
/**
 * NOTICE OF LICENSE
 *
 * You may not sell, sub-license, rent or lease
 * any portion of the Software or Documentation to anyone.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade to newer
 * versions in the future.
 *
 * @category   ET
 * @package    ET_CurrencyManager
 * @copyright  Copyright (c) 2012 ET Web Solutions (http://etwebsolutions.com)
 * @contacts   support@etwebsolutions.com
 * @license    http://shop.etwebsolutions.com/etws-license-free-v1/   ETWS Free License (EFL1)
 */

class ET_CurrencyManager_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * ZEND constants avalable in /lib/Zend/Currency.php
     *
     * NOTICE
     *
     * Magento ver 1.3.x - display - USE_SHORTNAME(3) by default
     * Magento ver 1.4.x - display - USE_SYMBOL(2) by default
     *
     * position: 8 - standart; 16 - right; 32 - left
     *
     */

    protected $_options = array();
    protected $_optionsadvanced = array();

    public function getOptions($options = array(), $old = false, $currency = "default") //$old for support Magento 1.3.x
    {
        $storeId = Mage::app()->getStore()->getStoreId();
        if ((!isset($this->_options[$storeId][$currency])) || (!isset($this->_optionsadvanced[$storeId][$currency]))) {
            $this->setOptions($currency);
        }
        $newOptions = $this->_options[$storeId][$currency];
        $newOptionsAdvanced = $this->_optionsadvanced[$storeId][$currency];

        if (!$old) {
            $newOptions = $newOptions + $newOptionsAdvanced;
        }

        // For JavaScript prices: Strange Symbol extracting in function getOutputFormat
        // in file app/code/core/Mage/Directory/Model/Currency.php
        // For Configurable, Bundle and Simple with custom options
        // This causes problem if any currency has by default NO_SYMBOL
        // with this module can't change display value in this case
        if (isset($options["display"])) {
            if ($options["display"] == Zend_Currency::NO_SYMBOL) {
                unset($newOptions["display"]);
            }
        }

        if (count($options) > 0) {
            return $newOptions + $options;
        } else {
            return $newOptions;
        }
    }

    public function clearOptions($options)
    {
        $oldOptions = array("position", "format", "display", "precision", "script", "name", "currency", "symbol");
        foreach (array_keys($options) as $optionKey) {
            if (!in_array($optionKey, $oldOptions)) {
                unset($options[$optionKey]);
            }
        }
        return $options;
    }


    public function isEnabled()
    {
        $config = Mage::getStoreConfig('currencymanager/general');
        $storeId = Mage::app()->getStore()->getStoreId();
        return ((($config['enabled']) && ($storeId > 0)) || (($config['enabledadm']) && ($storeId == 0)));
    }


    public function setOptions($currency = "default")
    {
        $config = Mage::getStoreConfig('currencymanager/general');

        $moduleName = Mage::app()->getRequest()->getModuleName();
        $options = array();
        $optionsAdvanced = array();
        $storeId = Mage::app()->getStore()->getStoreId();
        if ($this->isEnabled()) {
            $notCheckout = !($config['excludecheckout'] & $this->isInOrder());
            $this->_getGeneralOptions($config, $options, $optionsAdvanced, $notCheckout);

            // formatting symbols from admin, preparing to use. Maybe can do better :)
            // если в админке будут внесены
            // несколько значений для одной валюты,
            // то использоваться будет только одна
            if (isset($config['symbolreplace'])) {
                $this->_collectCurrencyOptions($config, $currency, $notCheckout, $options, $optionsAdvanced);
            }
        } // end NOT ENABLED

        $this->_options[$storeId][$currency] = $options;
        $this->_optionsadvanced[$storeId][$currency] = $optionsAdvanced;
        if (!isset($this->_options[$storeId]["default"])) {
            $this->_options[$storeId]["default"] = $options;
            $this->_optionsadvanced[$storeId]["default"] = $optionsAdvanced;
        }

        return $this;
    }

    protected function _getGeneralOptions($config, &$options, &$optionsAdvanced, $notCheckout)
    {
        if ($notCheckout) {
            if (isset($config['precision'])) { // precision must be in range -1 .. 30
                $options['precision'] = min(30, max(-1, (int)$config['precision']));
            }
        }

        if (isset($config['position'])) {
            $options['position'] = (int)$config['position'];
        }
        if (isset($config['display'])) {
            $options['display'] = (int)$config['display'];
        }

        if (isset($config['input_admin'])) {
            if ($config['input_admin'] > 0) {
                $optionsAdvanced['input_admin'] = (int)$config['input_admin'];
            }
        }

        $optionsAdvanced['excludecheckout'] = $config['excludecheckout'];
        $optionsAdvanced['cutzerodecimal'] = $config['cutzerodecimal'];
        $optionsAdvanced['cutzerodecimal_suffix'] = isset($config['cutzerodecimal_suffix']) ?
            $config['cutzerodecimal_suffix'] : "";
    }

    protected function _collectCurrencyOptions($config, $currency, $notCheckout, &$options, &$optionsAdvanced)
    {
        $symbolReplace = $this->_unsetSymbolReplace($config);

        if (count($symbolReplace['currency']) > 0) {
            $tmpOptions = array();
            $tmpOptionsAdvanced = array();

            $tmpOptionsAdvanced['cutzerodecimal'] = $this->_getCurrencyOption(
                $currency, $symbolReplace, 'cutzerodecimal', true
            );

            if (isset($symbolReplace['cutzerodecimal_suffix'])) {
                $tmpOptionsAdvanced["cutzerodecimal_suffix"] = $this->_getCurrencyOption(
                    $currency, $symbolReplace, 'cutzerodecimal_suffix'
                );
            }

            $tmpOptions['position'] = $this->_getCurrencyOption($currency, $symbolReplace, 'position', true);
            $tmpOptions['display'] = $this->_getCurrencyOption($currency, $symbolReplace, 'display', true);
            $tmpOptions['symbol'] = $this->_getCurrencyOption($currency, $symbolReplace, 'symbol');

            if ($notCheckout) {
                $tmpOptionsAdvanced['zerotext'] = $this->_getCurrencyOption(
                    $currency, $symbolReplace, 'zerotext'
                );

                $precision = $this->_getCurrencyOption($currency, $symbolReplace, 'precision', true);
                if ($precision !== false) {
                    $tmpOptions['precision'] = min(30, max(-1, $precision));
                }
            }

            foreach ($tmpOptions as $option => $value) {
                if ($value !== false) {
                    $options[$option] = $value;
                }
            }

            foreach ($tmpOptionsAdvanced as $option => $value) {
                if ($value !== false) {
                    $optionsAdvanced[$option] = $value;
                }
            }

        }
    }

    /**
     * To check where price is used
     * in some cases default values for precision and zerotext should be used
     * for sales/checkout in frontend
     * for admin AND sales_order*
     *
     * @return bool
     */
    public function isInOrder()
    {
        $moduleName = Mage::app()->getRequest()->getModuleName();
        $controllerName = Mage::app()->getRequest()->getControllerName();

        return (($moduleName == 'checkout') || ($moduleName == 'onestepcheckout') || ($moduleName == 'servired') || ($moduleName == 'paypal') || ($moduleName == 'sales') || (($moduleName == 'admin') && (strpos($controllerName, 'sales_order') !== false)
            ));  //añadimos  || ($moduleName == 'onestepcheckout') para incluir el modulo onestepcheckout en la exclusión.
    }

    protected function _unsetSymbolReplace($config)
    {
        if (!is_array($config['symbolreplace'])) {
            $symbolReplace = unserialize($config['symbolreplace']);
            foreach (array_keys($symbolReplace['currency']) as $symbolReplaceKey) {
                if (strlen(trim($symbolReplace['currency'][$symbolReplaceKey])) == 0) {
                    unset($symbolReplace['currency'][$symbolReplaceKey]);
                    unset($symbolReplace['precision'][$symbolReplaceKey]);
                    unset($symbolReplace['cutzerodecimal'][$symbolReplaceKey]);
                    unset($symbolReplace['cutzerodecimal_suffix'][$symbolReplaceKey]);
                    unset($symbolReplace['position'][$symbolReplaceKey]);
                    unset($symbolReplace['display'][$symbolReplaceKey]);
                    unset($symbolReplace['symbol'][$symbolReplaceKey]);
                    unset($symbolReplace['zerotext'][$symbolReplaceKey]);
                }
            }
            return $symbolReplace;
        }
        return false;
    }

    public function resetOptions()
    {
        $this->_options = array();
        $this->_optionsadvanced = array();
    }

    protected function _getCurrencyOption($currency, $symbolReplace, $option, $int = false)
    {
        $configSubData = array_combine($symbolReplace['currency'], $symbolReplace[$option]);
        if (array_key_exists($currency, $configSubData)) {
            $value = $configSubData[$currency];
            if ($value === "") {
                return false;
            }
            return ($int) ? (int)$value : $value;
        }
        return false;
    }

}