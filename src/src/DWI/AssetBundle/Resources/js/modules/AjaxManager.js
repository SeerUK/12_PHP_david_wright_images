/**
 * David Wright Images
 *
 * @author  Elliot Wright <wright.elliot@gmail.com>
 * @since   2013
 * @package DWI
 */

/**
 * Ajax Request Manager
 */
var AjaxManager = (function(window, $, undefined) {

    "use strict";

    var priv = {};


    /**
     * @type Array
     */
    priv.requests = [];


    /**
     * Container
     */
    function AjaxManager() {

        /**
         * Add request
         *
         * @param  object opt
         * @return AjaxManager
         */
        this.addRequest = function(opt) {
            priv.requests.push(opt);

            return this;
        };


        /**
         * Remove request
         *
         * @param  object opt
         * @return AjaxManager
         */
        this.removeRequest = function(opt) {
            if ($.inArray(opt, priv.requests) > -1) {
                priv.requests.splice($.inArray(opt, priv.requests), 1);
            }

            return this;
        };


        /**
         * Run queued requests
         */
        this.run = function() {
            var that = this;
            var sf;

            if( priv.requests.length ) {
                sf = priv.requests[0].complete;

                priv.requests[0].complete = function() {
                    if( typeof sf === 'function' ) {
                        sf();
                    }

                    priv.requests.shift();
                    that.run.apply(that, []);
                };

                $.ajax(priv.requests[0]);
            }
        };


        /**
         * Stop requests
         */
        this.stop = function() {
            priv.requests = [];
            clearTimeout(this.tid);
        };

    }

    return AjaxManager;

})(window, jQuery);
