/*
 *   Handles our search page. Pretty simple JavaScript in place.
 */

const SEARCH_FORM = 'form.search-form';

class Search {

    constructor() {
        this.attachEvents();
    }

    attachEvents() {
        $(SEARCH_FORM).on('submit', this.searchFormEvent);
    }

    searchFormEvent( event ) {

        let searchQuery = $(SEARCH_FORM + ' [type=search]').val();

        document.location.href = '/search/' + searchQuery;

        return false;
    }
}

$(function() {
    new Search();
});
