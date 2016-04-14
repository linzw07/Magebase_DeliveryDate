<?php
/**
 *  Magebase
 *
 *  @category    Magebase
 *  @package     Magebase_Deliverydate
 *  @author      Tom Lin <tom@lero9.co.nz>
 *  @copyright   Copyright (c) 2016 Magebase. (http://magebase.com)
 */
namespace Magebase\Deliverydate\Model\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;


class AddHtmlToOrderShippingViewObserver implements ObserverInterface
{

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * @param \Magento\Framework\ObjectManagerInterface $objectmanager
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectmanager)
    {
        $this->_objectManager = $objectmanager;
    }

    /***show delivery date into order, invoice, shipment, creditmemo detail page***/
    public function execute(EventObserver $observer)
    {                  
        if($observer->getElementName() == 'order_shipping_view')
        {
            $orderShippingViewBlock = $observer->getLayout()->getBlock($observer->getElementName());
            $order = $orderShippingViewBlock->getOrder();
            $localeDate = $this->_objectManager->create('\Magento\Framework\Stdlib\DateTime\TimezoneInterface');
            if($order->getDeliveryDate() == '0000-00-00 00:00:00'){
                 $formattedDate = __("Not Sepcified");
            } else {
                $formattedDate = $localeDate->formatDate(
                    $localeDate->scopeDate(
                        $order->getStore(),
                        $order->getDeliveryDate(),
                        true
                    ),
                    \IntlDateFormatter::MEDIUM,
                    false
                );
            }
        
            $deliveryDateBlock = $this->_objectManager->create('Magento\Framework\View\Element\Template');
            $deliveryDateBlock->setDeliveryDate($formattedDate); 

            $deliveryDateBlock->setTemplate('Magebase_Deliverydate::order_info_shipping_info.phtml');
            $html = $observer->getTransport()->getOutput() . $deliveryDateBlock->toHtml();
            $observer->getTransport()->setOutput($html);
        } else  if($observer->getElementName() == 'sales_invoice_view' || $observer->getElementName() == 'sales_invoice_create') {

            $invoiceViewBlock = $observer->getLayout()->getBlock($observer->getElementName());
            $invoice = $invoiceViewBlock->getInvoice();
            $localeDate = $this->_objectManager->create('\Magento\Framework\Stdlib\DateTime\TimezoneInterface');
            if($invoice->getDeliveryDate() == '0000-00-00 00:00:00'){
                 $formattedDate = __("Not Sepcified");
            } else {
                $formattedDate = $localeDate->formatDate(
                    $localeDate->scopeDate(
                        $invoice->getStore(),
                        $invoice->getDeliveryDate(),
                        true
                    ),
                    \IntlDateFormatter::MEDIUM,
                    false
                );
            }
            $deliveryDateBlock = $this->_objectManager->create('Magento\Framework\View\Element\Template');
            $deliveryDateBlock->setDeliveryDate($formattedDate);
            $deliveryDateBlock->setTemplate('Magebase_Deliverydate::order_invoice_info.phtml');
            $html = $observer->getTransport()->getOutput() . $deliveryDateBlock->toHtml();
            $observer->getTransport()->setOutput($html);
        } else  if($observer->getElementName() == 'sales_shipment_view' || $observer->getElementName() == 'sales_shipment_create') {

            $shippingViewBlock = $observer->getLayout()->getBlock($observer->getElementName());
            $shipping = $shippingViewBlock->getShipment();
            $localeDate = $this->_objectManager->create('\Magento\Framework\Stdlib\DateTime\TimezoneInterface');
             if($shipping->getDeliveryDate() == '0000-00-00 00:00:00'){
                 $formattedDate = __("Not Sepcified");
            } else {
                $formattedDate = $localeDate->formatDate(
                    $localeDate->scopeDate(
                        $shipping->getStore(),
                        $shipping->getDeliveryDate(),
                        true
                    ),
                    \IntlDateFormatter::MEDIUM,
                    false
                );
            }

            $deliveryDateBlock = $this->_objectManager->create('Magento\Framework\View\Element\Template');
            $deliveryDateBlock->setDeliveryDate($formattedDate);
            $deliveryDateBlock->setTemplate('Magebase_Deliverydate::order_shipping_info.phtml');
            $html = $observer->getTransport()->getOutput() . $deliveryDateBlock->toHtml();
            $observer->getTransport()->setOutput($html);
        } 
        else  if($observer->getElementName() == 'sales_creditmemo_view' || $observer->getElementName() == 'sales_creditmemo_create') {

            $creditmemoViewBlock = $observer->getLayout()->getBlock($observer->getElementName());
            $creditmemo = $creditmemoViewBlock->getcreditMemo();
            $localeDate = $this->_objectManager->create('\Magento\Framework\Stdlib\DateTime\TimezoneInterface');
            if($creditmemo->getDeliveryDate() == '0000-00-00 00:00:00'){
                $formattedDate = __("Not Sepcified");
            } else {
                $formattedDate = $localeDate->formatDate(
                    $localeDate->scopeDate(
                        $creditmemo->getStore(),
                        $creditmemo->getDeliveryDate(),
                        true
                    ),
                    \IntlDateFormatter::MEDIUM,
                    false
                );
            }

            $deliveryDateBlock = $this->_objectManager->create('Magento\Framework\View\Element\Template');
            $deliveryDateBlock->setDeliveryDate($formattedDate);
            $deliveryDateBlock->setTemplate('Magebase_Deliverydate::order_creditmemo_info.phtml');
            $html = $observer->getTransport()->getOutput() . $deliveryDateBlock->toHtml();
            $observer->getTransport()->setOutput($html);
        }
    }
}