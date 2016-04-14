<?php
/**
 *  Lero9
 *
 *  @category    Magebase
 *  @package     Magebase_Deliverydate
 *  @author      Tom Lin <tom@lero9.co.nz>
 *  @copyright   Copyright (c) 2016 Magebase. (http://magebase.com)
 */
namespace Magebase\Deliverydate\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_DELIVERYDATE_ENABLE = 'delivery_date/general/deliverydate';
    const XML_PATH_DELIVERYDATE_WEEKEND_ENABLE = 'delivery_date/general/allow_weekend';
    const XML_PATH_DELIVERYDATE_FORMAT_DATE = 'delivery_date/general/format_date';
    
    protected $_date;

    /**
     * Check if the extension is enabled
     *
     * @return boolean
     */
    public function isEnabled() {
        return $this->scopeConfig->getValue(
            self::XML_PATH_DELIVERYDATE_ENABLE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    public function isAllowWeekend() {
         return $this->scopeConfig->getValue(
            self::XML_PATH_DELIVERYDATE_WEEKEND_ENABLE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    public function errorMsg() {
        $errorMsg = 'Weekend is not allowed to be used as delivery date, Please change delivery date';
        return $errorMsg;
     }

}
