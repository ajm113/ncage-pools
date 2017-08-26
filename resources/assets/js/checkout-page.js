/*
    A lot of the HMTL 5 code handles a level of validation.
    Since in this case we just want to create some nifty JS, not much is required just to get the job done.
*/

const SAME_AS_SHIPPING_CHECKBOX_TOGGLE = '#shipping-same-as-billing';

$(function(){
    $(SAME_AS_SHIPPING_CHECKBOX_TOGGLE).on("change", function() {
        if(!this.checked)
            return;

        $("[name='shipping-address-one']").val( $("[name='billing-address-one']").val() );
        $("[name='shipping-address-two']").val( $("[name='billing-address-two']").val() );
        $("[name='shipping-city']").val( $("[name='billing-city']").val() );
        $("[name='shipping-postal-code']").val( $("[name='billing-postal-code']").val() );
        $("[name='shipping-country']").val( $("[name='billing-country']").val() );
    })
});
