define(
    [
        'ko',
        'Magento_Checkout/js/model/quote',
        'Magento_Checkout/js/model/resource-url-manager',
        'mage/storage',
        'Magento_Checkout/js/model/payment-service',
        'Magento_Checkout/js/model/payment/method-converter',
        'Magento_Checkout/js/model/error-processor',
        'Magento_Ui/js/model/messageList'
    ],
    function(ko, quote, resourceUrlManager, storage, paymentService, methodConverter, errorProcessor) {
        'use strict';
        return {
            saveShippingInformation: function() {
                var isWeekend = 0;
                if (jQuery('[name="enable_weekend"]').val() == 0 && jQuery('[name="delivery_date"]').val()) {
                    isWeekend = new Date(jQuery('[name="delivery_date"]').val()).getDay() % 6 == 0;
                }
                if(new Date() > new Date(jQuery('[name="delivery_date"]').val())) {
                    alert('Input date must be a future date, Please change delivery date');
                }
                if (isWeekend) {
                    var errorMsg = 'It can not set weekend as delivery date, Please change delivery date';
                    alert(errorMsg);
                } else {
                    var payload = {
                        addressInformation: {
                            shipping_address: quote.shippingAddress(),
                            shipping_method_code: quote.shippingMethod().method_code,
                            shipping_carrier_code: quote.shippingMethod().carrier_code,
                            extension_attributes: {
                                delivery_date: jQuery('[name="delivery_date"]').val()
                            }
                        }
                    };
                    return storage.post(
                        resourceUrlManager.getUrlForSetShippingInformation(quote),
                        JSON.stringify(payload)
                    ).done(
                        function(response) {
                            quote.setTotals(response.totals);
                            paymentService.setPaymentMethods(methodConverter(response.payment_methods));
                        }
                    ).fail(
                        function(response) {
                            errorProcessor.process(response);
                        }
                    );
                }
            }
        };
    }
);
