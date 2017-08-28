/*
 * N. Cage Analytics Tracker.
 * Reason why we abbreviate the file name is to avoid ad-blockers from seeing the term 'tracker'.
 */

 const DEBOUNCE_PAGE_VIEW_DELAY = 5000; // 5 Seconds.
 const DEBUG_MODE = true;
 const GUID_STORAGE_NAME = 'nca_guid';
 const GUID_STORAGE_DAYS = 365;

 var self = null;

class AnalyticsTracker {

    constructor() {
        this.enableLog = DEBUG_MODE;

        this.csrf = this.getCsrfToken();

        if(this.csrf === null) {
            this.log('Cannot track user! Failed getting csrf!', 'constructor');
            return;
        }

        self = this;

        // First find out if we can even track the user!
        // https://en.wikipedia.org/wiki/Do_Not_Track
        if(this.isDoNotTrackEnabled()) {
            this.log('Cannot track user! Quiting!', 'constructor');
            return;
        }

        // Make sure the Date supports 'now' function to timestamp events.
        this.setupDate();

        // Fetch and or calculate the guid.

        this.guid = this.getSavedGuid(); // Is it saved somewhere in the user's browser?

        if(!this.guid) {                        // If the guid is not found. We generate a new one for tracking purposes.
            this.guid = this.generateGuid();    // Generate a finger print based on browser information.
            this.saveGuid(this.guid);           // Save the finger print in case if the user changed something about their browser/screen.
        }

        this.log('Fingerprint: ' + this.guid, 'constructor');

        this.attachEvents();

    }

    attachEvents() {
        this.log('Initalizing events for capture.', 'attachEvents');

        this.pageLoadEvent();                                           // We know the page loaded so we call this event to tell analytics.
        setTimeout(this.pageDebounceEvent, DEBOUNCE_PAGE_VIEW_DELAY); // Once we know the user has been on the page for a while we let Analytics know.
    }

    pageLoadEvent() {
        self.log('Event fired!', 'pageLoadEvent');

        self.logEvent('pageLoad');
    }

    pageDebounceEvent() {
        self.log('Event fired!', 'pageDebounceEvent');

        self.logEvent('pageDebounce');
    }

    addToCartEvent() {
        self.log('Event fired!', 'addToCartEvent');

        self.logEvent('addToCart', {
            // Item Added To Cart
        });
    }

    checkoutEvent() {
        self.log('Event fired!', 'checkoutEvent');

        self.logEvent('checkout');
    }

    log(message, methodName='Unknown') {
        if(!this.enableLog)
            return;

        console.log(methodName + ': ' + message);
    }

    generateGuid() {
        // Get the user's guid based on browser properties.
        let screen = window.screen;
        let nav = navigator;

        let guid = nav.mimeTypes.length;
        guid += nav.plugins.length;
        guid += screen.availWidth || '';
        guid += screen.availHeight || '';
        guid += screen.width || '';
        guid += screen.height || '';

        guid += screen.colorDepth || '';
        guid += screen.pixelDepth || '';
        guid += (navigator.geolocation) ? 1 : 0;
        guid += navigator.language || '';
        guid += navigator.platform || '';
        guid += (navigator.javaEnabled()) ? 1 : 0;

        return guid;
    }

    isDoNotTrackEnabled() {
        if (!window.navigator.userAgent.match(/MSIE\s10\.0|trident\/6\.0/i))
            return window.navigator.doNotTrack || window.navigator.msDoNotTrack;
    }

    logEvent(action='Unkown', data=null) {

        let requestData = {
            'guid' :      self.guid,
            'action' :    action,
            'path' :      self.getURIPath(),
            'timestamp' : self.getUNIXTimestamp(),
            'data' :      data,
            '_token':     self.csrf
        };

        $.ajax({
            url: '/nca/',
            data: requestData,
            type: 'POST'
        })
        .done(function( response ) {
            self.log('Ajax Response:');
        })
        .fail(function( response ) {
            console.error(response);
        });
    }

    setupDate() {
        if(!Date.now) {
            Date.now = function() {
                return new Date().getTime();
            }
        }
    }

    getUNIXTimestamp() {
        return Date.now();
    }

    getURIPath() {
        return (window.location.pathname) ? window.location.pathname : '/';
    }

    saveGuid(guid) {

        if(typeof(Storage) !== "undefined") {
            localStorage.setItem(GUID_STORAGE_NAME, guid);
            return;
        }

        // Generate a expireation date for our cookie.
        let d = new Date();
        d.setTime(d.getTime() + (GUID_STORAGE_DAYS * 24 * 60 * 1000));

        // Save the cookie!
        document.cookie = GUID_STORAGE_NAME + '=' + encodeURIComponent(guid) + ";expires=" + d.toUTCString() + ';path=/';
    }

    getSavedGuid() {

        if(typeof(Storage) !== "undefined") {
             let guid = localStorage.getItem(GUID_STORAGE_NAME);

            if(guid)
                return guid;
        }

        const nameQuery = GUID_STORAGE_NAME + '=';
        const cookies = document.cookie.split(';');

        for (var i = 0; i < cookies.length; i++) {

            let c = cookies[i];
            while(c.charAt(0) == ' ') {
                c = c.substring(1);
            }

            if(c.indexOf(nameQuery) == 0) {
                return decodeURIComponent(c.substring(nameQuery.length, c.length));
            }
        }

        return null;
    }

    getCsrfToken() {

        var metaTags = document.getElementsByTagName('meta');

        for (var i = 0; i < metaTags.length; i++) {
            if(metaTags[i].getAttribute("name") == 'csrf-token')
                return metaTags[i].getAttribute('content');
        }

        return null;
    }
}

new AnalyticsTracker();
