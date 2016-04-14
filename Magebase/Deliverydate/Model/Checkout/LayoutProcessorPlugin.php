<?php
/**
 *  Magebase
 *
 *  @category    Magebase
 *  @package     Magebase_Deliverydate
 *  @author      Tom Lin <tom@lero9.co.nz>
 *  @copyright   Copyright (c) 2016 Magebase. (http://magebase.com)
 */
namespace Magebase\Deliverydate\Model\Checkout;
use Magebase\Deliverydate\Helper\Data;
class LayoutProcessorPlugin
{

    protected $helper;

    public function __construct(Data $data) 
    {
        $this->helper = $data;
    }

    /**
     * @param \Magento\Checkout\Block\Checkout\LayoutProcessor $subject
     * @param array $jsLayout
     * @return array
     */
    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
        array  $jsLayout
    ) {
        if($this->helper->isEnabled()) {
            $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
            ['shippingAddress']['children']['shipping-address-fieldset']['children']['delivery_date'] = [
                'component' => 'Magento_Ui/js/form/element/abstract',
                'config' => [
                    'customScope' => 'shippingAddress',
                    'template' => 'ui/form/field',
                    'elementTmpl' => 'ui/form/element/date',
                    'options' => [],
                    'id' => 'delivery-date'
                ],
                'dataScope' => 'shippingAddress.delivery_date',
                'label' => 'Delivery Date',
                'provider' => 'checkoutProvider',
                'visible' => true,
                'validation' => [],
                'sortOrder' => 200,
                'id' => 'delivery-date'
            ];
             $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
            ['shippingAddress']['children']['shipping-address-fieldset']['children']['enable_weekend'] = [
                'component' => 'Magento_Ui/js/form/element/abstract',
                'config' => [
                    'customScope' => 'shippingAddress',
                    'template' => 'ui/form/field',
                    'elementTmpl' => 'ui/form/element/input',
                    'options' => [],
                    'id' => 'enable_weekend'
                ],
                'dataScope' => 'shippingAddress.enable_weekend',
                'label' => 'Enable Weekend',
                'provider' => 'checkoutProvider',
                'visible' => false,
                'validation' => [],
                'value' => $this->helper->isAllowWeekend(),
                'sortOrder' => 250,
                'id' => 'enable_weekend'
            ];
        }
        return $jsLayout;
    }
}