/*
    A lot of the HMTL 5 code handles a level of validation.
    Since in this case we just want to create some nifty JS, not much is required just to get the job done.
*/

const SAME_AS_SHIPPING_CHECKBOX_TOGGLE = '#shipping-same-as-billing';
const PAYMENT_FORM = 'form.payment-form';
const PAYMENT_ERROR_MODAL = '#paymentErrorModel';

var _self = null;

class Checkout {

    constructor() {
        _self = this;
        this.attachEvents();
    }

    attachEvents() {
        $(SAME_AS_SHIPPING_CHECKBOX_TOGGLE).on("change", this.billingAndShippingSameToggleEvent);
        $(PAYMENT_FORM).on("submit", this.submitPaymentFormSubmit);
    }

    billingAndShippingSameToggleEvent() {
        if(!this.checked)
            return;

        $("[name='shipping-address-one']").val( $("[name='billing-address-one']").val() );
        $("[name='shipping-address-two']").val( $("[name='billing-address-two']").val() );
        $("[name='shipping-city']").val( $("[name='billing-city']").val() );
        $("[name='shipping-postal-code']").val( $("[name='billing-postal-code']").val() );
        $("[name='shipping-country']").val( $("[name='billing-country']").val() );
    }

    submitPaymentFormSubmit() {
        let isCreditCardNumberValid = $.payment.validateCardNumber($('[name=card-number]').val());

        if(!isCreditCardNumberValid) {
            $('[name=card-number]')[0].focus();
            _self.displayPaymentErrorModal('Credit Card Number is invalid!');
            return false;
        }

        if($('[name=name-on-card]').val().length < 5) {
            $('[name=name-on-card]')[0].focus();
            _self.displayPaymentErrorModal('Name on Card is too short!');
            return false;
        }

        if($('[name=cvv]').val().length < 3) {
            $('[name=cvv]')[0].focus();
            _self.displayPaymentErrorModal('CVV is too short!');
            return false;
        }

        let validateExpirationDate = function( date ) {
            if(date.length != 4) return false;
            if(!/^\d+$/.test(date)) return false;   // Make sure string only contains digits.

            // Start validating the numbers.
            let month = parseInt(date[0] + date[1]);
            let year = parseInt(date[2] + date[3]);

            if(month > 12 || month < 1) return false; // Make sure the month is valid.

            let currentYearString = new Date().getFullYear()+'';
            currentYearShort = parseInt(currentYearString.match(/\d{2}$/));

            if(year < currentYearShort) return false;

            return true;
        };

        if(!validateExpirationDate($('[name=expiration-date]').val())) {
            $('[name=expiration-date]')[0].focus();
            _self.displayPaymentErrorModal('Expiration Date is invalid.');
            return false;
        }

        return true;
    }

    displayPaymentErrorModal(message) {
        $(PAYMENT_ERROR_MODAL).modal('show');

        const MODEL_BODY = PAYMENT_ERROR_MODAL + ' .modal-body';

        $(MODEL_BODY).empty().append([
            $('<h4>', {text:'Issue Processing Payment', class: 'text-danger'}),
            $('<p>', {text: message})
        ]);
    }
}

$(function() {
    new Checkout();
});
