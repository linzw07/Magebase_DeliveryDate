<?php
/**
 *  Magebase
 *
 *  @category    Magebase
 *  @package     Magebase_Deliverydate
 *  @author      Tom Lin <tom@lero9.co.nz>
 *  @copyright   Copyright (c) 2016 Magebase. (http://magebase.com)
 */
namespace Magebase\Deliverydate\Model\Service\InvoiceService;

/****save delivery date value into invoice object****/
class Plugin
{
    protected $orderConverter;
    public function __construct(
          \Magento\Sales\Model\Convert\Order $orderConverter
    ) {
        $this->orderConverter = $orderConverter;
    }

    public function beforePrepareInvoice(\Magento\Sales\Model\Service\InvoiceService $subject,\Magento\Sales\Model\Order $order, array $qtys = [])
     {  
        $invoice = $this->orderConverter->toInvoice($order);
        $invoice->setDeliveryDate($order->getDeliveryDate());
    }
}