<?php
/**
 *  Magebase
 *
 *  @category    Magebase
 *  @package     Magebase_Deliverydate
 *  @author      Tom Lin <tom@lero9.co.nz>
 *  @copyright   Copyright (c) 2016 Magebase. (http://magebase.com)
 */
namespace Magebase\Deliverydate\Test\Unit\Helper;
use Magebase\Deliverydate\Helper\Data;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager as ObjectManagerHelper;

class DataTest extends \PHPUnit_Framework_TestCase
{
    
    protected $helper;
    protected $objectManager;
    protected $scopeConfigMock;
    private $errorMsg = 'Weekend is not allowed to be used as delivery date, Please change delivery date';
  
    public function setUp()
    {
         // initial scopeConfigMock which can be used to set backend variable later
        $this->scopeConfigMock = $this->getMock('\Magento\Framework\App\Config\ScopeConfigInterface');
        // initial objectManager which will used to create class which will do the test
        $this->objectManager = new ObjectManagerHelper($this);
        // initial related class which will do the test
        $this->helper = $this->objectManager->getObject('Magebase\Deliverydate\Helper\Data',
                        [
                            'scopeConfig' => $this->scopeConfigMock,
                        ]);
       
    }

    public function testErrorMsg() {
        $this->assertEquals($this->helper->errorMsg(),$this->errorMsg);
    }

    /*
    * Way to test backend configuration
    */
    public function testIsEnabled() {
        $deliveryDateEnable = "delivery_date/general/deliverydate";
        $this->scopeConfigMock->expects($this->once())
            ->method('getValue')
            ->with($deliveryDateEnable, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, null)
            ->willReturn(true);
        $this->assertEquals($this->helper->isEnabled(),true);
    }

    public function testIsAllowWeekend() {
        $isWeekendEnable = "delivery_date/general/allow_weekend";
        $this->scopeConfigMock->expects($this->once())
            ->method('getValue')
            ->with($isWeekendEnable, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, null)
            ->willReturn(true);
        $this->assertEquals($this->helper->isAllowWeekend(),true);
    }
}
