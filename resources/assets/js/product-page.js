/*
 *   Product Page JavaScript. Updates our cart, display modal notification.
 *   Nothing too special about this.
 */

const ADD_TO_CART_FORM = 'form.add-to-cart';
const ADD_TO_CART_MODAL = '#addingToCartModal';
const CURRENT_CART_COUNT = 'nav .current-cart-count';

class ProductPage {

    constructor() {
        this.attachEvents();
    }

    attachEvents() {
        $(ADD_TO_CART_FORM).on('submit', this.addToCartEvent);
    }

    addToCartEvent( event ) {
        event.preventDefault();  // Helps avoid the form actually running when submit. (usually for older browsers)

        $(ADD_TO_CART_MODAL).modal('show'); // Display model to user showing them we are adding item to cart!

        const MODEL_BODY = ADD_TO_CART_MODAL + ' .modal-body';

        // Clear the modal text and create new just in case if the user clicked the button more then once.
        $(MODEL_BODY).empty().append([
            $('<h4>', {text:'Adding item to cart, one moment...'}),
            $('<i>', {class: 'fa fa-spinner fa-pulse fa-3x fa-fw text-primary', 'aria-hidden': true})
        ]);

        let form = $( this );
        let postData = form.serialize();

        $.post(form.attr('action'), postData, function( response ) {

            if(response.success) {

                // Display message to user everything went well!
                $(MODEL_BODY).empty().append([
                    $('<h4>', {text:'Successfully added to cart!', class: 'text-success'}),
                    $('<i>', {class: 'fa fa-check-circle-o fa-3x fa-fw text-success', 'aria-hidden': true})
                ]);

                // Calculate new cart value to display on page.
                let newCartCountValue = parseInt($(CURRENT_CART_COUNT).text(), 10) + response.quantity;

                // Update UI
                $(CURRENT_CART_COUNT).text(newCartCountValue);

                return;
            }

            $(MODEL_BODY).empty().append([
                $('<h4>', {text:'Failed adding to cart!', class: 'text-danger'}),
                $('<p>', {text:'Please make sure the item you are attempting to add is still valid! Please refresh the page and try again.', class: 'text-danger'}),
                $('<i>', {class: 'fa fa-x fa-3x fa-fw text-danger', 'aria-hidden': true})
            ]);

        }).fail(function( response ) {

            // Display error in console, and to the user if something unexpected happened!
            console.error(response);
            alert("Woops, seems like something unexpected happened adding item to cart! " +
                "Please refresh the browser and try again! Sorry for the inconvenience. " +
                "If it happens again, please contact Cage Support!");
        });

        return false;           // Additional form of avoiding the form from actually submitting.
    }
}

$(function() {
    new ProductPage();
});
