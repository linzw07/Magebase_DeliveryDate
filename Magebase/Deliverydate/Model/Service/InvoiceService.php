<?php

namespace Magebase\Deliverydate\Model\Service;

/**
 * Class InvoiceService
 */
class InvoiceService extends \Magento\Sales\Model\Service\InvoiceService
{
    public function prepareInvoice(\Magento\Sales\Model\Order $order, array $qtys = [])
    {
        $invoice = $this->orderConverter->toInvoice($order);
        $totalQty = 0;
        foreach ($order->getAllItems() as $orderItem) {
            if (!$this->_canInvoiceItem($orderItem)) {
                continue;
            }
            $item = $this->orderConverter->itemToInvoiceItem($orderItem);
            if ($orderItem->isDummy()) {
                $qty = $orderItem->getQtyOrdered() ? $orderItem->getQtyOrdered() : 1;
            } elseif (isset($qtys[$orderItem->getId()])) {
                $qty = (double) $qtys[$orderItem->getId()];
            } else {
                $qty = $orderItem->getQtyToInvoice();
            }
            $totalQty += $qty;
            $this->setInvoiceItemQuantity($item, $qty);
            $invoice->addItem($item);
        }
        $invoice->setDeliveryDate($order->getDeliveryDate());
        $invoice->setTotalQty($totalQty);
        $invoice->collectTotals();
        $order->getInvoiceCollection()->addItem($invoice);
        return $invoice;
    }
}
