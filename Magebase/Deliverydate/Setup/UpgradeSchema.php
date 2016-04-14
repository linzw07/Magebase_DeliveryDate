<?php
/**
 *  Magebase
 *
 *  @category    Magebase
 *  @package     Magebase_Deliverydate
 *  @author      Tom Lin <tom@lero9.co.nz>
 *  @copyright   Copyright (c) 2016 Magebase. (http://magebase.com)
 */
namespace Magebase\Deliverydate\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Upgrade the Catalog module DB scheme
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.0.1') < 0) {
            $this->addDeliveryDateToInvoice($setup);
        } else if (version_compare($context->getVersion(), '1.0.4') < 0) {
             $this->addDeliveryDateToShip($setup);
        } 

        $setup->endSetup();
    }

  
/**
     * @param SchemaSetupInterface $setup
     * @return void
     */
    private function addDeliveryDateToShip(SchemaSetupInterface $setup)
    {

        /**
         * Add delivery_date into shipment table
         */
         $setup->getConnection()->addColumn(
            $setup->getTable('sales_shipment'),
            'delivery_date',
            [
                'type' => 'datetime',
                'nullable' => false,
                'comment' => 'Delivery Date',
            ]
        );

           /**
         * Add delivery_date into shipment grid table
         */
         $setup->getConnection()->addColumn(
            $setup->getTable('sales_shipment_grid'),
            'delivery_date',
            [
                'type' => 'datetime',
                'nullable' => false,
                'comment' => 'Delivery Date',
            ]
        );

          /**
         * Add delivery_date into creditmemo table
         */
         $setup->getConnection()->addColumn(
            $setup->getTable('sales_creditmemo'),
            'delivery_date',
            [
                'type' => 'datetime',
                'nullable' => false,
                'comment' => 'Delivery Date',
            ]
        );

           /**
         * Add delivery_date into creditmemo grid table
         */
         $setup->getConnection()->addColumn(
            $setup->getTable('sales_creditmemo_grid'),
            'delivery_date',
            [
                'type' => 'datetime',
                'nullable' => false,
                'comment' => 'Delivery Date',
            ]
        );
    }
   
    /**
     * @param SchemaSetupInterface $setup
     * @return void
     */
    private function addDeliveryDateToInvoice(SchemaSetupInterface $setup)
    {

        /**
         * Add delivery_date into invoice table
         */
         $setup->getConnection()->addColumn(
            $setup->getTable('sales_invoice'),
            'delivery_date',
            [
                'type' => 'datetime',
                'nullable' => false,
                'comment' => 'Delivery Date',
            ]
        );

           /**
         * Add delivery_date into invoice table
         */
         $setup->getConnection()->addColumn(
            $setup->getTable('sales_invoice_grid'),
            'delivery_date',
            [
                'type' => 'datetime',
                'nullable' => false,
                'comment' => 'Delivery Date',
            ]
        );
    }
}
