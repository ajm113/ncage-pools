/*
 *   Handles cart functionality such as updating quantity, removing items, and etc.
 *
 */

const REMOVE_FROM_CART = '.cart-item-delete';
const REMOVE_FROM_CART_MODAL = '#removeFromCartModal';
const CURRENT_CART_COUNT = 'nav .current-cart-count';
const CART_ITEM_UPDATE = '.cart-item-update';

class CartPage {

    constructor() {
        this.attachEvents();
    }

    attachEvents() {
        $(REMOVE_FROM_CART).on('click', this.removeFromCartEvent);
        $(CART_ITEM_UPDATE).on('keyup changed click', this.cartItemUpdate);
    }

    removeFromCartEvent( event ) {
        event.preventDefault();  // Helps avoid the form actually running when submit. (usually for older browsers)
        event.stopPropagation();

        $(REMOVE_FROM_CART_MODAL).modal('show'); // Display model to user showing them we are adding item to cart!

        const productId = $( this ).data('id');
        const token = $( this ).data('token');

        var modelYesResponse = function() {
            $.ajax({
                url: '/cart/' + productId,
                data: {'_token': token},
                type: 'delete',
            })
            .done(function( response ) {
                if(response.success) {
                    window.location.reload();
                    return;
                }

            })
            .fail(function( response ) {
                // Display error in console, and to the user if something unexpected happened!
                console.error(response);
                alert("Woops, seems like something unexpected happened removing the item from the cart! " +
                    "Please refresh the browser and try again! Sorry for the inconvenience. " +
                    "If it happens again, please contact Cage Support!");
            })
            .always(function(){
                $(REMOVE_FROM_CART_MODAL).modal('hide');
            });
        };

        $(REMOVE_FROM_CART_MODAL + ' .btn.yes').one('click', modelYesResponse)

        return false;
    }

    cartItemUpdate( event ) {

        clearTimeout(this.cartItemUpdateTimeout);

        const productId = $( this ).data('id');
        const token = $( this ).data('token');
        const qty = $( this ).val();

        let sendQtyUpdate = function() {
            $.ajax({
                url: '/cart/' + productId + '/' + qty,
                data: {'_token': token},
                type: 'put',
            })
            .done(function( response ) {
                if(response.success) {

                    // Calculate new cart value to display on page.
                    let newCartCountValue = parseInt($(CURRENT_CART_COUNT).text(), 10) + response.quantity;

                    // Update UI
                    $(CURRENT_CART_COUNT).text(newCartCountValue);

                    // Fetch the new totals.
                    $("tfoot").load("/cart tfoot > *");
                    return;
                }

            })
            .fail(function( response ) {
                // Display error in console, and to the user if something unexpected happened!
                console.error(response);
                alert("Woops, seems like something unexpected happened updating the cart!" +
                    "Please refresh the browser and try again! Sorry for the inconvenience. " +
                    "If it happens again, please contact Cage Support!");
            });
        };

        this.sendQtyUpdate = setTimeout(sendQtyUpdate, 300);

        return false;
    }
}

$(function() {
    new CartPage();
});
